<!-- Fixed navbar -->
<?php 
if(!empty($accrate_default))
  $rate = $accrate_default[0]->rate;
else
  $rate = 1;

$delivery_steps = array();

$delivery_steps["delivery"] = $delivery_steps['buy'] = array();

$delivery_steps["delivery"] = array(  "해외쇼핑몰<br>직접 구매",
                                      "배송대행 <br>신청서 작성",
                                      "현지 배송<br>",
                                      "센터입고<br>및 검수",
                                      "2차국제<br> 배송요청",
                                      "상품실측<br> 및 2차 결제",
                                      "국제배송<br> 및 통관",
                                      "국내배송<br> 및 물품수령");

$delivery_steps["buy"] = array("      구매신청<br>및 승인",
                                      "1차결제<br>(상품비)",
                                      "현지 구매<br>",
                                      "센터입고<br>및 검수",
                                      "2차국제<br>배송요청",
                                      "상품실측<br>및 2차 결제",
                                      "국제배송<br>및 통관",
                                      "국내배송<br>및 물품수령");

?>
<div class="theme-showcase mainpage" role="main">
  <div class="mConBox1 clearfix">
    <div class="m_btn">
      <div class="text-center">
        <p class="delivery-info">구매대행은 역시 타오달인!!</p>
        <a href="<?=base_url()?>delivery?options=buy" class="btn btn-zin-blue go-delivery  text-white" title="구매대행 신청">
          <span>구매대행 신청</span>&nbsp;&nbsp;&nbsp; <img src="/assets/images/infoarrow.png">
        </a>
        <a href="<?=base_url()?>delivery" class="btn btn-zin-blue go-delivery  text-white" title="배송대행 신청">
          <span>배송대행 신청</span>&nbsp;&nbsp;&nbsp;  <img src="/assets/images/infoarrow.png">
        </a>
      </div>
    </div>
    <div class="m_slider  col-md-12 mt-50">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          <?php if(!empty($banner)): ?>
            <?php foreach($banner as $keys=>$value): ?>
              <div class="item <?=$keys==0 ? "active":""?>">
                <a href="<?=$value->link == ""? "#":$value->link?>" target="<?=$value->target==2 ? "_blink":""?>" title="<?=$value->title?>">
                  <img  data-src="holder.js/1140x500/auto/#777:#555/text:First slide" src="/upload/homepage/banner/<?=$value->image?>" data-holder-rendered="true"  alt="<?=$value->title?>">
                </a>
              </div>
            <?php endforeach; ?>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
              <img src="<?=base_url()?>assets/images/banner_l.png" class="im-left">
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
              <img src="<?=base_url()?>assets/images/banner_r.png" class="im-right">
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="mConBox2 clearfix mt-50">
    <div class="container">
      <div class="row banners_1">
       <?php if(!empty($s_banner)): ?>
      <?php foreach($s_banner as $key=>$value): ?>
        <?php if($key > 0 &&  $key%6==0): ?>
          <div class="clearfix"></div>
        <?php endif; ?>
        <?php 
          $ss= explode("func-", $value->link);
          if(sizeof($ss) > 1) $link = "javascript:".$ss[1];
          else $link = $value->link;
        ?>
        <div class="col-md-2 p-right-3 p-left-3 text-center">
          <a href="<?=$link?>" target="<?=$value->target==2 ? "_blink":"_self"?>"
            style="background:url(/upload/homepage/banner_r/<?=$value->image?>) center 15px no-repeat">
            <p><?=$value->description?></p>
          </a>
          <?=$key ==0 || $key % 5 != 0 ? '<div class="border-deliveryinfo"></div>':'';?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="middle_part">
    <div class="container">
        <div class="mConBox3 my-1">
          <div class="row">
            <div class="col-md-6 right-posts">
              <div class="mConBox3_1">
                <h2>
                  <a href="/panel?id=RCNIr" class="p-5 tilebar" >
                    공지사항 <img src="/assets/images/arrow-right.png">
                  </a>
                </h2>
                <ul>
                  <?php if(!empty($ques)): ?>
                  <?php foreach($ques as $avi): ?>
                    <li>
                      -<a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>" title="<?=$avi->title?>">
                        <?php if (!empty($avi->category)):?>[<?=$avi->category?>]<?php endif; ?> <?=substr($avi->title,0,60)?>
                      </a>
                      <span class="abs"><?=date("m-d",strtotime($avi->updated_date))?></span>
                    </li>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
            <div class="col-md-6 right-posts">
              <div class="mConBox3_2">
                <h2>
                  <a href="/panel?id=idWQn" class="p-5 tilebar">
                    이용후기 <img src="/assets/images/arrow-right.png">
                  </a>
                </h2>
                <ul>
                  <?php if(!empty($afters)): ?>
                  <?php foreach($afters as $avi): ?>
                    <?php $image= 0; ?>
                    <li>
                    <div class="inline-block m-r-20">
                      <?php preg_match_all('/<img[^>]+>/i',$avi->content, $result);?>
                        <?php if(!empty($result[0])): ?>
                          <?php $image= 1; ?>
                         <a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>" title="<?=$avi->title?>"
                          class="w-80"><?php echo $result[0][0]; ?></a>
                        <?php endif; ?>
                        <?php if(empty($result[0])): ?>
                        <?php if(!empty($avi->file1)): ?>
                        <?php $ext = pathinfo($avi->file1, PATHINFO_EXTENSION); ?>
                        <?php if( strtolower($ext)=="jpg" || 
                            strtolower($ext)=="jpeg" || 
                            strtolower($ext)=="png" || 
                            strtolower($ext)=="gif"): ?>
                        <?php $image= 1; ?>
                      <a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>" class="w-80" title="<?=$avi->title?>">
                        <img data-original="/upload/mail/<?=$avi->id?>/<?=$avi->file1?>" alt="<?=$avi->title?>" class="lazy"> 
                      </a>
                      <?php goto a; ?>
                      <?php endif; ?>     
                    <?php endif; ?>
                    <?php if(!empty($avi->file2)): ?>
                      <?php $ext = pathinfo($avi->file2, PATHINFO_EXTENSION); ?>
                      <?php if( strtolower($ext)=="jpg" || 
                            strtolower($ext)=="jpeg" || 
                            strtolower($ext)=="png" || 
                            strtolower($ext)=="gif"): ?>
                      <?php $image= 1; ?>
                      <a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>" class="w-80" title="<?=$avi->title?>">
                        <img data-original="/upload/mail/<?=$avi->id?>/<?=$avi->file2?>" alt="<?=$avi->title?>" class="lazy">
                      </a>
                      <?php goto a; ?>
                      <?php endif; ?> 
                    <?php endif; ?>
                    <?php if(!empty($avi->file3)): ?>
                      <?php $ext = pathinfo($avi->file3, PATHINFO_EXTENSION); ?>
                      <?php if( strtolower($ext)=="jpg" || 
                            strtolower($ext)=="jpeg" || 
                            strtolower($ext)=="png" || 
                            strtolower($ext)=="gif"): ?>
                       <?php $image= 1; ?>      
                      <a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>" class="w-80" title="<?=$avi->title?>">
                        <img data-original="/upload/mail/<?=$avi->id?>/<?=$avi->file3?>" alt="<?=$avi->title?>" class="lazy">
                      </a>
                      <?php endif; ?> 
                    <?php endif; ?>
                    <?php endif;?>
                    <?php a: ?>
                    </div>  
                    <div class="inline-block top_align" style="max-width: 337px; <?=$image ==0 ? "margin-left: 70px;" : ""?>">
                      <a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>">
                        <span class="title"><?=substr($avi->title,0,60)?></span>
                      </a>
                      <div style="max-height: 41px;overflow: hidden;line-height: 24px;">
                        <?php 
                          $content = $avi->content;
                          $content = preg_replace("/<img[^>]+\>/i", "", $content); 
                          $content = trim(preg_replace('/\s\s+/', ' ', $content));
                          $content = substr($content,0,200);
                          echo trim($content);
                        ?>
                      </div>
                    </div>
                    </li>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
            <div class="col-md-6 right-posts">
              <div class="mConBox3_3">
                <h2>
                  <a href="/panel?id=M3AM5" class="p-5 tilebar">
                    문의사항 <img src="/assets/images/ff.png">
                  </a> 
                </h2>
                
                <ul>
                  <?php if(!empty($privas)): ?>
                  <?php foreach($privas as $avi): ?>
                    <?php
                      $nick = "";
                      if(!empty($avi->nickname) && strlen($avi->nickname) >1)
                      {
                        $avi->nickname[1] = "*";
                        $nick = $avi->nickname;
                      }
                     ?>
                    <li>
                      -<a href="/post/view/<?=$avi->id?>?id=<?=$avi->iden?>" class=" w-80">
                        <?=substr($avi->title,0,60)?></a>
                        <span class="abs"><?=$nick?> / <?=date("m-d",strtotime($avi->updated_date))?></span>
                    </li>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
            <div class="col-md-6 right-posts">
              <div class="mConBox3_4">
                <h2>
                  <a href="/event" class="p-5 tilebar" >
                    이벤트 <img src="/assets/images/ff.png">
                  </a>
                </h2>
                
                <ul>
                  <?php if(!empty($event)): ?>
                  <?php foreach($event as $avi): ?>
                    <li>
                      -<a href="<?=$avi->link?>" class=" w-80">
                        <span class="text-success font-weight-bold"></span>
                        <?=substr($avi->title,0,60)?></a>
                        <span class="abs"><?=date("m-d",strtotime($avi->updated_date))?></span>
                    </li>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
         <div class="mConBox7 row mt-30">
          <div class="col-md-12">
            <?php if(!empty($event_home)): ?>
            <a href="<?=$event_home[0]->link?>"><img src="/upload/event/<?=$event_home[0]->image?>" class="w-100"> </a>  
            <?php endif; ?>
          </div>
        </div>
        <div class="mConBox10">
          <div class="row mt-30">
            <?php if(!empty($jlca)): ?>
            <?php foreach($jlca as $key=>$value): ?>
             <div class="col-md-3 <?=$key==0 ? "p-right-1 p-left-0":"p-left-1 p-right-1"?>">
              <a id="act<?=$key+1?>" class="nav-link btn w-100 <?=$key==0 ? "btn-default":"btn-ordinary"?>  step_btn_delivery"  
                data-toggle="tab" href="#home-tab<?=$key?>" role="tab" 
                aria-controls="home" aria-selected="true" onclick="act<?=$key+1?>();">
                  <div><span class="mid"><?=$value->description?></span></div>
                </a>
            </div> 
            <?php endforeach; ?>
            <?php endif; ?>
              <div class="col-md-3 p-right-1 p-left-1">
                <a id="act<?=$key+1?>" class="nav-link btn w-100 btn-ordinary  step_btn_delivery" 
                  href="https://www.kuaidi100.com" target="_blink">
                  <div><span class="mid">중국내택배조회</span> <img src="/assets/images/tackbae_arrow_btn.png"></div>
                </a>
                
              </div>
               <div class="col-md-3  p-left-1 p-right-0">
                <a id="act<?=$key+1?>" class="nav-link btn w-100 btn-ordinary  step_btn_delivery" 
                  href="https://www.doortodoor.co.kr/parcel/pa_004.jsp" target="_blink">
                  <div>
                    <span class="mid">국내배송조회</span> <img src="/assets/images/tackbae_arrow_btn.png">
                  </div>
                </a>

              </div>
          </div>
          <div class="row mt-30 p-0">
            <div class="col-md-12 p-0">
              <div class="tab-content" id="myTabContent">
                <?php if(!empty($jlca)): ?>
                <?php foreach($jlca as $key=>$value): ?>
                <div class="tab-pane fade in <?=$key==0 ? "active":""?>" role="tabpanel" 
                  aria-labelledby="home-tab<?=$key?>" id="home-tab<?=$key?>">
                  <div class="overflow-auto pb-5 pt-5">

                    <?php 
                    if($key ==0){
                      $dpath = "delivery";
                      $dname  ="d";
                    } 
                    else{
                      $dpath = "buy";
                      $dname  ="b";
                    }

                    ?>
                      <?php for($di = 1 ;$di<=8;$di++){ ?>
                        <div class="step_delivery text-center">
                          <img src="/assets/images/<?=$dpath?>/<?=$dname?>-<?=$di?>.png" alt="<?=$delivery_steps[$dpath][$di-1]?>">
                          <p><?=$delivery_steps[$dpath][$di-1]?></p>
                        </div>
                        <?php if($di !=8): ?>
                        <div class="step_delivery delivery_arrow text-center">
                          <img src="/assets/images/delivery_arrow.png">
                        </div>
                        <?php endif; ?>
                      <?php } ?>
                  </div>
                </div>
                <?php endforeach;?>
              <?php endif; ?>
              </div>
              <div class="pHt30"></div>
            </div>

          </div>
        </div>
        <div class="mConBox9 clearfix f-bold">
          <div class="row">
            <?php if(!empty($shoppingList)): ?>
              <?php foreach($shoppingList as $value): ?>
                <div class="col-md-4 text-center">
                  <a href="<?=$value->link?>" target="_blank">
                    <img src="/upload/homepage/recommend/<?=$value->image?>">
                  </a>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          
        </div>
       
        <div class="mConBox8 my-10 row">
          <div class="col-md-12">
            <h2 class="head-posts p-5  text-center" style="margin-top: 20px;">
            <span>
              <a href="/shopping" class="text-white">
                <img src="/template/images/arrows.png"> <span class="f-medium">TAODALIN SHOPPING CENTER</span> 
              </a>
            </span>
          </h2>
          <?php if(!empty($cats)): ?>
            <?php foreach($cats as $vac): ?>
              <div class="row">
                <div class="col-md-12 p-0" style="margin-top: 30px">
                  <h3 class="taobao-head f-medium">타오바오인기상품 - <?=$vac->name?></h3>
                </div>
              </div>
              <div class="row p-left-5" style="margin-top: 15px">
                <!-- <div class="col-xs-3 p-0">
                  <img src="/upload/image/<?=$vac->image?>" width=100% height=200 style="object-fit: cover;">
                </div> -->
                <div class="col-xs-12 s_ss">
                  <?php $spp = getProducts($vac->id); ?>
                  <?php if(!empty($spp)): ?>
                    <?php foreach($spp as $valp): ?>
                      <a href="/view/shop_products/<?=$valp->rid?>" title="<?=$valp->name?>">  
                        <img src="/upload/shoppingmal/<?=$valp->id?>/<?=$valp->i1?>" alt="<?=$valp->name?>" height=220>
                        <p class="text-center"><?= strlen($valp->name) < 20 ? $valp->name : substr($valp->name,0,20)."..."?></p>
                        <p class="text-center"><strong><?=number_format($valp->singo)?></strong>원</p>
                      </a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          </div>
        </div>
        <div class="recoms row mt-30">
          <div class="col-md-12">
            <h3 class="taobao-head f-medium">타오바오 MD 추천상품</h3>
          </div>
          <?php if(!empty($reProducts)): ?>
          <?php foreach($reProducts as $rrp): ?>
            <div class="col-md-5 border-bottom" style="margin-top: 15px">
              <a href="<?=$rrp->link?>" <?php if($rrp->target==0): ?>target="_blink"<?php endif; ?> title="<?=$rrp->title?>">
                <img src="/upload/homepage/recommendPro/<?=$rrp->image?>" class="w-100 border" height=150 alt="<?=$rrp->title?>">
                <p class="ellipsis text-center"><?=$rrp->title?></p>
                <p class="font-weight-bold text-center"><strong><?=number_format($rrp->price)?></strong>원</p>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <div class="row mt-30">
          <div class="col-xs-12 p-1">
          <?php if(!empty($caan)): ?>
          <?php foreach($caan as $value): ?>
             <a href="<?=$value->link?>" target="_blink"><img src="/upload/homepage/banner_r/<?=$value->image?>" ></a>
          <?php endforeach; ?>
          <?php endif; ?>

          <?php if(!empty($inan)): ?>
          <?php foreach($inan as $value): ?>
             <a href="<?=$value->link?>" target="_blink"><img src="/upload/homepage/banner_r/<?=$value->image?>" ></a>
          <?php endforeach; ?>
          <?php endif; ?> 

          <?php if(!empty($blogs)): ?>
          <?php foreach($blogs as $value): ?>
            <a href="<?=$value->link?>" target="_blink"> <img src="/upload/homepage/banner_r/<?=$value->image?>" ></a>
          <?php endforeach; ?>
          <?php endif; ?>

          </div>
        </div>
    </div>
    </div>
</div> <!-- /container -->
<link href="<?php echo site_url('/template/css/style.css');?>?<?=time()?>" rel="stylesheet">
<?php if(!empty($popups)): ?>
  <?php foreach($popups as $value):
    if(empty($_COOKIE["MPop".$value->id]) || $_COOKIE["MPop".$value->id]==false):
    ?>
    <div id="MPop<?=$value->id?>" scroll="<?=$value->scroll_use==1 ? "Y":""?>" class="LayerPop" style="position: absolute; z-index: 9990914; left: <?=$value->po_w?>px; top: <?=$value->po_h?>px; visibility: visible;">
    <iframe id="MIfrA" style="width:<?=$value->size_w?>px;height:<?=$value->size_h?>px;background:#fff;border:1px solid #aaa;" frameborder="0" border="0" scrolling="no" src="/popupView?pop=<?=$value->id?>"></iframe>
    <div style="text-align:right;padding:3px 3px;background-color: rgba( 255, 255, 255, 0.6 );color:#444;">
    <form name="frmMPop<?=$value->id?>" id="frmMPop<?=$value->id?>">
      <label>오늘 하루 열지않음 <input type="checkbox" name="closeEvent" id="closeEvent" class="vm"></label> 
      <a href="javascript:fnMPopClose('MPop<?=$value->id?>');" class="btn_small2 vm"><span>닫기</span></a>
    </form>
    </div>
  </div>
  <?php 
  endif;
  endforeach; ?>
<?php endif; ?>
<script>
$('#carousel-example-generic').carousel(
  {
    interval: 8000
  }
);
$('.s_ss').slick({
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 1,
  arrows: true, 
  autoplay: true,
  autoplaySpeed: 3000,
  prevArrow : '<button class="slick-prev right-ab-ha" aria-label="Previous" type="button"><img src="/assets/images/shop_r.png"></button>',
  nextArrow : '<button class="slick-next left-ab-ha" aria-label="Next" type="button"><img src="/assets/images/shop_l.png"></button>',
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

function fnMPopClose(PopNm) {
  fnCookieControl( $("#frm" + PopNm + " input[name='closeEvent']:checkbox"), PopNm);
  $("#" + PopNm).hide("slow");
}
function act1(){
  $("#act1").removeClass("btn-ordinary");
  $("#act1").addClass("btn-default");
  $("#act2").removeClass("btn-default");
  $("#act2").addClass("btn-ordinary");
}
function act2(){
  $("#act2").removeClass("btn-ordinary");
  $("#act2").addClass("btn-default");
  $("#act1").removeClass("btn-default");
  $("#act1").addClass("btn-ordinary");
}
$(document).ready(function(){
  $("img.lazy").lazyload();
})
</script>
<style type="text/css">
.login-util ul li {
    float: left;
    margin-right: 10px;
    padding-right: 12px;
}
.slick-track{
  margin: unset;
}
.slick-slide  img{
  margin: auto;
}
</style>