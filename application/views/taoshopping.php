<div class="container-fluid">
	<div class="c-slider swiper-container-banner swiper-container">
	  	<div class="swiper-wrapper">
		<?php $banner_info = getBanners(23,0); ?>
		<?php foreach ($banner_info as $key => $value): ?>
	    <div class="swiper-slide">
	    	<a href="<?=$value->link?>" target="<?=$value->target==1 ? "_self" : "_blink"?>" title="<?=$value->title?>">
	    		<img src="<?=base_url()?>upload/homepage/banner/<?=$value->image?>" alt="<?=$value->description?>"/>
	    	</a>
	    </div>
	    <? endforeach; ?>
	  	</div>
	    <div class="swiper-button-next"></div>
	    <div class="swiper-button-prev"></div>
	</div>
	<div class="container" style="position: relative;">
		<div class="favorite_lists">
			<div class="best_p my-15">
				<div>
					<a href="<?=base_url()?>shopping?txt-category=best" target="_blink" title="베스트 상품"><h2 class="fav_h">베스트 상품</h2></a>
					<div class="best-line lines"></div>
				</div>
				<div>
					<ul>
						<?php if(!empty($best_products)): ?>
						<?php foreach($best_products as $key => $value):?>
						<li>
							<div>
								<?php if($key ==0): ?>
								<div class="best_part0">
					              	<div class="best_title">
						                <p>FOR YOUR</p>
						                <p>SPECIAL</p>
						                <p>GIFT</p>
					              	</div>
					              	<div class="best_small_title">
						                <p>특별한 선물 포장상자</p>
						                <p>기프트 블록</p>
					              	</div>
					            </div>	
								<?php endif; ?>
								<?php if($key ==1): ?>
								<div class="best_part1">
					              	<div class="best_title">
						                <p>BEST</p>
						                <p>PICK</p>
					             	</div>
					            </div>	
								<?php endif; ?>
								<div class="item_thumb">
									<a href="/view/shop_products/<?=$value->rid?>" title="<?=$value->name?>">
						          		<img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" width="250" alt="<?=$value->name?>">
						          	</a>	
					          	</div>
							</div>
						</li>
						<?php endforeach;?>
						<?php endif;?>
					</ul>
				</div>
			</div>
			<div class="rec_p">
				<div>
					<a href="<?=base_url()?>shopping?txt-category=rec" target="_blink" title="추천상품"><h2 class="fav_h">추천상품</h2></a>
					<div class="rec-line lines"></div>
				</div>
				<div class="se_item_list my-10">
					<div class="item_list item_box_5">
						<div class="layout_fix">
							<ul class="ul">
							<?php if(!empty($rec_products)): ?>
							<?php foreach($rec_products as $value):?>
								<li class="li">
									<div class="item_box noslide addon_quick_view m-l-0">
        
							          	<div class="item_thumb">
								            <a href="/view/shop_products/<?=$value->rid?>" class="quick_view" title="<?=$value->name?>">
								            	<img class="lazy" data-original="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" 
								            	height="220" alt="<?=$value->name?>">
								            </a>
							          	</div>   
							          	<div class="details">
								            <div class="parts_pt ellipsis">
								              <p><?=$value->name?></p>
								            </div>
								            <div><span class="font-weight-bold"><?=number_format($value->singo)?></span>원</div>
								            <div class="parts_count"><span class="font-weight-bold"><?=$value->count?></span> x</div>
							          	</div>
							          	<span class="upper_icon">
								          	<?php $p_icon = explode(",", $value->p_icon); ?>
								          	<?php if(sizeof($p_icon) > 0):?>
								          	<?php foreach($p_icon as $i_value): ?>
								          		<?php if(!empty($icons[$i_value])):?>
								          			<img src="/upload/Products/icon/<?=$icons[$i_value]?>">
								          		<?php endif;?>
								          	<?php endforeach; ?>	
								          	<?php endif;?>
							          	</span>
							      </div>
								</li>
							<?php endforeach;?>
							<?php endif; ?>	
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="new_p">
				<div>
					<a href="<?=base_url()?>shopping?txt-category=new" target="_blink" title="신상품"><h2 class="fav_h">신상품</h2></a>
					<div class="new-line lines"></div>
				</div>
				<div class="se_item_list my-10">
					<div class="item_list item_box_5">
						<div class="layout_fix">
							<ul class="ul">
							<?php if(!empty($new_products)): ?>
							<?php foreach($new_products as $value):?>
								<li class="li">
									<div class="item_box noslide addon_quick_view m-l-0">
        
							          	<div class="item_thumb">
								            <a href="/view/shop_products/<?=$value->rid?>" class="quick_view" title="<?=$value->name?>">
								            	<img class="lazy" data-original="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" 
								            	height="220" alt="<?=$value->name?>">
								            </a>
							          	</div>   
							          	<div class="details">
								            <div class="parts_pt ellipsis">
								              <p><?=$value->name?></p>
								            </div>
								            <div><span class="font-weight-bold"><?=number_format($value->singo)?></span>원</div>
								            <div class="parts_count"><span class="font-weight-bold"><?=$value->count?></span> x</div>
							          	</div>
							          	<span class="upper_icon">
								          	<?php $p_icon = explode(",", $value->p_icon); ?>
								          	<?php if(sizeof($p_icon) > 0):?>
								          	<?php foreach($p_icon as $i_value): ?>
								          		<?php if(!empty($icons[$i_value])):?>
								          			<img src="/upload/Products/icon/<?=$icons[$i_value]?>">
								          		<?php endif;?>
								          	<?php endforeach; ?>	
								          	<?php endif;?>
							          	</span>
							      </div>
								</li>
							<?php endforeach;?>
							<?php endif; ?>	
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="cheap_p">
				<div>
					<a href="<?=base_url()?>shopping?txt-category=low" target="_blink" title="싸다"><h2 class="fav_h">싸다</h2></a>
					<div class="cheap-line lines"></div>
				</div>
				<div class="se_item_list my-10">
					<div class="item_list item_box_5">
						<div class="layout_fix">
							<ul class="ul">
							<?php if(!empty($cheap_products)): ?>
							<?php foreach($cheap_products as $value):?>
								<li class="li">
									<div class="item_box noslide addon_quick_view m-l-0">
        
							          	<div class="item_thumb">
								            <a href="/view/shop_products/<?=$value->rid?>" class="quick_view" title="<?=$value->name?>">
								            	<img class="lazy" data-original="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" 
								            	height="220" alt="<?=$value->name?>">
								            </a>
							          	</div>   
							          	<div class="details">
								            <div class="parts_pt ellipsis">
								              <p><?=$value->name?></p>
								            </div>
								            <div><span class="font-weight-bold"><?=number_format($value->singo)?></span>원</div>
								            <div class="parts_count"><span class="font-weight-bold"><?=$value->count?></span> x</div>
							          	</div>
							          	<span class="upper_icon">
								          	<?php $p_icon = explode(",", $value->p_icon); ?>
								          	<?php if(sizeof($p_icon) > 0):?>
								          	<?php foreach($p_icon as $i_value): ?>
								          		<?php if(!empty($icons[$i_value])):?>
								          			<img src="/upload/Products/icon/<?=$icons[$i_value]?>">
								          		<?php endif;?>
								          	<?php endforeach; ?>	
								          	<?php endif;?>
							          	</span>
							      </div>
								</li>
							<?php endforeach;?>
							<?php endif; ?>	
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="wow_p">
				<div>
					<a href="<?=base_url()?>shopping?txt-category=low" target="_blink" title="멋지다"><h2 class="fav_h">멋지다</h2></a>
					<div class="wow-line lines"></div>
				</div>
				<div class="se_item_list my-10">
					<div class="item_list item_box_5">
						<div class="layout_fix">
							<ul class="ul">
							<?php if(!empty($wow_products)): ?>
							<?php foreach($wow_products as $value):?>
								<li class="li">
									<div class="item_box noslide addon_quick_view m-l-0">
        
							          	<div class="item_thumb">
								            <a href="/view/shop_products/<?=$value->rid?>" class="quick_view" title="<?=$value->name?>">
								            	<img class="lazy" data-original="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" 
								            	height="220" alt="<?=$value->name?>">
								            </a>
							          	</div>   
							          	<div class="details">
								            <div class="parts_pt ellipsis">
								              <p><?=$value->name?></p>
								            </div>
								            <div><span class="font-weight-bold"><?=number_format($value->singo)?></span>원</div>
								            <div class="parts_count"><span class="font-weight-bold"><?=$value->count?></span> x</div>
							          	</div>
							          	<span class="upper_icon">
								          	<?php $p_icon = explode(",", $value->p_icon); ?>
								          	<?php if(sizeof($p_icon) > 0):?>
								          	<?php foreach($p_icon as $i_value): ?>
								          		<?php if(!empty($icons[$i_value])):?>
								          			<img src="/upload/Products/icon/<?=$icons[$i_value]?>">
								          		<?php endif;?>
								          	<?php endforeach; ?>	
								          	<?php endif;?>
							          	</span>
							      </div>
								</li>
							<?php endforeach;?>
							<?php endif; ?>	
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="floating3" style="position: absolute; z-index: 10;"> 
      <!--오늘본상품-->
	 <div id="QiuckMenu">
	  <ul>
	    <?php 
	    $shop_parameter = 24;
	    $shop_image_folder = "banner";
	    ?>
	    <?php $rights = getBanners($shop_parameter); ?>
	   	<?php foreach($rights as $value): ?>
	      <?php 
	          $ss= explode("func-", $value->link);
	          if(sizeof($ss) > 1) $link = "javascript:".$ss[1];
	          else $link = $value->link;
	        ?>
	    <li style="<?=$value->mt > 0 ? "margin-top:".$value->mt."px;":""?> <?=$value->mb > 0 ? "margin-bottom:".$value->mb."px;":""?>">
	      <a href="<?=$link?>" target="<?=$value->target==2 ? "_blink":"_self"?>">
	        <img width="90" src="/upload/homepage/<?=$shop_image_folder?>/<?=$value->image?>" data-src="/upload/homepage/<?=$shop_image_folder?>/<?=$value->image?>" 
	        data-src1="/upload/homepage/<?=$shop_image_folder?>/<?=$value->image1?>" class="hover_img">
	      </a>
	    </li>
	    <?php endforeach; ?>
	  </ul>
	 </div>
	</div>
	</div>
	</div>
<script>
	$("img.lazy").lazyload();
</script>
<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/tao.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/assets/plugins/swiper/swiper.min.css'); ?>" rel="stylesheet">
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/assets/plugins/swiper/swiper.min.js')?>"></script>
<script src="<?php echo site_url('/template/js/main_shop.js')?>?<?=time()?>"></script>