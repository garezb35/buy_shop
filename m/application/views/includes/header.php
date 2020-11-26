<!DOCTYPE html>
<!--[if lt IE 7]><html lang="es" class="no-js lt-ie9 lt-ie8
lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9
lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js
lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html>
<!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="content-language" content="es-ES" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>
    <?php echo $pageTitle; ?>
  </title>
  <link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/slick.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="<?php echo site_url('/template/moby2.0.7/moby.min.css'); ?>" rel="stylesheet">
  <script>window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')</script>
  <script src="<?php echo site_url('/template/js/bootstrap-v3.3.6.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/slick.min.js')?>"></script>
  <script src="<?php echo site_url('/template/js/common.js')?>" type="text/javascript"></script>
  <script src="<?php echo site_url('/template/js/pop_cookies.js')?>"></script>
  <script src="<?php echo site_url('/template/js/bootstrap-datetimepicker.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/bootstrap-datetimepicker.kr.js')?>"></script>
  <!-- <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
  <script > var baseURL = "<?php echo base_url(); ?>";</script>
  <script > var baseURL_HOME = "<?php echo base_url_home(); ?>";</script>
  <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
  <script src="<?php echo site_url('/template/moby2.0.7/moby.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/rolldate.min.js') ?>"></script>
</head>
<body>
  <!-- Standard sample menu -->
  <div class="moby-menu" style="display: none;">
    <nav id="main-nav">
      <ul>
        <?php  $header = getPages("header"); ?>
          <li><a href="<?=!empty($header) ? "/ipage?id=".$header[0]->id:""?>">이용안내<span class="moby-expand"></span></a>
            <ul>
              <?php  if(!empty($header)): ?>
              <?php  foreach($header as $v): ?>
                 <li><a href="/ipage?id=<?=$v->id?>"><?=$v->title?></a></li>
              <?php  endforeach; ?>
              <?php  endif;?>
            </ul>
          </li>
        <li>
          <a href="/delivery" class="">배송대행<span class="moby-expand"></span></a>
          <ul>
              <li><a href="/delivery">배송대행 신청</a></li>
              <li><a href="/multi?type=1">대량등록(엑셀)</a></li>
          </ul>
        </li>
        <li>
          <a href="/delivery?options=buy" class="">구매대행<span class="moby-expand"></span></a>
          <ul>
              <li><a href="/delivery?options=buy">구매대행 신청</a></li>
              <li><a href="/multi?type=2">대량등록(엑셀)</a></li>
          </ul>
        </li>
        <li><a href="/shopping" class="">쇼핑몰</a></li>
        <li>
          <a href="<?=base_url()?>panel?id=M3AM5">고객센터<span class="moby-expand"></span></a>
          <ul>
              <?php $bmenu = get_board(); ?>
              <?php $n= ""; ?>
              <?php if(!empty($bmenu)): ?>
              <?php foreach($bmenu as $value): ?>
                <?php if($value->title=="1:1맞춤문의"): ?>
                <?php $n= "/panel?id=".$value->iden ?>
                <?php endif; ?>
              <li><a href="/panel?id=<?=$value->iden?>"><?=$value->title?></a></li>
              <?php endforeach; ?>
              <?php endif; ?>
              <li><a href="/event">이벤트</a></li>
          </ul>
        </li>
        <li>
          <a href="/mypage" class="">마이페이지<span class="moby-expand"></span></a>
          <ul>
            <li><a href="/mypage">마이홈</a></li>
            <li><a href="/mypay">결제 페이지</a></li>
            <li><a href="/deposit">예치금/포인트</a></li>
            <li><a href="/private?option=my">Q&A</a></li>
            <li><a href="/coupon">나의 쿠폰함</a></li>
            <li><a href="/mailbox">받은 쪽지함</a></li>
            <li><a href="/member">회원정보수정</a></li>
          </ul>
        </li>
        <?php  if(!empty($this->session->userdata('fisLoggedIn')) &&  $this->session->userdata('fisLoggedIn') > 0): ?>
          <script> var pinfo ='<div class="moby-close"><span class="moby-close-icon"></span><a href="/mypage" class="text-white"><?=$this->session->userdata('fname')?>(<?=$this->session->userdata('froleText')?>)님</a></div>\
          <p class="text-center"><a class="text-white" href="/deposit">예치금 (<strong><?=number_format($this->session->userdata('fdeposit'))?></strong>원)</a></p>\
          <p class="text-center"><a class="text-white" href="/point_history">포인트 (<strong><?=number_format($this->session->userdata("fpoint"))?>p</strong>)</a>`</p>'; 
          </script>
          <li><a href="/logout" class="">로그아웃</a></li>
        <?php endif; ?>
        <?php if(empty($this->session->userdata('fisLoggedIn'))): ?>
          <script> var pinfo ='<div class="moby-close"><span class="moby-close-icon"></span><a href="/"> <img src="/template/images/top_logo.png" width=150></a></div>'; 
          </script>
          <li><a href="/login" class="">로그인</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

<!-- Do NOT use an anchor tag for the mobile menu button -->
<div type="button" id="moby-button">
  <div></div>
  <div></div>
  <div></div>
</div>
<?php if(current_url()!=base_url()):  ?>
<div class="text-center mobile-header"><a href="\" class="font-weight-bold rdoFtBig"><?=$pageTitle?></a></div>
<?php endif; ?>
<script>
  var lang_date = {
        title: '날짜선택',
        cancel: '취소',
        confirm: '확인',
        year: '년',
        month: '월',
        day: '일'
      };
  var template  = '<div class="moby-inner">';
    template +=     pinfo; // Reserved class for closing moby
    template +=     '<div class="moby-wrap">';
    template +=         '<div>';
    template +=             '<div class="moby-menu"></div>'; // Must be included in template
    template +=         '</div>';
    template +=     '</div>';
    template += '</div>';
  var socket = io.connect('http://103.108.236.165:8081');
  var mobyMenu = new Moby({
  breakpoint     : 1024,
  enableEscape   : true,
  menu             : $('#main-nav'),
  menuClass    : 'left-side',
  mobyTrigger    : $("#moby-button"),
  onClose          : false,
  onOpen           : false,
  overlay      : true,
  overlayClass   : 'dark',
  template         : template
});
</script>