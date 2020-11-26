var letters = /^[a-zA-Z0-9 ]+$/;
var tt =0;
$(".taoali").hide();
var index_pro = 0;
var oType = 0;
var gFrmNm = "#deliverForm";
function openPopupImg(pid){
	$("#product_val").val(pid);
	$('#exampleModalCenter').modal('show');
}

function opentao(){
	$(".taoali").show();
	$("#ie-clipboard-contenteditable").show();
}

function  insertProductFromOut1(item){
	var order_items = $("#listBox ul li.order-item");
	if(order_items.length ==0 ) {
		if($("#ie-clipboard-contenteditable").find(".order-id").length > 0) {
			order_items = $("#ie-clipboard-contenteditable");
		}
	}
	if(order_items.length ==0){
		alert("상품이 현시되지 않습니다.");
		return;
	}
	order_items.each(function(){
		var order_title = $(this).find(".order-id").text().split("订单号：")[1];
		var orderInfo = $(this).find("table.orderInfo").find("td.detail");
		var proArray ={};
		var ii=0;		
		orderInfo.find("table tr").each(function(){
			temp = {};
			var link = $(this).find(".s2 .productName").attr("href");
			if (link ==undefined) return true;
			var image_url = $(this).find(".s1 img").attr("src");
			if (image_url ==undefined) return true;
			var title = $(this).find(".s2 .productName").text();
			if (title ==undefined) return true;
			var size="";
			var color ="";
			var t1="";
			var t="";
			var trade_spec = $(this).find(".trade-spec .spec-item.sku-item");
			trade_spec.each(function(){
				t= findAttr($(this).text())['color'];
				t1 = findAttr($(this).text())['size'];
				if(t!=""  && t!=undefined) color = t;
				if(t1!=""  && t1!=undefined) size = t1;
			});		
			var price = $(this).find(".s3 span").text();
			if(price !=undefined) price = price.replace(/,/g, "");
			if (price ==undefined) return true;
			var count = $(this).find(".s4 div").text();
			if (count ==undefined) return true;
			temp['image'] = image_url;
			temp['title'] = title;
			temp['price'] = price;
			temp['count'] = count;
			temp['order'] = order_title;
			temp['color'] = color;
			temp['size'] = size;
			temp['link'] = link;
			totalPriceArray[index_pro] = temp;
			index_pro++;
		});
	});
}

function insertProductFromOut2(item){
	var bought_root = $('table[class^=bought-table-mod__table___]');
	var order = "";
	var link = "";
	var image = "";
	var price = "";
	var count = 0;
	var title = "";
	if(bought_root.length ==0 ) {
		bought_root = $("table.bought-wrapper-mod__table___3xFFM");
		if(bought_root.length ==0 ) {
			bought_root = $("table.bought-table-mod__table___AnaXt");
			if(bought_root.length ==0 ) {
				alert("상품이 현시되지 않습니다.다시 시도하세요");
				return;
			}
		}
		
	}
	bought_root.each(function(){
		$(this).find("tbody").each(function(index,element ){
			if(index ==0) {
				if($(element).find("[class^=bought-wrapper-mod__head-info-cell]").find("span").length ==0) return true;
                order=$(element).find("[class^=bought-wrapper-mod__head-info-cell]").find("span")[2].innerText.split("订单号:")[1];
			}
			if(index ==1){
				$(element).find("tr").each(function(chd_index,chd_element){
					if($(chd_element).find("[class^=ml-mod__container]").text().trim()=="保险服务"){return true;}
                    link= $(chd_element).find("[class^=ml-mod__media]").find("a").attr("href");
                    image= $(chd_element).find("[class^=ml-mod__media]").find("a").find("img").attr("src");
                    if($(chd_element).find("[class^=price-mod__price]").find("p").length == 0 ) return true;
                    else { var s = $(chd_element).find("[class^=price-mod__price]").find("p").length; }                 
                    price = Number((/(\d+\.\d+)/.exec($(chd_element).find("[class^=price-mod__price]").find("p")[0].innerText) || []).pop());
                    count = Number($(chd_element).find("[class^=sol-mod__no-br]")[2].innerText);
                    title = $(chd_element).find("[class^=sol-mod__no-br]").find("a")[1].innerText;
					var t ="";
					var t1 ="";
					var size = "";
					var color = "";
					var item___3zYoT = $(chd_element).find("[class^=production-mod__sku-item]");
					item___3zYoT.each(function(color_index,ele_ch){
						t = findAttr($(ele_ch).text())['color'];
						t1= findAttr($(ele_ch).text())['size'];
						if(t.trim() !="" && t!=undefined) color = t;
						if(t1.trim() !="" && t1!=undefined) size = t1;
					});
					var temp =  {};
					temp['image'] = image;
					temp['title'] = title;
					temp['price'] = price;
					temp['count'] = count;
					temp['order'] = order;
					temp['color'] = color;
					temp['size'] = size;
					temp['link'] = link;
					totalPriceArray[index_pro] = temp;
					index_pro++;
				});
			}
		});
		
	});
	start:
	console.log("d");
}


function insertProductFromOut3(item){
	var mod_cart = $(".zone-goods.fd-clr");
	if(mod_cart.length ==0 ){
		if($(".goods-image").length > 0 || $(this).find("table.singles").length > 0 ){
			mod_cart = $("#ie-clipboard-contenteditable").children().eq(1);
		}
	}
	
	var tempArray =  {};
	var t;
	var temp1 = "";
	var temp2 = "";
	mod_cart.each(function(){
		t = $(this);
		t.find("table.singles tr.single").each(function(){
			var image = t.find(".goods-image img").attr("src");
			var title = t.find("div.description a").text();
			var unit_sku = $(this).find("dl.unit-sku");
			var link = t.find(".goods-image .img-wrap").attr("href");
			var size = "";
			var color = "";
			var tt="";
			var t1="";
			unit_sku.each(function(){
				tt = findAttr($(this).text())['color'];
				t1 = findAttr($(this).text())['size'];
				if(tt.trim() !="" && tt!=undefined) {color = tt;temp1=tt;}
				else {color = temp1;}
				if(t1.trim() !="" && t1 !=undefined) {size = t1;temp2 = t1;}
				else{size = temp2;}

			});
			var count = $(this).find(".unit-finecontrol input.input").val();
			if (count ==undefined) return true;
			var price = $(this).find(".amount-wrap .amount").text();
			price = parseFloat(price.replace(/,/g, ""))/parseFloat(count);
			tempArray['price'] = price;
			tempArray['title'] = title;
			tempArray['count'] = count;
			tempArray['color'] = color;
			tempArray['size'] = size;
			tempArray['image'] = image;
			tempArray['order'] = "";
			tempArray['link'] = link;
			totalPriceArray[index_pro] = tempArray;
			tempArray =  {};
			index_pro++;
		});
	});
}

function insertProductFromOut4(item){
	var item_holders = $(".item-holder");
	if(item_holders.length ==0 ) item_holders = $(".item-content");
	if(item_holders.length ==0) {alert("형식이 옳바르지 않습니다;다시 시도하십시요");return;}
	var proArray ={};
	var ii=0;
	item_holders.each(function(){
		var invalid = $(this).find(".item-invalid");
		if(invalid.length > 0)  return true;
		var title = $(this).find(".item-title").text();
		var image = $(this).find(".item-pic").find(".itempic").attr("src") !=null && $(this).find(".item-pic").find(".itempic").attr("src") !=undefined ? $(this).find(".item-pic").find(".itempic").attr("src"):"";
		var link = $(this).find(".item-title").attr("href");
		var price = Number((/(\d+\.\d+)/.exec($(this).find(".price-now").text()) || []).pop());
		var count =  $(this).find(".item-amount .text-amount").val();
		var order="";
		var size ="";
		var color = "";
		var t ="";
		var t1="";
		var item_props = $(this).find(".sku-line");
		if(item_props.length > 0 ){
			item_props.each(function(){
				t = findAttr($(this).text())['color'];
				t1= findAttr($(this).text())['size'];
				if(t.trim() !="" && t!=undefined) color = t;
				if(t1.trim() !="" && t1!=undefined) size = t1;
			})
		}
		var tempArray = {};
		tempArray['price'] = price;
		tempArray['title'] = title;
		tempArray['count'] = count;
		tempArray['color'] = color;
		tempArray['size'] = size;
		tempArray['image'] = image;
		tempArray['order'] = "";
		tempArray['link'] = link;
		totalPriceArray[ii] = tempArray;
		ii++;
		
	});
}

function cuttingString(str,cuttedStr){
	var result = "";
	result = str;
	if(result.length ==1) return "";
	result = result[1];
	var cars = ["尺码：", "颜色分类：", "发货时间："];
	for(var i=0;i<cars.length;i++){
		if(cuttedStr != cars[i]){
			if(result.indexOf(cars[i]) == 0 || result.indexOf(cars[i])== -1) continue;
			result = result.substring(0, result.indexOf(cars[i]));
		}
	}
	return result;
}
function cuttingString1(str){
	var result = "";
	result = str;
	if(result.length ==1) return "";
	result = result[1];
	if(result.indexOf(";") > -1) result = result.substring(0,result.indexOf(";"));
	return result;
}

function findAttr(str){
	var re={"color":"","size":""};
	var cars = ["尺寸","颜色","尺码","颜色分类", "大小","规格","适合身高","黑色","顏色分類","尺碼","顏色","适用型号","款式"];
	str = str.split("：").length ==1 ? str.split(":"):str.split("：");
	i
	for(var i = 0;i<cars.length;i++){
		if(str[0].includes(cars[i])){
			switch(i) {
			  	case 0:
			  		re['size']= str[1];
			  		break;
			  	case 1:
			  		re['color']= str[1];
			  		break;
			  	case 2:
			  		re['size']= str[1];
			  		break;
			  	case 3:
			  		re['color']= str[1];
			  		break;
			  	case 4:
			  		re['size']= str[1];
			  		break;
			  	case 5:
			  		re['size']= str[1];
			  		break;
			  	case 6:
			  		re['size']= str[1];
			  		break;
			  	case 7:
			  		re['color']= str[1];
			  		break;
			  	case 8:
			  		re['color']= str[1];
			  		break;
			  	case 9:
			  		re['size']= str[1];
			  		break;	
			  	case 10:
			  		re['color']= str[1];
			  		break;
			  	case 11:
			  		re['size']= str[1];
			  		break;	
			  	case 12:
			  		re['size']= str[1];
			  		break;								
			  	default:	
			}
		}
	}
	re['color'] = re['color'].trim();
	re['size'] = re['size'].trim();
	if(re['color'].slice(-1) ==";") re['color'] = re['color'].slice(0, -1);
	if(re['size'].slice(-1) ==";") re['size'] = re['size'].slice(0, -1);
	return re;
}

function openDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
			if ( data.userSelectedType == "R" ) {
				document.getElementById('ZIP').value = data.zonecode;
				document.getElementById('ADDR_1').value = data.roadAddress;
				document.getElementById('ADDR_2').focus();
				document.getElementById('ADDR_1_EN').value = data.addressEnglish;
			} else {
				alert("지번주소가 아닌 도로명주소를 선택하십시오.");
			}
        }
    }).open();
}
function fnArcAjax(sSeq, ShopNum){
	var url = "?CATE_SEQ="+sSeq; 
	fnGetChgHtmlAjax("TextArc_"+ShopNum, "/getCateogrys", url);
}
function fnArcChkYN(val1,val2){
	$("#TempShopNum").val(val1);
	var val = "sArcSeq=" + val2;  
	fnCtmArcProNmGet(val1);
}
function fnReqValGet(sVal) {
	$(gFrmNm + " input[name='REQ_1']").val( sVal );
}
function fnMemAddrCfm(aAddr) {
	var aMemAddr = aAddr.split("|");
	var aMobNo = "";
	aMobNo = aMemAddr[5].split("-");

	$("input[name='ADRS_KR']").val( aMemAddr[0] );
	$("input[name='ADRS_EN']").val( aMemAddr[1] );
	$("input[name='ZIP']").val( aMemAddr[2] );
	$("input[name='ADDR_1']").val( aMemAddr[3] );
	$("input[name='ADDR_2']").val( aMemAddr[4] );
	$("input[name='MOB_NO1']").val( aMobNo[0] );
	$("input[name='MOB_NO2']").val( aMobNo[1] );
	$("input[name='MOB_NO3']").val( aMobNo[2] );
	$("input[name='RRN_CD']:radio[value='" + aMemAddr[6] + "']").prop("checked", true);
	$("input[name='RRN_NO']").val( aMemAddr[7]);
	$("input[name='ADDR_1_EN']").val( aMemAddr[8] );
	$("input[name='ADDR_2_EN']").val( aMemAddr[9] );
}

function fnTrkNoAfChk(pNo) {
	if ( $("#deliverForm input[name='TRACKING_NO_YN']:checkbox").eq(pNo-1).prop("checked") == true ) {
		$("#deliverForm input[name='FRG_IVC_NO']").eq(pNo-1).val("");
		$("#deliverForm input[name='FRG_IVC_NO']").eq(pNo-1).css("display", "none");
		$("#deliverForm select[name='FRG_DLVR_COM']").eq(pNo-1).css("display", "none");
	} else {
		$("#deliverForm input[name='FRG_IVC_NO']").eq(pNo-1).css("display", "inline");
		$("#deliverForm select[name='FRG_DLVR_COM']").eq(pNo-1).css("display", "inline");
	}

	if ( $("#deliverForm input[name='TRACKING_NO_YN']:checkbox:checked").length > 0 ) {
		$("#requestAccept").hide();
	} else {
		$("#requestAccept").show();
	}
}

function registerProducts(){
	if($("#ie-clipboard-contenteditable").text().trim()=="") {
		alert("내용이 비였습니다.");
		return;
	}
	$("html, body").animate({ scrollTop: 0 }, "fast");
	$("#loader").show();
	$(window).off('scroll');
	var ss = $("#ie-clipboard-contenteditable").html();
	   	var products;
	   	var results;
	   	index_pro = 0;
	   	totalPriceArray={};
	   	var type_options = "";
	   	switch($("#types_order").val()) {
		  case "1":
		   insertProductFromOut2(ss);
		   results=2;
		   type_options = "delivery";
		    break;
		  case "2":
		    insertProductFromOut4(ss);
		    results=1;
		    type_options = "buy";
		    break;
		  case "3":
		    results=2;
		    type_options = "delivery";
		    insertProductFromOut1(ss);
		  	break;
		  case "4":
		    insertProductFromOut3(ss);
		    results=1;
		    type_options = "buy";
		  default:
		    // code block
		}
		if(Object.size(totalPriceArray) ==0) 
		{
			alert("상품이 현시되지 않습니다.");
			$("#loader").hide();
			$(window).on('scroll');
		}
		else{
			fnProductFromAliTao(JSON.stringify(totalPriceArray),$("#sProNum").val(),results,type_options);
		}
}

function fnProductFromAliTao(data,sShopNum,options,type_options){
	var sShopNum = parseInt(sShopNum);
	var sProNum=   $("#sProNum"); 
	var tempProNum = $("#TempProNum");
	if(	($("#PRO_NM").val().trim()!="" || ($("input[name='COST']").val().trim()!="" && parseInt($("input[name='COST']").val().trim()) > 0)) && sShopNum==1 || sShopNum >1) 
		sShopNum = parseInt(sShopNum)+1;
	var ss= $("#TextProduct"+sShopNum);
	$.ajax({
	      type: "POST",
	      url: "/getProduct",
	      dataType:"json",
	      data: { ORD_TY_CD: 1, sShopNum: sShopNum, types: options,data:data,type_options:type_options },
	 }).done(function(data) {
	 	$("#loader").hide();
	 	$(window).on('scroll');
    	$('html, body').animate({
            scrollTop: $(".gold_element").offset().top-20
        }, 1000);
        $("#ie-clipboard-contenteditable").html("");
        $("#ie-clipboard-contenteditable").hide();
	  	if(data.c==1) {alert(data.data); return;}
		else {
			ss.html(data.data);
		  	sProNum.val(data.num);
		  	tempProNum.val(data.num);
		  	tt++;
		  	for(var i=1;i<parseInt(data.num);i++)
		  	{
		  		fnNumChiper($("#TextProduct"+i+" .COST")[0], '2');
		    	fnNumChiper($("#TextProduct"+i+" .QTY")[0], '0');
		  	}
		    fnTotalProPrice();
		}
	}).fail(function(data) {
		$("#loader").hide();
		$(window).on('scroll');
    	$('html, body').animate({
            scrollTop: $(".gold_element").offset().top-20
        }, 1000);
        $("#ie-clipboard-contenteditable").html("");
        $("#ie-clipboard-contenteditable").hide();
	    ss.html(data.responseText);
	  });
}

function fnEtcSvcChk(pObj) {
  var fGrpCdInit = "";
    $(gFrmNm + " input[name='EtcDlvr']").each( function() {
        if ( $(this).is(":checked") ) {
           fGrpCdInit += "," + $(this).val();
        }
    });
  $("#fees").val(fGrpCdInit);
  fnTotalProPrice();
}
function fnTotalProPrice() {
	var sAmt = 0, sSaleAmt = 0; sFrgShipMny = 0; sTaxAmt = 0;
	var sTotalProCnt = 0, sTtCtmsCnt = 0;
	var sTotalAmt = 0;
	for(var i=1; i<=$("#TempProNum").val(); i++) {
		sAmt         = Number($("input[name='COST']").eq(i-1).val()) * Number($("input[name='QTY']").eq(i-1).val());
		sAmt         = sAmt.toFixed(2);
		$("input[name='AMT']").eq(i-1).val(sAmt);
		sTotalProCnt = Number(sTotalProCnt) + Number($("input[name='QTY']").eq(i-1).val());
		sTotalAmt    = Number(sTotalAmt) + Number(sAmt);
		if ( $("select[name='ARC_SEQ'] option:selected").eq(i-1).attr("rel") == "Y" ) {
			sTtCtmsCnt += 1;
		}
	}

	sSaleAmt    = 0;
	sTaxAmt     = 0;
	sFrgShipMny = $("input[name='SHIP_AMT']").val();
	sTotalAmt = Number(sTotalAmt) + Number(sTaxAmt) - Number(sSaleAmt) + Number(sFrgShipMny);
	sTotalAmt = sTotalAmt.toFixed(2);
	$("#PRO_AMT").val(sTotalAmt);
	$("#PRO_QTY").val(sTotalProCnt);

	if ( Number(sTotalAmt) < 1500 ) {
		$("input[name='EtcDlvr']").each( function(idx) {
			if ( $(this).val() == "28" ) {
				$(this).prop("checked", false);
				$(this).attr("disabled", true);
			}
		});
	} else {
		$("input[name='EtcDlvr']").each( function(idx) {
			if ( $(this).val() == "28" ) {
				$(this).attr("disabled", false);
				// 보험 가입 체크 시
				if ( $(this).prop("checked") == true ) {
					var fCifMny = 0, fCifKrwMny = 0;
					fCifMny = Number(sTotalAmt) * ( Number($(this).attr("mny")) / 100 );
					fCifKrwMny = Number(fCifMny) * Number( $("input[name='sExgRtMny']").val() );
					fCifKrwMny = fnNumRound(fCifKrwMny, 10);
					$("#dvCifMny").text( "예상 보험금액: ￥" + fCifMny.toFixed(2) + "(" + fnNumComma(fCifKrwMny) + "원)" );
				} else {
					$("#dvCifMny").text("");
				}
			}
		});
	}

	fnTrkNoChk();

	if ( $("input[name='RRN_CD']:radio:checked").val() == "3" ) {
		$("#htArcNmTt").text( "일반통관" );
		$("#htArcNmTt").removeClass("boxTy1");
		$("#htArcNmTt").addClass("boxTy2");

	} else {
		if ( sTtCtmsCnt > 0 ) {
			$("#htArcNmTt").text( "일반통관" );
			$("#htArcNmTt").removeClass("boxTy1");
			$("#htArcNmTt").addClass("boxTy2");
		} else {
			if ( Number(sTotalAmt)/6.6 > 150 ) {
				$("#htArcNmTt").text( "일반통관" );
				$("#htArcNmTt").removeClass("boxTy1");
				$("#htArcNmTt").addClass("boxTy2");
			} else {
				$("#htArcNmTt").text( "목록통관" );
				$("#htArcNmTt").removeClass("boxTy2");
				$("#htArcNmTt").addClass("boxTy1");
			}
		}
	}
	document.getElementById("TextTotalProCNT").innerHTML = sTotalProCnt;
	document.getElementById("TextTotalAmt").innerHTML    = sTotalAmt;
}

$( ".copy_paste_area" ).hide();
$("input[name='CTR_SEQ']").change (function () {
	$("input[name='CTR_SEQ']").each( function(idx) {
			if ($(this).is(':checked')){
				var ctr = $(this).data("v").split("|");
				var ctr_content = "*" + ctr[1] + "(" + ctr[0] + ")" + "주소 : <span class=\"bold clrBlue2\">" + ctr[3] + ",</span> " 			+ ctr[2] + "<br>" + "ZIP CODE: " + ctr[4] + "," + "TEL: " + ctr[5];
				$(".areaMyAddr").html(ctr_content);
			}
		});
});
$("#ADRS_EN").change(function(){
  	if($(this).val().match(letters))
  	{
  		return true;
  	}
  	else
  	{
  		alert('Please input alphabet characters only');
  		$(this).val("");
  		return false;
  	}
});
$("#PRO_NM").change(function(){
	var letters = /^[a-zA-Z0-9 ]+$/;
  	if($(this).val().match(letters))
  	{
  		return true;
  	}
  	else
  	{
  		alert('Please input alphabet characters only');
  		$(this).val("");
  		return false;
  	}
});

$("input[name='RRN_CD']").change( function() {
	if ( $(this).val() != "" ) { fnTotalProPrice(); }
	$("#RRN_NO").val( aRrnCdNm[$(this).val()] );
});

$(document).ready(function(){
	if($("#ie-clipboard-contenteditable").length > 0){
		document.getElementById("ie-clipboard-contenteditable").addEventListener("input", function() {
		    $( ".item-content" ).each(function( index ) {
				var price = $(this).find('.price-now').text().split('￥');// ¥
				var color = $( this ).find('.td-info > .item-props > .sku-line').text().split('尺码：');
				$( this ).find('.td-info > .item-props > p').each(function(index, val){
					var text = $(this).text().split('：');

					$("input[name='it_option"+(index+1)+"_form_arr'").val(text[1]);
				})

				$( "input[name='it_name_form_arr']" ).val( $( this ).find('.td-item > .td-inner > .item-info').text() );
				$( "input[name='it_sh_no_form_arr']" ).val( $( this ).find('.td-item > .td-inner > .item-info').text() ); 
				$( "input[name='it_site_url_form_arr']" ).val( $( this ).find('.td-item > .td-inner > .item-pic > a').attr("href") );
				$( "input[name='it_img_url_form_arr']" ).val( $( this ).find('.td-item > .td-inner > .item-pic > a > img').attr("src") );
				$( "input[name='it_img_view_form_arr']" ).attr("src", $( "input[name='it_img_url_form_arr']" ).val() );
				$("input[name='it_money_form_arr']").val(price[price.length - 1 ]);
				$("input[name='it_count_form_arr']").val($(this).find('.td-amount .text-amount').val());
				
				$("input").trigger("keyup");
					
		    });
		}, false);
	}
})