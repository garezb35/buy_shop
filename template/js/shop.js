var options = {

    url: "/getProductsWithJson",

     listLocation: "product_list",

    getValue: function(element) {
        return element.name;
    },


    list: {
        maxNumberOfElements: 10,
        match: {
            enabled: true
        },
        sort: {
            enabled: true
        }
    },
    ajaxSettings: {
        dataType: "json",
        method: "POST",
        data: {
          name: $("#txt-search").val(),
          category:$("#txt-category").val()
        }
      },

      preparePostData: function(data) {

        return data;
    },
    requestDelay: 400


};

function loadProducts(type,limit1=20,limit2="",category,name,size=20){

	var lists = new Array();
	var templateScriptTwo = $('#shopping-lists').html();
	jQuery.ajax({
	type : "POST",
	dataType : "json",
	url : baseURL+"getProductsWithJson",
	data : { type : type,"limit1":limit1,"limit2":limit2,"category":category,"name":name },
    beforeSend: function() {
        $('.loading_products').removeClass("d-none");
        product_loaded =0;
    }
	}).done(function(data){
		if(data.product_list.length ==0)
			$('#content_products').html("자료가 비였습니다.");
		else{
			var templateTwo = Handlebars.compile(templateScriptTwo);
			$('#content_products').append(templateTwo(data));
		}
        $("img.lazy").lazyload();
	}).always(function(a, textStatus, b) {
        product_loaded = 1;
        $('.loading_products').addClass("d-none");
        init1_limit = init1_limit + size;
        init2_limit = init2_limit + size;
    });
}



function eval_view(listpg) {
    if(listpg == undefined) listpg = 1;
    $.ajax({
        url: "./pages/product.eval.pro.php",
        cache: false,
        type: "POST",
        data: "_mode=view&talk_type=eval&pcode=<?=$pcode?>&listpg="+listpg,
        success: function(data){
            $("#ID_eval_list").html(data);
        }
    });
    eval_get_cnt();
}

function eval_write_form_view() {
    $("#eval_contents_area .form_area").toggle();
}

function getFindPrice(dtype="sea",weight){
    var rates = 1;
    var temp = "";
    var price = 0;
    var init_weight = 0;
    if(dtype =="sea"){
        rates = sea;
        temp = weights_sea;
    }
    if(dtype =="sky"){
        rates = sky;
        temp = weights_sky;
    }

    if(temp.length ==0)
    {
        price = 0;
        return price;
    }

    init_weight = temp[0].weight;
    price = temp[0].price;
    $.each(temp,function(index,value){

        if(weight == value.weight || weight < value.weight){
            price = value.price;
            return false;
        }

    });
    return price;
}

// 로그인 알럿

$(document).ready(function(){
    $('.category-layer ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(30).fadeIn(150);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(30).fadeOut(150);
    });


    $("#mnu-category li").click(function(){
        $("#srch-category").text($(this).text());
        $("#txt-category").val($(this).find("a").data("cate_id"));
    })

    $("#txt-search").easyAutocomplete(options);
    
});