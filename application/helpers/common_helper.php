<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function user_detail($id)
{
    $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');
    $user_detail = $CI->common->getData('user',array('id'=>$id),array('single'));

    if(!empty($user_detail)){
     return $user_detail;
    }
    else{
      return false;
    }
}
function user_full_name($id)
{
    $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');
    $user_detail = $CI->common->getData('user',array('id'=>$id),array('single'));

    if(!empty($user_detail)){
      return $user_detail['full_name'];
    }else{
     return false;
    }
}
function report_user($user_id,$block_id,$type="")
{
   $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');

    if(!empty($type)){
       $type = "1";
    }else{
       $type = "0";
    }

      $user_block = $CI->common->getData('report_user',array('block_id'=>$block_id,'user_id'=>$user_id,'type'=>$type),array('single'));

    if(!empty($user_block)){
      return 1;
    }else{
     return 0;
    }
}

function goal_name($id)
{
    $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');
    $goal_detail = $CI->common->getData('goals',array('id'=>$id),array('single'));

    if(!empty($goal_detail)){
      return $goal_detail['goal_name'];
    }else{
     return false;
    }
}

function gen_category($id)
{
    $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');
    $gen_category = $CI->common->getData('genre_category',array('genre_id'=>$id),array('single'));

    if(!empty($gen_category)){
      return $gen_category['genre_name'];
    }else{
      return false;
    }
}

function category_name($id)
{
    $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');
    $user_detail = $CI->common->getData('sell_category',array('id'=>$id),array('single'));

    if(!empty($user_detail)){
      return $user_detail['name'];
    }else{
      return false;
    }
}
function user_type($id)
{
    $CI = &get_instance();
    $CI->load->database();
    $CI->load->model('common');
    $user_detail = $CI->common->getData('user',array('id'=>$id),array('single'));

    if(!empty($user_detail)){
      return $user_detail['user_type'];
    }else{
     return false;
    }
}
