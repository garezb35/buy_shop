<?php 
$class = array();
$class[0]="";
$class[1]="";
$class[2]="";
$last_item = $selected_name;
if(!empty($breads_name)){
	$class[sizeof($breads_name)-1] = "active";
}

else{
	if($this->input->get("txt-category") =="best"){
		$last_item = "베스트상품";
	}
	if($this->input->get("txt-category") =="rec"){
		$last_item = "추천상품";
	}
	if($this->input->get("txt-category") =="new"){
		$last_item = "신상품";
	}
	if($this->input->get("txt-category") =="low"){
		$last_item = "싸다";
	}
	if($this->input->get("txt-category") =="wow"){
		$last_item = "멋지다";
	}

}

?>
<div class="container">
	<div class="row">
		<div id="subRight" class="col-md-12">
			<div>
			    <ol class="breadcrumb breadcrumb-arrow">
					<?php if(!empty($breads_name)): ?>
					<?php foreach($breads_name as $key=>$value):?>
					<li class="<?=$class[$key]?>">
					<?php if($key ==sizeof($breads_name)-1): ?><span><?=$value?></span><?php endif ;?>
					<?php if($key !=sizeof($breads_name)-1): ?><a href="/shopping?txt-category=<?=$breads[$key]?>"><?=$value?></a><?php endif ;?>
					</li>						
					<?php endforeach;?>
					<?php endif; ?>
					<?php if(empty($breads_name)): ?>
						<li class="active"><span  class="font-weight-bold"><?=$last_item?></span></li>
					<?php endif; ?>
				</ol>
			</div>
			<div class="con">
				<div class="t_board">
					<div class="se_item_list">
					    <div class="item_list item_box_5">
					      	<div class="layout_fix clearfix">
					        	<ul class="ul" id="content_products">
					        		
					        	</ul>
					        </div>
					    </div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>

<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<script id="shopping-lists" type="text/x-handlebars-template">
    {{#each  product_list}}
    <li class="li">
      <div class="item_box noslide addon_quick_view {{if_first_last @index}}">
        {{#if_eq count}}<span class="soldout"><img src="/assets/images/ic_soldout.png" alt="품절"></span>{{/if_eq}}
          <div class="item_thumb">
            <a href="/view/shop_products/{{rid}}" class="quick_view" title="{{name}}">
            	<img class="lazy" data-original = "/upload/shoppingmal/{{id}}/{{image}}" height="220" title="{{name}}">
            </a>
          </div>   
          <div class="details">
            <div class="parts_pt ellipsis">
              <p>{{name}}</p>
            </div>
            <div><p>{{accurate singo}}원</p></div>
            <div class="parts_count">{{count}} x</div>
          </div>
          {{#length_of_array icons}}
          <span class="upper_icon">
          	{{#each icons}}
          	<img src="/upload/Products/icon/{{this}}">
          	{{/each}}
          </span>
          {{/length_of_array}}
      </div>
    </li>
    {{/each}}
</script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script>
	init1_limit = <?=!isset($limit1) ? 20:$limit1?>;
	init2_limit = <?=!isset($limit2) ? 0:$limit2?>;
	var category_name = "<?=$this->input->get("txt-category")?>";
	var content_name = "<?=$this->input->get("txt-search")?>";
	var all = <?=$records_count?>;
	$(document).ready(function(){
		loadProducts("list","<?=!isset($limit1) ? "":$limit1?>","<?=!isset($limit2) ? "" : $limit2?>",category_name,content_name,20);
		 $(window).scroll(function(){
		 	if(product_loaded ==0) return;
		  var position = $(window).scrollTop();
		  var bottom = $(document).height() - $(window).height();

		  if( position == bottom ){
		  	if(init2_limit >= all) return ;
		  	loadProducts("list",init1_limit,init2_limit,category_name,content_name,20);
		  }

		 });	
	});
</script>