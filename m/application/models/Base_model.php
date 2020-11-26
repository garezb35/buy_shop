<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Base_model extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */

    function plusValue($database,$field,$value,$val_array,$type){
        $this->db->set($field, $field.$type.$value, FALSE);
        foreach($val_array as $v):
            $this->db->where($v[0],$v[1]);
        endforeach;
        $this->db->update($database);
    }

    function updateDataById($id,$data,$database,$record){
        $this->db->where($record, $id);
        $this->db->update($database, $data);
        return $this->db->affected_rows();
    }

     function deleteRecordsById($database,$record,$id){
        $this->db->where($record, $id);
        $this->db->delete($database); 
    }

    function getSelect($database,$array1=null,$array2=null,$array3=null,$array4=null){
        $this->db->select('*');
        $this->db->from($database);
        if($array1 !=null) 
            foreach($array1 as $value){
                $this->db->where($value['record'], $value['value']);  
            }
        if($array2 !=null) 
            foreach($array2 as $value1){
                if($value1['record']!="") $this->db->order_by($value1['record'], $value1['value']);  
            }
        if($array3 !=null) 
            foreach($array3 as $value2){
                if($value2['record']!="") $this->db->group_by($value2['record']);  
            }
        if($array4 !=null) 
            foreach($array4 as $value3){
                if($value3['record']!="") $this->db->limit($value3['record'], $value3['value']);
            }                 
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function insertArrayData($database,$data){

        $this->db->insert($database,$data);
        return $this->db->insert_id();
    }

    function getStepDeliveryTop()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_step_title as BaseTbl');
        $this->db->order_by('BaseTbl.step','asc');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }
    function getdelivery($id)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_steps as BaseTbl');
        $this->db->where('type',$id);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function getStepDelivery(){
        $topCategory = $this->getStepDeliveryTop();
        $details_category = array();
        foreach ($topCategory as $key => $value) {
            $details_category[$value->step] = $this->getdelivery($value->step);
        }
        return $details_category;
    }

    function insertPurchase($post,$id,$ordernum=null){

        foreach ($post as $key => $value) {
            $this->db->insert('tbl_purchasedproduct',array( "delivery_id"=>$id,
                                                            "trackingHeader"=>$value[0],
                                                            "trackingNumber"=>$value[1],
                                                            "order_number"=>$value[2],
                                                            "parent_category"=>$value[3],
                                                            "category"=>$value[4],
                                                            "productName"=>$value[5],
                                                            "unitPrice"=>$value[6],
                                                            "count"=>$value[7],
                                                            "color"=>$value[8],
                                                            "size"=>$value[9],
                                                            "url"=>$value[10],
                                                            "image"=>$value[11],
                                                            "step"=>!empty($value[12]) ? $value[12]:0,
                                                            "created_date"=>date("Y-m-d H:i:s"),
                                                            "shop"=>!empty($value[13]) ? $value[13]:0,
                                                            "serial"=>$ordernum."-".($key+1)));
        }
    }
    function loginMe($memId, $password)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.password, BaseTbl.name, BaseTbl.roleId, Roles.role,BaseTbl.point,BaseTbl.deposit,Roles.level,BaseTbl.log_num,BaseTbl.sase,BaseTbl.nickname');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.loginId', $memId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('Roles.type !=', 0);
        $query = $this->db->get();
        $user = $query->result();
        
        if(!empty($user)){
            if($this->encryption->decrypt($user[0]->password) ==$password)
                return $user;
             else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function getUser($id,$nickname,$email){
        $this->db->select('BaseTbl.userId, BaseTbl.password, BaseTbl.name, BaseTbl.roleId, Roles.role,BaseTbl.point,BaseTbl.deposit');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.loginId', $id);
        $this->db->where('BaseTbl.nickname', $nickname);
        $this->db->where('BaseTbl.email', $email);
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('Roles.type !=', 0);
        $query = $this->db->get();
        $user = $query->result();
        return $user;
    }

    function getIDUnique($id){
        $this->db->where('loginId', $id);
        $this->db->from('tbl_users');
        return $this->db->count_all_results();
    }

    function getEmailUnique($email){
        $this->db->where('email', $email);
        $this->db->from('tbl_users');
        return $this->db->count_all_results();
    }
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getDeliverContent($limit1= 10,$limit2=0,$delivery_id=null,$step=null,$userId=null,$from="",$to="",$process="",$ordernum="",$tracking=""){
        if($limit2 ==null) $limit2=0;
        $this->db->select('BaseTbl.*,count(Pproduct.id) as pcount,DeliverAddress.area_name,Method.name as method,Pproduct.order_number,Pproduct.trackingNumber,Step.name as sname,SUM(Pproduct.unitPrice*Pproduct.count) as pprice,Payhistory.delivery_id as did,DC.comment as Dcomment,DC.use as Duse,AP.add_check,AP.add_price,AP.gwan as agwan,AP.pegi as apegi,AP.cart_bunhal as acart_bunhal,AP.check_custom as acheck_custom,AP.gwatae as agwatae,AP.accurate as aaccurate,AP.v_weight,Payhistory.pending,Part.content,DeliverAddress.id as addid');
        $this->db->from('delivery as BaseTbl');
        if($delivery_id!=null){
            $this->db->where('BaseTbl.id',$delivery_id);
        }
       if($step!=null && $step!="" && $step !=12){
            $this->db->where('BaseTbl.state',$step);
        }
        if($step ==12) {
            $this->db->where("Pproduct.step",102);
            $this->db->where("BaseTbl.state !=",13);
            $this->db->where("BaseTbl.state !=",17);
            $this->db->where("BaseTbl.state !=",18);
            $this->db->where("BaseTbl.state !=",19);
            $this->db->where("BaseTbl.state !=",20);
            $this->db->where("BaseTbl.state !=",21);
            $this->db->where("BaseTbl.state !=",24);
        }
        
        if($userId !=null){
            $this->db->where('BaseTbl.userId',$userId);
        }
        if($from !="") $this->db->where("BaseTbl.".$process." >=",$from);
        if($to !="") $this->db->where("BaseTbl.".$process." <",date('Y-m-d', strtotime($to . ' +1 day')));
        if($ordernum !="" && trim($tracking) !=""){
            $type = "";
            if($ordernum ==1)
                $type="BaseTbl.ordernum";
            if($ordernum ==2)
                $type="Pproduct.trackingNumber";
            if($ordernum ==3)
                $type="BaseTbl.billing_krname";
            if($ordernum ==4)
                $type="Pproduct.order_number";
            if(trim($type) !="")
                $this->db->like($type,$tracking);
        }
        // $this->db->like("BaseTbl.ordernum",$ordernum);
        // if($tracking !="") $this->db->like("Pproduct.trackingNumber",$tracking);
        // if($recei !="") $this->db->like("BaseTbl.billing_krname",$recei);
        // if($order !="") $this->db->like("Pproduct.order_number",$order);
        $this->db->join('delivery_address as DeliverAddress', 'DeliverAddress.id = BaseTbl.place','left');
        $this->db->join('tbl_sendmethod as Method', 'Method.id = BaseTbl.incoming_method','left');
        $this->db->join('tbl_purchasedproduct as Pproduct', 'Pproduct.delivery_id = BaseTbl.id');
        $this->db->join('tbl_steps as Step', 'Step.step = BaseTbl.state');
        $this->db->join('tbl_payhistory as Payhistory', 'Payhistory.delivery_id = BaseTbl.id','left');
        $this->db->join('tbl_delivery_comment as DC', 'DC.delivery_id = BaseTbl.id','left');
        $this->db->join('tbl_add_price as AP', 'AP.id = BaseTbl.id','left');
        $this->db->join('tbl_service_delivery as Part', 'Part.delivery_id = BaseTbl.id','left');
        $this->db->group_by('BaseTbl.id');
        if($process!="") $this->db->order_by("BaseTbl.".$process,"DESC");
        if($limit1 !=null) {$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    function getDeliveryS($id){
        $this->db->select('BaseTbl.*,DeliverAddress.area_name,Method.name as method,SUM(Pproduct.unitPrice*Pproduct.count) as pprice,SUM(Pproduct.count) as ppcount,Part.content,DeliverAddress.id as addid');
        $this->db->from('delivery as BaseTbl');
        $this->db->join('delivery_address as DeliverAddress', 'DeliverAddress.id = BaseTbl.place'); 
        $this->db->join('tbl_sendmethod as Method', 'Method.id = BaseTbl.incoming_method');
        $this->db->join('tbl_purchasedproduct as Pproduct', 'Pproduct.delivery_id = BaseTbl.id');
        $this->db->join('tbl_service_delivery as Part', 'Part.delivery_id = BaseTbl.id','left');
        $this->db->where('BaseTbl.rid',$id);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    function getDeliverWaitingPay($limit1= 10,$limit2=0){

        $this->db->select('BaseTbl.*,count(Pproduct.id) as pcount,DeliverAddress.area_name,Method.name as method,Pproduct.order_number,Pproduct.trackingNumber,Step.name as sname,SUM(Pproduct.unitPrice*Pproduct.count) as pprice,Payhistory.delivery_id as did,Payhistory.pending as Ppending,AP.add_check,AP.add_price,Payhistory.amount as deamount,Payhistory.point as paypoint,DeliverAddress.id as addid');
        $this->db->from('delivery as BaseTbl');
        $this->db->join('delivery_address as DeliverAddress', 'DeliverAddress.id = BaseTbl.place');
        $this->db->join('tbl_sendmethod as Method', 'Method.id = BaseTbl.incoming_method');
        $this->db->join('tbl_purchasedproduct as Pproduct', 'Pproduct.delivery_id = BaseTbl.id');
        $this->db->join('tbl_steps as Step', 'Step.step = BaseTbl.state');
        $this->db->join('tbl_payhistory as Payhistory', 'Payhistory.delivery_id = BaseTbl.id','left');
        $this->db->join('tbl_add_price as AP', 'AP.id = BaseTbl.id','left');
        $this->db->where("(BaseTbl.userId=".$this->session->userdata('fuser')."  AND BaseTbl.pays=0 AND 
            ( (BaseTbl.state='5' AND BaseTbl.payed_checked=0) OR (BaseTbl.state='14' AND BaseTbl.payed_send=0) OR (BaseTbl.state='20' AND BaseTbl.return_check=0)))", NULL, FALSE);
        $this->db->or_where("(  BaseTbl.userId=".$this->session->userdata('fuser')."  AND 
                                AP.add_check=1 AND 
                                BaseTbl.state!='5' AND BaseTbl.state!='14' AND BaseTbl.state!='20')", NULL, FALSE);
        $this->db->group_by('BaseTbl.id');
        $this->db->order_by("BaseTbl.updated_date");
        if($limit1 !=-1)    $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getStateByUserId(){
        // $this->db->select("state,count(BaseTbl.id) as stateCount");
        // $this->db->from("delivery as BaseTbl");
        // // $this->db->join('tbl_purchasedproduct as Pproduct', 'Pproduct.delivery_id = BaseTbl.id');
        // $this->db->where('BaseTbl.userId',$this->session->userdata('fuser'));
        // $this->db->group_by(array("BaseTbl.state"));
        $query = $this->db->query("SELECT 
                                      A.state,
                                      COUNT(A.id)  as stateCount
                                    FROM
                                      (SELECT 
                                        BaseTbl.id,
                                        `state` 
                                      FROM
                                        `delivery` AS `BaseTbl` 
                                        JOIN `tbl_purchasedproduct` AS `Pproduct` 
                                          ON `Pproduct`.`delivery_id` = `BaseTbl`.`id` 
                                      WHERE `BaseTbl`.`userId` = '".$this->session->userdata('fuser')."' 
                                      GROUP BY `BaseTbl`.`id`,
                                        `BaseTbl`.`state`) A 
                                    GROUP BY A.state ");
        $results = $query->result();
        return $results;
    }

    public function getStateByDeliveryId($id){
        $this->db->trans_start();
        $this->db->select("BaseTbl.*,Part.content");
        $this->db->from("delivery as BaseTbl");
        $this->db->join("tbl_service_delivery as Part","Part.delivery_id=BaseTbl.id","left");
        $this->db->where('BaseTbl.id',$id);
        $query = $this->db->get();
        $this->db->trans_complete();
        $results = $query->result();
        return $results; 

    }

    public function insertDeposit($data){

        $this->db->trans_start();
        $this->db->insert('tbl_request_deposit',$data);
        $this->db->trans_complete();
        return 1;
    }

public function getMail($type=-1,$category=-1,$limit="",$userId=0,$shcol=null,$shkey=null,$limit1=null,$from='',$to='',$gg=null,$view=""){
        $this->db->select("tbl_mail.*,tbl_users.name,tbl_board.iden,tbl_users.nickname");
        $this->db->from("tbl_mail");
        $this->db->join("tbl_users","tbl_users.userId=tbl_mail.fromId","left");
        $this->db->join("tbl_board","tbl_board.id=tbl_mail.type","left");
        if($userId !=0) $this->db->where("tbl_mail.toId",$userId);
        if($shkey !="")
            if($shcol =="A") $this->db->like("tbl_mail.title",$shkey);
        if($shkey !="")
            if($shcol =="B") $this->db->like("tbl_users.name",$shkey);

        if($from !="" && $from !=null) $this->db->where('tbl_mail.updated_date >=', $from);
        if($to !=null && $to !="") $this->db->where('tbl_mail.updated_date <',date('Y-m-d', strtotime('+1 day', strtotime($to))));
        if($gg !=null) $this->db->where("tbl_board.title",$gg);
        else
            if($type  !=-1) $this->db->where("tbl_mail.type",$type);
        if($limit !="") $this->db->limit($limit,$limit1);
        if($category  !=-1) $this->db->where("tbl_mail.category",$category);
        if($view ==1) $this->db->where("tbl_mail.view",0);
        $this->db->order_by("tbl_mail.updated_date","DESC");
        $query = $this->db->get();
        $results = $query->result();
        return $results; 
    }

    public function getMailCount(){
        $this->db->from("tbl_mail");
        $this->db->where("type",0);
        $this->db->where("view",0);
        $this->db->where("toId",$this->session->userdata('fuser'));
        return $this->db->count_all_results();
    }


    public function getCommentsByPostId($limit1=5,$limit2=0,$id){

        $this->db->select("BaseTbl.*,User.name");
        $this->db->from("tbl_comment as BaseTbl");
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId");
        $this->db->where("BaseTbl.postId",$id);
        $this->db->order_by("BaseTbl.created_date","DESC");
        $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return $results; 
    }

    public function getCouponLists($event_coupon=0,$userId=0,$rr=null,$r1=null,$r2=null){
        $this->db->select("Coupon.coupon_type,BaseTbl.*,Coupon.terms,Coupon.use_terms,Coupon.send,Ctype.content,Coupon.gold,Coupon.gold_type,Coupon.event,DATEDIFF(BaseTbl.created_date,CURDATE()) as Diff");
        $this->db->from("tbl_coupon_user as BaseTbl");
        $this->db->join("tbl_coupon as Coupon","Coupon.id=BaseTbl.coupon_id");
        $this->db->join("tbl_coupon_type as Ctype","Ctype.id=Coupon.coupon_type");
        $this->db->where("Coupon.is_deleted",0);
        if($rr !=null){
            $anucode = explode(",", $rr);
            foreach ($anucode as $key => $value) {
                $this->db->where("Coupon.code!=",$value);
            }
        }
        if($r1 !=null)
        {
            $r1 = json_decode($r1,true);
            if(!isset($r1[7]) || $r1[7]<=0 )
                $this->db->where("Coupon.coupon_type!=",2);
            if(!isset($r1[46]) || $r1[46]<=0 )
                $this->db->where("Coupon.coupon_type!=",3);
            if(!isset($r1[63]) || $r1[63]<=0 )
                $this->db->where("Coupon.coupon_type!=",4);
            if(!isset($r1[47]) || $r1[47]<=0 )
                $this->db->where("Coupon.coupon_type!=",5);
            if(!isset($r1[51]   ) || $r1[51]<=0 )
                $this->db->where("Coupon.coupon_type!=",6);
            if($r2<=0 || $r2==null)
            $this->db->where("Coupon.coupon_type!=",7);
        }
        $this->db->where("((Coupon.event ='0' AND SUBSTRING_INDEX(Coupon.terms,\"|\",1) <='".date("Y-m-d")."' AND SUBSTRING_INDEX(Coupon.terms,\"|\",-1) >='".date("Y-m-d")."') OR (Coupon.event ='1' AND Coupon.use='1' AND BaseTbl.used='0' AND BaseTbl.byd >='".date("Y-m-d")."'))", NULL, FALSE);
        if($userId !=0) $this->db->where("BaseTbl.userId",$this->session->userdata('fuser'));
        $this->db->where("BaseTbl.used !=",1);
        $query = $this->db->get();
        $results = $query->result();
        return $results; 
    }
    public function getDeliveryContents($id){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_deliverytable as BaseTbl');
        $this->db->where("BaseTbl.address",$id);
        $this->db->order_by("BaseTbl.startWeight","ASC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results; 
    }
    public function getRoleByMember($c="yes",$user=0){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_roles as BaseTbl');
        $this->db->where("BaseTbl.type !=",0);
        if($c=="yes")  $this->db->where("BaseTbl.use",1);
        if($user==1) $this->db->where("BaseTbl.roleId",$this->session->userdata("frole"));
        $query = $this->db->get();
        $results = $query->result();
        return  $results; 
    }
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);       
        return TRUE;
    }
    
    public function getPopup($id=-1){
        $this->db->select('*');
        $this->db->from('tbl_popup');
        $this->db->where('use',1);
        if($id !=-1) $this->db->where("id",$id);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function deleteContactById($value){
        $this->db->where('id', $value);
        $this->db->delete('tbl_mycontact');
    }

    public function getContactById($value){
        $this->db->select('*');
        $this->db->from('tbl_mycontact');
        $this->db->where('id',$value);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

   public function getCoupon($event_coupon=0){
        $this->db->select("
            Coupon.id,Coupon.terms,Coupon.use_terms,Coupon.send,Ctype.content,Coupon.gold,Coupon.gold_type,Coupon.created_date,Coupon.event,DATEDIFF(SUBSTRING_INDEX(Coupon.terms,'|',-1), CURDATE()) as Diff");
        $this->db->from("tbl_coupon as Coupon");
        $this->db->join("tbl_coupon_type as Ctype","Ctype.id=Coupon.coupon_type");
        $this->db->where('Coupon.event',0);
        $this->db->where('SUBSTRING_INDEX(Coupon.terms,"|",1) <=',date("Y-m-d"));
        $this->db->where('SUBSTRING_INDEX(Coupon.terms,"|",-1) >=',date("Y-m-d"));
        $this->db->or_where("Coupon.event",1);
        $this->db->where("Coupon.use",1);
        $this->db->where('SUBSTRING_INDEX(Coupon.terms,"|",1) <=',date("Y-m-d"));
        if($event_coupon !=0)  $this->db->where('Coupon.event_coupon',$event_coupon);
        $query = $this->db->get();
        $results = $query->result();
        return $results; 
    }

    public function getPriceTotalByDel($val1,$val2){
        $this->db->select('*');
        $this->db->from('delivery');
        $this->db->where('id',$val1);
        $query = $this->db->get();
        $results = $query->result();
        $price = (int)str_replace(",","",$results[0]->sending_price);
        $golds = 0;
        $aa = array();
        $ss = $this->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$val1)));
        if(!empty($ss)) $aa = json_decode($ss[0]->content,true);
        if($val2 !=""){
            $aaa = explode(",", $val2);
            foreach ($aaa as $key => $value) {
               $resultss = $this->getCouponByCode($value);
               if(!empty($resultss)){
                    if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==1)  $golds =$golds + (int)$resultss[0]->gold;
                    if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==1)  $golds =$golds + $price*(int)$resultss[0]->gold/100;
                    if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==7)  $golds =$golds + (int)$resultss[0]->gold;
                    if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==7)  $golds =$golds + $price*(int)$resultss[0]->gold/100;
                    if(!empty($aa)){
                        if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==2)
                            $golds +=($aa[7] - (int)$resultss[0]->gold) <= 0 ? $aa[7] : (int)$resultss[0]->gold;
                        if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==2)  
                            $golds =$golds + $aa[7]*(int)$resultss[0]->gold/100;
                        if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==3)
                            $golds += ($aa[8] - (int)$resultss[0]->gold) <= 0 ? $aa[8] : (int)$resultss[0]->gold;
                        if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==3)  
                            $golds =$golds + $aa[8]*(int)$resultss[0]->gold/100;
                        if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==4)
                            $golds += ($aa[54] - (int)$resultss[0]->gold) <= 0 ? $aa[54] : (int)$resultss[0]->gold;
                        if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==4)  $golds =$golds + $aa[54]*(int)$resultss[0]->gold/100;
                        if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==5)
                            $golds += ($aa[47] - (int)$resultss[0]->gold) <= 0 ? $aa[47] : (int)$resultss[0]->gold;
                        if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==5)  $golds =$golds + $aa[47]*(int)$resultss[0]->gold/100;
                        if($resultss[0]->gold_type ==1 && $resultss[0]->coupon_type==6)
                            $golds += ($aa[51] - (int)$resultss[0]->gold) <= 0 ? $aa[51] : (int)$resultss[0]->gold;
                        if($resultss[0]->gold_type ==2 && $resultss[0]->coupon_type==6)  $golds =$golds + $aa[51]*(int)$resultss[0]->gold/100;
                    }
               }
                
            }
            
            
        }
        return ($price-$golds) < 0 ? 0:$price-$golds;
    }
    public function getCouponByCode($code){
        $this->db->select('BaseTbl.*,Coupon.gold,Coupon.gold_type,Coupon.coupon_type');
        $this->db->from('tbl_coupon_user as BaseTbl');
        $this->db->join('tbl_coupon as Coupon','Coupon.id=BaseTbl.coupon_id');
        $this->db->where('BaseTbl.code',$code);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPSum($id){
        $this->db->select("SUM(count) as count,SUM(count*unitPrice) as price");
        $this->db->from("tbl_purchasedproduct");
        $this->db->where('delivery_id',$id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getPBasket($ids){
        $this->db->select("SUM(Basket.count) as count,SUM(Basket.count*(BaseTbl.orgprice+BaseTbl.addprice)) as price");
        $this->db->from("tbl_sproducts as BaseTbl");
        $this->db->join("tbl_basket as Basket","Basket.productId=BaseTbl.id");
        foreach ($ids as $key => $value) {
            $this->db->or_where('Basket.id',$value);
        }
        $query =  $this->db->get();
        return $query->result();
    }

    public function incBasket($id){
        $this->db->where('productId', $id);
        $this->db->where('userId', $this->session->userdata('fuser'));
        $this->db->set('count', 'count+1', FALSE);
        $this->db->update('tbl_basket');
    }

    public function decreaseC($id,$c){
        $this->db->where('id', $id);
        $this->db->set('count', 'count-'.$c, FALSE);
        $this->db->update('tbl_sproducts');
    }

    public function getBasket($ids=null){
        $this->db->select("BaseTbl.*,Sp.i1,Sp.eg_name as name,SUM(Sp.orgprice+Sp.addprice) as Price,Sp.brand,Sp.category,BaseTbl.size,BaseTbl.color,Sp.rid");
        $this->db->from("tbl_basket as BaseTbl");
        $this->db->join('tbl_sproducts as Sp','Sp.id=BaseTbl.productId');
        if($ids !=null)
            foreach ($ids as $key => $value) {
                 $this->db->or_where('BaseTbl.id',$value);
            }
        $this->db->where('BaseTbl.userId',$this->session->userdata('fuser'));
        $this->db->order_by('BaseTbl.updated_time',"DESC");
        $this->db->group_by('BaseTbl.productId');
        $this->db->group_by('BaseTbl.color');
        $this->db->group_by('BaseTbl.size');
        $query =  $this->db->get();
        return $query->result();
    }

    public function getUsedCoupon($limit1=null,$limit2=""){
        $limit = "";
        if($limit2 == null) $limit2 =0;
        if($limit1 == null)
            $limit = "";
        else $limit = "LIMIT ".$limit2.",".$limit1;
        $query = $this->db->query("SELECT 
                                          `Coupon`.`gold`,
                                          `Coupon`.`coupon_type`,
                                          `Coupon`.`use_terms`,
                                          `Coupon`.`created_date`,
                                          `BaseTbl`.`updated_date`,
                                          `Ctype`.`content`,
                                          `BaseTbl`.`id`,
                                          `Coupon`.`gold_type`,
                                          `Coupon`.`terms`,
                                          `BaseTbl`.`used`,
                                          `BaseTbl`.`byd`,
                                          `Coupon`.`event` 
                                        FROM
                                          `tbl_coupon_user` AS `BaseTbl` 
                                          JOIN `tbl_coupon` AS `Coupon` 
                                            ON `Coupon`.`id` = `BaseTbl`.`coupon_id` 
                                          JOIN `tbl_coupon_type` AS `Ctype` 
                                            ON `Ctype`.`id` = `Coupon`.`coupon_type` 
                                        WHERE `BaseTbl`.`userId` = '".$this->session->userdata("fuser")."' 
                                          AND (
                                           
                                             (
                                              CASE
                                                WHEN Coupon.event = 1 
                                                THEN BaseTbl.byd < '".date("Y-m-d")."' 
                                                ELSE SUBSTRING_INDEX(Coupon.terms, \"|\", - 1) < '".date("Y-m-d")."'
                                            OR SUBSTRING_INDEX(Coupon.terms, \"|\", 1) > '".date("Y-m-d")."'
                                              END
                                            ) OR BaseTbl.used=1
                                          ) 
                                        ORDER BY `BaseTbl`.`updated_date` DESC ".$limit);
        return $query->result_array();
    }

     public function getPayHistory($shkey = null,$begin=null,$end=null,$limit1=null,$limit2=0){
        $this->db->select("BaseTbl.*,Delivery.ordernum");
        $this->db->from("tbl_payhistory as BaseTbl");
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->where('BaseTbl.userId',$this->session->userdata("fuser"));
        if($shkey!=null){
           $this->db->where('BaseTbl.payed_type',$shkey);
        }
        else {
            $this->db->group_start();
            $this->db->or_where('BaseTbl.payed_type',4);
            $this->db->or_where('BaseTbl.payed_type',5);
            $this->db->group_end();
        }
        if($begin !=null) $this->db->where('BaseTbl.updated_date >=',$begin);
        if($end !=null) $this->db->where('BaseTbl.updated_date <=',$end);
        $this->db->order_by("BaseTbl.updated_date","DESC");
        $this->db->group_by("BaseTbl.security");
        if($limit1 !=null) $this->db->limit($limit1,$limit2);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getDepositHistory($limit1=0,$limit2=null ,$from,$to){
            $where = "";
            if($limit1 == null) $limit1 =0;
            if($limit2 == null)
                $limit = "";
            else
                $limit= "limit ".$limit1.",".$limit2;

            if(!empty($from) && trim($from) !="")
                $where .= " AND  BaseTbl.updated_date >='".$from."'";
            if(!empty($to)  && trim($to) !="")
                $where .= " AND BaseTbl.updated_date < '".date('Y-m-d', strtotime('+1 day', strtotime($to)))."'";
            $query = $this->db->query("SELECT A.* FROM (SELECT  Delivery.ordernum,BaseTbl.by,BaseTbl.amount,BaseTbl.updated_date,BaseTbl.payed_type AS typess,BaseTbl.all_amount AS plus,tt,BaseTbl.pending FROM tbl_payhistory AS `BaseTbl` LEFT JOIN `delivery` AS `Delivery` 
                                            ON `Delivery`.`id` = `BaseTbl`.`delivery_id` WHERE BaseTbl.payed_type!=10 AND BaseTbl.amount > 0 and BaseTbl.userId=".$this->session->userdata('fuser')."  ".$where." ) AS A 
                                                  ORDER BY A.updated_date DESC ".$limit);
        return $query->result_array();
    } 
    public function getDeliveryAvailableCombine($id,$address=null,$center=null,$type=1){
        $this->db->select("Product.*,BaseTbl.address,BaseTbl.place,BaseTbl.ordernum,BaseTbl.billing_krname,Address.area_name,BaseTbl.get,BaseTbl.updated_date");
        $this->db->from("tbl_purchasedproduct as Product");
        $this->db->join("delivery as BaseTbl","BaseTbl.id=Product.delivery_id");
        $this->db->join("delivery_address as Address","Address.id=BaseTbl.place");
        $this->db->where('BaseTbl.combine','-1');
        if($type==1) $this->db->where("BaseTbl.id",$id);
        if($type==2) $this->db->where("BaseTbl.id!=",$id);
        if($address!=null) $this->db->where("BaseTbl.address",$address);
        if($center!=null) $this->db->where("BaseTbl.place",$center);
        $this->db->where("BaseTbl.sending_price",0);
        $this->db->where("BaseTbl.payed_send",0);
        $this->db->where("Product.step",101);
        $this->db->where("(BaseTbl.state='2' OR BaseTbl.state='11' OR BaseTbl.state='7')", NULL, FALSE);
        $this->db->order_by("Product.created_date","ASC");
        $query =  $this->db->get();
        return $query->result();
    }
    public function viewPhoto($id){
        $this->db->select("BaseTbl.*,Delivery.ordernum,Delivery.billing_krname");
        $this->db->from("tbl_delivery_comment as BaseTbl");
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->where("BaseTbl.delivery_id",$id);
        $query =  $this->db->get();
        return $query->result();
    }
    public function getErrorProductsCount(){
        $this->db->select("Delivery.id");
        $this->db->from("delivery as Delivery");
        $this->db->join("tbl_purchasedproduct as Product","Product.delivery_id=Delivery.id");
        $this->db->where("Product.step",102);
        $this->db->where("Delivery.state !=",13);
        $this->db->where("Delivery.state !=",17);
        $this->db->where("Delivery.state !=",18);
        $this->db->where("Delivery.state !=",19);
        $this->db->where("Delivery.state !=",20);
        $this->db->where("Delivery.state !=",21);
        $this->db->where("Delivery.state !=",24);
        $this->db->where("Delivery.userId",$this->session->userdata('fuser'));
        $this->db->group_by("Product.delivery_id");
        $query = $this->db->get();
        $results = $query->result();
        return sizeof($results);
    }
    public function getReq($id,$limit1=10,$limit2=0,$category=null,$item=null,$content=null,$gg=null){
        $ii=0;
        if(!empty($this->session->userdata('fuser')) || $this->session->userdata('fuser') > 0 ){
           $ii=$this->session->userdata('fuser');                 
        }
        $this->db->select('BaseTbl.*,User.name as UserName,Board.iden,COUNT(Comment.id) as comment_count,User.nickname as NickName');
        $this->db->from('tbl_mail as BaseTbl');
        $this->db->join("tbl_users as User","User.userId=BaseTbl.fromId");
        $this->db->join("tbl_board as Board","Board.id=BaseTbl.type");
        $this->db->join("tbl_comment as Comment","Comment.postId=BaseTbl.id","left");
        if($gg !=null) $this->db->where('Board.title',$gg);
        else $this->db->where('BaseTbl.type',$id);
        if($category !=null && $category !="") $this->db->where('BaseTbl.category',$category);
        if($content !=null && $content !=""){
            if($item =="A")
                $this->db->like('BaseTbl.title',$content,"both");
            if($item =="B")
                $this->db->like('User.name',$content,"both");
        }
        if($limit1!=null) $this->db->limit($limit1,$limit2);
        $this->db->order_by("BaseTbl.letter_l","DESC");
        $this->db->order_by('BaseTbl.updated_date','DESC');
        $this->db->group_by('BaseTbl.id');
        $query = $this->db->get();
        $results = $query->result();
        return  $results; 
    }
    public function getReqById($id){
        $this->db->select('BaseTbl.*,User.name as UserName,Board.category_use,Board.category as bcategory,Board.state_use as bstate_use,Board.state as bstate,Board.title as btitle,Board.recommend_use,Board.wrview_use,Board.download_use,Board.comment_use,Board.writing_use,Board.iden,Board.id as bid');
        $this->db->from('tbl_mail as BaseTbl');
        $this->db->join("tbl_users as User","User.userId=BaseTbl.fromId");
        $this->db->join("tbl_board as Board","Board.id=BaseTbl.type");
        $this->db->where('BaseTbl.id',$id);
        $this->db->order_by('BaseTbl.updated_date','DESC');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getProductShoppinmal($delivery_id){
        $this->db->select("BaseTbl.*,Po.point");
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->join('tbl_sproducts as Po','Po.id=BaseTbl.shop');
        $this->db->where("BaseTbl.delivery_id",$delivery_id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getPointHistory($limit1=null,$limit2=null,$sd=null,$ed=null,$s=null,$shType=null){
        $this->db->select("tbl_point_users.*,Usrs.name,Usrs.loginId");
        $this->db->from("tbl_point_users");
        $this->db->join('tbl_users as Usrs','Usrs.userId=tbl_point_users.userId');
        if($sd !=null) 
            $this->db->where("tbl_point_users.created_date >=",$sd );
        if($ed !=null) 
            $this->db->where("tbl_point_users.created_date <=",$ed );
        if($s !=null){
            if($s =="Y") $this->db->where("tbl_point_users.s",0 );
            if($s =="N") $this->db->where("tbl_point_users.s",1 );
        }
        if($shType !=null){
            if($shType =="A") $this->db->where("tbl_point_users.type",1 );
            if($shType =="B") $this->db->where("tbl_point_users.type",2 );
            if($shType =="C") $this->db->where("tbl_point_users.type",3 );
            if($shType =="D") $this->db->where("tbl_point_users.type",5 );
            if($shType =="E") $this->db->where("tbl_point_users.type",4 );
        }
        $this->db->where("tbl_point_users.userId",$this->session->userdata('fuser') );
        $this->db->order_by("tbl_point_users.created_date","DESC");
        if($limit1 !=null) $this->db->limit($limit1,$limit2);
        $query =  $this->db->get();
        return $query->result();
    }
    public function getServices(){
        $this->db->select("BaseTbl.*,Part.name as ppart");
        $this->db->from("tbl_services as BaseTbl");
        $this->db->join('tbl_service_header as Part','Part.id=BaseTbl.part');
        $this->db->where("BaseTbl.use",1);
        $this->db->where("Part.use",1);
        $this->db->order_by("BaseTbl.part","part");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }
     public function getDeliveryByService($id){
        $this->db->select("BaseTbl.*,Part.content");
        $this->db->from("delivery as BaseTbl");
        $this->db->join('tbl_service_delivery as Part','Part.delivery_id=BaseTbl.id','left');
        $this->db->where("BaseTbl.rid",$id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getDeCrea($r=null){
        $a = "";
        if($r!=null)
            $a = " LIMIT ".$r." ".$r+6;
        $ff = $this->db->query("SELECT * FROM `tbl_sproducts` WHERE `use` = 1 AND `sold` = 1 AND `singo` > orgprice+addprice ORDER BY `updated_date` DESC ".$a);
        return $ff->result();
    }
    public function getRecommendProducts($id,$category){
        $query =  $this->db->query("SELECT `BaseTbl`.* FROM `tbl_sproducts` AS `BaseTbl` WHERE `BaseTbl`.`id` != '".$id."' AND (`BaseTbl`.`category` = '".$category."' OR `BaseTbl`.`new` = 1) ORDER BY RAND() LIMIT 15");
        return $query->result();
    }

    public function getProductWithCategory($id){
        $this->db->select("BaseTbl.*,Category.en_subject,Category.kr_subject,Category.chn_subject,Delivery.ordernum,Delivery1.combine,Delivery.rid,Delivery1.ordernum AS new_order,Delivery1.rid as drid,Delivery.combine as dcombine,Delivery1.type,Delivery.type as dtype");
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->join('tbl_category as Category','Category.id=BaseTbl.category','left');
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.old_delivery_id','left');
        $this->db->join('delivery as Delivery1','Delivery1.id=BaseTbl.delivery_id','left');
        $this->db->where("BaseTbl.delivery_id",$id);
        $this->db->or_where("BaseTbl.old_delivery_id",$id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getCategoryBySh(){
        $this->db->select('Category.name,Category.image,Category.id');
        $this->db->from('tbl_sproducts as BaseTbl');
        $this->db->join('tbl_shop_category as Category','Category.id = BaseTbl.shop_category');
        $this->db->where("BaseTbl.use",1);
        $this->db->group_by("Category.id");
        $query = $this->db->get();
        $user = $query->result();
        return $user;
    }

    public function getProductsBySh($limit1=-1,$limit2=-1){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_sproducts as BaseTbl');
        $this->db->join('tbl_shop_category as Category','Category.id = BaseTbl.shop_category');
        $this->db->where("BaseTbl.use",1);
        if($limit1 !=-1)  $this->db->limit($limit1,$limit2);
        $this->db->order_by("BaseTbl.updated_date","DESC");
        $query = $this->db->get();
        $user = $query->result();
        return $user;
    }

    function getUserInfo($userId)
    {
        $this->db->select('BaseTbl.*,Roles.role,Roles.level,Roles.sending_inul,Roles.address_rate');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join("tbl_roles as Roles","Roles.roleId=BaseTbl.roleId","left");
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->where('BaseTbl.userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    public function getOrdersFromSecurity($security){
        $this->db->select("Delivery.ordernum,Delivery.rid");
        $this->db->from("tbl_payhistory as BaseTbl");
        $this->db->join("delivery as Delivery","Delivery.id=BaseTbl.delivery_id");
        $this->db->where("BaseTbl.security",$security);
        $query = $this->db->get();
        return $query->result();
    }
}?>

