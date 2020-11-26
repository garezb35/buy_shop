$(document).ready(function(){
	var pcode = $("#pcode").val();
	$(".p_category").removeClass("d-none");
	getRelatedProduct(pcode,"related_top");
	getReivews('#ID_eval_list','eval','');
	getReivews('#ID_qna_list','qna','');
	getRelatedProduct(pcode,"related_bottom");
	$("#deliverForm").validate({
		rules:{
			ADRS_KR: {
				required: true,
			},
			ADRS_EN: {
				required: true
			},
			RRN_NO: {
				required: true,
			},

			ZIP: {
				required: true,
			},
			ADDR_1: {
				required: true
			},
			MOB_NO1: {
				required: true,
			},
			MOB_NO2: {
				required: true,
			},
			MOB_NO3: {
				required: true,
			},
		},
		messages: {
			ADRS_KR :  "이 필드는 반드시 입력해야 합니다.",
			ADRS_EN :  "이 필드는 반드시 입력해야 합니다.",
			RRN_NO :  "이 필드는 반드시 입력해야 합니다.",
			ZIP: "이 필드는 반드시 입력해야 합니다.",
			ADDR_1: "이 필드는 반드시 입력해야 합니다.",
			MOB_NO1: "이 필드는 반드시 입력해야 합니다.",
			MOB_NO2: "이 필드는 반드시 입력해야 합니다.",
			MOB_NO3: "이 필드는 반드시 입력해야 합니다."
		},
		submitHandler: function(form) { //通过之后回调
		//进行ajax传值
			event.preventDefault();
			var con =1;
			$("#delivery_type").val("purchase");
		    $.each($(".option-value"),function(index,value){
				if($(this).val() ==""){
					alert("옵션을 선택하세요");
					$(this).focus();
					con =0;
					return false;
				}
			});
			if(con ==0){
				return;
			}
	        var form = $('#deliverForm')[0];
	        var data = new FormData(form);
  			$.ajax({
	            type: "POST",
	            url: "/update_bracket",
	            data: data,
	            processData: false,
	            contentType: false,
	            cache: false,
	            dataType:"json",
	            success: function (data) {
	            	var add_msg= "";
	            	if(data.status =="login_error"){
						login_alert();
						return;
					}
					if(data.status =="error"){
						alert(data.message);
						return;
					}
					if(data.status =="success_purchase"){
						if(data.happened_adds)
						{
							add_msg = "\n도서산관추가배송비가 추가되였습니다.결제페이지에서 확인하세요";
						}
						socket.emit("chat message",1,data.post_id,userId,"shop",userName);
						alert(data.message + add_msg);
						location.href = "/mypay";
						return;
					}

	            },
	            error: function (e) {
	            	alert("오류발생");
	            	location.reload();
	            }
	        })
			return false;
		},
		invalidHandler: function(form, validator) {return false;}
	});
});
$('#carousel-products').carousel(
	{
		interval:false
	}
);


function getRelatedProduct(pcode,element){
	var templateScriptTwo = $('#related-lists').html();
	var templateTwo = Handlebars.compile(templateScriptTwo);
	var obj  = $("#"+element);
	$.ajax({
		url: "/relatedProudct",
		type: "POST",
		dataType: "json",
		data: {pcode : pcode },
		beforeSend:function(){
			$('.loading_products').removeClass("d-none");
		},
		success: function(data){
			if(data.length > 0)
			{	
				$.each(data,function(index,value){
					obj.append(templateTwo(value)); 
				});
				$(".ratings").starRating({
				 	readOnly:true,
					disableAfterRate: false,
				    starShape: 'rounded',
				    starSize: 15,
				    emptyColor: 'lightgray',
				    hoverColor: 'salmon',
				    activeColor: 'crimson',
				    minRating: 0
				});

				obj.slick({
				  speed: 300,
				  slidesToShow: 5,
				  slidesToScroll: 1,
				  arrows: false, 
				  autoplay: true,
				  autoplaySpeed: 3000,
				  prevArrow : '<button class="slick-prev right-ab-ha" aria-label="Previous" type="button"><img src="/assets/images/shop_r.png"></button>',
				  nextArrow : '<button class="slick-next left-ab-ha" aria-label="Next" type="button"><img src="/assets/images/shop_l.png"></button>',
				  responsive: [
				    {
				      breakpoint: 1024,
				      settings: {
				        slidesToShow: 3,
				        slidesToScroll: 3,
				        infinite: true,
				      }
				    },
				    {
				      breakpoint: 600,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 2
				      }
				    },
				    {
				      breakpoint: 480,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    }
				  ]
				});
				// $("img.lazy").lazyload();
			}
			else
				$(".withnames").text("");
			$('.loading_products').addClass("d-none");
		}
	}).fail(function(){
		$('.loading_products').addClass("d-none");
	});
}

function app_submit(pcode,type,obj){
	var con = 1;
	$.each($(".option-value"),function(index,value){
		if($(this).val() ==""){
			alert("옵션을 선택하세요");
			$(this).focus();
			con =0;
			return false;
		}
	});
	if(con ==0) return;
	$("#delivery_type").val("basket");
	var formData = new FormData(document.getElementById("deliverForm"));
	$.ajax({
		url: "/update_bracket",
		type: "POST",
		dataType: "json",
		data: formData,
		async: false,
		processData: false,
		contentType: false,
		success: function(data){
			if(data.status =="login_error"){
				login_alert();
				return;
			}
			if(data.status =="error"){
				alert(data.message);
				return;
			}
			if(data.status =="success"){
				alert(data.message);
				return;
			}
		}
	}).fail(function(jq){
		debugger;
		alert("예상치 못한 오류가 발생하였습니다.잠시후에 오세요")
		location.reload();
	})
}

function pro_cnt_up() {
    cnt = $("#option_select_cnt").val()*1;
    if(cnt > $("#option_select_cnt").data("max")-1)
    {
        alert("최대상품개수보다 클수 없습니다.");
        return;
    }
    $("#option_select_cnt").val(cnt+1);
    update_sum_price();
}
function pro_cnt_down() {

    cnt = $("#option_select_cnt").val()*1;
    if(cnt > 1) $("#option_select_cnt").val(cnt-1);

    update_sum_price();
}
function update_sum_price() {
	if($("#option_select_cnt").val() > $("#option_select_cnt").data("max"))
    {
        alert("최대상품개수보다 클수 없습니다.");
        $("#option_select_cnt").val($("#option_select_cnt").data("max")) ;
    }
	if($("#option_select_cnt").val() <=0 || isNaN($("#option_select_cnt").val()))
	{
		$("#option_select_cnt").val(1);
	}
    var sumprice = 0;
    sumprice = String(parseInt($("#option_select_expricesum").val())*$("#option_select_cnt").val());
    if(sumprice == "NaN") sumprice = "0";
    $("#option_select_expricesum_display").html(fnCommaNum(sumprice));
    $("#option_select_count_display").html($("#option_select_cnt").val());
    
    if(t_delivery ==0 && by_delivery > sumprice){
        $("#option_free_price_display").html("+배송비 "+delivery_price*$("#option_select_cnt").val()+"<br><span style='color:#999;margin-top: 5px'>("+fnCommaNum(by_delivery)+"원 이상 결제시 무료 배송)</span>");
    }

    if((t_delivery ==0 && by_delivery <= sumprice)	 || t_delivery ==2)
    {
    	$("#option_free_price_display").html("<em class='sky'>무료배송</em>");
    }
    if(t_delivery ==1)
    {
        var del_price = getFindPrice(delivery_method,weight * $("#option_select_cnt").val());
       	if(delivery_method =="sea")
       		$("#delivery_method").find(":selected").text("해운특송 (5일 ~ 7일) +"+fnCommaNum(del_price)+"원");
       	if(delivery_method =="sky")
       		$("#delivery_method").find(":selected").text("항공특송 (3일 ~ 5일) +"+fnCommaNum(del_price)+"원");
        $("#option_free_price_display").html("+배송비 "+fnCommaNum(del_price));
    }
}

function visibleForm(){
	$("#deliveryForm").removeClass("d-none");
	$([document.documentElement, document.body]).animate({
        scrollTop: $("#deliveryForm").offset().top
    }, 500);	
}



$(".option-value").change(function(){
	var temp_price = parseInt(price);
	var count = $("#option_select_cnt").val();
	var name = $(this).data("name");
	init_add = 0;
	output_adds = new Array();
	if(o_type.includes(name)){
		$(".color").val($(this).find(":selected").data("insert"));
	}
	else{
		$(".size").val($(this).find(":selected").data("insert"));
	}

	add_options[$(this).val()] = $(this).find(":selected").data("price");
	var temp = 0;
	$.each($(".option-value"),function(index,value){
		var this_p = parseInt($(this).find(":selected").data("price"));
		output_adds.push($(this).val());
		if(temp < this_p)
			temp = this_p;
	});
	$("#option_select_expricesum").val(temp);
	$("#option_select_addsum").val(temp);
	$("#option_select_expricesum_display").text(fnCommaNum((temp)*count));
});


$("#delivery_method").change(function(){
	delivery_price = $(this).find(":selected").data("price");
	$(".method").text($(this).val());
	delivery_method = $(this).val();
	update_sum_price();
});

