<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
  public function Update_login_data()
  {
    $data = array(
      'last_activity' => date('Y-m-d H:i:s')
    );
    $this->db->where('login_data_id', $this->session->userdata('id'));
    $this->db->update('login_data', $data);
  }
  public function User_last_activity($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->order_by('login_data_id', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('login_data');
    foreach ($query->result() as $row)
    {
      return $row->last_activity;
    }
  }
  public function getData($table, $where = "", $options = array())
  {
    if (isset($options['field']))
    {
      $this->db->select($options['field']);
    }
    if ($where != "")
    {
      $this->db->where($where);
    }
    if (isset($options['where_in']) && isset($options['where_in']))
    {
      $this->db->where_in($options['colname'], $options['where_in']);
    }
    if (isset($options['sort_by']) && isset($options['sort_direction']))
    {
      $this->db->order_by($options['sort_by'], $options['sort_direction']);
    }
    if (isset($options['group_by']))
    {
      $this->db->group_by($options['group_by']);
    }
    if (isset($options['limit']) && isset($options['offset']))
    {
      $this->db->limit($options['limit'], $options['offset']);
    }
    else
    {
      if (isset($options['limit']))
      {
        $this->db->limit($options['limit']);
      }
    }
    $query = $this->db->get($table);
    $result = $query->result_array();
    if (!empty($options) && in_array('count', $options))
    {
      return count($result);
    }
    if ($result)
    {
      if (isset($options) && in_array('single', $options))
      {
        return $result[0];
      }
      else
      {
        return $result;
      }
    }
    else
    {
      if (isset($options) && in_array('api', $options))
      {
        return array();
      }
      return false;
    }
  }
  public function getField($table, $data)
  {
    $post = array();
    $fields = $this->db->list_fields($table);
    foreach ($data as $key => $value)
    {
      if (in_array($key, $fields))
      {
        $post[$key] = $value;
      }
    }
    return $post;
  }
  public function getFieldKey($table)
  {
    return $this->db->list_fields($table);
  }
  public function insertData($table, $data)
  {
    return $this->db->insert($table, $data);
  }
  public function updateData($table, $data, $where)
  {
    return $this->db->update($table, $data, $where);
  }
  public function checkTrue()
  {
    if ($this->db->affected_rows())
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function deleteData($table, $where)
  {
    return $this->db->delete($table, $where);
  }
  function query($sql)
  {
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    else
    {
      return FALSE;
    }
  }
  public function whereIn($table, $colname, $in, $where = array())
  {
    $this->db->where($where);
    $search = "FIND_IN_SET('" . $in . "', $colname)";
    $this->db->where($search);
    $query = $this->db->get($table);
    $result = $query->result_array();
    if ($result)
    {
      return $result[0];
    }
    else
    {
      return false;
    }
  }
  public function arrayToName($table, $field, $array)
  {
    foreach ($array as $value)
    {
      $name[] = $this->getData($table, array(
        'id' => $value
      ) , array(
        'field' => $field,
        'single'
      ));
    }
    if (!empty($name))
    {
      foreach ($name as $key => $value)
      {
        $name1[] = $value[$field];
      }
      return implode(',', $name1);
    }
    else
    {
      return false;
    }
  }
  public function sendMail($to, $subject, $message, $options = array())
  {
    $msg = "";
    include (APPPATH . 'third_party/phpmailer/class.phpmailer.php');
    $account = "admin@mailbox.bringitasap.com";
    $password = "Wealthnow111";
    $msg .= $message;
    $from = "no-reply@quickkitty.com";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host = "mailbox.bringitasap.com";
    $mail->SMTPAuth = true;
    $mail->Port = 587; // Or 587
    $mail->Username = $account;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->From = $from;
    $mail->Body = $msg;
    $mail->FromName = "Quickkitty Inc.";
    $mail->isHTML(true);
    $mail->Subject = $subject;
    if (!empty($options))
    {
      while (list($key, $val) = each($options))
      {
        $mail->addAddress($val);
      }
    }
    else
    {
      $mail->addAddress($to);
    }
    $send = $mail->send();
    if ($send)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function do_upload($file, $path)
  {
    $this->load->library('image_lib');
    $config['upload_path'] = $path;
    $config['encrypt_name'] = true;
    $config['allowed_types'] = '*';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload($file))
    {
      $error = array(
        'error' => $this->upload->display_errors()
      );
      $data['error_msg'] = $this->upload->display_errors();
      return $error;
    }
    else
    {
      $image_data = $this->upload->data();
      $configer = array(
        'image_library' => 'gd2',
        'source_image' => $image_data['full_path'],
        'maintain_ratio' => TRUE,
        'width' => 500,
        'height' => 500,
      );
      $this->image_lib->clear();
      $this->image_lib->initialize($configer);
      $this->image_lib->resize();
      $data = array(
        'upload_data' => $this->upload->data()
      );
      $data['success_msg'] = 'File has been uploaded successfully.';
      return $data;
    }
  }
  public function file_compress($userfileName, $path)
  {
    $this->load->library('image_lib');
    $config['upload_path'] = $path;
    $config['encrypt_name'] = true;
    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPD|PMG|jpd|pmg';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload($userfileName))
    {
      $error = array(
        'error' => $this->upload->display_errors()
      );
      $data['error_msg'] = $this->upload->display_errors();
      return $error;
    }
    else
    {
      $image_data = $this->upload->data();
      $configer = array(
        'image_library' => 'gd2',
        'source_image' => $image_data['full_path'],
        'maintain_ratio' => TRUE,
        'width' => 500,
        'height' => 500,
      );
      $this->image_lib->clear();
      $this->image_lib->initialize($configer);
      $this->image_lib->resize();
      $data = array(
        'upload_data' => $this->upload->data()
      );
      $data['success_msg'] = 'File has been uploaded successfully.';
    }
  }
  
  public function multi_upload($file, $path)
  {
    $config = array();
    $config['upload_path'] = $path; // upload path eg. - './resources/images/products/';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    //$config['max_size']      = '0';
    $config['overwrite'] = FALSE;
    $this->load->library('upload', $config);
    $dataInfo = array();
    $files = $_FILES;
    foreach ($files[$file]['name'] as $key => $image)
    {
      $_FILES[$file]['name'] = $files[$file]['name'][$key];
      $_FILES[$file]['type'] = $files[$file]['type'][$key];
      $_FILES[$file]['tmp_name'] = $files[$file]['tmp_name'][$key];
      $_FILES[$file]['error'] = $files[$file]['error'][$key];
      $_FILES[$file]['size'] = $files[$file]['size'][$key];
      $this->upload->initialize($config);
      if ($this->upload->do_upload($file))
      {
        $dataInfo[] = $this->upload->data();
      }
      else
      {
        return $this->upload->display_errors();
      }
    }
    if (!empty($dataInfo))
    {
      return $dataInfo;
    }
    else
    {
      return false;
    }
  }
  function get_record_join_two_table($table1, $table2, $id1, $id2, $column = '', $where = '', $orderby = '', $options = array())
  {
    if ($column != '')
    {
      $this->db->select($column);
    }
    else
    {
      $this->db->select('*');
    }
    $this->db->from($table1);
    $this->db->join($table2, $table2 . '.' . $id2 . '=' . $table1 . '.' . $id1);
    if ($where != '')
    {
      $this->db->where($where);
    }
    if ($orderby != '')
    {
      $this->db->order_by($orderby, 'desc');
    }
    $query = $this->db->get();
    $result = $query->result_array();
    if ($result)
    {
      if (isset($options) && in_array('single', $options))
      {
        return $result[0];
      }
      else
      {
        return $result;
      }
    }
    else
    {
      return false;
    }
  }
  function get_data_join_four_tabel_where($table1, $table2, $table3, $table4, $id1, $id2, $id3, $id4, $id5, $id6, $column = '', $where, $orderby = '', $options = array())
  {
    if ($column != '')
    {
      $this->db->select($column);
    }
    else
    {
      $this->db->select('*');
    }
    $this->db->from($table1);
    $this->db->join($table2, $table2 . '.' . $id1 . '=' . $table1 . '.' . $id2);
    $this->db->join($table3, $table3 . '.' . $id3 . '=' . $table1 . '.' . $id4);
    $this->db->join($table4, $table4 . '.' . $id5 . '=' . $table1 . '.' . $id6);
    $this->db->where($where);
    if ($orderby != '')
    {
      $this->db->order_by($orderby, 'desc');
    }
    $query = $this->db->get();
    $result = $query->result_array();
    if ($result)
    {
      if (isset($options) && in_array('single', $options))
      {
        return $result[0];
      }
      else
      {
        return $result;
      }
    }
    else
    {
      return false;
    }
  }
  //////////////////////////////Notification///////////////////
    public function sendNotification_android($tokens, $message, $data = array())
    {   
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
          'registration_ids' => $tokens,
          "notification" => $message,
          "data" => $data
        );

         $headers = array(
        'Authorization:key = AAAANFh56N0:APA91bHENFNVUtdkMfrKeXm9iQ5l0UkLfWtKcK4FlNwAoksYFs33VAoewlY33cEBpq5Ym9gwHOdJivlWMmS--ubW7BlIje7SeA3JAWHmf86ift0C6XGcp2DL8AaElimy7g1CssGlxAVv',
        'Content-Type: application/json'
        );
      
        return $this->curl($url,$headers,$fields);

    }
  
    public function sendNotification_ios($tokens,$message,$title,$type,$data)
    {   
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = 'AAAAXPc5J3I:APA91bFC__hpGiHMjZkmCO3-Q941xAS29aXLmhe3gOBm9XVBK2wbRsEL3pPLVNE39XEhj89e4E1FiMJNhQ4KZApwi2zlrMadC9Mv6Viw0-0fU5m4YA4VkTscx4Vov7Iyo2Jvuj8aHsB-';
        
        $notification = array('title'=>$title,"body"=>$message,'text'=>$data,'type'=>$type,'sound'=>'default','badge'=>'1');
        $fields = array('to' => $tokens,'data'=>$data,'notification' => $notification,'priority'=>'high');
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        return $this->curl($url,$headers,$fields);
    
    }
     public function curl($url, $headers, $fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE)
        {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
////////////////////////////////////////////new functions////////////////
public function reply_post_comment($comments,$post_id=""){
 if(!empty($comments)){
    $data = array();
    $this->db->select('*'); 
    $this->db->where('post_id',$post_id);   

    if(!empty($comments[0])){

                    $where = '';$a=1;
                    foreach($comments as $comm){
                        if($a>1){
                            $where .= " OR ";
                        }
                        $where .= "FIND_IN_SET('".$comm."',refer_id) <> 0"; 
                        $a++;
                    }if($where !=""){
                      $this->db->where( '('.$where.')' );
                    }
                    
                }   
      $this->db->from('post_comment');
      $this->db->order_by('comment_id','desc');

      $query = $this->db->get();
      if($query->num_rows()>0)
      {

          $row = $query->result_array();
          if(!empty($row)){
          foreach($row as $value){ 

              $data[] = $value['comment_id'];
          }

           return $data;
       }else{
        return $data;
       }

      }
      else
      {
          return array();
      }
    }
 }
public function post_comments($post_id=""){
  $this->db->select('*'); 
  $this->db->where('post_id',$post_id);
  $this->db->where('refer_id',0);
  $this->db->from('post_comment');
  $this->db->order_by('comment_id','desc');
  $query = $this->db->get();
  if($query->num_rows()>0)
  {
      $row = $query->result_array();
      return $row;
  }
  else
      {
      return "";
      }
}
public function fetch_post_reply_comments($article_id,$parent_id,$user_id) { 
    $sql = "select  comment_id,post_id,reciever_id,sender_id,message,created_date,created_time,created_at,refer_id,total_like 
    from    (select * from post_comment
             order by refer_id,comment_id) products_sorted,
            (select @pv := '".$parent_id."') initialisation
    where   find_in_set(refer_id, @pv)
    and     length(@pv := concat(@pv, ',', comment_id))
    and post_id = '".$article_id."'";// order by refer_id asc,created_at desc
    $query = $this->db->query($sql);
    //echo $this->db->last_query();
    $comments =  $query->result_array();
    $comm = array();
    if(!empty($comments)){
      foreach ($comments as $key => $value) {
         $user =$this->common->getData('user',array('id'=>$value['sender_id']),array('single'));

         $like = $this->common->getData('post_comment_like',array("comment_id"=>$value['comment_id'],"user_id"=>$user_id),array('single'));              
          if(!empty($like)){
              $value['is_comment_like'] = 1;
          }else{
              $value['is_comment_like'] = 0;
          }    
          $value['full_name'] = $user['full_name'];
          $value['profile_image'] = $user['profile_image'];
          $value['email'] = $user['email'];
          $comm[] = $value;
      }
    }
     return $comm;   
}

public function getcomment($post_id,$user_id){
    $this->db->select('P.*,U.full_name,U.profile_image,U.email');
    $this->db->from('post_comment as P');
    $this->db->join('user as U', 'U.id = P.sender_id');
    $this->db->where('P.post_id',$post_id);
    $this->db->where('P.refer_id',0);
    $query = $this->db->get();
    $comments =  $query->result_array();
     if(!empty($comments)){
        foreach ($comments as $key => $value) {

          $value['post_reply'] =  $this->common->fetch_post_reply_comments($value['post_id'], $value['comment_id'],$user_id); 

          $value['total_reply'] = count($value['post_reply']);

         $like = $this->common->getData('post_comment_like',array("comment_id"=>$value['comment_id'],"user_id"=>$user_id),array('single'));              
        if(!empty($like)){
              $value['is_comment_like'] = 1;
          }else{
              $value['is_comment_like'] = 0;
          }  
          $data[] = $value;

        }
        return $data;
    }
}
public function fetch_reels_reply_comments($article_id,$parent_id,$user_id) { 
    $sql = "select  comment_id,reels_id,reciever_id,sender_id,message,created_date,created_time,refer_id,created_at,total_like 
    from    (select * from reels_comment
             order by refer_id asc,comment_id desc) products_sorted,
            (select @pv := '".$parent_id."') initialisation
    where   find_in_set(refer_id, @pv)
    and     length(@pv := concat(@pv, ',', comment_id))
    and reels_id = '".$article_id."' ";//order by refer_id asc,comment_id desc
    $query = $this->db->query($sql);
   // echo $this->db->last_query();
    $comments =  $query->result_array();
    $comm = array();
    if(!empty($comments)){
      foreach ($comments as $key => $value) {
         $user =$this->common->getData('user',array('id'=>$value['sender_id']),array('single'));

          $like = $this->common->getData('reels_comment_like',array("comment_id"=>$value['comment_id'],"user_id"=>$user_id),array('single'));              
          if(!empty($like)){
              $value['is_comment_like'] = 1;
          }else{
              $value['is_comment_like'] = 0;
          }    

          $value['full_name'] = $user['full_name'];
          $value['profile_image'] = $user['profile_image'];
          $value['email'] = $user['email'];
          $comm[] = $value;
      }
    }
     return $comm;   
}
public function get_reels_comment($post_id,$user_id){
    $this->db->select('P.*,U.full_name,U.profile_image,U.email');
    $this->db->from('reels_comment as P');
    $this->db->join('user as U', 'U.id = P.sender_id');
    $this->db->where('P.reels_id',$post_id);
    $this->db->where('P.refer_id',0);
    $query = $this->db->get();
    $comments =  $query->result_array();
     if(!empty($comments)){
        foreach ($comments as $key => $value) {

          $value['reels_reply'] =  $this->common->fetch_reels_reply_comments($value['reels_id'], $value['comment_id'],$user_id); 
          $value['total_reply'] = count($value['reels_reply']);

           $like = $this->common->getData('reels_comment_like',array("comment_id"=>$value['comment_id'],"user_id"=>$user_id),array('single'));              
        if(!empty($like)){
              $value['is_comment_like'] = 1;
          }else{
              $value['is_comment_like'] = 0;
          }  
          $data[] = $value;
        }
        return $data;
    }
}
public function send_all_notification($user_id,$message,$type,$ref_type,$data=array()){
        $userdetail = user_detail($user_id);
        $title =   $type;
        
        $body = $message;
        $msg_notification = array("body" =>$body,"title"=>$title);  
        if($userdetail['device_type'] == "1" && !empty($userdetail['android_token']))
        {
          $res = $this->common->sendNotification_android(array($userdetail['android_token']), $msg_notification, $data);
        
        }   
        if($userdetail['device_type'] == "2" && !empty($userdetail['ios_token']))
        {
            $messages_push =  array("notification" => $msg_notification,"notification_type" => 'Artist Army','data'=>$data);
            $res = $this->common->sendNotification_ios($userdetail['ios_token'],$body,$title,$type,$messages_push); 
              
        }

        if($res){
            $json_array=json_decode($res ,true);
            $created_at = date('Y-m-d H:i:s');
            if($json_array["success"]>0){
                $noti  =  array('message'=>$body,'user_id'=>$user_id,'created_at'=>$created_at,
                  'type_name'=>$type);
                $result = $this->common->insertData('notification', $noti);
            }
        }

     return $res;
    }    
  public function artist_refer_detail($ref_artist_id,$ref_user_id,$fans_id)
  {

      $insertid = 0;
       $credit_amount = $this->common->getData('credit_amount',array(),array());
      $amount = $credit_amount[0]['amount'];
    
      $share_link = 'deeplinking/artist_army.php?artist_id='.$ref_artist_id.'&user_id='.$ref_user_id.'&type=3';

      $credits = array("refer_id" => $ref_user_id, "fans_id" =>$fans_id, "artist_id" => $ref_artist_id, "amount" => $amount,"song_no" => '0');

      $artist_arr = array("artist_id" => $ref_artist_id, "user_id" =>$ref_user_id, "share_to" => $fans_id,'share_link'=>$share_link);
      $getcredits = $this->common->getData('credits',$credits,array('single'));


      $getartistshare = $this->common->getData('artist_page_share',$artist_arr,array('single'));

      if(empty($getcredits))
      {
        $update = $this->common->updateData('user', array('ref_user_id'=>$ref_user_id,'ref_artist_id'=>$ref_artist_id),array('id' => $fans_id));

        $insertid = $this->common->insertData('credits',$credits);

        $amounthalf = floatval($amount/2);
        $credits1 = array("refer_id" => $fans_id, "fans_id" => $ref_user_id, "artist_id" => $ref_artist_id, "amount" =>$amounthalf,"song_no" => "0",'ref_fans_id'=>$fans_id);

        $result = $this->common->insertData('credits', $credits1);
                  
      }
      if(empty($getartistshare))
      {
         $addshare = $this->common->insertData('artist_page_share',$artist_arr);
         $shareid = $this->db->insert_id();
          if (!empty($shareid)) {
                
                $reciver = user_detail($fans_id);
                $sender = user_detail($ref_user_id);

                $result = $this->common->insertData('chat_messages', array('sender_id' => $ref_user_id, 'sender_name' => isset($sender['full_name']) ? $sender['full_name'] : "", 'sender_image' => $sender['profile_image'], 'receiver_id' => $fans_id, 'receiver_name' => $reciver['full_name'], 'receiver_image' => $reciver['profile_image'], 'messages' => $share_link, 'image' => "", "type" => "3", 'refer_id'=>$ref_artist_id,'datetime' => strtotime(date('Y-m-d'))));

                $notifi = $this->send_all_notification($ref_user_id,'You have earned '.$amount.' credit points ',"Credits");
              }
      }
        return $getcredits;
 }


public function credit_amount($fans_id,$user_id){
        $this->db->select('SUM(C.amount) as amount ,C.refer_id,C.artist_id,C.ref_fans_id,C.created_at,U.full_name,U.email,U.total_like,U.profile_image,U.id as fans_id');
        $this->db->from('credits as C');
        $this->db->join('user as U', 'U.id = C.refer_id');
        $this->db->where('C.refer_id', $fans_id);
        $this->db->where('C.artist_id', $user_id);
        $this->db->group_by('C.refer_id');
        $query = $this->db->get();
        $result = $query->result_array()[0];

        if ($result)
        {
           return $result;
        } else {
          return  array();
        }
      }

public function reels_list($user_id,$type="",$limit, $offset,$page_count){
      if (!empty($user_id)) {
      $subquery = "(exists (select 1
        from reels_like L
        where L.reels_id = R.id and L.user_id = '" . $user_id . "') ) as is_like , (exists (select 1
        from reels_favourite F
        where F.reels_id = R.id and F.user_id = '" . $user_id . "') ) as is_favourite ,";
      } else {
        $subquery = "";
      }
       $this->db->select("R.*,S.song_name,S.singer_name," . $subquery . " U.profile_image as user_profile_image,U.full_name as user_full_name,SUM(R.total_like + R.total_star) as sum_reel");
        $this->db->from('reels  as R');
        $this->db->join('user as U', 'R.user_id = U.id');
        $this->db->join('songs as S', 'S.id = R.reel_songs',"LEFT");
        $this->db->group_by('R.id');
        if($type == 1){
           $this->db->having('sum_reel > 0');
        }else{
           $this->db->having('sum_reel <= 1');
        }
        if(!empty($page_count)){
          $this->db->limit($offset,$limit);
          }
        $query = $this->db->get();
    // echo $this->db->last_query();
    // die;
        $list = $query->result_array();
   // $sql = "SELECT R.*,S.song_name,S.singer_name," . $subquery . " U.profile_image as user_profile_image,U.full_name as user_full_name,SUM(R.total_like + R.total_star) as sum_reel from reels as R  LEFT JOIN user as U ON R.user_id = U.id LEFT JOIN songs as S ON S.id = R.reel_songs GROUP BY R.id $having $limit";
   
     if ($list)
        {
           return $list;
        } else {
          return  array();
        }
}
public function add_post_comment($post_id){
      $this->db->select('P.*,U.android_token,U.ios_token,U.full_name');
      $this->db->from('user as U');
      $this->db->join('post as P', 'P.user_id = U.id');
      $this->db->where('P.id', $post_id);
      $query = $this->db->get();
      $post_list = $query->result_array()[0];
     if($post_list)
        {
          return $post_list;
        } else {
          return  array();
        }
}
public function genre_category($user_id,$search=""){
       if (!empty($user_id)) {
            $subquery = "(exists (select 1 from user L where  FIND_IN_SET(C.genre_id,L.genre_cat) <> 0 and L.id = '" . $user_id . "') ) as is_selected ,";
        } else {
            $subquery = "";
        }
        $this->db->select('C.*,' . $subquery);
        $this->db->from('genre_category as C');
        if (!empty($search)) {
            $this->db->where("genre_name LIKE '%" . $search . "%'");
        }
        $this->db->where('status', '0');
        $query = $this->db->get();
        $genre_category = $query->result_array();
        if($genre_category)
          {
            return $genre_category;
          } else {
            return  array();
          }
}
public function post_list($user_id="",$limit, $offset,$page_count){
        if(!empty($user_id)) {
        $subquery = "(exists (select 1  from post_like L where L.post_id = P.id and L.user_id = '".$user_id."') ) as is_like ,(exists (select 1 from pinboard Pin where Pin.post_id = P.id and Pin.user_id = '" .$user_id."') ) as is_saved ,";
        } else {
            $subquery = "";
        }
        $this->db->select('P.*,'.$subquery .'U.profile_image as user_profile_image,U.full_name as user_full_name');
        $this->db->from('post as P');
        $this->db->join('user as U', 'P.user_id = U.id');
        $this->db->order_by('P.id', 'desc');
          if(!empty($page_count)){
               $this->db->limit($offset,$limit);
          }
         $query = $this->db->get();
      // echo $this->db->last_query();
        $post_list = $query->result_array();
      if($post_list)
          {
            return $post_list;
          } else {
            return  array();
          }
}

public function getProfile($user_id){
    $sql = "SELECT i.*, GROUP_CONCAT(c.genre_name) AS genre_name FROM user i, genre_category c WHERE FIND_IN_SET(c.genre_id, i.genre_cat) <> 0 AND c.status = '0' AND i.id='" . $user_id . "' and  i.genre_cat IS NOT NULL";
    $query = $this->db->query($sql);
    $user = $query->result_array()[0];
      if($user)
          {
            return $user;
          } else {
            return  array();
          }
}
  public function  all_likes($id,$type){
         if ($type == 1) {
              $sql = "Select U.*,P.* from post_like as P JOIN user as U ON P.user_id = U.id where post_id = '".$id."'";
          } else if ($type == 2) {
              $sql = "Select U.*,P.* from post_comment_like as P  JOIN user as U ON P.user_id = U.id where comment_id = '".$id."'";
          }
          $query = $this->db->query($sql);
          $like_list = $query->result_array();
          if($like_list)
            {
              return $like_list;
            } else {
              return  array();
            }
  }
  public function  artistsongs_list($search="",$user_id){
        $sql = "select * from artist_songs where songs_title LIKE '%" . $search . "%' AND user_id = '" . $user_id . "'";
        $query = $this->db->query($sql);
        $songsdata = $query->result_array();
          if($songsdata)
            {
              return $songsdata;
            } else {
              return  array();
            }
  }
 public function  favourite_artistlist($user_id=""){
        $this->db->select('RF.*,R.user_id as artist_id,U.full_name,U.profile_image,U.email,U.user_type,U.total_like');
        $this->db->from('reels as R');
        $this->db->join('reels_favourite as RF', 'R.id = RF.reels_id');
        $this->db->join('user as U', 'U.id = R.user_id');
        $this->db->where('RF.user_id', $user_id);
        $query = $this->db->get();
      //  echo $this->db->last_query();
        $reels_fav = $query->result_array();
         if($reels_fav)
        {
          return $reels_fav;
        } else {
          return  array();
        }

}
public function  get_allfollowers($artist_id,$fans_id="",$limit, $offset,$page_count){
      if (!empty($fans_id)) {
            $subquery2 = ",(exists (select 1
                from friends Fo
                where Fo.friends_id = F.fans_id and Fo.user_id = '" . $fans_id . "') ) as is_friend ";
        } else {
            $subquery2 = "";
        }
        $this->db->select('F.*,U.*' . $subquery2);
        $this->db->from('follower as F');
        $this->db->join('user as U', 'U.id = F.fans_id');
        $this->db->where('F.artist_id', $artist_id);
        $this->db->where('F.fans_id !=', $fans_id);
        if(!empty($page_count)){
          $this->db->limit($offset,$limit);
          }
        $query = $this->db->get();
        $fandata = $query->result_array();
        if($fandata)
        {
          return $fandata;
        } else {
          return  array();
        }
}
public function  get_allfansList($artist_id,$limit,$offset,$page_count){
        $this->db->select('F.*,U.*');
        $this->db->from('follower as F');
        $this->db->join('user as U', 'U.id = F.fans_id');
        $this->db->where('F.artist_id', $artist_id);
         if(!empty($page_count)){
          $this->db->limit($offset,$limit);
          }
        $query = $this->db->get();
        $fandata = $query->result_array();        
        if($fandata)
        {
          return $fandata;
        } else {
          return  array();
        }
}
public function  get_allfriends($user_id,$fans_id="",$limit,$offset,$page_count){
         if (!empty($fans_id)) {
            $subquery2 = ",(exists (select 1
                from friends Fo
                where F.user_id = Fo.user_id and Fo.friends_id = '" . $fans_id . "') ) as is_friend ";
        } else {
            $subquery2 = "";
        }
        $this->db->select('F.user_id,F.friends_id,U.*' . $subquery2);
        $this->db->from('friends as F');
        $this->db->join('user as U', 'U.id = F.friends_id');
        $this->db->where('F.user_id', $user_id);
         if(!empty($page_count)){
          $this->db->limit($offset,$limit);
          }
        $query = $this->db->get();
        $data = $query->result_array();
        if($data)
        {
          return $data;
        } else {
          return  array();
        }
}
public function  all_concert($user_id,$fans_id=""){
        if (!empty($fans_id)) {
          $subquery = "(exists (select 1 from concert_booking CB where CB.concert_id = C.concert_id and CB.user_id = '" . $fans_id . "') ) as is_booked ";
        } else {
            $subquery = "";
        }
        $this->db->select('C.*,' . $subquery);
        $this->db->from('concerts as C');
        $this->db->where('C.user_id', $user_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        $concertdata = $query->result_array();
        if($concertdata)
        {
          return $concertdata;
        } else {
          return  array();
        }
}
public function  fanProfile($user_id){
      $subquery = "
        (SELECT COUNT(*) FROM friends WHERE user_id=U.id) AS total_friend ,
        (SELECT COUNT(*) FROM artist_page_share WHERE user_id=U.id) AS total_shared ,
        (SELECT Count(*) from redeem_checkout where user_id = U.id) AS total_redeem,
        (SELECT SUM(amount) from credits where refer_id = U.id) AS total_credits";
        // (SELECT Count(*) from goals where find_in_set(redeem_members,U.id)<>0 ) AS total_redeem
        //(SELECT COUNT(*) FROM goals WHERE user_id=U.id) AS total_credits ,
        $this->db->select('U.*,G.genre_name,G.genre_image,' . $subquery);
        $this->db->from('user as U');
        $this->db->join('genre_category as G', 'G.genre_id = U.genre_cat', 'LEFT');
        $this->db->where('U.id', $user_id);
        $query = $this->db->get();
        $fandata = $query->result_array()[0];
        if($fandata)
        {
          return $fandata;
        } else {
          return  array();
        }
}
public function  newsfeed_list($fansid="",$artist_id=""){
      if(!empty($fansid)) {
            $subquery = "(exists (select 1 from post_like L where L.post_id = P.id and L.user_id = '" . $fansid . "') ) as is_like ,(exists (select 1 from pinboard Pin where Pin.post_id = P.id and Pin.user_id = '" . $fansid . "') ) as is_saved ,";
        } else {
            $subquery = "";
        }
        $this->db->select('P.*,' . $subquery . 'U.profile_image as user_profile_image,U.full_name as user_full_name');
        $this->db->from('post as P');
        $this->db->join('user as U', 'P.user_id = U.id');
        $this->db->where('P.user_id', $artist_id);
        $query = $this->db->get();
        $post_list = $query->result_array();
        if($post_list)
        {
          return $post_list;
        } else {
          return  array();
        }
}
public function  concertbooked_byuser($user_id){
        $this->db->select('C.*,CB.user_id as booked_by');
        $this->db->from('concert_booking  CB');
        $this->db->join('concerts C', 'C.concert_id = CB.concert_id', 'LEFT');
        $this->db->where('CB.user_id', $user_id);
        $query = $this->db->get();
        $detail = $query->result_array();
        if($detail)
        {
          return $detail;
        } else {
          return  array();
        }
}
public function  get_pinboard($user_id=""){
     if (!empty($user_id)) {
            $subquery = "(exists (select 1
                from post_like L
                where L.post_id = P.id and L.user_id = '" . $user_id . "') ) as is_like ,
                 (exists (select 1
                from pinboard Pin
                where Pin.post_id = P.id and Pin.user_id = '" . $user_id . "') ) as is_saved ,";
        } else {
            $subquery = "";
        }
        $this->db->select('P.*,' . $subquery . 'U.profile_image as user_profile_image,U.full_name as user_full_name');
        $this->db->from('pinboard as Pin');
        $this->db->join('post as P', 'Pin.post_id = P.id');
        $this->db->join('user as U', 'U.id = P.user_id');
        $this->db->where('Pin.user_id', $user_id);
        $this->db->order_by('Pin.id', 'desc');
        $query = $this->db->get();
        $pin_list = $query->result_array();
        if($pin_list)
        {
          return $pin_list;
        } else {
          return  array();
        }
}
public function  hall_of_fame($user_id="",$filter="",$type=""){
        $this->db->select('F.*,U.*');
        if ($type == '0') {
            $this->db->from('friends as F');
            $this->db->join('user as U', 'U.id = F.friends_id');
            $this->db->where('F.user_id', $user_id);
        }
        if($type == '1') {
            $this->db->from('follower as F');
            $this->db->join('user as U', 'U.id = F.fans_id');
            $this->db->where('F.artist_id', $user_id);
        }
        if($filter != '') {
            $this->db->where('DATE(F.created_at) >= DATE(NOW()) - INTERVAL ' . $filter . ' DAY');
        }
        $this->db->order_by('F.id', 'desc');
        $query = $this->db->get();
        $fandata = $query->result_array();


        $this->db->select('D.*,U.full_name,U.email,U.profile_image,U.id as donator_id');
        $this->db->from('donate_bits as D');
        $this->db->join('user as U', 'U.id =D.donate_by');
        $this->db->where('D.donate_to', $user_id);
         if (!empty($filter)) {
           $this->db->where('DATE(D.created_at) >= DATE(NOW()) - INTERVAL ' . $filter . ' DAY');
        }
        $query2 = $this->db->get();
        $donate = $query2->result_array();
        if(empty($fandata))
        {
          $fandata =  array();
        }
        if(empty($donate))
        {
          $donate =  array();
        }

        $array = array('fandata'=>$fandata,'donate'=>$donate);
        return $array;
}
public function  chat_users($user_id="",$user_type){
          if ($user_type == '0') {
                $this->db->select('U.id,U.full_name,U.profile_image');
                $this->db->from('friends as F');
                $this->db->join('user as U', 'U.id = F.friends_id');
                $this->db->where('F.user_id', $user_id);
                $query = $this->db->get();
                $chat_users = $query->result_array();
            }
            if ($user_type == '1') {
                $this->db->select('U.id,U.full_name,U.email,U.profile_image');
                $this->db->from('follower as F');
                $this->db->join('user as U', 'U.id = F.fans_id');
                $this->db->where('F.artist_id', $user_id);
                $query = $this->db->get();
                $chat_users = $query->result_array();
            }
     
        if($chat_users)
        {
          return $chat_users;
        } else {
          return  array();
        }
}
public function  home_search($user_id="",$search=""){
     
      $this->db->select('U.*');
      $this->db->from('user as U');
      if (!empty($search)) {
        $this->db->like('U.full_name', $search);
        $this->db->or_like('U.artist_name', $search);
      }
      $this->db->where('id !=', $user_id);
      $query = $this->db->get();
      $userinfo = $query->result_array();
        if($userinfo)
        {
          return $userinfo;
        } else {
          return  array();
        }
}









}