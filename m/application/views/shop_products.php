 <link href="<?php echo site_url('/template/css/slick-theme.css'); ?>" rel="stylesheet">
 <link href="<?php echo site_url('/template/css/slick.css'); ?>" rel="stylesheet">
<?php 
if(sizeof($product)) $uf = $product[0];
else return;
$i1 = $uf->i1!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i1:"";
$i2 = $uf->i2!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i2:"";
$i3 = $uf->i3!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i3:"";
$i4 = $uf->i4!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i4:"";
$i5 = $uf->i5!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i5:"";

?>
<? $site = getSiteName(); ?>
<div class="container">
	<?php 
	$data['category'] = $category;
	$data['tt'] = 3;
	$data['t'] = 1;?>
	<?php $this->load->view("shop_header",$data); ?>
<div class="container">
	<div id="subRight">
		<div class="con">
			<main class="pt-4">
			    <div class="dark-grey-text">

			      <!--Grid row-->
			      <div class="row wow fadeIn">

			        <!--Grid column-->
			        <div class="col-md-6 mb-4">
			        	<div class="slicks">
			        		<?php if($i1!=""): ?>
			        		<div>
				        		<img src="<?=base_url_home()?><?=$i1?>" class="img-fluid" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i2!=""): ?>
		        			<div>
				        		<img src="<?=base_url_home()?><?=$i2?>" class="img-fluid" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i3!=""): ?>
			        		<div>
				        		<img src="<?=base_url_home()?><?=$i3?>" class="img-fluid" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i4!=""): ?>
			        		<div>
				        		<img src="<?=base_url_home()?><?=$i4?>" class="img-fluid" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i5!=""): ?>
			        		<div>
				        		<img src="<?=base_url_home()?><?=$i5?>" class="img-fluid" alt="">
				        	</div>
			        		<?php endif; ?>
			        	</div>
			        	<div class="slider-nav">
			        		<?php if($i1!=""): ?>
			        		<div >
				        		<img src="<?=base_url_home()?><?=$i1?>" class="img-fluid w-100" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i2!=""): ?>
		        			<div >
				        		<img src="<?=base_url_home()?><?=$i2?>" class="img-fluid w-100" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i3!=""): ?>
			        		<div >
				        		<img src="<?=base_url_home()?><?=$i3?>" class="img-fluid w-100" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i4!=""): ?>
			        		<div >
				        		<img src="<?=base_url_home()?><?=$i4?>" class="img-fluid w-100" alt="">
				        	</div>
			        		<?php endif; ?>
			        		<?php if($i5!=""): ?>
			        		<div >
				        		<img src="<?=base_url_home()?><?=$i5?>" class="img-fluid w-100" alt="">
				        	</div>
			        		<?php endif; ?>
			        	</div>
			        </div>
			        <!--Grid column-->

			        <!--Grid column-->
			        <div class="col-md-6 mb-4">
			        	<div>
			        		<h3 class="product-title"><?=$uf->name?></h3>
					          <!--Content-->
					        <div class="p-4">
					            <p class="lead_qw">
					            	<label style="width: 90px;" class="m-0 mb-15">상품가격</label>
						            <span class="mr-1">
						                <del><?=number_format($uf->singo*$accuringRate->rate)?>원</del>
						            </span>
					              	<span><strong class="text-danger"><?=number_format(($uf->orgprice+$uf->addprice)*$accuringRate->rate)?>원</strong></span>
					            </p>
					            <div class="border-bottom"></div>
					            <p class="lead_qw">
					            	<label style="width: 90px;" class="m-0 mt-15 mb-15">적립포인트</label>&nbsp;<span class="h5 font-weight-bold"><?=$uf->point?></span>P
					            </p>
					            <?php if(!empty($options)): ?>
					            	<div class="border-bottom mb-15"></div>
					            	<?php foreach($options as $values): ?>
					            	<h5 class="sizes" style="margin-top: 0px"><label style="width: 90px;" class="m-0"><?=$values->name?></label>
						            	<?php $colors = explode("|", $values->key) ?>
						            	<select class="options input-txt2" data-v = "<?=$values->name?>">
						            		<option value="">-선택-</option>
						            	<?php foreach( $colors as $vc): ?>
						            		<?php if(empty($vc)) continue; ?>
											<option value="<?=$vc?>"><?=$vc?></option>
										<?php endforeach; ?>
										</select>
									</h5>
					            	<?php endforeach; ?>
					            <?php endif; ?>
					            <span class="hide color"></span>
					            <span class="hide size"></span>
								<?php if(!empty($this->session->userdata('fuser')) && $this->session->userdata('fuser') > 0 ): ?>
									<div class="border-bottom"></div>
									<form class="d-flex mt-15 mb-15">
						              <input type="number" value="1" aria-label="Search" class="form-control input-sm" style="width: 150px;height: 35px;" id="card_num">
						              <a href="javascript:void(0)" class="btn btn-sm btn-warning btn-sm btn-round ml-15"  onclick="javascript:changeShopCount('<?=$uf->orgprice+$uf->addprice?>','<?=$uf->id?>',$('#card_num').val());" style="margin-top: 0px;font-size: 1.2rem;line-height: 23px">장바구니에 추가
						                <i class="fa fa-shopping-cart"></i>
						              </a>
						            </form>
						            <div class="border-bottom"></div>
								<?php endif; ?>
					          </div>
			        	</div>
			        	
			          <!--Content-->

			        </div>
			        <!--Grid column-->
			      </div>
			      <!--Grid row-->
			      <div class="row mt-5">
			      	<div class="col-md-12 img100">
			            <p><?=$uf->description?></p>
			      	</div>
			      </div>
			      <div class="row mt-5">
			      	<div class="col-xs-12">
			      		<p class="recommend_title">추천상품</p>
			      	</div>
			      </div>
			      <div class="row mt-5">
			      	<?php if(!empty($recommentProducts)): ?>
			      	<div class="col-xs-12 part-slick-recommend">
			      	<?php foreach($recommentProducts as $v): ?>
			      		<a href="/view/shop_products/<?=$v->rid?>" class="slick-slide" style="position: relative;">
		                    <img src="<?=base_url_home()?>/upload/shoppingmal/<?=$v->id?>/<?=$v->i1?>" style ="height: 100px;object-fit: cover;">
		                    <div class="title_P"></div>
		                    <div style="display: table; width: 100%;height: 100%;top: 0;position: absolute;z-index: 1200">
		                    	<p class="text-center title_ff"><?=$v->name?></p></div>
		                </a>
			      	<?php endforeach; ?>
			      	</div>
			      	<?php endif; ?>
			      </div>
			      <!--Grid row-->
			    </div>
			  </main>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/shop.css');?>" rel="stylesheet">
<script type="text/javascript">
	function changeShopCount(price,id,count){
		if(count <=0 ){alert("수량은 0보다 작을수 없습니다.");return;}
		var size = $(".size").text();
		var color = $(".color").text();
		jQuery.ajax({
          method: "POST",
          url: baseURL+"addCar",   
          data: {id:id,count:count,size:size,color:color}
        })
          .done(function( msg ) {
            if(msg == 3) 
          		alert('옵션을 선택해주세요');
          	if(msg == 2) 
          		alert('상품이 존재하지 않습니다.');	
          	if(msg ==1 )
            	alert("장바구니에 추가되였습니다");
            if(msg ==5 )
            	alert("이미 장바구니에 추가된 상품입니다.");
          });
	}

	 $('.slicks').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
	  slidesToShow: 5,
	  slidesToScroll: 1,
	  asNavFor: '.slicks',
	  centerMode: true,
	  focusOnSelect: true
	});
	$( ".options" ).change(function() {
		if($(this).data("v")=="크기" || $(this).data("v")=="사이즈")
			$(".size").text($(this).val());
		if($(this).data("v")=="칼러" || $(this).data("v")=="칼라" || $(this).data("v")=="색상" || $(this).data("v")=="상품모델")
			$(".color").text($(this).val());
	});
	$('.part-slick-recommend').slick({
	  speed: 300,
	  slidesToShow: 8,
	  slidesToScroll: 1,
	  arrows: false, 
	  autoplay: true,
	  autoplaySpeed: 3000,
	  responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 8,
	        slidesToScroll: 3,
	        infinite: true,
	      }
	    },
	    {
	      breakpoint: 600,
	      settings: {
	        slidesToShow: 5,
	        slidesToScroll: 2
	      }
	    },
	    {
	      breakpoint: 480,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1
	      }
	    }
	  ]
	});
	$(".cart_add").hover(function(){
	  $(".cart_add img").attr("src", "/template/images/cart_btn2.png");
	  }, function(){
	  $(".cart_add img").attr("src", "/template/images/cart_btn1.png");
	});
</script>