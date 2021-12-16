 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
class Api extends Base_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('common_helper');
        $this->data = json_decode(file_get_contents("php://input"));
    }
    //// signup///////////
    public function signup_mobile() {
        if (!empty($_POST['mobile_number'])) {
            $rand = rand(1000, 9999);
            $_POST['otp'] = (string)$rand;
            $this->response(true, "First Step Done Succesfully!", array('userinfo' => array('mobile_number' => $_POST['mobile_number'], 'otp' => $_POST['otp'])));
        } else {
            $this->response(false, " Invalid detail, please try again.");
        }
    }
    public function otp_verification() {
        if (!empty($_POST['otp'])) {
            $this->response(true, "OTP Verified!", array('userinfo' => array('mobile_number' => $_POST['mobile_number'], 'otp' => $_POST['otp'])));
        } else {
            $this->response(false, " Invalid detail, please try again.");
        }
    }
    public function signup_pass() {
        if (!empty($_POST['mobile_number'])) {
            $_POST['status'] = 1;
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['password'] = md5($_POST['password']);
            $exist2 = $this->common->getData('user', array('mobile_number' => $_POST['mobile_number']), array('single'));
            if ($exist2) {
                $this->response(false, "Mobile Number already exist");
                die;
            } else {
                $post = $this->common->getField('user', $_POST);
                $result = $this->common->insertData('user', $post);
                $user_id = $this->db->insert_id();
                if ($user_id) {
                    $user = $this->common->getData('user', array('id' => $user_id), array('single'));
                    $this->response(true, "Signup Succesfully!", array('userinfo' => $user));
                } else {
                    $this->response(false, " Invalid detail, please try again.");
                }
            }
        } else {
            $this->response(false, " Invalid detail, please try again.");
        }
    }
    //////////////////////////////// login //////////////////////////////
    public function login() {
        $_POST['password'] = md5($_POST['password']);
        $result = array();
        $where = "mobile_number = '" . $_POST['mobile_number'] . "' AND password = '" . $_POST['password'] . "'";
        $result = $this->common->getData('user', $where, array('single'));
        if ($result) {
            if (isset($_REQUEST['android_token'])) {
                $old_device = $this->common->getData('user', array('android_token' => $_REQUEST['android_token']), array('single', 'field' => 'id'));
            }
            if (isset($_REQUEST['ios_token'])) {
                $old_device = $this->common->getData('user', array('ios_token' => $_REQUEST['ios_token']), array('single', 'field' => 'id'));
            }
            if ($old_device) {
                $this->common->updateData('user', array('android_token' => "", "ios_token" => ""), array('id' => $old_device['id']));
            }

            if($_POST['ref_user_id'] && $_POST['ref_artist_id']){
                $ref_user_id = $_POST['ref_user_id'];
                $ref_artist_id =  $_POST['ref_artist_id'];
            }else{
                $ref_user_id = "";
                $ref_artist_id =  "";
            }

            $this->common->updateData('user', array('ios_token' => $_REQUEST['ios_token'], 'android_token' => $_REQUEST['android_token'],'device_type'=>$_REQUEST['device_type'],'ref_user_id'=>$ref_user_id,'ref_artist_id'=>$ref_artist_id),array('id' => $result['id']));

            $select =   $this->common->getData('bitpack_users', array('user_id' => $result['id']), array('sort_by'=>'id','sort_direction'=>'desc','single'));
            if($select['bitpack_status'] == '0'){
                 $result['total_donate_bit'] = $select['total_donate_bit'];
                $result['bit_pack_id'] = $select['bit_pack_id'];
            }else{
                 $result['total_donate_bit'] = '0';
                 $result['bit_pack_id'] = '0';
            }
           

            $result['android_token'] = $_REQUEST['android_token'];

            $this->response(true, 'Successfully Login', array("userinfo" => $result));
        } else {
            $message = "Wrong mobile number or password";
            $this->response(false, $message, array("userinfo" => (object) array()));
        }
    }
    //////////////////add_post///////////
    public function add_post() {
        if (!empty($_POST['user_id'])) {
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $post = $this->common->getField('post', $_POST);
            $result = $this->common->insertData('post', $post);
            $postid = $this->db->insert_id();
        } else {
            $this->response(false, "User Id field is mandatory");
            exit();
        }
        if (isset($_FILES['images'])) {
            $image = $this->common->multi_upload('images', './assets/post/');
            foreach ($image as $k => $val) {
                $res = $this->common->insertData('post_image', array('user_id' => $_POST['user_id'], 'post_id' => $postid, 'image' => $val['file_name'], 'post_type' => $_POST['post_type']));
            }
            $this->response(true, "Post successfully added", array('file' => $_FILES['images']));
        } else {
            $this->response(false, "All fields are mandatory");
        }
    }
    //post_like///////////
    public function post_like() {
        $user_id = $_POST['user_id'];
        $post_id = $_POST['post_id'];
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $count = 0;
        $message = "";
        $likedata = $this->common->getData('post_like', array('user_id' => $user_id, 'post_id' => $post_id), array('single'));

        $postdata = $this->common->getData('post', array('id' => $post_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('post_like', array('like_id' => $likedata['like_id']));
            if ($postdata['total_like'] > 0) {
                $count = $postdata['total_like'] - 1;
            } else {
                $count = $postdata['total_like'];
            }
            $message = "Dislike Post";
            $test = 2;
        } else {
            $post = $this->common->getField('post_like', $_POST);
            $result = $this->common->insertData('post_like', $post);
            $count = $postdata['total_like'] + 1;
            $message = "Like Post";
            $test = 1;
           
        }
        $update = $this->common->updateData('post', array('total_like' => $count), array('id' => $post_id));

        if (!empty($update)) {

            if($test == 1){
                $user_detail = user_detail($_POST['user_id']);
             $sendnoti =  $this->common->send_all_notification($postdata['user_id'],ucwords($user_detail['full_name'])." liked your post","Like",'1',array('refer_id'=>$_POST['post_id']));
            }
            $this->response(true, $message, array('count' => $count));
        } else {
            $this->response(false, "There is a problem, please try again.", array('count' => $count));
        }
    }
    //delete_post/////
    public function delete_post() {
        $post = $this->common->deleteData('post', array('id' => $_POST['post_id']));
        $post_like = $this->common->deleteData('post_like', array('post_id' => $_POST['post_id']));
        $post_comment = $this->common->deleteData('post_comment', array('post_id' => $_POST['post_id']));
        $post_image = $this->common->deleteData('post_image', array('post_id' => $_POST['post_id']));
        if ($post_image) {
            foreach ($post_image as $key => $value) {
                $image_path = getcwd();
                unlink($image_path . "/assets/post/" . $value['images']);
            }
            $this->response(true, "Post successfully deleted");
        } else {
            $this->response(false, "Post not deleted");
        }
    }
    ///////post_comment//////////////
    public function add_post_comment() {
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $post_list = $this->common->add_post_comment($_POST['post_id']);
        if ($_POST['comment_id']) {
            $_POST['refer_id'] = $_POST['comment_id'];
        } else {
            $_POST['refer_id'] = 0;
        }
        unset($_POST['comment_id']);
        $_POST['reciever_id'] = $post_list['user_id'];
        $post = $this->common->getField('post_comment', $_POST);
        $result = $this->common->insertData('post_comment', $post);
        if (!empty($result)) {
            $id = $this->db->insert_id();
            $comment = $this->common->getData('post_comment', array('post_id' => $_POST['post_id'], 'refer_id' => 0), array());
            $count = count($comment);
            $upcomment = $this->common->updateData('post', array('total_comment' => $count), array('id' => $_POST['post_id']));
            $this->response(true, "Success Comment Added", array('comment' => $comment, 'count' => $count));
        } else {
            $this->response(false, "No Comments Yet!");
        }
    }
    //////genre_category/////
    public function genre_category() {
         $genre_category = $this->common->genre_category($_POST['user_id'],$_POST['search']);
        if (!empty($genre_category)) {
            $this->response(true, "Success", array('genre_category' => $genre_category));
        } else {
            $this->response(false, "Genre Category Not found");
        }
    }
    /////////////add_genre////////////
    public function add_genre() {
        if (!empty($_POST['user_id'])) {
            $_POST['status'] = '1';
            $post = $this->common->getField('genre_category', $_POST);
            $result = $this->common->insertData('genre_category', $post);
            $postid = $this->db->insert_id();
        } else {
            $this->response(false, "User Id field is mandatory");
            exit();
        }
        $this->response(true, "genre category will be active when admin verify it");
    }
    ///////edit_comment/////
    public function edit_comment() {
        $update = $this->common->updateData('post_comment', array('message' => $_POST['message']), array('comment_id' => $_POST['comment_id']));
        if ($update) {
            $this->response(true, "comment updated Successfully.");
        } else {
            $this->response(false, "There is a problem, please try again.");
        }
    }
    //////delete_comment/////
    public function delete_comment() {
        $results = $this->common->deleteData('post_comment', array('comment_id' => $_POST['comment_id']));
        if ($this->db->affected_rows() > 0) {
            $post = $this->common->getData('post', array('id' => $_POST['post_id']), array('single'));
            $count = isset($post['total_comment']) > 0 ? ($post['total_comment'] - 1) : 0;
            $upcomment = $this->common->updateData('post', array('total_comment' => $count), array('id' => $_POST['post_id']));
            $this->response(true, "Comment Successfully Deleted");
        } else {
            $this->response(false, "comment does not exits");
        }
    }
    //////post_list/////
    public function post_list() {
        $arr = array();
        $key0 = "";   

        $limit = $offset= '';
        $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }

        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }



        $post_list = $this->common->post_list($_POST['user_id'],$limit,$offset,$page_count);
        if (!empty($post_list)) {
            foreach ($post_list as $key => $value) {
                $r = $this->common->getData('post_image', array('post_id' => $value['id']), array('', 'field' => 'image'));
                if (!empty($r)) {
                    $value['post_images'] = $r;
                } else {
                    $value['post_images'] = array();
                }
                // if($this->common->getcomment($value['id'])){
                //      $post_list[$key]['post_comments'] = $this->common->getcomment($value['id']);
                // }else{
                //    $post_list[$key]['post_comments'] = array();
                // }
                //$value['created_at'] = date('d-m-Y H:i',strtotime($value['created_at']));
                $report = report_user($_POST['user_id'], $value['user_id'],'0');
                if ($report == 1) {
                    unset($value);
                }
                 $report1 = report_user($_POST['user_id'], $value['user_id'],'1');
                if ($report1 == 1) {
                    unset($value);
                }
                if (!empty($_POST['post_id']) && $_POST['post_id'] == $value['id']) {
                    $key0 = $value;
                    unset($value);
                }
                if (!empty($value)) {
                    $arr[] = $value;
                }
            }
            if (!empty($key0)) {
                array_unshift($arr, $key0);
            }
            $this->response(true, "Post List", array('post_list' => $arr));
        } else {
            $this->response(false, "There is a problem, please try again.", array('post_list' => array()));
        }
    }
    ////////////All comments////////
    public function post_all_comments() {
        $user_id = $_POST['user_id'];
        $post_comments = $this->common->getcomment($_POST['post_id'], $user_id);
        // echo $this->db->last_query();
        if ($post_comments) {
            $this->response(true, "Post List", array('post_comments' => $post_comments, 'total_comment' => count($post_comments)));
        } else {
            $this->response(false, "There is a problem, please try again.", array('post_comments' => array()));
        }
    }
    ////////post_comment_like/////////////////
    public function post_comment_like() {
        $user_id = $_POST['user_id'];
        $comment_id = $_POST['comment_id'];
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $count = 0;
        $message = "";
        $likedata = $this->common->getData('post_comment_like', array('user_id' => $user_id, 'comment_id' => $comment_id), array('single'));
        $postdata = $this->common->getData('post_comment', array('comment_id' => $comment_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('post_comment_like', array('like_id' => $likedata['like_id']));
            if ($postdata['total_like'] > 0) {
                $count = $postdata['total_like'] - 1;
            } else {
                $count = $postdata['total_like'];
            }
            $message = "Dislike Comment";
        } else {
            $post = $this->common->getField('post_comment_like', $_POST);
            $result = $this->common->insertData('post_comment_like', $post);
            $count = $postdata['total_like'] + 1;
            $message = "Like Comment";
        }
        $update = $this->common->updateData('post_comment', array('total_like' => $count), array('comment_id' => $comment_id));
        if (!empty($update)) {
            $postdata = $this->common->getData('post_comment', array('comment_id' => $comment_id), array('single'));
            $like = $this->common->getData('post_comment_like', array("comment_id" => $comment_id, "user_id" => $user_id), array('single'));
            if (!empty($like)) {
                $is_comment_like = 1;
            } else {
                $is_comment_like = 0;
            }
            $this->response(true, $message, array('count' => (string)$count, 'is_comment_like' => $is_comment_like));
        } else {
            $this->response(false, "There is a problem, please try again.", array('count' => $count));
        }
    }
    //////////Update Profile
    public function update_profile() {
        $result = $this->common->getData('user', array('id' => $_POST['user_id']), array('single'));
        if ($result) {
           
            $post = $this->common->getField('user', $_POST);
            $info = $this->common->updateData('user', $post, array('id' => $_POST['user_id']));
            $this->db->select('U.*');
            $this->db->from('user as U');
            // $this->db->join('genre_category as G', 'G.genre_id = U.id','LEFT');
            $this->db->where('U.id', $_POST['user_id']);
            $query = $this->db->get();
            $user = $query->result_array()[0];
             $select =   $this->common->getData('bitpack_users', array('user_id' => $_POST['user_id']), array('sort_by'=>'id','sort_direction'=>'desc','single'));
            if($select['bitpack_status'] == '0'){
                $user['total_donate_bit'] = $select['total_donate_bit'];
                $user['bit_pack_id'] = $select['bit_pack_id'];
            }else{
                 $user['total_donate_bit'] = '0';
                 $user['bit_pack_id'] = '0';
            }

            $this->response(true, "Your Profile Is Updated Sucessfully.", array('userinfo' => $user));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array('userinfo' => (object)array()));
        }
    }
//////////////////////////////////getProfile /////////////////
    public function getProfile(){
        $user = $this->common->getProfile($_POST['user_id']);
        //SELECT i.*,  and   TRIM( IFNULL( i.genre_cat  , '' ) ) > ''
        //echo $this->db->last_query();
        // $this->db->select('U.*,G.genre_name,G.genre_image');
        // $this->db->from('user as U');
        // $this->db->join('genre_category as G', 'G.genre_id = U.genre_cat','LEFT');
        // $this->db->where('U.id',$_POST['user_id']);
        // $query = $this->db->get();
        // $user =  $query->result_array()[0];
         $select =   $this->common->getData('bitpack_users', array('user_id' => $_POST['user_id']), array('sort_by'=>'id','sort_direction'=>'desc','single'));
            if($select['bitpack_status'] == '0'){
                $user['total_donate_bit'] = $select['total_donate_bit'];
                $user['bit_pack_id'] = $select['bit_pack_id'];
            }else{
                 $user['total_donate_bit'] = '0';
                 $user['bit_pack_id'] = '0';
            }

        if ($user) {
            $this->response(true, "Profile Fetch Successful", array("userinfo" => $user));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array("userinfo" => array()));
        }
    }
//////////////////////artistProfile//////////////////////////////    
    public function artistProfile() {

        $subquery = "

        (SELECT COUNT(donate_bit) FROM donate_bits WHERE donate_to=U.id) AS total_credits ,

        (SELECT COUNT(*) FROM artist_page_share WHERE artist_id=U.id) AS total_post ,
        (SELECT COUNT(*) FROM follower WHERE artist_id=U.id) AS total_follower ,

        (SELECT Count(*) from redeem_checkout where goal_id_user = U.id) AS total_redeem ";
        //  (SELECT COUNT(*) FROM post WHERE user_id=U.id) AS total_post ,
        // (SELECT SUM(LENGTH(redeem_members) - LENGTH(REPLACE(redeem_members, ',', '')) + 1)
        // FROM goals  where user_id = U.id and  TRIM( IFNULL( redeem_members , '' ) ) > '') AS total_redeem
        $this->db->select('U.*,G.genre_name,G.genre_image,'.$subquery);
        $this->db->from('user as U');
        $this->db->join('genre_category as G', 'G.genre_id = U.genre_cat', 'LEFT');
        $this->db->where('U.id', $_POST['artist_id']);
       // $this->db->where('G.status', '0');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $user = $query->result_array() [0];
        if ($user) {
            if (!empty($_POST['fans_id'])) {
                $ffans_id = $this->common->getData('follower', array('artist_id' => $_POST['artist_id'], 'fans_id' => $_POST['fans_id']), array('single'));
                if (!empty($ffans_id)) {
                    $user['is_follow'] = "1";
                } else {
                    $user['is_follow'] = "0";
                }
            }
            $artist_songs = $this->common->getData('artist_songs', array('user_id' => $_POST['artist_id']), array('sort_by' => 'id', 'sort_direction' => 'desc', 'limit' => '3'));
            $user['artist_songs'] = !empty($artist_songs) ? $artist_songs : array();

             if(!empty($_POST['ref_user_id']) && !empty($_POST['ref_artist_id'])){

                 $artist_refer_detail = $this->common->artist_refer_detail($_POST['ref_artist_id'],$_POST['ref_user_id'],$_POST['fans_id']);

             }
            $select =   $this->common->getData('bitpack_users', array('user_id' => $_POST['artist_id']), array('sort_by'=>'id','sort_direction'=>'desc','single'));
            if($select['bitpack_status'] == '0'){
                 $user['total_donate_bit'] = $select['total_donate_bit'];
                $user['bit_pack_id'] = $select['bit_pack_id'];
            }else{
                 $user['total_donate_bit'] = '0';
                 $user['bit_pack_id'] = '0';
            }

            $this->response(true, "Profile Fetch Successful", array("userinfo" => $user,'artist_refer_detail'=>$artist_refer_detail));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array("userinfo" => array()));
        }
    }
    ////////// add_post///////////
    public function add_reels() {
        if (!empty($_POST['user_id'])) {
            //  $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['reel_video'] = '';
            if (isset($_FILES['reel_video'])) {
                $reel_video = $this->common->do_upload('reel_video', './assets/reels/');
                if (isset($reel_video['upload_data'])) {
                    $_POST['reel_video'] = $reel_video['upload_data']['file_name'];
                }
            }
            if ($_POST["reel_songs"] = "") {
                $_POST["reel_songs"] = "";
            }
            $post = $this->common->getField('reels', $_POST);
            $result = $this->common->insertData('reels', $post);
            $postid = $this->db->insert_id();
        } else {
            $this->response(false, "User Id field is mandatory");
            exit();
        }
        $this->response(true, "Reels successfully added", array('file' => $_FILES));
    }
    ////////////songs_list/////////////////////
    public function songs_list() {
        $this->db->select('*');
        $this->db->from('songs');
        $query = $this->db->get();
        $songs = $query->result_array();
        if ($songs) {
            foreach ($songs as $key => $value) {
                $value['file_path'] = base_url('assets/songs/') . $value['song_name'];
                $song[] = $value;
            }
            $this->response(true, "Songs Fetch Successful", array("songs" => $song));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array("songs" => array()));
        }
    }
    ////////////reels_list////////////////
    public function reels_list() {
        $key0 = "";
        $key1 = "";
        $arr= array();
        $arr1 =array();
         $limit = $offset= '';
         $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }
        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }
    $reels_list = $this->common->reels_list($_POST['user_id'],'1',$limit,$offset,$page_count);
    $for_you = $this->common->reels_list($_POST['user_id'],'2',$limit,$offset,$page_count);
        if (!empty($reels_list)){
            foreach ($reels_list as $key => $value) {
                $report = report_user($_POST['user_id'], $value['user_id'],'1');
                    if ($report == 1) {
                        unset($value);
                    }
                    if (!empty($_POST['reels_id']) && $_POST['reels_id'] == $value['id']) {
                        $key0 = $value;
                        unset($value);
                    }
                    if (!empty($value)) {
                        $arr[] = $value;
                    }
                }
                if (!empty($key0)) {
                    array_unshift($arr, $key0);
                }           
            foreach ($for_you as $key => $value) {
                $report = report_user($_POST['user_id'], $value['user_id'],'1');
                    if ($report == 1) {
                        unset($value);
                    }
                    if (!empty($_POST['reels_id']) && $_POST['reels_id'] == $value['id']) {
                        $key1 = $value;
                        unset($value);
                    }
                    if (!empty($value)) {
                        $arr1[] = $value;
                    }
                }
                if (!empty($key1)) {
                    array_unshift($arr1, $key1);
                } 
            $this->response(true, "reels List",array('reels_list' => $arr, 'for_you' => $arr1));
        } else {
            $this->response(false, "There is a problem, please try again.", array('reels_list' => array()));
        }
    }
    public function reels_list_with_type() {
        $key0 = "";
        $arr= array();
         $limit = $offset= '';
         $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }
        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+$page_count);
        }
        if ($_POST['type'] == '1') {
           $reels_list = $this->common->reels_list($_POST['user_id'],'1',$limit,$offset,$page_count);    
        }
        if ($_POST['type'] == '2') {
          $reels_list = $this->common->reels_list($_POST['user_id'],'2',$limit,$offset,$page_count);
        }
        if (!empty($reels_list)) {

            foreach ($reels_list as $key => $value) {
                $report = report_user($_POST['user_id'], $value['user_id'],'1');
                    if ($report == 1) {
                        unset($value);
                    }
                    if (!empty($_POST['reels_id']) && $_POST['reels_id'] == $value['id']) {
                        $key0 = $value;
                        unset($value);
                    }
                    if (!empty($value)) {
                        $arr[] = $value;
                    }
                }
                 if (!empty($key0)) {
                    array_unshift($arr, $key0);
                }

            $this->response(true, "reels List", array('reels_list' => $arr));
        } else {
            $this->response(false, "There is a problem, please try again.", array('reels_list' => array()));
        }
    }
    //////////////////reels_comment//////////////
    public function reels_all_comments() {
        $user_id = $_POST['user_id'];
        $reels_comments = $this->common->get_reels_comment($_POST['reels_id'], $user_id);
        if ($reels_comments) {
            $this->response(true, "reels List", array('reels_comments' => $reels_comments, 'total_comment' => count($reels_comments)));
        } else {
            $this->response(false, "There is a problem, please try again.", array('reels_comments' => array()));
        }
    }
    //////////////reels_like
    public function reels_like() {
        $user_id = $_POST['user_id'];
        $post_id = $_POST['reels_id'];
        //$group_id = $_POST['group_id'];
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $count = 0;
        $test = "";
        $message = "";
        $likedata = $this->common->getData('reels_like', array('user_id' => $user_id, 'reels_id' => $post_id), array('single'));
        $postdata = $this->common->getData('reels', array('id' => $post_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('reels_like', array('like_id' => $likedata['like_id']));
            if ($postdata['total_like'] > 0) {
                $count = $postdata['total_like'] - 1;
            } else {
                $count = $postdata['total_like'];
            }
            $test = '2';
            $message = "Dislike Reel";
        } else {
            $post = $this->common->getField('reels_like', $_POST);
            $result = $this->common->insertData('reels_like', $post);
            $count = $postdata['total_like'] + 1;
            $message = "Like Reel";
            $test = '1';
        }
        $update = $this->common->updateData('reels', array('total_like' => $count), array('id' => $post_id));
        if (!empty($update)) {
             $userdetail = user_detail($_POST['user_id']);
             $sendnoti =  $this->common->send_all_notification($postdata['user_id'],ucwords($userdetail['full_name'])." liked your reel","Like",'2',array('refer_id'=>$_POST['reels_id']));

            $this->response(true, $message, array('count' => $count));
        } else {
            $this->response(false, "There is a problem, please try again.", array('count' => $count));
        }
    }
    ///////post_comment//////////////
    public function add_reel_comment() {
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $this->db->select('P.*,U.android_token,U.ios_token,U.full_name');
        $this->db->from('user as U');
        $this->db->join('reels as P', 'P.user_id = U.id');
        $this->db->where('P.id', $_POST['reels_id']);
        $query = $this->db->get();
        $post_list = $query->result_array() [0];
        if ($_POST['comment_id']) {
            $_POST['refer_id'] = $_POST['comment_id'];
        } else {
            $_POST['refer_id'] = 0;
        }
        unset($_POST['comment_id']);
        $_POST['reciever_id'] = $post_list['user_id'];
        $post = $this->common->getField('reels_comment', $_POST);
        $result = $this->common->insertData('reels_comment', $post);
        if (!empty($result)) {
            $id = $this->db->insert_id();
            $comment = $this->common->getData('reels_comment', array('reels_id' => $_POST['reels_id'], 'refer_id' => 0), array('sort_by' => 'comment_id', 'sort_direction' => 'desc'));
            $count = count($comment);
            $upcomment = $this->common->updateData('reels', array('total_comment' => $count), array('id' => $_POST['reels_id']));
            $this->response(true, "Success Comment Added", array('comment' => $comment, 'count' => $count));
        } else {
            $this->response(false, "No Comments Yet!");
        }
    }
    //////////////////delete_reels/////////////////////////
    public function delete_reels() {
        $post = $this->common->deleteData('reels', array('id' => $_POST['reels_id']));
        $post_like = $this->common->deleteData('reels_like', array('reels_id' => $_POST['reels_id']));
        $post_comment = $this->common->deleteData('reels_comment', array('reels_id' => $_POST['reels_id']));
        if ($post_comment) {
            $this->response(true, "reels successfully deleted");
        } else {
            $this->response(false, "reels not deleted");
        }
    }
    ///////////////////////reels_comment_like/////////////////
    public function reels_comment_like() {
        $user_id = $_POST['user_id'];
        $comment_id = $_POST['comment_id'];
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $count = 0;
        $message = "";
        $likedata = $this->common->getData('reels_comment_like', array('user_id' => $user_id, 'comment_id' => $comment_id), array('single'));
        $postdata = $this->common->getData('reels_comment', array('comment_id' => $comment_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('reels_comment_like', array('like_id' => $likedata['like_id']));
            if ($postdata['total_like'] > 0) {
                $count = $postdata['total_like'] - 1;
            } else {
                $count = $postdata['total_like'];
            }
            $message = "Dislike Comment";
        } else {
            $post = $this->common->getField('reels_comment_like', $_POST);
            $result = $this->common->insertData('reels_comment_like', $post);
            $count = $postdata['total_like'] + 1;
            $message = "Like Comment";
        }
        $update = $this->common->updateData('reels_comment', array('total_like' => $count), array('comment_id' => $comment_id));
        if (!empty($update)) {
            $this->response(true, $message, array('count' => $count));
        } else {
            $this->response(false, "There is a problem, please try again.", array('count' => $count));
        }
    }
    /////////////////////add favourite //////////////////////
    public function reels_favourite() {
        $user_id = $_POST['user_id'];
        $post_id = $_POST['reels_id'];
        //$group_id = $_POST['group_id'];
        $_POST['created_date'] = date('Y-m-d');
        $_POST['created_time'] = date('H:i:s');
        $count = 0;
        $message = "";
        $likedata = $this->common->getData('reels_favourite', array('user_id' => $user_id, 'reels_id' => $post_id), array('single'));
        $postdata = $this->common->getData('reels', array('id' => $post_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('reels_favourite', array('fav_id' => $likedata['fav_id']));
            if ($postdata['total_star'] > 0) {
                $count = $postdata['total_star'] - 1;
            } else {
                $count = $postdata['total_star'];
            }
            $message = "disfavored Reel";
        } else {
            $post = $this->common->getField('reels_favourite', $_POST);
            $result = $this->common->insertData('reels_favourite', $post);
            $count = $postdata['total_star'] + 1;
            $message = "favourite Reel";
        }
        $update = $this->common->updateData('reels', array('total_star' => $count), array('id' => $post_id));
        if (!empty($update)) {
            $this->response(true, $message, array('count' => $count));
        } else {
            $this->response(false, "There is a problem, please try again.", array('count' => $count));
        }
    }
    ///////created api by naincy 14/07/21
    public function terms_services() {
        $terms_services = $this->common->getData('contact_about', array('id' => 3), array('single'));
        if (!empty($terms_services)) {
            $this->response(true, "Success", array('contact_about' => $terms_services));
        } else {
            $this->response(false, "Services Not found");
        }
    }
    public function privacy_policy() {
        $privacy_policy = $this->common->getData('contact_about', array('id' => 4), array('single'));
        if (!empty($privacy_policy)) {
            $this->response(true, "Success", array('contact_about' => $privacy_policy));
        } else {
            $this->response(false, "Privacy Policy Not found");
        }
    }
    public function license() {
        $license_policy = $this->common->getData('licenses', array('id' => 1), array('single'));
        if (!empty($license_policy)) {
            $this->response(true, "Success", array('licenses' => $license_policy));
        } else {
            $this->response(false, "License Policy Not found");
        }
    }
     public function aboutUs() {
        $about_us = $this->common->getData('contact_about', array('id' => 1), array('single'));
        if (!empty($about_us)) {
            $this->response(true, "Success", array('about_us' => $about_us));
        } else {
            $this->response(false, "License Policy Not found");
        }
    }
     public function contactUs() {
            $contactUs = $this->common->getData('contact_about', array('id' => 2), array('single'));
            if (!empty($contactUs)) {
                $this->response(true, "Success", array('contactUs' => $contactUs));
            } else {
                $this->response(false, "License Policy Not found");
            }
        }



    //////////////// all post_like / comment like///////////////////
    public function all_likes() {
        $type = $_POST['type'];
        $id = $_POST['id'];
          if ($type == 1) {

             $msg = "Post Like User list";
          }else if ($type == 2) {

             $msg = "Comment Like User list";
          }
          $like_list = $this->common->all_likes($id,$type);
        if (!empty($like_list)) {
            $this->response(true, $msg, array('user_list' => $like_list));
        } else {
            $this->response(false, "There is a problem, please try again.", array('user_list' => array()));
        }
    }
    ////////////////Setting ///////////////////
    ///////// add_artistsongs //////////////////
    public function add_artistsongs() {
        if (!empty($_POST['user_id'])) {
            if (!empty($_POST['songs_title1'])) {
                if (isset($_FILES['songs_name1'])) {
                    $singer_names = $this->common->do_upload('songs_name1', './assets/songs/');
                    if (isset($singer_names['upload_data'])) {
                        $_POST['songs_name1'] = $singer_names['upload_data']['file_name'];
                    }
                }
                if (isset($_FILES['songs_image1'])) {
                    $songs_image = $this->common->do_upload('songs_image1', './assets/songs/');
                    if (isset($songs_image['upload_data'])) {
                        $_POST['songs_image1'] = $songs_image['upload_data']['file_name'];
                    }
                }
                $array = array('user_id' => $_POST['user_id'], 'songs_title' => $_POST['songs_title1'], 'singer_name' => $_POST['singer_name1'], 'songs_name' => isset($_POST['songs_name1']) ? $_POST['songs_name1'] : "", 'songs_image' => isset($_POST['songs_image1']) ? $_POST['songs_image1'] : "");
                $result = $this->common->insertData('artist_songs', $array);
                $postid = $this->db->insert_id();
            }
            if (!empty($_POST['songs_title2'])) {
                if (isset($_FILES['songs_name2'])) {
                    $singer_names = $this->common->do_upload('songs_name2', './assets/songs/');
                    if (isset($singer_names['upload_data'])) {
                        $_POST['songs_name2'] = $singer_names['upload_data']['file_name'];
                    }
                }
                if (isset($_FILES['songs_image2'])) {
                    $songs_image = $this->common->do_upload('songs_image2', './assets/songs/');
                    if (isset($songs_image['upload_data'])) {
                        $_POST['songs_image2'] = $songs_image['upload_data']['file_name'];
                    }
                }
                $array1 = array('user_id' => $_POST['user_id'], 'songs_title' => $_POST['songs_title2'], 'singer_name' => $_POST['singer_name2'], 'songs_name' => isset($_POST['songs_name2']) ? $_POST['songs_name2'] : "", 'songs_image' => isset($_POST['songs_image2']) ? $_POST['songs_image2'] : "");
                $result = $this->common->insertData('artist_songs', $array1);
                $postid = $this->db->insert_id();
            }
            if (!empty($_POST['songs_title3'])) {
                if (isset($_FILES['songs_name3'])) {
                    $singer_names = $this->common->do_upload('songs_name3', './assets/songs/');
                    if (isset($singer_names['upload_data'])) {
                        $_POST['songs_name3'] = $singer_names['upload_data']['file_name'];
                    }
                }
                if (isset($_FILES['songs_image3'])) {
                    $songs_image = $this->common->do_upload('songs_image3', './assets/songs/');
                    if (isset($songs_image['upload_data'])) {
                        $_POST['songs_image3'] = $songs_image['upload_data']['file_name'];
                    }
                }
                $array3 = array('user_id' => $_POST['user_id'], 'songs_title' => $_POST['songs_title3'], 'singer_name' => $_POST['singer_name3'], 'songs_name' => isset($_POST['songs_name3']) ? $_POST['songs_name3'] : "", 'songs_image' => isset($_POST['songs_image3']) ? $_POST['songs_image3'] : "");
                $result = $this->common->insertData('artist_songs', $array3);
                $postid = $this->db->insert_id();
            }
        } else {
            $this->response(false, "User Id field is mandatory");
            exit();
        }
        $this->response(true, "Artist songs successfully added");
    }
    ///////// artistsongs_list //////////////////
    public function artistsongs_list() {
        $user_id = $_POST['user_id'];
        $search = $_POST['search'];
        $song = array();
        $songsdata = $this->common->artistsongs_list($search,$user_id);
        if (!empty($songsdata)) {
            foreach ($songsdata as $key => $value) {
                if(!empty($_POST['fans_id'])){
                    $userdetail = user_detail($_POST['fans_id']);
                    $ref = $userdetail['ref_user_id'];
                }else{
                    $ref = "";
                }
                
                $value['refer_id'] = $ref;
                $song[] = $value;
            }
            $this->response(true, "Success", array('artist_songs' => $song));
        } else {
            $this->response(false, "Lists Not found");
        }
    }
    ////////////////////add_artistgoals//////////////
    public function add_artistgoals() {
        if (!empty($_POST['user_id'])) {
            //  $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['goal_image'] = '';
            if (isset($_FILES['goal_image'])) {
                $goal_images = $this->common->do_upload('goal_image', './assets/images/');
                if (isset($goal_images['upload_data'])) {
                    $_POST['goal_image'] = $goal_images['upload_data']['file_name'];
                }
            }
            $post = $this->common->getField('goals', $_POST);
            $result = $this->common->insertData('goals', $post);
            $postid = $this->db->insert_id();
        } else {
            $this->response(false, "User Id field is mandatory");
            exit();
        }
        $this->response(true, "Artist Goals successfully added");
    }
    ///////////////// artistgoallist_byid  /////////////////////
    public function artistgoal_list() {
        $user_id = $_POST['user_id'];
        $array = array("yellow", "green", "red");
        $progress = array("50", "20", "40", "30", "20");
        $gray = "gray";
        $goalsdata = $this->common->getData('goals', array('user_id' => $user_id), array());
        if (!empty($goalsdata)) {
            foreach ($goalsdata as $key => $value) {
                if (!empty($value['goal_image'])) {
                    $value['color_code'] = $gray;
                } else {
                    $arr = array_rand($array);
                    $value['color_code'] = $array[$arr];
                }
                $value['progress_bar'] = $progress[$key];
                $goals[] = $value;
                //print_r($arr);
                
            }
            $this->response(true, "Success", array('goals' => $goals));
        } else {
            $this->response(false, "Artist Goals List Not found");
        }
    }
    //////////Created Api by naincy 20/07/21
    public function favourite_artistlist() {
        $userid = $_POST['user_id'];
        $arr = array();
        if (!empty($userid)) {
            $reels_fav = $this->common->favourite_artistlist($userid);
            if (!empty($reels_fav)) {
                foreach ($reels_fav as $key => $value) {
                     $report = report_user($_POST['user_id'], $value['artist_id'],'1');
                    if ($report == 1) {
                        unset($value);
                    }
                     if (!empty($value)) {
                     $arr[] = $value;
                    }
                }
                $this->response(true, "Favourite artist", array('favourite_artist' => $arr));
            } else {
                $this->response(false, "There is a problem, please try again.", array('reels_favourite' => array()));
            }
        }
    }
    public function create_group() {
        $member = $this->common->getData('create_group', array('user_id' => $_POST['user_id'], 'tittle' => $_POST['tittle']), array('single'));
        if ($member) {
            $this->response(false, "Group already created");
        } else {
            $image = '';
            if (!empty($_FILES['image'])) {
                $image1 = $this->common->do_upload('image', './assets/chat');
                if (isset($image1['upload_data'])) {
                    $image = $image1['upload_data']['file_name'];
                }
            }
            $bimage = '';
            if (isset($_FILES['image'])) {
                $image2 = $this->common->do_upload('image', './assets/chat');
                if (isset($image2['upload_data'])) {
                    $bimage = $image2['upload_data']['file_name'];
                }
            }
            $_POST['image'] = $image;
            $_POST['banner_image'] = $bimage;
            $_POST['created_at'] = date('d-m-Y H:i:s');
            //$_POST['members'] = json_decode($_POST['members'],true);
            /*print_r($_POST['members']);           
            die;*/
            $post = $this->common->getField('create_group', $_POST);
            $result = $this->common->insertData('create_group', $post);
            $group_id = $this->db->insert_id();
            $this->response(true, "Group created successfully");
        }
    }
    public function grouplist_byid() {
        $user_id = $_POST['user_id'];
        $subquery = ",
        (SELECT SUM(LENGTH(members) - LENGTH(REPLACE(members, ',', '')) + 1)
        FROM create_group  where  TRIM( IFNULL( members , '' ) ) > '') AS total_members ";
        $this->db->select('C.*' . $subquery);
        $this->db->from('create_group as C');
        $this->db->where('find_in_set("' . $user_id . '", C.members) <> 0');
        $query = $this->db->get();
        $groupdata = $query->result_array();
        $this->db->select('C.*' . $subquery);
        $this->db->from('create_group as C');
        $this->db->where('!find_in_set("' . $user_id . '", C.members) <> 0');
        $query = $this->db->get();
        $groupdata2 = $query->result_array();
        if (!empty($groupdata2)) {
            $this->response(true, "Success", array('group_list' => $groupdata, "group_suggestion" => $groupdata2));
        } else {
            $this->response(false, "Group Lists Not found");
        }
    }
    public function add_followers() {
        $artist_id = $_POST['artist_id'];
        $fans_id = $_POST['fans_id'];
        $message = "";
        $code = "";
        $likedata = $this->common->getData('follower', array('artist_id' => $artist_id, 'fans_id' => $fans_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('follower', array('id' => $likedata['id']));
            $message = "UnFollow artist successfully!";
            //$code = false;
            
        } else {
            $post = $this->common->getField('follower', $_POST);
            $result = $this->common->insertData('follower', $post);
            $message = "Follow artist successfully!";

            $userdetail = user_detail($_POST['fans_id']);
            $sendnoti =  $this->common->send_all_notification($_POST['artist_id'],ucwords($userdetail['full_name'])." started following you.","Follow",'4',array('refer_id'=>$_POST['fans_id']));
            
        }
        if (!empty($message)) {
            $this->response(true, $message, array());
        } else {
            $this->response(false, "There is a problem, please try again.", array());
        }
    }
    public function get_allfollowers() {
        $arr = array();
        $artist_id = $_POST['artist_id'];
        $fans_id = $_POST['fans_id'];
        $limit = $offset= '';
        $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }
        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }
        $fandata = $this->common->get_allfollowers($artist_id,$fans_id,$limit,$offset,$page_count);
        if (!empty($fandata)) {
            foreach ($fandata as $key => $value) {
                $report = report_user($_POST['artist_id'], $value['fans_id'],'1');
                if ($report == 1) {
                    unset($value);
                }
                if (!empty($value)) {
                    $arr[] = $value;
                }
            }
            $this->response(true, "Success", array('Followers' => $arr));
        } else {
            $this->response(false, "Followers List Not found");
        }
    }
    public function get_allfansList(){
        $arr = array();
        $artist_id = $_POST['user_id'];
        $limit = $offset= '';
        $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }
        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }
        $fandata = $this->common->get_allfansList($artist_id,$limit,$offset,$page_count);     
        if (!empty($fandata)) {
            foreach ($fandata as $key => $value) {
                $report = report_user($_POST['user_id'], $value['fans_id'],'1');
                if ($report == 1) {
                    unset($value);
                }
                if (!empty($value)) {
                    $arr[] = $value;
                }
            }
            $this->response(true, "Success", array('Fans' => $arr));
        } else {
            $this->response(false, "Fans List Not found");
        }
    }
    public function add_friends() {
        $user_id = $_POST['user_id'];
        $friends_id = $_POST['friends_id'];
        $message = "";
        $code = "";
        $likedata = $this->common->getData('friends', array('user_id' => $user_id, 'friends_id' => $friends_id), array('single'));
        if (!empty($likedata)) {
            $result = $this->common->deleteData('friends', array('id' => $likedata['id']));
            $message = "UnFriend successfully";
        } else {
            $post = $this->common->getField('friends', $_POST);
            $result = $this->common->insertData('friends', $post);
            $message = "Friend successfully";
            $userdetail = user_detail($_POST['friends_id']);
            $sendnoti =  $this->common->send_all_notification($_POST['user_id'],ucwords($userdetail['full_name'])." is your friend now .","Friend",'4',array('refer_id'=>$_POST['friends_id']));
        }
        if (!empty($message)) {
            $this->response(true, $message, array());
        } else {
            $this->response(false, "There is a problem, please try again.", array());
        }
    }
    public function get_allfriends() {
        $user_id = $_POST['user_id'];
        $fans_id = $_POST['fans_id'];
        $limit = $offset= '';
        $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }
        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }
        $data = $this->common->get_allfriends($user_id,$fans_id,$limit,$offset,$page_count);
        $data1 = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (empty($_POST['fans_id'])) {
                    $value['is_friend'] = "1";
                }
                $report = report_user($_POST['user_id'], $value['friends_id'],'1');
                if ($report == 1) {
                    unset($value);
                }
                if (!empty($value)) {
                    $data1[] = $value;
                }
            }
            $this->response(true, "Success", array('friends' => $data1));
        } else {
            $this->response(false, "Friends List Not found");
        }
    }
    //////////////////////////preview introduction/////////////////
    public function preview_intro() {
        $result = $this->common->getData('user', array('id' => $_POST['user_id']), array('single'));
        if ($result) {
            $_POST['profile_image'] = '';
            if (isset($_FILES['profile_image'])) {
                $image = $this->common->do_upload('profile_image', './assets/userfile/profile/');
                if (isset($image['upload_data'])) {
                    $_POST['profile_image'] = $image['upload_data']['file_name'];
                }
            }
            $_POST['song'] = '';
            if (isset($_FILES['song'])) {
                $image = $this->common->do_upload('song', './assets/songs/');
                if (isset($image['upload_data'])) {
                    $_POST['song'] = $image['upload_data']['file_name'];
                }
            }
            $post = $this->common->getField('user', $_POST);
            $info = $this->common->updateData('user', $post, array('id' => $_POST['user_id']));


            $user = $this->common->getData('user', array('id' => $_POST['user_id']), array('single'));            // $this->db->select('U.*');
            // $this->db->from('user as U');
            // $this->db->join('genre_category as G', 'G.genre_id = U.id','LEFT');
            // $this->db->where('U.id', $_POST['user_id']);
            // $query = $this->db->get();
            // $user = $query->result_array() [0];

            $this->response(true, "Your preview introduction Is Updated Sucessfully.", array('userinfo' => $user));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array('userinfo' => (object)array()));
        }
    }
    ///////////////concert /////////////////////
    public function add_concerts() {
        if (!empty($_POST['user_id'])) {
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['concert_image'] = '';
            if (isset($_FILES['concert_image'])) {
                $image = $this->common->do_upload('concert_image', './assets/concerts/');
                if (isset($image['upload_data'])) {
                    $_POST['concert_image'] = $image['upload_data']['file_name'];
                }
            }
            $concert = $this->common->getField('concerts', $_POST);
            $result = $this->common->insertData('concerts', $concert);
            $concertid = $this->db->insert_id();
        } else {
            $this->response(false, "user Id field is mandatory");
            exit();
        }
        $this->response(true, "Concert successfully added");
    }
    /////////////////////////all_concert/////////////////////
    public function all_concert() {
        $user_id = $_POST['artist_id'];
        $fan_id = $_POST['fans_id'];
        $concertdata = $this->common->all_concert($user_id,$fan_id);
        if (!empty($concertdata)) {
            $this->response(true, "Success", array('concerts' => $concertdata));
        } else {
            $this->response(false, "Concerts List Not found");
        }
    }
    ////////////////////////delete_concerts //////////////
    public function delete_concerts() {
        $concertdel = $this->common->deleteData('concerts', array('concert_id' => $_POST['concert_id']));
        $concert_booking = $this->common->deleteData('concert_booking', array('concert_id' => $_POST['concert_id']));
        if ($concertdel) {
            $this->response(true, "Concerts successfully deleted");
        } else {
            $this->response(false, "Concerts not deleted");
        }
    }
    ////////////////////////concert_cancel//////////////
    public function cancel_concert_booking() {
        $concertdel = $this->common->deleteData('concert_booking', array('concert_id' => $_POST['concert_id'], 'user_id' => $_POST['user_id']));
        if ($concertdel) {
            $this->response(true, "booking successfully canceled");
        } else {
            $this->response(false, "booking not canceled");
        }
    }
    ////////////////////////get_bitpak //////////////
    public function get_bitpack() {
        $user_id  = $_POST['user_id'];
        if (!empty($user_id)) {
            $subquery = "(exists (select 1
                from bitpack_users Bu
                where Bu.bit_pack_id = B.id and Bu.user_id = '".$user_id."')) as is_selected ,";
        } else {
            $subquery = "";
        }

        $result = $this->common->getData('bit_pack as B', array(), array('field'=>$subquery.' B.id,B.bit_name,B.type,B.bit_amount_d,B.amount_in_bit,B.euro_amount_d,B.amount_in_euro,B.image,B.created_at'));
        if (!empty($result)) {
            $this->response(true, "Bit Packs Fetch Successfully.", array("BitPackList" => $result));
        } else {
            $this->response(false, "Bit Packs  Not Found", array("BitPackList" => array()));
        }
    }
    ////////// donate_bit /////////////////////////
    public function donate_bits() {
        if (!empty($_POST['donate_by'])) {
            $sum = 0;
            $userdetail = user_detail($_POST['donate_by']);

            $select =   $this->common->getData('bitpack_users', array('user_id' => $_POST['donate_by']), array('sort_by'=>'id','sort_direction'=>'desc','single'));

            if(empty($select)){
                $this->response(false, "You don't have any bit pack,please buy bit pack from bit store");
               exit();
            }else if($select['bitpack_status'] =='1'){
                $this->response(false, "You have completed your bit pack,please buy bit pack from bit store");
               exit();
            }else{

                $donate_amount = $_POST['donate_bit'];
                $_POST['created_at'] = date('Y-m-d H:i:s');
                $donate_bits = $this->common->getField('donate_bits', $_POST);
                $result = $this->common->insertData('donate_bits', $donate_bits);
                $donateid = $this->db->insert_id();
        
                if($donateid > 0){
                     $sumamount  =  ($select['total_donate_bit']-$donate_amount);

                     if($sumamount == 0){
                        $bitpack_status = '1';
                     }else{
                        $bitpack_status = '0';
                     }
                     $update = $this->common->updateData('bitpack_users', array('total_donate_bit' => $sumamount,'bitpack_status'=>$bitpack_status), array('id' => $select['id']));

                    $sendnoti =  $this->common->send_all_notification($_POST['donate_to'],ucwords($userdetail['full_name'])." donated ".$_POST['donate_bit']." credit points to you.","Donate",'4',array('refer_id'=>$_POST['donate_to']));
                }
                 $this->response(true, "Bit sent successfully!",array('total_donate_bit'=>$sumamount ));

                }
           
        } else {
            $this->response(false, "donate by field is mandatory",array('total_donate_bit'=>'0'));
            exit();
        }
       
    }

    ///////////////////////////////////////////////////////
    public function update_image() {
        $result = $this->common->getData('user', array('id' => $_POST['user_id']), array('single'));
        if (!empty($result)) {
            $type = $_POST['type'];
            $image_name = "";
            if ($type == 1) {
                $_POST['image'] = '';
                if (isset($_FILES['image'])) {
                    $image = $this->common->do_upload('image', './assets/userfile/profile/');
                    if (isset($image['upload_data'])) {
                        $_POST['profile_image'] = $image['upload_data']['file_name'];
                        $image_name = $_POST['profile_image'];
                    }
                }
            }
            if ($type == 2) {
                $_POST['image'] = '';
                if (isset($_FILES['image'])) {
                    $image = $this->common->do_upload('image', './assets/userfile/profile/');
                    if (isset($image['upload_data'])) {
                        $_POST['cover_image'] = $image['upload_data']['file_name'];
                        $image_name = $_POST['cover_image'];
                    }
                }
            }
            unset($_POST['image']);
            $post = $this->common->getField('user', $_POST);
            $info = $this->common->updateData('user', $post, array('id' => $_POST['user_id']));
            $this->response(true, "Your Profile Is Updated Sucessfully.", array('image' => $image_name, 'type' => $_POST['type'], 'user_id' => $_POST['user_id']));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array('userinfo' => (object)array()));
        }
    }
    ////////////fan profile ///////////////
    public function fanProfile() {
        $user = $this->common->fanProfile($_POST['user_id']);
        if ($user) {
            if (!empty($_POST['fans_id'])) {
                $fanres = $this->common->getData('friends', array('friends_id' => $_POST['fans_id'], 'user_id' => $_POST['user_id']), array('single'));
                if (!empty($fanres)) {
                    $user['is_friend'] = "1";
                } else {
                    $user['is_friend'] = "0";
                }
            }
           $user['total_credits'] = !empty($user['total_credits'])?$user['total_credits']:"0";
            $user['genre_name'] = "";
            $user['genre_image'] = "";
             $select =   $this->common->getData('bitpack_users', array('user_id' => $_POST['user_id']), array('sort_by'=>'id','sort_direction'=>'desc','single'));
            if($select['bitpack_status'] == '0'){
                 $user['total_donate_bit'] = $select['total_donate_bit'];
                $user['bit_pack_id'] = $select['bit_pack_id'];
            }else{
                 $user['total_donate_bit'] = '0';
                 $user['bit_pack_id'] = '0';
            }
            $this->response(true, "Profile Fetch Successful", array("userinfo" => $user));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array("userinfo" => array()));
        }
    }
    ///////////////News Feed List by user_id
    public function newsfeed_list() {
        $fansid = $_POST['fans_id'];
        $post_list = $this->common->newsfeed_list($_POST['fans_id'],$_POST['artist_id']);
        if (!empty($post_list)) {
            foreach ($post_list as $key => $value) {
                $r = $this->common->getData('post_image', array('post_id' => $value['id']), array('', 'field' => 'image'));
                if (!empty($r)) {
                    $post_list[$key]['post_images'] = $r;
                } else {
                    $post_list[$key]['post_images'] = array();
                }
            }
            $this->response(true, "Post List", array('post_list' => $post_list));
        } else {
            $this->response(false, "There is a problem, please try again.", array('post_list' => array()));
        }
    }
    //////////////////////concert booking /////////////////
    public function concert_booking() {
        $fansid = $_POST['user_id'];
        $concertid = $_POST['concert_id'];
        if (!empty($_POST['user_id'])) {
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $concertbooking = $this->common->getField('concert_booking', $_POST);
            $result = $this->common->insertData('concert_booking', $concertbooking);
            $concerts_id = $this->db->insert_id();
        } else {
            $this->response(false, "Id field is mandatory");
            exit();
        }
        $this->response(true, "Concert Books successfully");
    }
    ////////////////////////Concert booked by user ////////////////////
    public function concertbooked_byuser() {
        $user_id = $_POST['user_id'];
        $detail = $this->common->concertbooked_byuser($user_id);
        if ($detail) {
            foreach ($detail as $key => $value) {
                $value['is_booked'] = "1";
                $details[] = $value;
            }
            $this->response(true, "Booking Fetch Successful", array("bookinginfo" => $details));
        } else {
            $this->response(false, "There Is a Problem, Please Try Again.", array("bookinginfo" => array()));
        }
    }
    /////////////pinboard/////////////
    public function get_pinboard() {
         $pin_list = $this->common->get_pinboard($_POST['user_id']);
        if (!empty($pin_list)) {
            foreach ($pin_list as $key => $value) {
                $r = $this->common->getData('post_image', array('post_id' => $value['id']), array('', 'field' => 'image'));
                if (!empty($r)) {
                    $pin_list[$key]['post_images'] = $r;
                } else {
                    $pin_list[$key]['post_images'] = array();
                }
            }
            $this->response(true, "pinboard List", array('post_list' => $pin_list));
        } else {
            $this->response(false, "There is a problem, please try again.", array('pin_list' => array()));
        }
    }
    /////////////add_pinboard////////////////
    public function add_pinboard() {
        if (!empty($_POST['user_id'])) {
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $savedata = $this->common->getData('pinboard', array('user_id' => $_POST['user_id'], 'post_id' => $_POST['post_id']), array('single'));
            if (!empty($savedata)) {
                $result = $this->common->deleteData('pinboard', array('id' => $savedata['id']));
                $message = "Unsaved Post Successfully";
            } else {
                $pin = $this->common->getField('pinboard', $_POST);
                $result = $this->common->insertData('pinboard', $pin);
                $pinid = $this->db->insert_id();
                $message = "Saved Post Successfully";
            }
            $this->response(true, $message);
        } else {
            $this->response(false, "There is a problem, please try again.");
            exit();
        }
    }
    //////////////////// redeem_checkout /////////
    // public function redeem_check() {
    //     if (!empty($_POST['user_id'])) {
    //         if (!empty($_POST['goal_id'])) {
    //             $goal_id_user = $this->common->getData('goals', array('id' => $_POST['goal_id']), array('single'));
    //             $_POST['goal_id_user'] = $goal_id_user['user_id'];
    //         }
    //         $_POST['created_at'] = date('Y-m-d H:i:s');
    //         $redeem = $this->common->getField('redeem_checkout', $_POST);
    //         $result = $this->common->insertData('redeem_checkout', $redeem);
    //         $checkid = $this->db->insert_id();
    //     } else {
    //         $this->response(false, "Id's field is mandatory");
    //         exit();
    //     }
    //     $this->response(true, "Redeem code successfully added");
    // }

    public function redeem_check() {

    $user_id =   $_POST['user_id'];
    $goal_id = $_POST['goal_id'];

    if (!empty($user_id))
     {
        if (!empty($goal_id))  {
            $goal_id_user = $this->common->getData('goals', array('id' => $_POST['goal_id']), array('single'));
            $_POST['goal_id_user'] = $goal_id_user['user_id'];
            $goal_amount = $goal_id_user['amount'];
        }
        $total_amount =  $this->common->getData('credits', array("refer_id
        " => $user_id, "artist_id" =>  $_POST['goal_id_user']),
        array('field'=>'SUM(amount) as totalamount'));
             if($total_amount[0]['totalamount'] <= $goal_amount)
             {
                $_POST['created_at'] = date('Y-m-d H:i:s');
                $_POST['goal_amount'] =  $goal_amount ;
                $_POST['credit_amount'] = $total_amount[0]['totalamount'] ;
                $redeem = $this->common->getField('redeem_checkout', $_POST);
                $result = $this->common->insertData('redeem_checkout', $redeem);
                $checkid = $this->db->insert_id();
             }  
        } else {
            $this->response(false, "Id's field is mandatory");
            exit();
        }
        $this->response(true, "Redeem code successfully added");
    }
    ///////////Media////////////////////////
    public function get_media() {
        $new_array = array();
        $base_url = base_url('assets/userfile/profile/');
        $base_url2 = base_url('assets/post/');
        $base_url3 = base_url('assets/concerts/');
        if (!empty($_POST['user_id'])) {
            $tables = array("user", "post_image", "concerts");
            foreach ($tables as $table) {
                $col = "user_id";
                if ($table == "user") {
                    $col = "id";
                    $user_id = $_POST['user_id'];
                }
                // $sql = "select * from $table where $col = '" . $user_id . "'";
                // $query = $this->db->query($sql);
                // $imagedata = $query->result_array();

                $imagedata =  $this->common->getData($table, array($col=>$user_id),array(''));

                foreach ($imagedata as $key => $value) {
                    if (!empty($value)) {
                        $new = array();
                        if (!empty($value['profile_image'])) {
                            $new['image'] = $base_url . $value['profile_image'];
                        }
                        if (!empty($value['cover_image'])) {
                            $new['image'] = $base_url . $value['cover_image'];
                        }
                        if (!empty($value['image'])) {
                            $new['image'] = $base_url2 . $value['image'];
                        }
                        if (!empty($value['concert_image'])) {
                            $new['image'] = $base_url3 . $value['concert_image'];
                        }
                        if (!empty($new)) {
                            $new_array[] = $new;
                        }
                    }
                }
            }
            $this->response(true, "All images", array('media' => $new_array));
        } else {
            $this->response(false, "There is a problem, please try again.", array('media' => array()));
        }
    }
    ///////////////////////////////////notification/////////////////////////
    public function get_notification() {
        $user_id = $_POST['user_id'];
        $data = $this->common->getData('notification', array('user_id' => $user_id), array('sort_by' => 'created_at', 'sort_direction' => 'desc'));
        if (!empty($data)) {
            $this->response(true, "Notification fetch Successfully", array('notification' => $data));
        } else {
            $this->response(false, "No notification found");
        }
    }
     public function get_notification_by_date() {
        $user_id = $_POST['user_id'];
        $array = array();

         $limit = $offset= '';
         $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }
        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }
        $count = 0;
     //  $data = $this->common->getData('notification', array('user_id' => $user_id), array('sort_by' => 'created_at','sort_direction' => 'desc','limit'=>$offset.','.$limit));
        $data = $this->common->getData('notification', array('user_id' => $user_id), array('group_by'=>'created_at','sort_by' => 'created_at','sort_direction' => 'desc','limit'=>$offset.','.$limit));

        if (!empty($data)) {
            foreach ($data as $key => $value){ 
                 $data1 = $this->common->getData('notification', array('user_id' => $user_id,'created_at'=>$value['created_at']), array('sort_by' => 'notification_id','sort_direction' => 'desc'));
                       $count += count($data1);
                       if(!empty($data1)){
                            $arr['date'] = $value['created_at'];
                            $arr['data'] = $data1;
                            $array[] = $arr;
                       }
            }
         
            $this->response(true, "Notification fetch Successfully", array('notification' => $array));
        } else {
            $this->response(false, "No notification found");
        }
    }
    ///////////////////////////Leave Group ////////////////////////
    public function leave_group() {
        $user_id = $_POST['user_id'];
        $group_id = $_POST['group_id'];
        $create_group = $this->common->getData('create_group', array('id' => $group_id, 'find_in_set("' . $user_id . '",members) <>' => 0), array('single'));
        if (!empty($create_group)) {
            $members = explode(',', $create_group['members']);
            $index = array_search($user_id, $members);
            if ($index !== false) {
                unset($members[$index]);
            }
            $members = implode(',', $members);
            $update = $this->common->updateData('create_group', array('members' => $members), array('id' => $group_id));
        }
        if (!empty($update)) {
            $this->response(true, "Successfully Leave group", array());
        } else {
            $this->response(false, "There is a problem, please try again.", array());
        }
    }
    /////////////////////////////////// Hall of Fame ///////////////////////
    public function hall_of_fame() {
        $fdonate = "";
        $allcredits = array();
        $filter = $_POST['filter'];
        $type = $_POST['type'];
        $user_id = $_POST['user_id'];
    
        $fandata = $this->common->hall_of_fame($user_id,$filter,$type);
        if (!empty($fandata['fandata'])) {
            foreach ($fandata['fandata'] as $key => $value) {
                 if ($type == '0') {
                    $credit = $this->common->credit_amount($value['friends_id'],$user_id);
                 }

                 if ($type == '1') {
                     $credit = $this->common->credit_amount($value['fans_id'],$user_id);
                 }

                if(!empty($credit)) {
                    $allcredits[] = $credit;  
                }
            }

            $donate = $this->common->hall_of_fame($user_id,$filter,$type);
            if (!empty($donate['donate'])) {
                $donate_list = $donate['donate'];
            } else {
                $donate_list = array();
            }
            $this->response(true, "Updated Hall Of fame", array('top_fan' => $fandata['fandata'], 'credits' => $allcredits, 'donaters' => $donate_list));
        } else {
            $this->response(false, "No hall of fame found");
        }
    }
     public function updated_hall_of_fame() {
        $fdonate = "";
        $allcredits = array();
        $filter = $_POST['filter'];
        $type = $_POST['type'];
        $user_id = $_POST['user_id'];
        $fandata = $this->common->hall_of_fame($user_id,$filter,$type);
        if (!empty($fandata['fandata'])) {
            foreach ($fandata['fandata'] as $key => $value) {
                 if ($type == '0') {
                    $credit = $this->common->credit_amount($value['friends_id'],$user_id);
                 }

                 if ($type == '1') {
                     $credit = $this->common->credit_amount($value['fans_id'],$user_id);
                 }

                if(!empty($credit)) {
                    $allcredits[] = $credit;  
                }
            }
            $donate = $this->common->hall_of_fame($user_id,$filter,$type);
            if (!empty($donate['donate'])) {
                $donate_list = $donate['donate'];
            } else {
                $donate_list = array();
            }
            $array1 = array( 'title' => "Top Fan",'type'=>'grid','data' => $fandata['fandata']);
            $array2 =  array('title'=> "Top Fan List",'type'=>'list','data' => $allcredits);
            $array3 =   array('title'=> "Top Donaters",'type'=>'grid','data' => $donate_list);
            $array4 =   array('title'=> "Top Donaters List",'type'=>'list','data' => $donate_list);
        
            $this->response(true, "Updated Hall Of fame", array('hall_of_fame' => array($array1,$array2,$array3,$array4)));
        } else {
            $this->response(false, "No hall of fame found");
        }
    }
    ///////////////////////////testing api /////////////////////
    public function test_file() {
        $target_path = "./assets/testing/";
        // array for final json respone
        $response = array();
        // getting server ip address
        $server_ip = gethostbyname(gethostname());
        // final file url that is being uploaded
        $file_upload_url = base_url('/assets/testing/');
        if (isset($_FILES['image']['name'])) {
            $target_path = $target_path . basename($_FILES['image']['name']);
            // reading other post parameters
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $website = isset($_POST['website']) ? $_POST['website'] : '';
            $response['file_name'] = basename($_FILES['image']['name']);
            $response['email'] = $email;
            $response['website'] = $website;
            try {
                // Throws exception incase file is not being moved
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    // make error flag true
                    $response['error'] = true;
                    $response['message'] = 'Could not move the file!';
                }
                // File successfully uploaded
                $response['message'] = 'File uploaded successfully!';
                $response['error'] = false;
                $response['file_path'] = $file_upload_url . basename($_FILES['image']['name']);
            }
            catch(Exception $e) {
                // Exception occurred. Make error flag true
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
        } else {
            // File parameter is missing
            $response['error'] = true;
            $response['message'] = 'Not received any file!F';
        }
        // Echo final json response to client
        echo json_encode($response);
    }
    ////////////////////////////share//////////////////
    public function reels_share() {
        if (!empty($_POST['user_id'])) {
            $share_link = '?reels_id='.$_POST['reels_id'];
            $_POST['share_link'] =  $share_link;

            if(!empty($_POST['share_to'])){
                $export = explode(',', $_POST['share_to']);
                foreach ($export as $key => $value) {
                     $_POST['share_to'] = $value;
                     $share = $this->common->getField('reels_share', $_POST);
                     $result = $this->common->insertData('reels_share', $share);
                     $shareid = $this->db->insert_id();

                     if (!empty($shareid)) {
                            $reciver = user_detail($value);
                            $sender = user_detail($_POST['user_id']);
                            $result = $this->common->insertData('chat_messages', array('sender_id' => $_POST['user_id'], 'sender_name' => isset($sender['full_name']) ? $sender['full_name'] : "", 'sender_image' => $sender['profile_image'], 'receiver_id' => $_POST['share_to'], 'receiver_name' => $reciver['full_name'], 'receiver_image' => $reciver['profile_image'], 'messages' => $share_link, 'image' => "", "type" => "2",'refer_id'=>$_POST['reels_id'], 'datetime' => strtotime(date('Y-m-d'))));

                             $noti  = $this->common->send_all_notification($value,ucwords($sender['full_name']).' shared a reel' ,"Share",'2',array('refer_id'=>$_POST['reels_id']));
                        }
                }
            }
            $this->response(true, "Successfully Shared!", array());
        } else {
            $this->response(false, "Not Shared!");
            exit();
        }
    }
    ///////////////////////////artist_page_share /////////
    public function artist_page_share() {

          $share_link = 'deeplinking/artist_army.php?artist_id='.$_POST['artist_id'].'&user_id='.$_POST['user_id'].'&type=3';
          $_POST['share_link'] =  $share_link;

          $artist_detail = user_detail($_POST['artist_id']);
        if (!empty($_POST['user_id'])) {
            if(!empty($_POST['share_to'])){
                $export = explode(',', $_POST['share_to']);
                foreach ($export as $key => $value) {
                     $_POST['share_to'] = $value;
                     $share = $this->common->getField('artist_page_share', $_POST);
                     $result = $this->common->insertData('artist_page_share', $share);
                     $shareid = $this->db->insert_id();

                     if (!empty($shareid)) {
                            $reciver = user_detail($value);
                            $sender = user_detail($_POST['user_id']);
                            $result = $this->common->insertData('chat_messages', array('sender_id' => $_POST['user_id'], 'sender_name' => isset($sender['full_name']) ? $sender['full_name'] : "", 'sender_image' => $sender['profile_image'], 'receiver_id' => $_POST['share_to'], 'receiver_name' => $reciver['full_name'], 'receiver_image' => $reciver['profile_image'], 'messages' => $share_link, 'image' => "", "type" => "3", 'refer_id'=>$_POST['artist_id'],'datetime' => strtotime(date('Y-m-d'))));

                            $notifi = $this->common->send_all_notification($value,$sender['full_name'].' sent you a artist profile:'.$artist_detail['artist_name'],"Profile",'3',array('refer_id'=>$_POST['user_id'],'ref_artist_id'=>$_POST['artist_id']));

                        }
                }
            }
          
            $this->response(true, "Successfully Shared!", array('not'=>$notifi));
        } else {
            $this->response(false, "Not Shared!");
            exit();
        }
    }
     ///////////////////////////post_share /////////
    public function post_share() {

          $share_link = '?post_id='.$_POST['post_id'];

           $postdata = $this->common->getData('post', array('id' => $_POST['post_id']), array('single'));
           $post_user_fullname = user_detail($postdata['user_id']);

          $_POST['share_link'] =  $share_link;
            $noti = "";
        if (!empty($_POST['user_id'])) {
            if(!empty($_POST['share_to'])){
                $export = explode(',', $_POST['share_to']);
                foreach ($export as $key => $value) {
                     $_POST['share_to'] = $value;
                     $share = $this->common->getField('post_share', $_POST);
                     $result = $this->common->insertData('post_share', $share);
                     $shareid = $this->db->insert_id();

                     if (!empty($shareid)) {
                            $reciver = user_detail($value);
                            $sender = user_detail($_POST['user_id']);
                            $result = $this->common->insertData('chat_messages', array('sender_id' => $_POST['user_id'], 'sender_name' => isset($sender['full_name']) ? $sender['full_name'] : "", 'sender_image' => $sender['profile_image'], 'receiver_id' => $_POST['share_to'], 'receiver_name' => $reciver['full_name'], 'receiver_image' => $reciver['profile_image'], 'messages' => $share_link, 'image' => "", "type" => "1",'refer_id'=>$_POST['post_id'], 'datetime' => strtotime(date('Y-m-d'))));

                            $noti  = $this->common->send_all_notification($value,ucwords($sender['full_name']).' shared you a post by '.ucwords($post_user_fullname['full_name']),"Share",'1',array('refer_id'=>$_POST['post_id']));
                        }

                }
            }
            $this->response(true, "Successfully Shared!", array('sendnoti'=>$noti));
        } else {
            $this->response(false, "Not Shared!");
            exit();
        }
    }
    /////////////////////////////////add_credits////////////////////////
    public function add_credits() {
        $song_no = $_POST['song_no'];
        $amount = 0;
        if (!empty($_POST['user_id']) && !empty($_POST['refer_id'])) {

             $credit_amount = $this->common->getData('credit_amount',array(),array());
             $amount = $credit_amount[1]['amount'];

            if(!empty($_POST['song_id'])){
                $song_id  = $_POST['song_id'];
            }else{
                $song_id  = "";
            }
            if (!empty($song_no)) {
              
                $credits = array("refer_id" => $_POST['refer_id'], "fans_id" => $_POST['user_id'], "artist_id" => $_POST['artist_id'], "amount" => $amount  , "song_no" => $_POST['song_no'],'song_id'=>$song_id);
            }

            $getcredits = $this->common->getData('credits',array("refer_id" => $_POST['refer_id'], "fans_id" => $_POST['user_id'], "artist_id" => $_POST['artist_id'],"song_no" => $_POST['song_no'],'song_id'=>$song_id),array('single'));

            if(empty($getcredits)){
                $result = $this->common->insertData('credits', $credits);
                $insert_id = $this->db->insert_id();

                if($insert_id){
                    $amounthalf = floatval($amount/2);
                     $credits = array("refer_id" => $_POST['user_id'], "fans_id" => $_POST['refer_id'], "artist_id" => $_POST['artist_id'], "amount" =>$amounthalf,"song_no" => $_POST['song_no'],'ref_fans_id'=>$_POST['refer_id'],'song_id'=>$song_id);

                    $result = $this->common->insertData('credits', $credits);
                    $insert_id = $this->db->insert_id();

                     $notifi = $this->common->send_all_notification($_POST['refer_id'],'You have earned '.$amount.' credit points ',"Credits",'4',array('refer_id'=>$_POST['refer_id']));
                }
            }
            // $totalamount = $this->common->getData('credits', array("refer_id" => $_POST['refer_id'], "fans_id" => $_POST['user_id'], "artist_id" => $_POST['artist_id']), array('field'=>'SUM(amount) as totalamount'));
            $this->response(true, "Successfully credited!");
        } else {
            $this->response(false, " Not credited!");
            exit();
        }
    }
    /////////////////////////////////Chat messages///////////////////////////
    public function send_message() {

        $result = $this->common->insertData('chat_messages', array('sender_id' => $_GET['sender_id'], 'sender_name' => $_GET['sender_name'], 'sender_image' => $_GET['sender_image'], 'receiver_id' => $_GET['receiver_id'], 'receiver_name' => $_GET['receiver_name'], 'receiver_image' => $_GET['receiver_image'], 'messages' => $_GET['messages'], 'image' => $_GET['image'], 'datetime' => $_GET['datetime']));

        $insert_id = $this->db->insert_id();
        if ($insert_id > 0) {
            $this->response(true, "Successfully Sent!", array());
        } else {
            $this->response(false, "Not Sent!");
        }
    }
    public function chat_image() {
        $image_name = "";
        if (isset($_FILES['image'])) {
            $image = $this->common->do_upload('image', './assets/chat/');
            if (isset($image['upload_data'])) {
                $image_name = $image['upload_data']['file_name'];
                $url = base_url('assets/chat/') . $image_name;
            }
        }
        if ($image_name != "") {
            $this->response(true, "file Upload Successfully!", array('image_url' => $url));
        } else {
            $this->response(false, "Not Sent!");
        }
    }
    public function user_chat_messages() {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        $arr = array();
        if (!empty($user_id)) {
            $where = " (sender_id = '" . $user_id . "' and receiver_id = '" . $friend_id . "') OR  (receiver_id = '" . $user_id . "' and sender_id = '" . $friend_id . "') ";
        
             $chat_messages = $this->common->getData('chat_messages', $where, array('sort_by'=>"messages_id",'sort_direction'=>"ASC"));

             if(!empty($chat_messages)){
                foreach ($chat_messages as $key => $value) {
                     if (!empty($value['messages'])) {

                        if($value['type'] > 0){

                              $value['messages'] = base_url().$value['messages'];
                        }
                      
                    }
                    $arr[] = $value;
                }
             }
            $this->response(true, "Fetch messages Successfully!", array("chat_messages" => $arr));
        } else {
            $this->response(false, "No message found", array("chat_messages" => array()));
        }
    }
    public function chat_users() {

        $arr = array();
        $key0 = "";   

        $limit = $offset= '';
        $page_count = $_POST['page_count'];

        if($_POST['start'] == 0){
             $offset  = ($_POST['start']+$page_count);
             $limit = 0;
        }

        if($_POST['start'] != 0){
             $limit  = $_POST['start'];
             $offset = ($_POST['start']+ $page_count);
        }

        $user_id = $_POST['user_id'];
        $chats = array();
        $cmessages = array();
        if (!empty($user_id)) {
            $cwhere = " receiver_id = '" . $user_id . "'";
            $cmessages = $this->common->getData('chat_messages', $cwhere, array('field'=>'sender_id as id, sender_name as full_name, sender_image as profile_image','group_by'=>'id','sort_by'=>'messages_id','sort_direction'=>'desc'));

            $user = $this->common->getData('user', array('id' => $user_id), array('single'));

            $chat_users =  $this->common->chat_users($user_id,$user['user_type']);

            if (!empty($chat_users)) {
                $array1 = array_merge($cmessages, $chat_users);
                $ids = array_column($array1, 'id');
                $ids = array_unique($ids);
                $array = array_filter($array1, function ($key, $value) use ($ids) {
                    return in_array($value, array_keys($ids));
                }, ARRAY_FILTER_USE_BOTH);

            if(!empty($page_count)){
                 $array =  array_splice($array,$limit,$offset);
            
              }
                foreach ($array as $key => $value) {

                     $lwhere = "(sender_id = '" . $value['id'] . "') OR  (receiver_id = '" . $value['id'] . "')";  

                     $chat_messages = $this->common->getData('chat_messages',$lwhere, array('sort_by'=>'messages_id','sort_direction'=>'desc','limit'=>1,'single'));

                    if (!empty($chat_messages['messages'])) {

                        if($chat_messages['type'] > 0){

                              $value['messages'] = base_url().$chat_messages['messages'];
                        }else{
                              $value['messages'] = $chat_messages['messages'];
                        }
                      
                    } else if (!empty($chat_messages['image'])) {
                        $value['messages'] = "Photo";
                    } else {
                        $value['messages'] = "";
                    }
                    $value['datetime'] = $value['datetime'] = !empty($chat_messages['datetime']) ? $chat_messages['datetime'] : "";
                    $value['count'] = 0;
                    $chats[] = $value;
                }
                $this->response(true, "Fetch messages Successfully!", array("chat_users" => $chats));
            } else {
                $this->response(false, "No chat user found", array("chat_users" => array()));
            }
        } else {
            $this->response(false, "user Id field is mandatory", array("chat_users" => array()));
        }
    }
    public function read_chat() {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        if (!empty($user_id)) {

            $where = "(sender_id = '" . $user_id . "' and receiver_id = '" . $friend_id . "') OR  (receiver_id = '" . $user_id . "' and sender_id = '" . $friend_id . "') and status = '1' ";  
            $chat_messages = $this->common->getData('chat_messages',$where, array('sort_by'=>'messages_id','sort_direction'=>'desc'));
            if ($chat_messages) {
                foreach ($chat_messages as $key => $value) {
                    $update = $this->common->updateData('chat_messages', array('status' => "0"), array('messages_id' => $value['messages_id']));
                }
                $this->response(true, "read messages Successfully!");
            } else {
                $this->response(false, "No message found");
            }
        } else {
            $this->response(false, "Sender Id field is mandatory");
        }
    }
    public function delete_chat() {
        $sender_id = $_POST['user_id'];
        $receiver_id = $_POST['friend_id'];
        if (!empty($sender_id)) {
            $where = "(sender_id = '" . $sender_id . "' and receiver_id  = '" . $receiver_id . "' ) OR  (sender_id = '" . $receiver_id . "' and receiver_id = '" . $sender_id . "')";  
            $chat_messages = $this->common->getData('chat_messages',$where, array('sort_by'=>'messages_id','sort_direction'=>'desc'));
            if ($chat_messages) {
                foreach ($chat_messages as $key => $value) {
                    $result = $this->common->deleteData('chat_messages', array('messages_id' => $value['messages_id']));
                }
                $this->response(true, "message deleted!");
            } else {
                $this->response(false, "No message found");
            }
        } else {
            $this->response(false, "User Id field is mandatory");
        }
    }
 ////////////////////home_search///////////////////////////////////////////   
    public function home_search() {
        $user_id = $_POST['user_id'];
        $user = $this->common->getData('user', array('id' => $user_id), array('single'));
          if (!empty($user)) {
            $search = $_POST['search'];
            $userinfo = $this->common->home_search($user_id,$search);
            if (!empty($userinfo)) {
                $this->response(true, "Fetch user Successfully!", array("userinfo" => $userinfo));
            } else {
                $this->response(false, "No user found", array("userinfo" => array()));
            }
        } else {
            $this->response(false, "user Id field is mandatory", array("userinfo" => array()));
        }
    }
////////////////////////report user//////////////////
    public function report_user() {
        $user_id = $_POST['user_id'];
        $report_user = $this->common->getData('report_user', array('user_id' => $user_id, 'block_id' => $_POST['block_id'], 'post_id' => $_POST['post_id'],'type'=>'0'), array('single'));
        if (!empty($user_id)) {
            if (!empty($report_user)) {
                $this->response(false, "You have already Reported for this user");
                exit();
            } else {
                $insert = $this->common->insertData('report_user', $_POST);
                $insertid = $this->db->insert_id();
                if ($insertid > 0) {
                $this->response(true, "Reported successfully!");
                }
            }
        } else {
            $this->response(false, "user Id field is mandatory");
        }
    }
     public function block_user() {
         $_POST['type'] = 1;
        $user_id = $_POST['user_id'];
        $report_user = $this->common->getData('report_user', array('user_id' => $user_id, 'block_id' => $_POST['block_id'], 'type' => $_POST['type']), array('single'));
        if (!empty($user_id)) {
            if (!empty($report_user)) {
                $this->response(false, "You have already Blocked this user");
                exit();
            } else {
                $insert = $this->common->insertData('report_user', $_POST);
                $insertid = $this->db->insert_id();
                if ($insertid > 0) {
                    $this->response(true, "Blocked successfully!");
                }
            }
        } else {
            $this->response(false, "user Id field is mandatory");
        }
    }

     public function report_artist() {
        $user_id = $_POST['user_id'];
        $report_artist = $this->common->getData('report_artist', array('block_id' => $_POST['block_id']), array('single'));
        if (!empty($user_id)) {
            $count = count($report_artist);
            if (!empty($report_artist) && $count == 5) {

                if(report_user($user_id,$_POST['block_id'],'1') != 1){

                     $report_user = $this->common->insertData('report_user', array('user_id' => $user_id, 'block_id' => $_POST['block_id'],'type'=>'1'));
                        $this->response(false, "You have Blocked this artist");
                }else{
                       $this->response(false, "You have already Blocked this artist");
                }
             
                exit();
            } else {
                $insert = $this->common->insertData('report_artist', $_POST);
                $insertid = $this->db->insert_id();
                if ($insertid > 0) {
                    $this->response(true, "Artist Reported successfully!");
                }
            }
        } else {
            $this->response(false, "Artist Id field is mandatory");
        }
    }

    public function select_bitpack()
    {
        $user_id = $_POST['user_id'];
        $bit_pack_id = $_POST['bit_pack_id'];
        $total_donate_bit = $_POST['bit_amount'];

        $select =   $this->common->getData('bitpack_users', array('bit_pack_id' => $bit_pack_id,'user_id' => $user_id,'bitpack_status' => '0'), array('single'));

        if(empty($select)){
                $array = array("bit_pack_id"=>$bit_pack_id, "bit_pack_amount"=>$_POST['bit_amount'], "total_donate_bit"=>$_POST['bit_amount'], "user_id"=> $user_id);
                $insert = $this->common->insertData('bitpack_users', $array);
                $insertid = $this->db->insert_id();
            if ($insertid >0) {
                    $this->response(true, "Bitpack Added on your account Successfully.");
            }
        }else{
            $this->response(false, "You have already selected bitpack");
            exit();
        }
    }
 ///////////////post image //////////////////////
public function get_post_image()
    {
         $post_image = $this->common->getData('post_image', array('post_id' => $_POST['post_id']), array('field' => 'image'));

         if (!empty($post_image)) {
                $this->response(true, "Post image", array('post_images' => $post_image));
        } else {
            $this->response(false, "There is a problem, please try again.", array('post_images' => array()));
        }
    }

}