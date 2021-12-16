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
  public function send_all_notification($user_id,$message,$type,$data=array()){
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
                  'type'=>$type);
                $result = $this->common->insertData('notification', $noti);
            }
        }

     return $res;
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



}