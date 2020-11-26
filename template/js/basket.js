var check_sea=false,check_sky=false;
var here = new Array();
var returned_check = new Array();
here["sea"] = here["sky"] = 0;
returned_check["sea"]  = returned_check["sky"] = 1;
var bakset_form = $("#bakset_form");
$(".all").click(function(){
	var checked_status = true;
    $("input[class='basket']").each(function(){
        this.checked = checked_status;
      });
});

function changeShopCount(id,count,max,dtype=""){

	var pid = $("#pid_"+id);
	var temp = count;
	var count_element = pid.find(".pg_count");
	var pg_price = pid.find(".pg_price").find("span");
	var pg_delivery = pid.find(".pg_delivery").find("span");

	var product_hidden = pid.find(".all_product_price");
	var delivery_hidden = pid.find(".this_delivery");
	var unit_hidden = pid.find(".unit");
	var weight_hidden = pid.find(".weight");
	var type_hidden = pid.find(".type");

	if(count_element.val() > max){
		alert("최대 수량보다 클수 없습니다");
		count_element.val(max);
		temp = max;
	}

	if(count_element.val() <=0){
		alert("0보다 작을수 없습니다");
		count_element.val(1);
		temp = 1;
	}
	jQuery.ajax({
	type : "POST",
	dataType : "json",
	url : baseURL + "changeShopCount",
	data : { id : id ,count : temp },
	boferSend:function(){
		count_element.prop("disabled", true);
	}
	}).done(function(data){
		if(data.status=="error"){
			alert(data.message);
			return;
		}

		if(data.status =="error_count"){
			alert(data.message);
			location.reload();
			return;
		}
		var this_delivery  =0;
		var type = type_hidden.val();
		var wei = 0;
		var all_price = temp * parseInt(unit_hidden.val());
		if(type == 0 && (all_price < by_delivery) ){
			this_delivery = s_delprice;
		}
		if(type ==1){
			wei = weight_hidden.val() * temp;
			this_delivery = getFindPrice(dtype,wei);
		}
		product_hidden.val(all_price);
		delivery_hidden.val(this_delivery);
		pg_delivery.text(fnCommaNum(this_delivery));
		pg_price.text(fnCommaNum(all_price));
		updateSum(dtype);
	}).always(function(){
		count_element.prop("disabled", false);
	});
}

function checkProduct(name){
	var temp = true;
	var t ="";
	if(name =="basket_sea"){
		check_sea = !check_sea;
		temp = check_sea;
		t = "sea";
	}
	if(name =="basket_sky"){
		check_sky = !check_sky;
		temp = check_sky;
		t="sky";	
	}

	$("input[class='"+name+"']").each(function(){
        $(this).prop("checked",temp);
    });
    updateSum(t);
}

function deleteBasket(id){
	var confirmation = confirm("변경하시겠습니까?");
	if(confirmation)
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : baseURL+"deleteBasket",
			data : { id : id } 
			}).done(function(data){
				if(data==1)	window.location.reload();
		});
}

function updateSum(t){
	var price =0;
	var wet = 0;
	var proprice = 0;
	var cc = 0;
	var halin = 0;
	$("input[class='basket_"+t+"']").each(function(){
    	if($(this).prop("checked") == true)
    	{
    		var pri = parseInt($("#pid_"+$(this).val()).find(".all_product_price").val());
    		var thsd = parseInt($("#pid_"+$(this).val()).find(".this_delivery").val());
    		price = price + pri +thsd;
    		proprice += pri;
    		cc = parseInt($("#pid_"+$(this).val()).find(".pg_count").val());
    		wet += parseFloat($("#pid_"+$(this).val()).find(".weight").val() * cc);
    		if($("#pid_"+$(this).val()).find(".type").val() ==0){
    			halin += parseInt($("#pid_"+$(this).val()).find(".this_delivery").val());
    		}
    	}
	});
	if(parseFloat(wet) > 0){
		halin += proprice + parseInt(getFindPrice(t,wet));
	}
	else{
		halin += proprice;
	}
    $(".price_"+t).find("strong").text(fnCommaNum(price));
    $(".halin_"+t).find("strong").text(fnCommaNum(halin));
}

function moreBasket(t){
	var templateScriptTwo = $('#basket_list').html();
	var templateTwo = Handlebars.compile(templateScriptTwo);
	var tbody = $(".tbody_"+t);
	if(here[t] >= review_count[t]) $(".more_"+t).addClass("disabled");
	if(here[t] < review_count[t] && returned_check[t] ==1){
		jQuery.ajax({
		      method: "POST",
		      url: baseURL+"getMoreBasket",   
		      data: {here:here[t],type:t},
		      dataType:"json",
		      beforeSend: function() {
		        returned_check[t] = 0 ;
		        $('.loading_products').removeClass("d-none");
		    },
		})
		.done(function( msg ) {
			$('.loading_products').addClass("d-none");
			returned_check[t] =1;
			here[t] =  here[t] + 10;
			if(here[t] >= review_count[t]) $(".more_"+t).addClass("disabled");
		    if(msg.status =="success"){
		    	$.each(msg.result,function(index,value){
		    		tbody.append(templateTwo(value));
		    	});
		    	$("img.lazy").lazyload();
		    }

		}).fail(function(jq) {
			$('.loading_products').addClass("d-none");
			returned_check[t] =1;
			return;
		});
	}
}

function cart_select_delete(t,t_mode="delete"){

	var msg = "선택하신 상품을 장바구니에서 삭제하시겠습니까?";
	if(t_mode =="all_delete"){
		msg = "장바구니에 든 상품들을 전부 비우시겠습니까?";
	}
	var de_tbody = $(".tbody_"+t);
	if(confirm(msg)){
		if(t_mode  =="delete")
			if($(".basket_"+t+":checkbox:checked").length ==0){
				alert("1개 이상 선택해주시기 바랍니다.");
				return;
			}
		$("#mode").val(t_mode);
		$("#type_delete").val(t);
		var formData = new FormData(bakset_form[0]);
		jQuery.ajax({
		      	method: "POST",
		      	url: baseURL+"updateBasketData",   
		      	data: formData,
		      	dataType:"json",
		      	async: false,
				processData: false,
				contentType: false,
		      beforeSend: function() {
		        $('.loading_products').removeClass("d-none");
		    },
		})
		.done(function( msg ) {
			$('.loading_products').addClass("d-none");
			if(msg.status ==1){
				$.each(msg.ids,function(index,value){
					$("#pid_"+value).remove();
				})
			}

			if(msg.status ==2){
				de_tbody.html("");
			}
			
		}).fail(function(jq) {
			$('.loading_products').addClass("d-none");
			return;
		});
	}
}

function visibleForm(){
	if($(".basket_sea:checkbox:checked").length ==0 && $(".basket_sky:checkbox:checked").length ==0){
		alert("1개 이상 선택해주시기 바랍니다.");
		return;
	}
	$(".enable-purchase").hide();
	$("#deliverForm").removeClass("d-none");
	$([document.documentElement, document.body]).animate({
        scrollTop: $("#deliverForm").offset().top
    }, 500);
}


$(document).ready(function(){
	moreBasket("sea");
	moreBasket("sky");

	$("#bakset_form").validate({
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
	        var form = bakset_form[0];
	        var data = new FormData(form);
  			$.ajax({
	            type: "POST",
	            url: "/makeorder",
	            data: data,
	            processData: false,
	            contentType: false,
	            cache: false,
	            dataType:"json",
	            beforeSend:function(){
	            	$(".loading_products").removeClass(".d-none");
	            },
	            success: function (data) {
	            	$(".loading_products").removeClass(".d-none");
	            	var add_msg= "";
	            	if(data.status =="login_error"){
						login_alert();
						return;
					}
					if(data.status =="error"){
						alert(data.message);
						return;
					}
					if(data.status =="success"){
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
	            	$(".loading_products").removeClass(".d-none");
	            	debugger;
	            	alert("오류발생");
	            	location.reload();
	            }
	        })
			return false;
		},
		invalidHandler: function(form, validator) {return false;}
	});
})