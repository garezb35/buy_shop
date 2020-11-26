<?php 
$img  ="";
$i1 = $value->i1!="" ? "upload/shoppingmal/".$value->id."/".$value->i1:"";
?>
<a href="/view/shop_products/<?=$value->rid?>">
	<div class="product_list p-5">
		<div class="product_img">
			<img src="<?=base_url_home().$i1?>">
		</div>
		<div class="product_content mid p-left-10">
			<div class="details">
				<p><?=$value->name?></p>
				<div>
					<span class="text-gray"><del><?=number_format($value->singo*$accuringRate->rate)?>원</del></span>
					<span class='text-green font-weight-bold ml-15'><?=number_format(($value->orgprice+$value->addprice)*$accuringRate->rate)?>원</span>
				</div>
			</div>
		</div>
	</div>
</a>