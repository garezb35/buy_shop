// $('.spin').spin();
var socket = io.connect('http://121.254.254.216:8081');
var init1_limit = 0;
var init2_limit = 0;
$(".favo").click(function(){
  alert("정상적으로 작동이 안될 경우 Ctrl+D 키를 눌러 즐겨찾기 추가하세요.");
});
$(document).ready(function(){
  $(".renewal-header").css("display","block");
  $("#floating").css("display","block");
  $("#floating2").css("display","block");
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
  var gaps = ($(window).width()-$(".container").width())/2;
  $("#floating").css('right',(gaps-120)+'px');
  $("#floating2").css('left',(gaps-100)+'px');
  $( ".hover_img" ).hover(
    function() {
      $(this).attr("src",$(this).data("src1"));
    }, function() {
      $(this).attr("src",$(this).data("src"));
    }
  );
  $(".Menu > li.firclass").hover(function(){
      var ul = $(this).find("ul")[0];
        $(".Menu > li").removeClass("-active");
        $(this).addClass("-active");
        ul.classList.add("-visible");
        ul.classList.add("-animating");
        setTimeout(function(){
          ul.classList.remove("-animating")
        }, 25);
          }, function(){
        var ul = $(this).find("ul")[0];
        $(this).removeClass("-active");
        ul.classList.remove("-visible");
        ul.classList.remove("-animating");
    });

  $(".category-layer").hover(function(){
     $(".category-layer").css("display","block");
  },function(){
    $(this).css("display","none");
  })

  $(".category-btn").hover(function(){
    $(".category-layer").css("display","block");
  },function(){
    $(".category-layer").css("display","none");
  })
});


//login_redirect

function login_alert() {
    alert("로그인 후 이용할수 있습니다.");
    window.location.href="/login?redirect="+ConvertStringToHex(location.href);
}


function goBannerPage(link,self_type){
  window.open(link, self_type);
}
//handlebars register

Handlebars.registerHelper('if_eq', function(a, opts) {
    if (a <= 0) {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});

Handlebars.registerHelper('if_type_request', function(a, opts) {
    if (a =="eval") {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});

Handlebars.registerHelper('if_first_last', function(a, opts) {
    if (a % 5 == 0) {
        return "m-l-0";
    } 

    if(a % 5 ==4){
        return "m-r-0";
    }

    return ""
});

Handlebars.registerHelper('accurate', function(a, opts) {
    return fnCommaNum(a);
});


Handlebars.registerHelper('multiple', function(a,b,c, opts) {
  if(c==1)
    return a*b;
  else
    return fnCommaNum(a*b);
});

Handlebars.registerHelper('length_of_array', function(a, opts) {
    if (a.length > 0) {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});

