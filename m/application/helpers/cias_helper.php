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
    function getBanners($type)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getSelect("banner",array(  array("record"=>"use","value"=>1),
                                                            array("record"=>"type","value"=>$type)));
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


if(!function_exists('base_url_home'))
{
    function base_url_home()
    {
        return "http://atmos89.com/";
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

?>