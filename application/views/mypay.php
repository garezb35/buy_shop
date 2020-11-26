<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<form name="frmPageInfo" id="frmPageInfo" method="post" action="/processPay"> 
				<input type="hidden" name="TotMny" id="TotMny"ㅇ>
				<input type="hidden" name="OlnTotMny" id="OlnTotMny">
				<input type="hidden" name="aCPN" id="aCPN" >
				<input type="hidden" name="seqOrd" id="seqOrd">
				<div class="padgeName">
					<h2>결제페이지</h2>
				</div>
				<div class="con">
					<div class="row">
						<div class="col-md-6 p-left-0">
							<a href="/mypay" class="btn btn-yonpu text-white">대행결제</a>
							<a href="/payHistory" class="btn btn-charo text-white">대행 결제내역</a>
						</div>
					</div>
					<div class="table-responsive" style="margin-top: 20px">
						<table class="table table-bordered">
							<thead class="thead-jin">
						      <tr>
						        <th class="vm_box text-center mid">
						        	<input type="checkbox" class="input_chk" title="선택" name="Cha_All" id="Cha_All" value="total" 
						        	onclick="fnChkBoxTotal(this, 'chkCHA_SEQ');fnPayPrice();">
						        </th>
						        <th scope="col" class="text-center">주문번호</th>
						        <th scope="col" class="text-center">구분	</th>
						        <th scope="col" class="text-center">실무게</th>
						        <th scope="col" class="text-center">부피무게</th>
						        <th scope="col" class="text-center">적용무게</th>
						        <th scope="col" class="text-center">결제금액</th>
						        <th scope="col" class="text-center">비용등록일</th>
						        <th></th>
						      </tr>
						    </thead>
						    <tbody>
						    	<?php foreach($content as $scontent):
						    		$prices = ""; 
						    		$plabel = "";
						    		$label= "";
						    		if($scontent->get=="delivery") 
						    		{
						    			$label = '배송';
						    		}
						    		if($scontent->get=="buy") 
						    		{
						    			$label = '구매';
						    		}
						    		if($scontent->get=="return") 
						    		{
						    			$label = '리턴';
						    		}
						    		if($scontent->type==3) 
						    		{
						    			$label = '쇼핑';
						    		}
						    		if($scontent->state==5) 
						    		{
						    			$prices = $scontent->purchase_price;
						    			$plabel = '구매';
						    		}

						    		if($scontent->type==3 && $scontent->state==5) 
						    		{
						    			$label = '쇼핑';
						    			$prices = $scontent->purchase_price + $scontent->sending_price;
						    		}
									if($scontent->state==14){
										$prices = $scontent->sending_price;
										$plabel = '배송';
									}
									if($scontent->state==20){

										$prices = $scontent->return_price;
										$plabel = '리턴';
									}
									if($scontent->add_check==1){
										$prices = $scontent->add_price;
										$plabel = '추가';
									}
								?>
						    		<tr>
							    		<td <?php if($plabel=="배송"): ?> rowspan="2" <?php endif; ?>class="vm_box text-center mid">
											<label><input type="checkbox" class="input_chk" title="선택" name="chkCHA_SEQ" id="chkCHA_SEQ" value="<?=$scontent->id?>" onclick="fnPayPrice()"></label>
											<input type="hidden" name="PMT_MNY_<?=$scontent->id?>" id="PMT_MNY_<?=$scontent->id?>" value="<?php echo str_replace(",", "", $prices); ?>">
											<div id="HiddenSaleMny_<?=$scontent->id?>">
												<input type="hidden" name="rPMT_MNY_<?=$scontent->id?>" id="rPMT_MNY_<?=$scontent->id?>" value="<?php echo str_replace(",", "", $prices); ?>">
											</div>	
											<input type="hidden" name="CPN_<?=$scontent->id?>" id="CPN_<?=$scontent->id?>">
											<input type="hidden" name="PRO_AMT_<?=$scontent->id?>" id="PRO_AMT_<?=$scontent->id?>" value="3200">
											<input type="hidden" name="CPN_1_<?=$scontent->id?>" id="CPN_1_<?=$scontent->id?>">
							
											<input type="hidden" name="CPN_2_<?=$scontent->id?>" id="CPN_2_<?=$scontent->id?>">
										
											<input type="hidden" name="CPN_4_<?=$scontent->id?>" id="CPN_4_<?=$scontent->id?>">
										
											<input type="hidden" name="CPN_5_<?=$scontent->id?>" id="CPN_5_<?=$scontent->id?>">
										
											<input type="hidden" name="CPN_6_<?=$scontent->id?>" id="CPN_6_<?=$scontent->id?>">
										
											<input type="hidden" name="CPN_3_<?=$scontent->id?>" id="CPN_3_<?=$scontent->id?>">
										
											<input type="hidden" name="CPN_7_<?=$scontent->id?>" id="CPN_7_<?=$scontent->id?>">
										</td>
										<td class="mid text-center"><a href="/view/delivery/<?=$scontent->rid?>" class="mid">
											<span class="lht_150 bold blue"><?=$scontent->ordernum?></span></a>
										</td>
										<td style="width: 100px" class="mid"> 
											<span class="bold">
												<?php if($scontent->add_check !=1): ?>
													<?=$scontent->type==3 && $scontent->state==5 ? "구매비/배송비":$plabel."비"?>
													<br>
												<?php endif; ?>	
												<?php if($scontent->add_check ==1): ?>
													추가결제비용
												<?php endif; ?>
												/<?=$scontent->type==3 && $scontent->state==5 ? "쇼핑몰":$label."대행"?>
												/<?php if($scontent->pcount >1)echo '합배송';else echo '단독배송'; ?>/<?=$scontent->method?>												
											</span>
										</td>
										<?php  $weight = "";?>
										<?php if($scontent->addid ==3) $weight = "CBM"; else $weight = "kg";?>
										<td class="text-center mid"><?=$scontent->real_weight != "0.00" ? $scontent->real_weight.$weight : "" ?> </td>
										<td class="text-center mid"><?=$scontent->vlm_wt !="0.00" ? $scontent->vlm_wt."kg": ""?> </td>
										<td class="text-center mid"><span class="bold"><?=!empty($scontent->mem_wt) || $scontent->mem_wt !=0 ? $scontent->mem_wt.$weight : ""?> </span></td>
										<td class="text-center mid">
											<div class="lht_150">
												<?php 
													$prices = number_format(str_replace(",", "", $prices));
												?>
												<span id="textPmtMny_<?=$scontent->id?>" class="bold text-danger"><?php echo $prices; ?>원</span>
											</div>
										</td>
										<td class="mid text-center"><?=explode(" ",$scontent->updated_date)[0]?></td>
										<td class="mid text-center">
											<a href="javascript:fnChaView(<?=$scontent->id?>);"><span class="bold text-danger">상세내역보기</span></a>
										</td>
							    	</tr>
							    		<?php if($plabel=="배송" ||($scontent->type==3 && $scontent->state==5 && $scontent->sending_price > 0)): ?>
							    	<tr>		
							    		<td colspan="8" >
							    			<input type="radio" class="input_chk vm" name="SHOT_DLVR_<?=$scontent->id?>" id="SHOT_DLVR_<?=$scontent->id?>" value="N" onclick="fnShotDlvr('<?=$scontent->id?>');" style="width:0;height:0;" checked="">
							    			<a href="javascript:fnCpnSel('<?=$scontent->id?>');"><span class="bold text-danger">쿠폰선택</span></a>
							    			<div id="sCpnDtl_<?=$scontent->id?>" style="padding-left: 8px;line-height:180%;"></div>
							    		</td>
							    	</tr>	
							    	<?php endif; ?>
						    	<?php endforeach; ?>
						    </tbody>
						</table>
					</div>	
					<div class="row form-group">
						<div class="col-md-3 p-left-0" style="line-height: 32px">
							예치금 결제<span class="bold red1">(<?=number_format($user[0]->deposit)?>원)</span>
						</div>
						<div class="col-md-6">
							<a href="javascript:fnMaxPayPrice('1');" class="btn btn-warning btn-round btn-sm"><span>전액적용</span></a>
							<input type="text" class="" title="예치금" value="0" name="MemDpstMny" id="MemDpstMny" 
							onblur="fnNumChiperCom(this, '0');fnPayPrice();">원
							<input type="hidden" class="input_txt" title="예치금" 
							value="<?=$user[0]->deposit?>" name="MemDpstMnyMax" id="MemDpstMnyMax">
						</div>	
					</div>  
					<div class="row form-group">
						<div class="col-md-3  p-left-0" style="line-height: 32px">
							포인트 적용
							<span class="bold red1">(<?=number_format($user[0]->point)?>P)</span>
						</div>
						<div class="col-md-6">
							<a href="javascript:fnMaxPayPrice('2');" class="btn btn-warning btn-round btn-sm"><span>전액적용</span></a>
							<input type="hidden" class="input_txt" title="포인트" value="<?=$user[0]->point?>" name="MemPntMnyMax" id="MemPntMnyMax">
							<input type="text" class="input_txt" title="포인트" value="0" name="MemPntMny" id="MemPntMny" 
							onblur="fnNumChiperCom(this, '0');fnPayPrice();">P
						</div>
					</div> 
					<div class="row">
						<div class="col-xs-12  p-left-0  p-right-0">
							* 여러 건을 한꺼번에 결제하실 경우에는 해당 건을 모두 클릭해주시면 됩니다.</br>
							* 결제대기건의 경우 모든 포장, 배송비 계측이 마무리 된 것이므로 재포장이나 합배송/묶음배송이 불가능합니다.
						</div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="col-xs-12 text-center info-bank p-left-0  p-right-0">
							<?php if(!empty($bank)): ?>
							<span>무통장 입금계좌 : <?=$bank[0]->bank?>&nbsp;<?=$bank[0]->number?>&nbsp;<?=$bank[0]->name?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="row border">
						<div class="col-md-6 p-left-0">
							<div class="bscBox vm_box last_svc">
								<span class="bold black1 ft_15">결제수단 선택</span><br>
								<label style="padding:5px 0;" ><input type="radio" class="input_chk" name="OlnPmtCd" id="OlnPmtCd" value="4" checked=""> 무통장 입금</label><br>
								<label style="padding:5px 0;" ><input type="radio" class="input_chk " name="OlnPmtCd" id="OlnPmtCd" value="5" > 예치금 전액 결제</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="last_svc2_box">
								<span class="bold black1 ft_15">※ 총 결제금액</span><br>
								<p class="last_mny"><span class="bold" id="textReTotMny">0원</span></p>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 20px;">
						<div class="text-left">
							<input type="submit"  class="btn btn-warning btn-round accept" value="결제하기">	
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">결제내역상세</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
<script>
var gSubmit = true;
function fnPayPrice() {
	var ChkBox = document.getElementsByName("chkCHA_SEQ"); 
	var TotalMny = 0;
	var TotalMnyBf = 0;
	var MemDpstMnyVal = 0;

	if (ChkBox.length == undefined) {
			if (document.getElementsByName("chkCHA_SEQ").checked){
				TotalMnyBf = TotalMnyBf + Number($("#PMT_MNY_"+ChkBox.value).val());
				TotalMny   = TotalMny + Number($("#rPMT_MNY_"+ChkBox.value).val());
			}
	}
	else {
		for (var i = 0; i < (ChkBox.length); i++) {
			if (ChkBox[i].checked){
				TotalMnyBf = TotalMnyBf + Number($("#PMT_MNY_"+ChkBox[i].value).val()); 
				TotalMny   = TotalMny + Number($("#rPMT_MNY_"+ChkBox[i].value).val()); 
			} 
		}
	}
	TotalMny = parseInt(TotalMny);
	//결제 금액
	$("#TotMny").val(TotalMny);
	//document.getElementById("textTotMny").innerHTML = fnNumComma(TotalMnyBf)+"원";

	if (Number($("#MemDpstMny").val().replace(/,/g, "")) > Number($("#MemDpstMnyMax").val())){
		//alert("금액이 초과 되었습니다.");
		if ( Number($("#MemDpstMnyMax").val()) < 0 ) {
			$("#MemDpstMny").val("0");
		} else {
			$("#MemDpstMny").val( fnNumComma($("#MemDpstMnyMax").val()) );
		}
	}
	if (Number($("#MemPntMny").val().replace(/,/g, "")) > Number($("#MemPntMnyMax").val())){
		//alert("포인트가 초과 되었습니다.");
		if ( Number($("#MemPntMnyMax").val()) < 0 ) {
			$("#MemPntMny").val("0");
		} else {
			$("#MemPntMny").val( fnNumComma($("#MemPntMnyMax").val()) );
		}
	}

	//예치금 금액
	TotalMny = TotalMny - Number($("#MemDpstMny").val().replace(/,/g, ""));

	if (TotalMny < 0 ){
		//alert("금액이 초과 되었습니다.");
		TotalMny = TotalMny + Number($("#MemDpstMny").val().replace(/,/g, ""));
		$("#MemDpstMny").val( fnNumComma(TotalMny) );
		TotalMny = TotalMny - Number($("#MemDpstMny").val().replace(/,/g, ""));
		$("#MemPntMny").val("0");
	}
	//포인트 
	TotalMny = TotalMny - Number($("#MemPntMny").val().replace(/,/g, ""));
	if (TotalMny < 0 ){
		//alert("금액이 초과 되었습니다.");
		TotalMny = TotalMny + Number($("#MemPntMny").val().replace(/,/g, ""));
		$("#MemPntMny").val( fnNumComma(TotalMny) );
		TotalMny = TotalMny - Number($("#MemPntMny").val().replace(/,/g, "")); 
	}
	//온라인 결제 금액
	$("#OlnTotMny").val(TotalMny);
	document.getElementById("textReTotMny").innerHTML = "<strong>"+fnNumComma(TotalMny)+"</strong>원";

	if ( TotalMny == 0 && fnGetChkboxValue(document.frmPageInfo.chkCHA_SEQ) ) {
		$("#frmPageInfo input[name='OlnPmtCd']:radio[value='5']").prop("checked", true);
	}

} 

$("#frmPageInfo").submit(function (e) {
	e.preventDefault(e);
	//결제 쿠폰 갯수 가능 여부 
	var frmObj = "#frmPageInfo";
	var ChaVal = "";
	var ChaValCpn = "", ChaShotDlvr = "";
	var SubMitVal = ""; 
	var OlnPmtCd = "";

	if (fnSelBoxCnt($(frmObj + " input[name='chkCHA_SEQ']")) == "0") {
		alert('결제할 주문을 선택해 주세요.');
		return;
	}

	// 예치금 결제
	if ( $(frmObj + " input:radio[name='OlnPmtCd']:checked").val() == "5" && $("#OlnTotMny").val() * 1 > 0 ) {
		alert('결제 금액이 0원일때 가능한 결제입니다.');
		return;
	}

	if ( $(frmObj + " input:radio[name='OlnPmtCd']:checked").val() != "5" && $("#OlnTotMny").val() * 1 == 0 ) {
		alert('결제 금액이 0원입니다.0원 결제로 변경 바랍니다.');
		return;
	}

	// 무통장 선택 시
	if ( $(frmObj + " input:radio[name='OlnPmtCd']:checked").val() == "4" ) {
		if ( !confirm("무통장 입금을 진행하게 되면 한국 고객센터 운영시간에만 확인이 가능하여 결제확인이 늦어질 수 있습니다. 계속 진행하시겠습니까?") ) {
			return;
		}
	} else {
		if ( !confirm("결제를 진행하시겠습니까?") ) {
			return;
		}
	}

	if ( $(frmObj + " input[name='chkCHA_SEQ']").length == undefined ) {
		if ($(frmObj + " input[name='chkCHA_SEQ']").checked) {
			 ChaVal = $(frmObj + " input[name='chkCHA_SEQ']").value
			 ChaValCpn = $("#CPN_"+$(frmObj + " input[name='chkCHA_SEQ']").value).val();
			// 총알배송 옵션
			var fShotVal = $(frmObj + " input[name='SHOT_DLVR_" + $(frmObj + " input[name='chkCHA_SEQ']").value + "']:radio:checked").val();
			if ( fShotVal == undefined ) {
				ChaShotDlvr = "N|";
			} else {
				ChaShotDlvr = fShotVal+"|";
			}
		}
	} else {
		for(var i=0; i<$(frmObj + " input[name='chkCHA_SEQ']").length; i++) {
			if($(frmObj + " input[name='chkCHA_SEQ']")[i].checked) {
				ChaVal += $(frmObj + " input[name='chkCHA_SEQ']")[i].value + "|"; 
				ChaValCpn += $("#CPN_"+$(frmObj + " input[name='chkCHA_SEQ']")[i].value).val() + "|"; 
				// 총알배송 옵션
				var fShotVal = $(frmObj + " input[name='SHOT_DLVR_" + $(frmObj + " input[name='chkCHA_SEQ']")[i].value + "']:radio:checked").val();
				if ( fShotVal == undefined ) {
					ChaShotDlvr += "N|";
				} else {
					ChaShotDlvr += fShotVal+"|";
				}
			}
		}
		ChaVal = ChaVal.substring(0, ChaVal.length-1); 
		ChaValCpn = ChaValCpn.substring(0, ChaValCpn.length-1); 
		ChaShotDlvr = ChaShotDlvr.substring(0, ChaShotDlvr.length-1); 
	}

	OlnPmtCd = $(frmObj + " input:radio[name='OlnPmtCd']:checked" ).val();
	SubMitVal = "TotMny=" + $("#TotMny").val()
			  + "&OlnTotMny=" + $("#OlnTotMny").val()
			  + "&MemDpstMny=" + $("#MemDpstMny").val().replace(/,/g, "")
			  + "&MemPntMny=" + $("#MemPntMny").val().replace(/,/g, "")
			  + "&OlnPmtCd=" + OlnPmtCd
			  + "&ChaVal=" + ChaVal
			  + "&ChaValCpn=" + ChaValCpn
			  + "&ChaShotDlvr=" + ChaShotDlvr
			  + "&sKind=M";
	$("#seqOrd").val(ChaVal);		  
		var formData = new FormData(this);
		$.ajax({
		    async: true,
		    type: $(frmObj).attr('method'),
		    url: $(frmObj).attr('action'),
		    data: formData,
		    cache: false,
		    processData: false,
		    contentType: false,
		    dataType: "json",
		    success: function (data) {
		    	socket.emit("chat message",2,data.o,<?=$this->session->userdata('fuser')?>,data.p,"<?=$this->session->userdata('fname')?>");
		    	window.location.href="/payHistory";
		    	
		    },
		    error: function(request, status, error) {
		    	console.log(error);
		    }
		  }).always(function(jqXHR, textStatus) {
        	console.log(textStatus);  
        });
	});

function fnCpnSel(val){
	var CpnCnt = 0;
	var aCpnChk = "";
	var aCpnExt = "";
	var aCpnCode = "";
	var ChkBox = document.getElementsByName("chkCHA_SEQ"); 

	if (ChkBox.length == undefined) {
		document.getElementsByName("chkCHA_SEQ").checked = true;
	}
	else {
		for (var i = 0; i < ( ChkBox.length ); i++) {
			if ( ChkBox[i].value == val ){
				document.getElementsByName("chkCHA_SEQ")[i].checked = true;
			}
		}
	}

	// 쿠폰 카운트
	if ( $("#aCPN").val() != "" ) CpnCnt = $("#aCPN").val().split(",").length;
	else CpnCnt = 0;
	if (CpnCnt > 0) {
			aCpnCode = $("#aCPN").val();
			aCpnChk  = $("#CPN_" + val).val();

			fnPaySale(); 
			window.open('./couponSet?CHA_SEQ='+val+'&aCpnCode='+aCpnCode+"&aCpnChk="+aCpnChk, 'mypopup2', 'width=800, height=450, scrollbars=yes');
  
	}else{
			$("#aCPN").val($("#aCPN").val().replace(/,/g, ",")); 
			fnPaySale(); 
			window.open('./couponSet?CHA_SEQ='+val+'&aCpnCode='+$("#aCPN").val(), 'mypopup2', 'width=800, height=450, scrollbars=yes');
 
	}
}
function fnPaySale(){
 
	var ChkBox = document.getElementsByName("chkCHA_SEQ"); 
	var TotalMny = 0;
	if (ChkBox.length == undefined) {
		document.getElementById("textPmtMny_"+ChkBox.value).innerHTML = fnNumComma($("#rPMT_MNY_"+ChkBox.value).val())+"원"; 
	}
	else {
		for (var i = 0; i < (ChkBox.length); i++) { 
			document.getElementById("textPmtMny_"+ChkBox[i].value).innerHTML = fnNumComma($("#rPMT_MNY_"+ChkBox[i].value).val())+"원"; 
		}
	} 
	fnPayPrice();
} 

function fnCpnCnl(val1, val2){
	var aCpnCode = "";
	var aChkValue = "";
	var sTextVal = "";
	var sCpnTyCnt = 7;
	var fCpnAll = $("#aCPN");
	var fCpnCodeDel = $("#CPN_" + val1 + "_" + val2).val().split("|")[0];

	fCpnAll.val(fCpnAll.val().replace( fCpnCodeDel + ",", "" ));
	fCpnAll.val(fCpnAll.val().replace( "," + fCpnCodeDel, "" ));
	fCpnAll.val(fCpnAll.val().replace( fCpnCodeDel, ""));

	$("#CPN_" + val1 + "_" + val2).val("");

	for ( var i = 1; i <= sCpnTyCnt; i++) {
		if ( parseInt(val1) != i && $("#CPN_" + i + "_" + val2).val() != "" ) {
			aChkValue = $("#CPN_" + i + "_" + val2).val().split("|");
			aCpnCode += aChkValue[0] +",";
			sTextVal += aChkValue[3] + " : "+aChkValue[0]+" &nbsp;&nbsp; "+aChkValue[2] + " &nbsp;&nbsp; [<a href=\"javascript:fnCpnCnl('"+aChkValue[1]+"','"+val2+"');\" style='color:#ff3300'>취소</a>]<br />";
		}
	}

	aCpnCode = aCpnCode.substring(0, aCpnCode.length-1);

	$("#CPN_" + val2).val(aCpnCode);
	document.getElementById("sCpnDtl_"+val2).innerHTML = sTextVal;
	fnShotDlvr(val2,"no");
} 
function fnShotDlvr(ChaSeq,check="ok") {
	var aCpnCode = "";
	var aChkValue = "";
	var sTextVal = "";
	var sCpnTyCnt = 7;
	var fCpnAll = $("#aCPN"), fProAmt = $("#frmPageInfo input[name='PRO_AMT_" + ChaSeq + "']").val();

	// 총알배송 제한 체크
	if ( $("#frmPageInfo input[name='SHOT_DLVR_" + ChaSeq + "']:radio:checked").val() == "Y" ) {
		// 총구매금액 $120 제한
		if ( Number(fProAmt) >= 120 ) {
			alert("총알배송은 총 구매금액이 ＄120 미만이어야 가능합니다.");
			$("#frmPageInfo input[name='SHOT_DLVR_" + ChaSeq + "']:radio[value='N']").prop("checked", true);
			return;
		}
		if ( $("#frmPageInfo input[name='CTMS_YN_" + ChaSeq + "']").val() != "N" ) {
			alert("총알배송은 목록통관만 가능합니다.");
			$("#frmPageInfo input[name='SHOT_DLVR_" + ChaSeq + "']:radio[value='N']").prop("checked", true);
			return;
		}
		if ( $("#frmPageInfo input[name='ADDR_1_" + ChaSeq + "']").val() != "서울" ) {
			alert("총알배송은 수령지가 서울특별시만 가능합니다.");
			$("#frmPageInfo input[name='SHOT_DLVR_" + ChaSeq + "']:radio[value='N']").prop("checked", true);
			return;
		}
	}

	aCpnCode = $("#frmPageInfo input[name='CPN_" + ChaSeq + "']").val();

	if ( $("#frmPageInfo input[name='SHOT_DLVR_" + ChaSeq + "']:radio:checked").val() == "Y" ) {
		$("#frmPageInfo input[name='chkCHA_SEQ']").each( function(idx) {
			if ( $(this).val() == ChaSeq ) {
				$(this).prop("checked", true);
			}
		});
	}
	var aUrl = "?aCpnCode=" + aCpnCode	
			 + "&sCHA_SEQ=" + ChaSeq
			 + "&sSHOT_DLVR_YN=" + $("#frmPageInfo input[name='SHOT_DLVR_" + ChaSeq + "']:radio:checked").val();

	fnGetChgHtmlAjax("HiddenSaleMny_"+ChaSeq, "/Pay_Sale", aUrl);
	fnPaySale();
}
function fnReSaleMnyAjax(val1, val2){
	fnShotDlvr(val2);
}
function fnMaxPayPrice(val){
	if (val == "1" ){
		if ( Number($("#MemDpstMnyMax").val()) < 0 ) {
			alert("예치금이 마이너스입니다. 예치금 충전 후 이용하시기 바랍니다.");
			return;
		}
		$("#MemDpstMny").val( fnNumComma($("#MemDpstMnyMax").val()) );
	}else{
		if ( Number($("#MemPntMnyMax").val()) < 0 ) {
			alert("포인트가 마이너스입니다. 이용이 불가합니다.");
			return;
		}
		$("#MemPntMny").val( fnNumComma($("#MemPntMnyMax").val()) ); 
	}
	fnPayPrice();
}
function fnChaView(id){

	jQuery.ajax({
		type : "POST",
		url : baseURL+"getDelivery",
		data : { delivery_id : id } 
		}).done(function(data){
			$("#details_modal").modal("show");
			$("#details_modal .modal-body").html(data);
	});
}
</script>