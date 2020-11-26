<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['UserPage'] = 'Index/UserPage';
$route['delivery'] = 'Index/delivery';
$route['nodata'] = 'Index/nodata';
$route['shopping'] = 'Index/shopping';
$route['shopping/(:num)'] = 'Index/shopping/$1';
$route['contact'] = 'Index/contact';
$route['mypage'] = 'Index/mypage';
$route['mypage/(:num)'] = 'Index/mypage/$1';
$route['offten_question']= 'Index/offten_question';
$route['event'] = 'Index/event';
$route['private']=  'Index/private_discuss';
$route['private/(:num)']=  'Index/private_discuss/$1';
$route['after_use'] = 'Index/after_use';
$route['mypay'] = 'Index/mypay';
$route['deposit'] = 'Index/deposit';
$route['quesanw'] = 'Index/quesanw';
$route['coupon'] = 'Index/coupon';
$route['mailbox'] = 'Index/mailbox';
$route['mailbox/(:any)'] = 'Index/mailbox/$1';
$route['member'] = 'Index/member';
$route['getProduct'] = 'Ajax/getProduct';
$route['insertDeliver']= 'Index/insertDeliver';
$route['login']= 'Index/login';
$route['register'] = 'Index/register';
$route['findpass'] = 'Index/findpass';
$route['usetext'] = 'Index/usetext';
$route['policy'] = 'Index/policy';
$route['doLogin'] = "Index/doLogin";
$route['doRegister'] = "Index/doRegister";
$route['logout'] = "Index/logout";
$route["processPay"] = "Index/processPay";
$route['sendRequestDeposit'] = "Index/sendRequestDeposit";
$route['board_write'] = "Index/board_write";
$route['registerCoupon'] = "Index/registerCoupon";
$route['processCoupon'] = "Index/processCoupon";
$route['getCateogrys'] = "Index/getCateogrys";
$route['getCategoryById'] = 'Index/getCategoryById';
$route['bbSend'] = "Index/bbSend";
$route['getmailbyid'] = 'Index/getMailById';
$route['after_use/view/(:num)'] = 'Index/AfterView/$1';
$route['post/view/(:num)'] = 'Index/AfterView/$1';
$route['insertComment'] = 'Index/insertComment';
$route['private/view/(:num)']  = 'Index/privateView/$1';
$route['couponSet']  = 'Index/couponSet';
$route['incomingNot'] = 'Index/InNot';
$route['gwanbu'] = 'Index/gwanbu';
$route['totalfee'] = 'Index/totalFee';
$route['deliveryShow'] = 'Index/deliveryShow';
$route['buyShow'] = 'Index/buyShow';
$route['delivery_price'] = 'Index/deliveryp';
$route['editUser'] = 'Index/editUser';
$route['ajaxGetUser'] = 'Index/ajaxGetUser';
$route['homePage'] = 'Index/homePage';
$route['popupView']  ='Index/popupView';
$route['registerImage'] = 'Index/registerImage';
$route['multi'] = "Index/multi";
$route['multiupload']= "Index/multiupload";
$route['getTimes']= "Index/getTimes";
$route['getPricesByRole'] = 'Index/getPricesByRole';
$route['registerContact'] = 'Index/registerContact';
$route['deleteContact'] = 'Index/deleteContact';
$route['getContact'] = 'Index/getContact';
$route['Pay_Sale'] = 'Index/Pay_Sale';
$route['payHistory'] = "Index/payHistory";
$route['payHistory/(:num)'] = "Index/payHistory/$1";
$route['exitMember'] = "Index/exitMember";
$route['User_MemAddr_S'] = 'Index/User_MemAddr_S';
$route['registerDeliveryAddr'] = "Index/registerDeliveryAddr";
$route['editDeliveryAddr/(:num)'] = "Index/editDeliveryAddr/$1";
$route['view/delivery/(:any)']= "Index/viewDelivery/$1";
$route['dProduct'] = "Index/dProduct";
$route['getDproducts'] = "Index/getDproducts";
$route['deletesO'] = "Index/deletesO";
$route['editDelivery/(:any)'] = "Index/editDelivery/$1";
$route['updateDeliver'] = "Index/updateDeliver";
$route['addBasket'] = 'Index/addBasket';
$route['mybasket'] = 'Index/mybasket';
$route['makeorder'] = 'Index/makeorder';
$route['changeShopCount'] = 'Index/changeShopCount';
$route['view/shop_products/(:any)'] = 'Index/shop_products/$1';
$route['addCar'] = "Index/addCar";
$route['deleteDeposit'] = "Index/deleteDeposit";
$route['deposit_history'] = "Index/deposit_history";
$route['deposit_history/(:num)'] = "Index/deposit_history/$1";
$route['coupon_list'] = "Index/coupon_list";
$route['coupon_list/(:num)'] = "Index/coupon_list/$1";
$route['deposit_return'] = "Index/deposit_return";
$route['deposit_return/(:num)'] = "Index/deposit_return/$1";
$route['returntDeposit'] = "Index/returntDeposit";
$route['refuseDeposit'] = 'Index/refuseDeposit';
$route['getDelivery'] = "Index/getDelivery";
$route['getTotalDelivery'] = "Index/getTotalDelivery";
$route['activeCombine'] = "Index/activeCombine";
$route['ActingPlus_I'] = "Index/ActingPlus_I";
$route['ActingMinus_I'] = "Index/ActingMinus_I";
$route['requestDelivery'] = "Index/requestDelivery";
$route['MemCtr_S'] = "Index/MemCtr_S";
$route['view-photo']="Index/view_photo";
$route['deleteBasket']="Index/deleteBasket";
$route['Dlvr_Mny_Pop_W'] = "Index/Dlvr_Mny_Pop_W";
$route['IdChk'] = "Index/IdChk";
$route['panel'] = "Index/panel";
$route['panel/(:num)'] = "Index/panel/$1";
$route['use'] = 'Index/use';
$route['fnBbs_Dn'] = "Index/fnBbs_Dn";
$route['view_board/(:num)'] = "Index/view_board/$1";
$route['getCommentMore'] = "Index/getCommentMore";
$route['deleteComment'] = "Index/deleteComment";
$route['updateBilling'] = "Index/updateBilling";
$route['point_history'] = "Index/point_history";
$route['point_history/(:num)'] = "Index/point_history/$1";
$route["getss"]='Index/getss';
$route["com_profile"]='Index/com_profile';
$route["ipage"]='Index/ipage';
$route["acceptO"]='Index/acceptO';
$route["board_edit"] = "Index/board_edit";
$route['deletepost'] ="Index/deletepost";
$route['returnRequest'] ="Index/returnRequest";
$route['submitError'] ="Index/submitError";
$route['EmailChk'] = "Index/EmailChk";
$route['deleteFile'] = "Index/deleteFile";
$route['checkForget'] = "Index/checkForget";
$route['deleteMails'] = "Index/deleteMails";
$route['getShopCategories']="Index/getShopCategories";

$route["getProductsWithJson"] = "Index/getProductsWithJson";

$route["eval_update"] = "Index/eval_update";

$route["getReivews"] = "Index/getReivews";

$route["service_eval_list"] = "Index/service_eval_list";

$route["product_wish"]  = "Index/product_wish";

$route["wish_list"]  = "Index/wish_list";

$route["getWish"] = "Index/getWish";

$route["deleteWishes"] = "Index/deleteWishes";

$route["relatedProudct"] = "Index/relatedProudct";

$route["update_bracket"] = "Index/update_bracket";

$route["getMoreBasket"] = "Index/getMoreBasket";

$route["updateBasketData"] = "Index/updateBasketData";

$route["taoshopping"] = "Index/taoshopping";