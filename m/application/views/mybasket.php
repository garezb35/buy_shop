<? $site = $pageTitle; ?>
<div class="container">
	<?php 
	$data['category'] = $category;
	$data['tt'] = 2;
	$data['t'] = 1;?>
	<?php $this->load->view("shop_header",$data); ?>
<div class="container">
	<div id="subRight" >
		<div class="con">
			<form action="/makeorder" method="post">
				<div class="t_board mt20 p-5">
					<div>
						<table class="table table-dark">
						    <thead class="thead-jin">
						      <tr>
						        <th scope="col">상품명/브랜드</th>
						        <th></th>
						      </tr>
						    </thead>
						    <tbody>
						    	<?php if(!empty($mybasket)): ?>
						    		<?php foreach($mybasket as $value): ?>
						    			<tr class="border-b">
						    				<td class="mid">
						    					<input type="checkbox" name="basket[]" value="<?=$value->id?>" class="basket">
						    					<a href="/view/shop_products/<?=$value->rid?>">
						    						<img src="<?=base_url_home()?>upload/shoppingmal/<?=$value->productId?>/<?=$value->i1?>" width="100" height="100">
						    					</a>
						    				</td>
						    				<td class="mid">
						    					<a href="/view/shop_products/<?=$value->rid?>">
						    						<?=$value->name?>
						    					</a>
						    					<span style="color: #ff6633;"><?=$value->color?></span>/ 
						    					<span style="color: #ff6633;"><?=$value->size?></span>
						    					<div>
						    						<span class="mt-5 text-danger"  id="pid<?=$value->id?>"><?=number_format($accuringRate->rate*$value->Price*$value->count)?>원</span>
						    						/<input type="number" class="form-control ml-5" value="<?=$value->count?>" 
							    					onchange="changeShopCount('<?=$value->Price?>','<?=$value->id?>',$(this).val())" 
							    					style="width: 63px;height: 23px;line-height: 23px;display: initial;">
						    					</div>
						    					<a class="btn btn-danger my-4 btn-round" href="javascript:deleteBasket(<?=$value->id?>)" data-id="<?php echo $value->id; ?>">삭제</a>
						    				</td>
						    			</tr>
						    		<?php endforeach; ?>
						    	<?php endif; ?>
						    </tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 p-5 pt-0">
						<input type="button" value="전체 선택" class="btn btn-danger all btn-round">
						<input type="submit" value="주문하기" class="btn btn-warning btn-round">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/shop.css');?>" rel="stylesheet">
<script type="text/javascript">
	var acc  = <?=!empty($accrate_default) ? $accrate_default[0]->rate : 1 ?>;
	function changeShopCount(price,id,count){
		if(count <= 0){
			alert("수량은 0보다 작을수 없습니다.");
			return false;
		}
		DoCallbackCommon("/changeShopCount?id="+id+"&count="+count);
		$("#pid"+id).text(number_format(price*count*acc)+'원');
	}
	$(".all").click(function(){
		var checked_status = true;
	    $("input[class='basket']").each(function(){
	        this.checked = checked_status;
	      });
	});

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
</script>
<style type="text/css">
	.table{
		margin-bottom: 0px
	}
</style>