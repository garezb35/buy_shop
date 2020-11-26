<? $site = $pageTitle; ?>
<div class="container">
	<?php 
	$data['category'] = $category;
	$data['tt'] = 1;
	?>
	<?php $this->load->view("shop_header",$data); ?>
	<div id="subRight">
		<div class="row shoplist">
			<div class="product_list_content">
					<?php if(!empty($products)): ?>
					<?php foreach($products as $shop_list): ?>
				    <?php $data['value']  = $shop_list; ?>
				    <?php $data['accuringRate'] = $accuringRate; ?>
				    <?php $this->load->view("product_list",$data); ?>
				    <?php endforeach; ?>
					<?php endif; ?>
		    </div>
		    <div class="more_btn">
		      <a href="javascript:void(0)" class="btn -1 w-100 clickmore" onclick="clickMore($(this))">+ 더보기</a>
		    </div>
			<!-- <div class="col-xs-6 col-md-3 p-5">
				<a href="/view/shop_products/<?=$value->rid?>?category=<?=$this->input->get("category")?>">
					<div class="border">
						<div class="text-center">
							<img src="<?=base_url_home()?>upload/shoppingmal/<?=$value->id?>/<?=$value->i1?>" height=130 width="100%">	
						</div>
						<div class="title_part p-5">
							<p class="name">[<?=$site?>]<?=$value->name?></p>
							<p class="price">
				              	<span class="mr-1">
				                	<del><?=number_format($value->singo*$accuringRate->rate)?>원</del>
				              	</span>
				              	<span><?=number_format(($value->orgprice+$value->addprice)*$accuringRate->rate)?>원</span>
			            	</p>
						</div>
					</div>
				</a>
			</div -->
			
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/shop.css');?>" rel="stylesheet">
<script>
	var lp = <?=$sizes?>;
	var hitURL = baseURL+"getShopProducts";
	var site = "<?=$site?>";
	var rate = <?=$accuringRate->rate?>;
	var home = "<?=base_url_home()?>";
	var o_type = "<?=$o_type?>";
	var category = "<?=$this->input->get("category")?>";
</script>