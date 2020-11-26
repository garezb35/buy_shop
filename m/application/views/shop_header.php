<?php $s=""; ?>
<div class="bg-white">
	<div class="shop_header p-5 bg-green">
		<div class="row">
			<div class="col-xs-12 text-center p-1">
				<img src="/template/images/back.png" class="back_btn" width="18px" onclick="history.back();">
				<span class="parts1 text-white">쇼핑몰</span>
			</div>
		</div>
	</div>
	<!-- <div class="category_part"> -->
		<!-- <ul class="nav-shop">
			<li class="shop-item"><a href="#">카테고리</a></li>
			<?php if(!empty($category)): ?>
			<?php foreach($category as $vv): ?>
			<li class="shop-item"><a href="/shopping?category=<?=$vv->id?>"><span class="border-l 
				<?php if($this->input->get("category")==$vv->id) {echo "text-yellow";$s = $vv->name;}?>"><?=$vv->name?></span></a></li>
			<?php endforeach; ?>
			<?php endif; ?>
		</ul> -->


	<div class="row p-3">
		<div class="col-xs-6 p-3" style="padding-top: 0px !important">
			<a href="/shopping" class="btn <?=$tt==1 || $tt==3? "btn-green-2":"btn-green-1"?>   w-100">진행중인 쇼핑몰</a>
		</div>
		<div class="col-xs-6 p-3" style="padding-top: 0px !important">
			<a href="/mybasket" class="btn <?=$tt==1 || $tt==3 ? "btn-green-1":"btn-green-2"?>  w-100">장바구니 내역</a>
		</div>
	</div>
	<?php if(!isset($t) || $t != 1): ?>
	<div class="row">
		<div class="col-xs-12 p-3">
			<select class="shop_cate_list form-control">
			  	<option value="">전체</option>
			  	<?php if(!empty($category)): ?>
			  	<?php foreach($category as $vv): ?>
			  	<option value="<?=$vv->id?>" <?php if($this->input->get("category")==$vv->id) {echo "selected";}?>><?=$vv->name?></option>
			  	<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
	</div>
	<?php endif;?>
</div>

<!-- <script src="<?php echo site_url('/template/js/select2.min.js') ?>"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo site_url('/template/css/select2.min.css') ?>"> -->
<script>
	$('.shop_cate_list').on("change", function (e) {
		location.href="/shopping?category="+this.value;
	});;
</script>