<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

if(!function_exists('setFeeList'))
{
    function setFeeList($data)
    {
        $temp = FEE_LIST;
        foreach ($data as $key => $value) {
            unset($temp[$value]);
        }

        return $temp;
    }
}

if(!function_exists('calculateTime'))
{
    function calculateTime($data)
    {
        $seconds = strtotime(date("Y-m-d H:i:s")) - strtotime($data);
        $days    = floor($seconds / 86400);
        $hours   = floor(($seconds - ($days * 86400)) / 3600);
        $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
        $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
        if($days > 0) { return $days."일";}
        if($hours > 0) { return $hours."시간";}
        if($minutes > 0) { return $minutes."분";}
        if($seconds > 0) { return "방금";}
    }
}
if(!function_exists('getMailCount'))
{
    function getMailCount()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getMailCount();
    }
}

if(!function_exists('generateRandomString'))
{
    function generateRandomString($length = 10,$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if(!function_exists('get_board'))
{
    function get_board()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getSelect("tbl_board",null,array(array("record"=>"grade","value"=>"ASC")));
    }
}

if(!function_exists('getBanners'))
{
    function getBanners($type,$mobile=-1)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        if($mobile ==-1)
            $where = array( array("record"=>"use","value"=>1),
                        array("record"=>"type","value"=>$type));
        if($mobile !=-1){
            $where = array( array("record"=>"use","value"=>1),
                            array("record"=>"type","value"=>$type),
                            array("record"=>"mobile","value"=>$mobile)   
                        );
        }
        return  $CI->base_model->getSelect("banner",$where,array(array("record"=>"order","value"=>"ASC")));
    }
}

if(!function_exists('getRate'))
{
    function getRate()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")))[0]->rate;
        return !empty($rate) ? $rate:0;
    }
}

if(!function_exists('getProducts'))
{
    function getProducts($id)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("tbl_sproducts", array(array("record"=>"shop_category","value"=>$id)),
                                                            null,
                                                            null,
                                                            array(array("record"=>10,"value"=>0)));
        return $rate;
    }
}


if(!function_exists('getFooterContent'))
{
    function getFooterContent()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("banner",array(array("record"=>"id","value"=>"77")));
        return $rate;
    }
}
if(!function_exists('getSiteName'))
{
    function getSiteName()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $ss =  $CI->base_model->getSelect("tbl_company");
        if(!empty($ss))
            return $ss[0]->site;
        return "";
    }
}
if(!function_exists('getPages'))
{
    function getPages($type)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("banner",    array(array("record"=>$type,"value"=>1)),
                                                        array(array("record"=>"order","value"=>"ASC")));
        return $rate;
    }
}


function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if(!function_exists('deleteFile'))
{
    function deleteFile($url)
    {
        
        if(!file_exists($url)){
            return 0;
        }
        if(unlink($url)) return 1;
        else return 0;
    }
}  

if(!function_exists('multi_categories'))
{
    function multi_categories()
    {
        $second = array();
        $three = array();
        $second_category = array();
        $three_category = array();
        $returns = array();
        $CI = &get_instance();
        $CI->load->model('base_model');
        $categories1 = $CI->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent","value"=>0)),array(array("record"=>"order","value"=>"ASC")));
        if(!empty($categories1))
          foreach($categories1 as $value)
            array_push($second, $value->id); 
        $categories2 = $CI->base_model->getCategoriesFromParentsArray($second);
        if(!empty($categories2))
          foreach($categories2 as $value)
            array_push($three, $value->id); 
        $categories3 = $CI->base_model->getCategoriesFromParentsArray($three);

        foreach($categories2 as $value)
            if(in_array($value->parent, $second))
            {
                if(!isset($second_category[$value->parent]))
                    $second_category[$value->parent] = array();
                    array_push($second_category[$value->parent],$value);
            }
            else
                $second_category[$value->parent] = array();
        foreach($categories3 as $value)
            if(in_array($value->parent, $three))
            {
                if(!isset($three_category[$value->parent]))
                    $three_category[$value->parent] = array();
                array_push($three_category[$value->parent],$value);
            }
            else
                $three_category[$value->parent] = array();
        return array(   "categories1" => $categories1,
                        "categories2" => $second_category,
                        "categories3" => $three_category);
    }


if(!function_exists('getSiteInfo'))
{
    function getSiteInfo()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getSelect("tbl_smart_setup")[0];
    }
}

if(!function_exists('getDeliveryPrice'))
{
    function getDeliveryPrice($first_weight,$weight,$weight_gap,$first_price,$gap,$rate,$end_weight)
    {
       
        $i = $first_weight;
        $correct_weight = 0;

        if($weight <=$first_weight){
            $correct_weight = $first_weight;
        }

        else{
            while($i < $end_weight){
                if($weight > $i && $weight <=$i+$weight_gap){
                    $correct_weight = $i+$weight_gap;
                    break;
                }
                $i += $weight_gap;
            }
        }



        $diff = ($correct_weight-$first_weight) / $weight_gap;
        $total = $first_price + $gap*$diff;
        return array("price"=>$total * $rate,"weight"=>$correct_weight);
    }
}

} 
?>