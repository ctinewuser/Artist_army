 <?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set("Asia/Kolkata");

error_reporting(0);

class Api extends Base_Controller {

    public function __construct()

    {

        parent:: __construct();

        $this->load->helper('common_helper');

        $this->data = json_decode(file_get_contents("php://input"));

    }   

//// signup///////////

	public function signup_mobile()

	    {

    	if(!empty($_POST['mobile_number'])){

			$rand = rand(1000,9999);

			$_POST['otp'] =(string)$rand;		

			$this->response(true,"First Step Done Succesfully!",array('userinfo'=>array('mobile_number' => $_POST['mobile_number'],'otp'=>$_POST['otp'])));					

			}else{

				$this->response(false," Invalid detail, please try again.");

			}		 

		}

	public function otp_verification()

	    {

    		 if(!empty($_POST['otp'])){

				$this->response(true,"OTP Verified!",array('userinfo'=>array('mobile_number' => $_POST['mobile_number'],'otp'=>$_POST['otp'])));					

			}else{

				$this->response(false," Invalid detail, please try again.");

			}		 

		}

	public function signup_pass()

	{

    	if(!empty($_POST['mobile_number'])) {

					

			$_POST['status'] = 1;    

			$_POST['created_at'] = date('Y-m-d H:i:s');

			$_POST['password'] = md5($_POST['password']);



		$exist2 = $this->common->getData('user',array('mobile_number' => $_POST['mobile_number']),array('single'));

		if($exist2){

			$this->response(false,"Mobile Number already exist");

			die;

		}else{

			$post = $this->common->getField('user',$_POST); 

			$result = $this->common->insertData('user',$post);

			$user_id = $this->db->insert_id();

    		if($user_id)

    		 {	

    		    $user = $this->common->getData('user',array('id' => $user_id),array('single'));

				$this->response(true,"Signup Succesfully!",array('userinfo'=>$user));					

			}else{

			   $this->response(false," Invalid detail, please try again.");

			}

		}		 

	}else{

			  $this->response(false," Invalid detail, please try again.");

		}	

    }

//// login///////////

    public function login()

    {               

        $_POST['password'] = md5($_POST['password']);



        $where = "mobile_number = '".$_POST['mobile_number']."' AND password = '".$_POST['password']."'";

       

        $result = $this->common->getData('user',$where,array('single'));

        

        if($result){

        if(isset($_REQUEST['android_token'])){

        $old_device = $this->common->getData('user',array('android_token' => $_REQUEST['android_token']),array('single','field'=>'id'));    

        }       

        if (isset($_REQUEST['ios_token'])) {

        $old_device = $this->common->getData('user',array('ios_token' => $_REQUEST['ios_token']),array('single','field'=>'id'));    

        }

        if($old_device){

        $this->common->updateData('user',array('android_token' => "", "ios_token" => ""),array('id' => $old_device['id']));

        }

        $this->common->updateData('user',array('ios_token' =>$_REQUEST['ios_token'], 'android_token' => $_REQUEST['android_token']), array('id' => $result['id']));

        $result['android_token'] = $_REQUEST['android_token'];

        $this->response(true,'Successfully Login',array("userinfo" => $result));                    

        }else{

        $message = "Wrong email or password";           

        $this->response(false,$message,array("userinfo" => array()));

        }

    }

//// add_post///////////    

    public function add_post()

    {



        if(!empty($_POST['user_id'])){

            $_POST['created_at'] = date('Y-m-d H:i:s');         

            $post = $this->common->getField('post',$_POST); 

            $result = $this->common->insertData('post',$post);

            $postid = $this->db->insert_id();

        }else{

             $this->response(false,"User Id field is mandatory"); 

            exit();

        }

       

        if(isset($_FILES['images']))

       {

        $image = $this->common->multi_upload('images','./assets/post/');

        

        foreach($image as $k =>$val)

       {

            $res=$this->common->insertData('post_image',array('user_id'=>$_POST['user_id'],'post_id'=>$postid,'image'=>$val['file_name'],'post_type'=>$_POST['post_type'])); 

       }

       

        $this->response(true,"Post successfully added",array('file'=>$_FILES['images']));

    }

    else

    {

         $this->response(false,"All fields are mandatory"); 

    }

 }

//post_like/////////// 

    public function post_like()

    {

        $user_id = $_POST['user_id'];

        $post_id = $_POST['post_id'];

        //$group_id = $_POST['group_id'];

        $_POST['created_date']=  date('Y-m-d');

        $_POST['created_time'] = date('H:i:s');

        $count = 0;

        $message = "";

        $likedata =  $this->common->getData('post_like',array('user_id'=>$user_id,'post_id'=>$post_id),array('single'));



        $postdata =  $this->common->getData('post',array('id'=>$post_id),array('single'));



         if(!empty($likedata)){

            $result=$this->common->deleteData('post_like',array('like_id'=>$likedata['like_id']));

            if($postdata['total_like'] > 0){

                $count = $postdata['total_like'] - 1;   

            }else{

                $count = $postdata['total_like'];

            }

            $message = "Dislike Post";

            

         }else{

            $post = $this->common->getField('post_like',$_POST); 

            $result = $this->common->insertData('post_like',$post);

            $count = $postdata['total_like'] + 1;

            $message = "Like Post";

         }  



          $update = $this->common->updateData('post',array('total_like'=>$count),array('id' =>$post_id));   

                

        if(!empty($update))

        {

            $this->response(true,$message,array('count'=>$count));

        }

        else

        {

            $this->response(false,"There is a problem, please try again.",array('count'=>$count));

        }

}

//delete_post/////

    public function delete_post()

    {



        $post=$this->common->deleteData('post',array('id'=>$_POST['post_id']));



        $post_like=$this->common->deleteData('post_like',array('post_id'=>$_POST['post_id']));

        $post_comment=$this->common->deleteData('post_comment',array('post_id'=>$_POST['post_id']));





        $post_image=$this->common->deleteData('post_image',array('post_id'=>$_POST['post_id']));

        if($post_image)

        {

            foreach ($post_image as $key => $value) {



                  $image_path = getcwd();

                   unlink($image_path."/assets/post/".$value['images']);

            }

            $this->response(true,"Post successfully deleted");

        }

        else

        {

            $this->response(false,"Post not deleted");

        }

}

///////post_comment//////////////

public function add_post_comment()

   {

        $_POST['created_date'] =date('Y-m-d');

        $_POST['created_time'] = date('H:i:s');



        $this->db->select('P.*,U.android_token,U.ios_token,U.full_name');

        $this->db->from('user as U');

        $this->db->join('post as P', 'P.user_id = U.id');

        $this->db->where('P.id',$_POST['post_id']);

        $query = $this->db->get();

        $post_list =  $query->result_array()[0];



        if($_POST['comment_id']){

            $_POST['refer_id'] = $_POST['comment_id'];

        }else{

            $_POST['refer_id'] = 0;

        }



        unset($_POST['comment_id']);

        $_POST['reciever_id'] = $post_list['user_id'];

        $post = $this->common->getField('post_comment',$_POST); 

        $result = $this->common->insertData('post_comment',$post);



        if(!empty($result)){

            $id = $this->db->insert_id();

            $comment = $this->common->getData('post_comment',array('post_id'=> $_POST['post_id'],'refer_id'=>0),array());

            $count = count($comment);



            $upcomment = $this->common->updateData('post',array('total_comment'=>$count),array('id'=>$_POST['post_id']));



            $this->response(true,"Success Comment Added",array('comment'=>$comment,'count'=>$count));

        }else{

            $this->response(false,"No Comments Yet!");

        }

   }



//////genre_category/////

    public function genre_category(){



        if(!empty($_POST['user_id'])){

             $subquery = "(exists (select 1

                from user L

                where  FIND_IN_SET(C.genre_id,L.genre_cat) <> 0 and L.id = '".$_POST['user_id']."') ) as is_selected ,";

                //$subquery ="";

        }else{

            $subquery ="";

        }



        $this->db->select('C.*,'.$subquery);

        $this->db->from('genre_category as C');

        if(!empty($_POST['search'])){



           $this->db->where("genre_name LIKE '%".$_POST['search']."%'");

        }

        $query = $this->db->get();

        $genre_category =  $query->result_array();



      

       // $genre_category = $this->common->getData('genre_category',array('status'=>0),array());

        if(!empty($genre_category))

        {

            $this->response(true,"Success",array('genre_category'=>$genre_category));



        }else

        {

            $this->response(false,"Genre Category Not found");



        }

    }

///////edit_comment/////   

    public function edit_comment()

    {

        $update = $this->common->updateData('post_comment',array('message' =>$_POST['message']),array('comment_id' => $_POST['comment_id']));

            if($update){

            $this->response(true,"comment updated Successfully.");

            }else{

                $this->response(false,"There is a problem, please try again.");

            }

    }

//////delete_comment/////      

    public function delete_comment()

    {

       $results=$this->common->deleteData('post_comment',array('comment_id'=>$_POST['comment_id']));

            if($this->db->affected_rows() > 0){

                $post = $this->common->getData('post',array('id'=> $_POST['post_id']),array('single'));

                $count = isset($post['total_comment']) > 0 ? ($post['total_comment'] - 1): 0;

                $upcomment = $this->common->updateData('post',array('total_comment'=>$count),array('id'=>$_POST['post_id']));

                 $this->response(true,"Comment Successfully Deleted");

            }

        else

        {

            $this->response(false,"comment does not exits");

        }

    }

//////post_list/////          

    public function post_list()

    {

        if(!empty($_POST['user_id'])){
            $subquery = "(exists (select 1
                from post_like L
                where L.post_id = P.id and L.user_id = '".$_POST['user_id']."') ) as is_like ,

                (exists (select 1
                from pinboard Pin
                where Pin.post_id = P.id and Pin.user_id = '".$_POST['user_id']."') ) as is_saved ,";
        }else{
            $subquery ="";
        }

        $this->db->select('P.*,'.$subquery.'U.profile_image as user_profile_image,U.full_name as user_full_name');

        $this->db->from('post as P');

        $this->db->join('user as U', 'P.user_id = U.id');

        $this->db->order_by('P.id','desc');



        $query = $this->db->get();

        $post_list =  $query->result_array();

        if(!empty($post_list)){

        foreach ($post_list as $key => $value) {



           $r=$this->common->getData('post_image',array('post_id'=>$value['id']),array('','field'=>'image'));



           if(!empty($r))

           {

                $post_list[$key]['post_images']=$r;

           }

           else

           {

                $post_list[$key]['post_images']=array();

           }

           // if($this->common->getcomment($value['id'])){

           //      $post_list[$key]['post_comments'] = $this->common->getcomment($value['id']);

           // }else{

           //    $post_list[$key]['post_comments'] = array();



           // }

        }

         $this->response(true,"Post List",array('post_list'=>$post_list)); 

    }else{

         $this->response(false,"There is a problem, please try again.",array('post_list'=>array())); 

    }

}

////////////All comments//////// 

    public function post_all_comments()

      {

           $user_id = $_POST['user_id'];

            $post_comments = $this->common->getcomment($_POST['post_id'],$user_id);

            // echo $this->db->last_query();

            if($post_comments){

                $this->response(true,"Post List",array('post_comments'=>$post_comments,'total_comment'=>count($post_comments))); 

            }else{

                 $this->response(false,"There is a problem, please try again.",array('post_comments'=>array())); 

            }

        }

////////post_comment_like/////////////////

public function post_comment_like()

{

    $user_id = $_POST['user_id'];

    $comment_id = $_POST['comment_id'];

   

    $_POST['created_date']=  date('Y-m-d');

    $_POST['created_time'] = date('H:i:s');

    $count = 0;

    $message = "";

    $likedata =  $this->common->getData('post_comment_like',array('user_id'=>$user_id,'comment_id'=>$comment_id),array('single'));



    $postdata =  $this->common->getData('post_comment',array('comment_id'=>$comment_id),array('single'));



     if(!empty($likedata)){

        $result=$this->common->deleteData('post_comment_like',array('like_id'=>$likedata['like_id']));

        if($postdata['total_like'] > 0){

            $count = $postdata['total_like'] - 1;   

        }else{

            $count = $postdata['total_like'];

        }

        $message = "Dislike Comment";

        

     }else{

        $post = $this->common->getField('post_comment_like',$_POST); 

        $result = $this->common->insertData('post_comment_like',$post);

        $count = $postdata['total_like'] + 1;

        $message = "Like Comment";

     }  



      $update = $this->common->updateData('post_comment',array('total_like'=>$count),array('comment_id' =>$comment_id)); 

            

    if(!empty($update))

    {

        $postdata =  $this->common->getData('post_comment',array('comment_id'=>$comment_id),array('single'));

        $like = $this->common->getData('post_comment_like',array("comment_id"=>$comment_id,"user_id"=>$user_id),array('single'));              

          if(!empty($like)){

              $is_comment_like = 1;

          }else{

              $is_comment_like = 0;

          }  



        $this->response(true,$message,array('count'=>(string)$count,'is_comment_like'=>$is_comment_like));

    }

    else

    {

        $this->response(false,"There is a problem, please try again.",array('count'=>$count));

    }

}        

//////////Update Profile        

public function update_profile()

    {

        $result = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));

        if($result)

        {

            /*$_POST['profile_image'] = '';

            if(isset($_FILES['profile_image'])){

                 $image = $this->common->do_upload('profile_image','./assets/userfile/profile/');

                if(isset($image['upload_data'])){

                    $_POST['profile_image'] = $image['upload_data']['file_name'];

                }

             }
*/
            $post = $this->common->getField('user',$_POST); 

            $info = $this->common->updateData('user',$post,array('id'=>$_POST['user_id']));

            $this->db->select('U.*');

            $this->db->from('user as U');

           // $this->db->join('genre_category as G', 'G.genre_id = U.id','LEFT');

            $this->db->where('U.id',$_POST['user_id']);

            $query = $this->db->get();

            $user =  $query->result_array()[0];

         

            $this->response(true,"Your Profile Is Updated Sucessfully.",array('userinfo'=>$user));  

        }else{

             $this->response(false,"There Is a Problem, Please Try Again.",array('userinfo'=>(object)array()));

        }

    }

//////////getProfile /////////////////     

    public function getProfile()

    {

        $sql = "SELECT i.*, GROUP_CONCAT(c.genre_name) AS genre_name FROM user i, genre_category c WHERE FIND_IN_SET(c.genre_id, i.genre_cat)<> 0 AND i.id='".$_POST['user_id']."' and  i.genre_cat IS NOT NULL";    

        $query = $this->db->query($sql);

        $user = $query->result_array()[0];

        //SELECT i.*, GROUP_CONCAT(c.genre_name) AS Ganrename FROM user i, genre_category c 

        //WHERE FIND_IN_SET(c.genre_id, i.genre_cat)<> 0 and   TRIM( IFNULL( i.genre_cat  , '' ) ) > ''

         //echo $this->db->last_query();

        // $this->db->select('U.*,G.genre_name,G.genre_image');

        // $this->db->from('user as U');

        // $this->db->join('genre_category as G', 'G.genre_id = U.genre_cat','LEFT');

        // $this->db->where('U.id',$_POST['user_id']);

        // $query = $this->db->get();

        // $user =  $query->result_array()[0];

        if($user){

            $this->response(true,"Profile Fetch Successful",array("userinfo" => $user));

        }else{

             $this->response(false,"There Is a Problem, Please Try Again.",array("userinfo" => array()));

        }           

    }

     public function artistProfile()

    {
       
        $subquery = "(SELECT COUNT(*) FROM post WHERE user_id=U.id) AS total_post ,

        (SELECT COUNT(*) FROM goals WHERE user_id=U.id) AS total_credits ,

        (SELECT COUNT(*) FROM follower WHERE artist_id=U.id) AS total_follower ,

       

        (SELECT SUM(LENGTH(redeem_members) - LENGTH(REPLACE(redeem_members, ',', '')) + 1)

        FROM goals  where user_id = U.id and  TRIM( IFNULL( redeem_members , '' ) ) > '') AS total_redeem      

       ";

        $this->db->select('U.*,G.genre_name,G.genre_image,'.$subquery);

        $this->db->from('user as U');

        $this->db->join('genre_category as G', 'G.genre_id = U.genre_cat','LEFT');

        $this->db->where('U.id',$_POST['artist_id']);

        $query = $this->db->get();


        //echo $this->db->last_query();

        $user =  $query->result_array()[0];

        if($user){


        if(!empty($_POST['fans_id'])){


            $ffans_id = $this->common->getData('follower',array('artist_id'=>$_POST['artist_id'],'fans_id'=>$_POST['fans_id']),array('single'));  

            if(!empty($ffans_id)){

              $user['is_follow'] =  "1" ; 
            }else{
                $user['is_follow'] =  "0" ; 
            }
        }
        //     $subquery2 = ",(exists (select 1

        //         from follower F

        //         where F.fans_id = '".$_POST['fans_id']."') ) as is_follow ";

        // }else{

        //     $subquery2 ="";

        // }

        $artist_songs = $this->common->getData('artist_songs',array('user_id'=>$_POST['artist_id']),array('sort_by'=>'id','sort_direction'=>'desc','limit'=>'3'));  

        $user['artist_songs'] = !empty($artist_songs) ? $artist_songs :array();

            $this->response(true,"Profile Fetch Successful",array("userinfo" => $user));

        }else{

             $this->response(false,"There Is a Problem, Please Try Again.",array("userinfo" =>array()));

        }           

    }

////////// add_post///////////    

    public function add_reels()

    {



        if(!empty($_POST['user_id'])){

          //  $_POST['created_at'] = date('Y-m-d H:i:s');         

             $_POST['reel_video'] = '';

            if(isset($_FILES['reel_video'])){

                 $reel_video = $this->common->do_upload('reel_video','./assets/reels/');

                if(isset($reel_video['upload_data'])){

                    $_POST['reel_video'] = $reel_video['upload_data']['file_name'];

                }

             }

              $post = $this->common->getField('reels',$_POST); 

            $result = $this->common->insertData('reels',$post);

            $postid = $this->db->insert_id();



        }else{

             $this->response(false,"User Id field is mandatory"); 

             exit();

        }

                  

             $this->response(true,"Reels successfully added");

     }

////////////songs_list/////////////////////         

    public function songs_list()

        {

            $this->db->select('*');

            $this->db->from('songs');

            $query = $this->db->get();

            $songs =  $query->result_array();

            if($songs){
            	foreach ($songs as $key => $value) {
            		$value['file_path'] = base_url('assets/songs/').$value['song_name'];
            		$song[] = $value;
            	}
                $this->response(true,"Songs Fetch Successful",array("songs" => $song));

            }else{

                 $this->response(false,"There Is a Problem, Please Try Again.",array("songs" =>array()));

            }           

        }

////////////reels_list////////////////

    public function reels_list()

    {

        if(!empty($_POST['user_id'])){

            $subquery = "(exists (select 1

                from reels_like L

                where L.reels_id = R.id and L.user_id = '".$_POST['user_id']."') ) as is_like , (exists (select 1

                from reels_favourite F

                where F.reels_id = R.id and F.user_id = '".$_POST['user_id']."') ) as is_favourite ,";

        }else{

            $subquery ="";

        }

        



        $sql = "SELECT R.*,S.song_name,S.singer_name,".$subquery." U.profile_image as user_profile_image,U.full_name as user_full_name,SUM(R.total_like + R.total_star) as sum_reel from reels as R 

        LEFT JOIN user as U ON R.user_id = U.id

        LEFT JOIN songs as S ON S.id = R.reel_songs

         GROUP BY R.id  having sum_reel > 0";    

        $query = $this->db->query($sql);

        $reels_list = $query->result_array();







       $sql = "SELECT R.*,S.song_name,S.singer_name,".$subquery." U.profile_image as user_profile_image,U.full_name as user_full_name,SUM(R.total_like + R.total_star) as sum_reel from reels as R 

        LEFT JOIN user as U ON R.user_id = U.id

        LEFT JOIN songs as S ON S.id = R.reel_songs

         GROUP BY R.id  having sum_reel <= 1";    

        $query = $this->db->query($sql);

        $for_you = $query->result_array();





        if(!empty($reels_list)){

         $this->response(true,"reels List",array('reels_list'=>$reels_list,'for_you'=>$for_you)); 

    }else{

         $this->response(false,"There is a problem, please try again.",array('reels_list'=>array())); 

    }

 }



 public function reels_list_with_type()

    {

        if(!empty($_POST['user_id'])){

            $subquery = "(exists (select 1

                from reels_like L

                where L.reels_id = R.id and L.user_id = '".$_POST['user_id']."') ) as is_like , (exists (select 1

                from reels_favourite F

                where F.reels_id = R.id and F.user_id = '".$_POST['user_id']."') ) as is_favourite ,";

        }else{

            $subquery ="";

        }

        
      if($_POST['type'] == '1'){

          $sql = "SELECT R.*,S.song_name,S.singer_name,".$subquery." U.profile_image as user_profile_image,U.full_name as user_full_name,SUM(R.total_like + R.total_star) as sum_reel from reels as R 

        LEFT JOIN user as U ON R.user_id = U.id

        LEFT JOIN songs as S ON S.id = R.reel_songs

         GROUP BY R.id  having sum_reel > 0";    

        $query = $this->db->query($sql);

        $reels_list = $query->result_array();

      }


       if($_POST['type'] == '2'){

       $sql = "SELECT R.*,S.song_name,S.singer_name,".$subquery." U.profile_image as user_profile_image,U.full_name as user_full_name,SUM(R.total_like + R.total_star) as sum_reel from reels as R 

        LEFT JOIN user as U ON R.user_id = U.id

        LEFT JOIN songs as S ON S.id = R.reel_songs

         GROUP BY R.id  having sum_reel <= 1";    

        $query = $this->db->query($sql);

        $reels_list = $query->result_array();

      }

        if(!empty($reels_list)){

         $this->response(true,"reels List",array('reels_list'=>$reels_list)); 

    }else{

         $this->response(false,"There is a problem, please try again.",array('reels_list'=>array())); 

    }

 }

//////////////////reels_comment//////////////

  public function reels_all_comments()

      {

        $user_id = $_POST['user_id'];

            $reels_comments = $this->common->get_reels_comment($_POST['reels_id'],$user_id);

            if($reels_comments){

                $this->response(true,"reels List",array('reels_comments'=>$reels_comments,'total_comment'=>count($reels_comments))); 

            }else{

                 $this->response(false,"There is a problem, please try again.",array('reels_comments'=>array())); 

            }

        }

//////////////reels_like

public function reels_like()

    {

        $user_id = $_POST['user_id'];

        $post_id = $_POST['reels_id'];

        //$group_id = $_POST['group_id'];

        $_POST['created_date']=  date('Y-m-d');

        $_POST['created_time'] = date('H:i:s');

        $count = 0;

        $message = "";

        $likedata =  $this->common->getData('reels_like',array('user_id'=>$user_id,'reels_id'=>$post_id),array('single'));



        $postdata =  $this->common->getData('reels',array('id'=>$post_id),array('single'));



         if(!empty($likedata)){

            $result=$this->common->deleteData('reels_like',array('like_id'=>$likedata['like_id']));

            if($postdata['total_like'] > 0){

                $count = $postdata['total_like'] - 1;   

            }else{

                $count = $postdata['total_like'];

            }

            $message = "Dislike Reel";

            

         }else{

            $post = $this->common->getField('reels_like',$_POST); 

            $result = $this->common->insertData('reels_like',$post);

            $count = $postdata['total_like'] + 1;

            $message = "Like Reel";

         }  



          $update = $this->common->updateData('reels',array('total_like'=>$count),array('id' =>$post_id));   

                

        if(!empty($update))

        {

            $this->response(true,$message,array('count'=>$count));

        }

        else

        {

            $this->response(false,"There is a problem, please try again.",array('count'=>$count));

        }

} 



///////post_comment//////////////

public function add_reel_comment()

   {

        $_POST['created_date'] =date('Y-m-d');

        $_POST['created_time'] = date('H:i:s');



        $this->db->select('P.*,U.android_token,U.ios_token,U.full_name');

        $this->db->from('user as U');

        $this->db->join('reels as P', 'P.user_id = U.id');

        $this->db->where('P.id',$_POST['reels_id']);

        $query = $this->db->get();

        $post_list =  $query->result_array()[0];



        if($_POST['comment_id']){

            $_POST['refer_id'] = $_POST['comment_id'];

        }else{

            $_POST['refer_id'] = 0;

        }



        unset($_POST['comment_id']);

        $_POST['reciever_id'] = $post_list['user_id'];

        $post = $this->common->getField('reels_comment',$_POST); 

        $result = $this->common->insertData('reels_comment',$post);

    

        if(!empty($result)){

            $id = $this->db->insert_id();

            $comment = $this->common->getData('reels_comment',array('reels_id'=> $_POST['reels_id'],'refer_id'=>0),array('sort_by'=>'comment_id','sort_direction'=>'desc'));

            $count = count($comment);



            $upcomment = $this->common->updateData('reels',array('total_comment'=>$count),array('id'=>$_POST['reels_id']));



            $this->response(true,"Success Comment Added",array('comment'=>$comment,'count'=>$count));

        }else{

            $this->response(false,"No Comments Yet!");

        }

   }

//////////////////delete_reels/////////////////////////

    public function delete_reels()

    {



        $post=$this->common->deleteData('reels',array('id'=>$_POST['reels_id']));



        $post_like=$this->common->deleteData('reels_like',array('reels_id'=>$_POST['reels_id']));

        $post_comment=$this->common->deleteData('reels_comment',array('reels_id'=>$_POST['reels_id']));



        if($post_comment)

        {

          

            $this->response(true,"reels successfully deleted");

        }

        else

        {

            $this->response(false,"reels not deleted");

        }

}

///////////////////////reels_comment_like/////////////////

public function reels_comment_like()

{

    $user_id = $_POST['user_id'];

    $comment_id = $_POST['comment_id'];

   

    $_POST['created_date']=  date('Y-m-d');

    $_POST['created_time'] = date('H:i:s');

    $count = 0;

    $message = "";

    $likedata =  $this->common->getData('reels_comment_like',array('user_id'=>$user_id,'comment_id'=>$comment_id),array('single'));



    $postdata =  $this->common->getData('reels_comment',array('comment_id'=>$comment_id),array('single'));



     if(!empty($likedata)){

        $result=$this->common->deleteData('reels_comment_like',array('like_id'=>$likedata['like_id']));

        if($postdata['total_like'] > 0){

            $count = $postdata['total_like'] - 1;   

        }else{

            $count = $postdata['total_like'];

        }

        $message = "Dislike Comment";

        

     }else{

        $post = $this->common->getField('reels_comment_like',$_POST); 

        $result = $this->common->insertData('reels_comment_like',$post);

        $count = $postdata['total_like'] + 1;

        $message = "Like Comment";

     }  



      $update = $this->common->updateData('reels_comment',array('total_like'=>$count),array('comment_id' =>$comment_id)); 

            

    if(!empty($update))

    {

        $this->response(true,$message,array('count'=>$count));

    }

    else

    {

        $this->response(false,"There is a problem, please try again.",array('count'=>$count));

    }

}

/////////////////////add favourite //////////////////////

public function reels_favourite()

    {

        $user_id = $_POST['user_id'];

        $post_id = $_POST['reels_id'];

        //$group_id = $_POST['group_id'];

        $_POST['created_date']=  date('Y-m-d');

        $_POST['created_time'] = date('H:i:s');

        $count = 0;

        $message = "";

        $likedata =  $this->common->getData('reels_favourite',array('user_id'=>$user_id,'reels_id'=>$post_id),array('single'));



        $postdata =  $this->common->getData('reels',array('id'=>$post_id),array('single'));



         if(!empty($likedata)){

            $result=$this->common->deleteData('reels_favourite',array('fav_id'=>$likedata['fav_id']));

            if($postdata['total_star'] > 0){

                $count = $postdata['total_star'] - 1;   

            }else{

                $count = $postdata['total_star'];

            }

            $message = "disfavored Reel";

            

         }else{

            $post = $this->common->getField('reels_favourite',$_POST); 

            $result = $this->common->insertData('reels_favourite',$post);

            $count = $postdata['total_star'] + 1;

            $message = "favourite Reel";

         }  



          $update = $this->common->updateData('reels',array('total_star'=>$count),array('id' =>$post_id));   

                

        if(!empty($update))

        {

            $this->response(true,$message,array('count'=>$count));

        }

        else

        {

            $this->response(false,"There is a problem, please try again.",array('count'=>$count));

        }

} 



///////created api by naincy 14/07/21

     public function terms_services(){

        $terms_services = $this->common->getData('terms_condition',array('id'=>1),array('single'));

        if(!empty($terms_services))

        {

            $this->response(true,"Success",array('terms_condition'=>$terms_services));



        }else

        {

            $this->response(false,"Services Not found");



        }

    }

     public function privacy_policy(){

        $privacy_policy = $this->common->getData('privacy_policy',array('id'=>1),array('single'));

        if(!empty($privacy_policy))

        {

            $this->response(true,"Success",array('privacy_policy'=>$privacy_policy));



        }else

        {

            $this->response(false,"Privacy Policy Not found");



        }

    }

    public function license(){

        $license_policy = $this->common->getData('licenses',array('id'=>1),array('single'));

        if(!empty($license_policy))

        {

            $this->response(true,"Success",array('licenses'=>$license_policy));



        }else

        {

            $this->response(false,"License Policy Not found");



        }

    }

//////////////// all post_like / comment like///////////////////

 public function all_likes()

   {

    $type = $_POST['type'];

    $id = $_POST['id'];

    if($type == 1){

         $sql="Select U.*,P.* from post_like as P  JOIN user as U ON P.user_id = U.id where post_id = '".$id."'"; 

         $msg = "Post Like User list";

    }

    else if($type == 2){

         $sql="Select U.*,P.* from post_comment_like as P  JOIN user as U ON P.user_id = U.id where comment_id = '".$id."'"; 

         $msg = "Comment Like User list"; 

    }

    $query = $this->db->query($sql);

    $like_list = $query->result_array();



    if(!empty($like_list)){

        $this->response(true,$msg,array('user_list'=>$like_list));

     }else{

        $this->response(false,"There is a problem, please try again.",array('user_list'=>array())); 

        }

}

////////////////Setting ///////////////////
///////// add_artistsongs //////////////////
   public function add_artistsongs()
   {
        if(!empty($_POST['user_id'])){
                if(!empty($_POST['songs_title1'])){
                   if(isset($_FILES['songs_name1'])){
                         $singer_names = $this->common->do_upload('songs_name1','./assets/songs/');
                        if(isset($singer_names['upload_data'])){
                            $_POST['songs_name1'] = $singer_names['upload_data']['file_name'];
                        }
                     }
                     $array = array('user_id'=>$_POST['user_id'],'songs_title'=>$_POST['songs_title1'],
                        'singer_name' => $_POST['singer_name1'],
                        'songs_name'=>isset($_POST['songs_name1']) ? $_POST['songs_name1'] : ""
                        );
                    $result = $this->common->insertData('artist_songs',$array);
                    $postid = $this->db->insert_id();
                }
                if(!empty($_POST['songs_title2'])){
                    if(isset($_FILES['songs_name2'])){
                         $singer_names = $this->common->do_upload('songs_name2','./assets/songs/');
                        if(isset($singer_names['upload_data'])){
                            $_POST['songs_name2'] = $singer_names['upload_data']['file_name'];
                        }
                     }
                     $array1 = array('user_id'=>$_POST['user_id'],'songs_title'=>$_POST['songs_title2'],
                        'singer_name' => $_POST['singer_name2'],
                        'songs_name'=>isset($_POST['songs_name2']) ? $_POST['songs_name2'] : ""
                        );
                    $result = $this->common->insertData('artist_songs',$array1);
                    $postid = $this->db->insert_id();

                }
                if(!empty($_POST['songs_title3'])){
                    if(isset($_FILES['songs_name3'])){
                         $singer_names = $this->common->do_upload('songs_name3','./assets/songs/');
                        if(isset($singer_names['upload_data'])){
                            $_POST['songs_name3'] = $singer_names['upload_data']['file_name'];
                        }
                     }
                     $array3 = array('user_id'=>$_POST['user_id'],'songs_title'=>$_POST['songs_title3'],
                        'singer_name' => $_POST['singer_name3'],
                        'songs_name'=>isset($_POST['songs_name3']) ? $_POST['songs_name3'] : ""
                        );
                    $result = $this->common->insertData('artist_songs',$array3);
                    $postid = $this->db->insert_id();
                }
        }else{
             $this->response(false,"User Id field is mandatory"); 
             exit();
        }
             $this->response(true,"Artist songs successfully added");
   }

///////// artistsongs_list //////////////////    

    public function artistsongs_list()

    {

        $user_id = $_POST['user_id'];

        $search = $_POST['search'];

        $sql = "select * from artist_songs where songs_title LIKE '%".$search."%' AND user_id = '".$user_id."'";

        $query = $this->db->query($sql);

        $songsdata = $query->result_array();

         if(!empty($songsdata))

        {

            $this->response(true,"Success",array('artist_songs'=>$songsdata));



        }else

        {

            $this->response(false,"Lists Not found");



        } 

    }



////////////////////add_artistgoals//////////////   

    public function add_artistgoals()

   {

        if(!empty($_POST['user_id'])){

             //  $_POST['created_at'] = date('Y-m-d H:i:s');     

            $_POST['goal_image'] = '';

            if(isset($_FILES['goal_image'])){

                 $goal_images = $this->common->do_upload('goal_image','./assets/images/');

                if(isset($goal_images['upload_data'])){

                    $_POST['goal_image'] = $goal_images['upload_data']['file_name'];

                }

             }

            $post = $this->common->getField('goals',$_POST); 

            $result = $this->common->insertData('goals',$post);

            $postid = $this->db->insert_id();



        }else{

             $this->response(false,"User Id field is mandatory"); 

             exit();

        }

             $this->response(true,"Artist Goals successfully added");

   }

///////////////// artistgoallist_byid  /////////////////////   

     public function artistgoal_list()

    {

        $user_id = $_POST['user_id'];

        $array = array("yellow","green","red");

        $progress = array("50","20","40","30","20");

        $gray =  "gray";

        

        $goalsdata =  $this->common->getData('goals',array('user_id'=>$user_id),array()); 

         if(!empty($goalsdata))

        {

            foreach ($goalsdata as $key => $value) {

               



                if(!empty($value['goal_image'])){

                     $value['color_code'] = $gray;

                }else{

                    $arr = array_rand($array);

                    $value['color_code'] = $array[$arr];

                }

                

                $value['progress_bar'] = $progress[$key];

                $goals[] = $value;

               //print_r($arr);

            }

            $this->response(true,"Success",array('goals'=>$goals));



        }else

        {

            $this->response(false,"Artist Goals List Not found");



        } 

    }



    //////////Created Api by naincy 20/07/21

    public function favourite_artistlist()

        {

        $userid =$_POST['user_id'];

        if(!empty($userid))

        {

         $this->db->select('RF.*,R.user_id as artist_id,U.full_name,U.profile_image,U.email,U.user_type,U.total_like');

        $this->db->from('reels as R');

        $this->db->join('reels_favourite as RF','R.id = RF.reels_id');

        $this->db->join('user as U','U.id = R.user_id');

        $this->db->where('RF.user_id',$userid);

        $query = $this->db->get();

        $reels_fav =  $query->result_array();

        if(!empty($reels_fav))

        {
            

         $this->response(true,"Reels Favourite",array('favourite_artist'=>$reels_fav)); 

         }else{

         $this->response(false,"There is a problem, please try again.",array('reels_favourite'=>array())); 

         }

        }

        }

        

    public function create_group()

      {

       $member=  $this->common->getData('create_group',array('user_id'=>$_POST['user_id'],'tittle'=>$_POST['tittle']),array('single'));

            if($member)

            {

            $this->response(false,"Group already created");

            }

            else

             {

               $image = ''; 

                if(!empty($_FILES['image'])){

                    $image1 = $this->common->do_upload('image','./assets/group');

                    

                    if(isset($image1['upload_data'])){

                    $image = $image1['upload_data']['file_name'];

                    }

                } 

                $bimage = '';

            if(isset($_FILES['image'])){

                     $image2 = $this->common->do_upload('image','./assets/group');

                if(isset($image2['upload_data'])){

                    $bimage = $image2['upload_data']['file_name'];

                }

            }

            $_POST['image'] = $image;

            $_POST['banner_image'] = $bimage;

            $_POST['created_at'] = date('d-m-Y H:i:s');

            //$_POST['members'] = json_decode($_POST['members'],true);

            /*print_r($_POST['members']);

            die;*/

        $post = $this->common->getField('create_group',$_POST); 

        $result = $this->common->insertData('create_group',$post);

            $group_id = $this->db->insert_id();

            $this->response(true,"Group created successfully"); 

            

            }      

    }

    public function grouplist_byid()

    {

        $user_id = $_POST['user_id'];

        $subquery = ",

        (SELECT SUM(LENGTH(members) - LENGTH(REPLACE(members, ',', '')) + 1)

        FROM create_group  where  TRIM( IFNULL( members , '' ) ) > '') AS total_members ";

        

         $this->db->select('C.*'.$subquery);

        $this->db->from('create_group as C');

        $this->db->where('find_in_set("'.$user_id.'", C.members) <> 0'); 

        $query = $this->db->get();

        $groupdata =  $query->result_array();



         $this->db->select('C.*'.$subquery);

        $this->db->from('create_group as C');

        $this->db->where('!find_in_set("'.$user_id.'", C.members) <> 0'); 

        $query = $this->db->get();

        $groupdata2 =  $query->result_array();



         if(!empty($groupdata2))

        {

            $this->response(true,"Success",array('group_list'=>$groupdata,"group_suggestion"=>$groupdata2));

        }else

        {

            $this->response(false,"Group Lists Not found");

        }  

    }

   

    public function add_followers()

    {

        $artist_id = $_POST['artist_id'];

        $fans_id = $_POST['fans_id'];

        $message = "";

          $code= "";

        $likedata =  $this->common->getData('follower',array('artist_id'=>$artist_id,'fans_id'=>$fans_id),array('single'));

         if(!empty($likedata)){

            $result=$this->common->deleteData('follower',array('id'=>$likedata['id']));

            $message = "UnFollow artist successfully!";

            //$code = false;

         }else{

             $post = $this->common->getField('follower',$_POST);

             $result = $this->common->insertData('follower',$post);

             $message = "Follow artist successfully!";

             //$code = true;

         }  



        if(!empty($message))

        {

            $this->response(true,$message,array());

        }

        else

        {

            $this->response(false,"There is a problem, please try again.",array());

        }

    }



    public function get_allfollowers()

    {

        $artist_id = $_POST['artist_id'];

        $fans_id = $_POST['fans_id'];

        if(!empty($_POST['fans_id'])){

            $subquery2 = ",(exists (select 1

                from friends Fo

                where Fo.friends_id = F.fans_id and Fo.user_id = '".$_POST['fans_id']."') ) as is_friend ";

        }else{

            $subquery2 ="";

        }

        $this->db->select('F.*,U.*'.$subquery2);

        $this->db->from('follower as F');

        $this->db->join('user as U','U.id = F.fans_id');

        $this->db->where('F.artist_id',$artist_id);

        $this->db->where('F.fans_id !=',$fans_id);

        $query = $this->db->get();

        $fandata =  $query->result_array();

        if(!empty($fandata))

        {

        $this->response(true,"Success",array('Followers'=>$fandata));



        }else

        {

        $this->response(false,"Followers List Not found");



        } 

    }

     public function get_allfansList()

    {

        $artist_id = $_POST['user_id'];

        $this->db->select('F.*,U.*');

        $this->db->from('follower as F');

        $this->db->join('user as U','U.id = F.fans_id');

        $this->db->where('F.artist_id',$artist_id);

        $query = $this->db->get();

        $fandata =  $query->result_array();

        if(!empty($fandata))

        {

        $this->response(true,"Success",array('Fans'=>$fandata));



        }else

        {

            $this->response(false,"Fans List Not found");



        } 

    }

   

    public function add_friends()

    {

        $user_id = $_POST['user_id'];

        $friends_id = $_POST['friends_id'];

        $message = "";

        $code= "";

        $likedata =  $this->common->getData('friends',array('user_id'=>$user_id,'friends_id'=>$friends_id),array('single'));



         if(!empty($likedata)){

            $result=$this->common->deleteData('friends',array('id'=>$likedata['id']));

            $message = "UnFriend successfully";

           

         }else{



            $post = $this->common->getField('friends',$_POST);

            $result = $this->common->insertData('friends',$post);

          

            $message = "Friend successfully";

            

         }  



        if(!empty($message))

        {

            $this->response(true,$message,array());

        }

        else

        {

            $this->response(false,"There is a problem, please try again.",array());

        }

    }

    public function get_allfriends()

    {

        $user_id = $_POST['user_id'];

        $fans_id = $_POST['fans_id'];


        if(!empty($_POST['fans_id'])){

            $subquery2 = ",(exists (select 1

                from friends Fo

                where F.user_id = Fo.user_id and Fo.friends_id = '".$_POST['fans_id']."') ) as is_friend ";

        }else{

            $subquery2 ="";

        }

        $this->db->select('F.*,U.*'.$subquery2);

        $this->db->from('friends as F');

        $this->db->join('user as U','U.id = F.user_id');

        $this->db->where('F.user_id',$user_id);

        $query = $this->db->get();

        $data =  $query->result_array();


        $data1 = array();
         if(!empty($data))

        {


            foreach ($data as $key => $value) {

                if(empty($_POST['fans_id'])){
                    $value['is_friend'] = "1";
                }
                  $data1[] = $value;
            }
        $this->response(true,"Success",array('friends'=>$data1));



        }else

        {

            $this->response(false,"Friends List Not found");



        } 

    }

//////////////////////////preview introduction/////////////////

  public function preview_intro()

   {

        $result = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));

        if($result)

        {

            $_POST['profile_image'] = '';

            if(isset($_FILES['profile_image'])){

                 $image = $this->common->do_upload('profile_image','./assets/userfile/profile/');

                if(isset($image['upload_data'])){

                    $_POST['profile_image'] = $image['upload_data']['file_name'];

                }

            }



            $_POST['song'] = '';

            if(isset($_FILES['song'])){

                 $image = $this->common->do_upload('song','./assets/songs/');

                if(isset($image['upload_data'])){

                    $_POST['song'] = $image['upload_data']['file_name'];

                }

            }

            $post = $this->common->getField('user',$_POST); 

            $info = $this->common->updateData('user',$post,array('id'=>$_POST['user_id']));

            $this->db->select('U.*');

            $this->db->from('user as U');

           // $this->db->join('genre_category as G', 'G.genre_id = U.id','LEFT');

            $this->db->where('U.id',$_POST['user_id']);

            $query = $this->db->get();

            $user =  $query->result_array()[0];

         

            $this->response(true,"Your preview introduction Is Updated Sucessfully.",array('userinfo'=>$user)); 



        }else{

             $this->response(false,"There Is a Problem, Please Try Again.",array('userinfo'=>(object)array()));

        }

    }

///////////////concert /////////////////////

public function add_concerts()

    {

       if(!empty($_POST['user_id'])){

          $_POST['created_at'] = date('Y-m-d H:i:s'); 

          

          $_POST['concert_image'] = '';

            if(isset($_FILES['concert_image'])){

                 $image = $this->common->do_upload('concert_image','./assets/concerts/');

                if(isset($image['upload_data'])){

                    $_POST['concert_image'] = $image['upload_data']['file_name'];

                }

             }

             

             

              $concert = $this->common->getField('concerts',$_POST); 

            $result = $this->common->insertData('concerts',$concert);

            $concertid = $this->db->insert_id();



        }else{

             $this->response(false,"user Id field is mandatory"); 

             exit();

        }

                  

        $this->response(true,"Concert successfully added");  

    }

/////////////////////////all_concert/////////////////////
    public function all_concert()
    {
        $user_id = $_POST['artist_id'];
        $fan_id = $_POST['fans_id'];
            if(!empty($_POST['fans_id'])){
                $subquery = "(exists (select 1
                    from concert_booking CB
                    where CB.concert_id = C.concert_id and CB.user_id = '".$fan_id."') ) as is_booked ";
            }else{
                $subquery ="";
            }
            $this->db->select('C.*,'.$subquery);
            $this->db->from('concerts as C');
            $this->db->where('C.user_id',$user_id);
            $query = $this->db->get();
            // echo $this->db->last_query();
            $concertdata =  $query->result_array();
         if(!empty($concertdata))

        {

            $this->response(true,"Success",array('concerts'=>$concertdata));

        }else

        {

            $this->response(false,"Concerts List Not found");



        } 

    }

////////////////////////delete_concerts //////////////     

    public function delete_concerts()

    {


    $concertdel=$this->common->deleteData('concerts',array('concert_id'=>$_POST['concert_id']));

    $concert_booking = $this->common->deleteData('concert_booking',array('concert_id'=>$_POST['concert_id']));

            if($concertdel)

            {

                $this->response(true,"Concerts successfully deleted");

            }

            else

            {

                $this->response(false,"Concerts not deleted");

            }

    }
////////////////////////concert_cancel//////////////     
    public function cancel_concert_booking()
    {

        $concertdel=$this->common->deleteData('concert_booking',array('concert_id'=>$_POST['concert_id'],'user_id'=>$_POST['user_id']));
            if($concertdel)
            {
                $this->response(true,"booking successfully canceled");
            }
            else
            {
                $this->response(false,"booking not canceled");
            }
    }

////////////////////////get_bitpak //////////////    

    public function get_bitpack()

    { 

        $result = $this->common->getData('bit_pack',array(),array());

        if(!empty($result))

        { 

            $this->response(true,"Bit Packs Fetch Successfully.",array("BitPackList" => $result));         

        }else{

            $this->response(false,"Bit Packs  Not Found",array("BitPackList" => array()));

        }

   }

////////// donate_bit /////////////////////////

public function donate_bit()

    {

       if(!empty($_POST['donate_by'])){

          $_POST['created_at'] = date('Y-m-d H:i:s'); 

              $concert = $this->common->getField('concerts',$_POST); 

            $result = $this->common->insertData('concerts',$concert);

            $concertid = $this->db->insert_id();



        }else{

             $this->response(false,"donate by field is mandatory"); 

             exit();

        }

                  

        $this->response(true,"Bit sent successfully!");  

    }

///////////////////////////////////////////////////////    

    public function update_image()

    {

      $result = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));

        if(!empty($result))

        {

        $type = $_POST['type'];

        $image_name = "";

           if($type==1){ 

                    $_POST['image'] = '';

                    if(isset($_FILES['image'])){

                         $image = $this->common->do_upload('image','./assets/userfile/profile/');

                    if(isset($image['upload_data'])){

                        $_POST['profile_image'] = $image['upload_data']['file_name'];

                           $image_name = $_POST['profile_image']; 

                    }

                }

            }

             if($type==2){

                $_POST['image'] = '';

                if(isset($_FILES['image'])){

                         $image = $this->common->do_upload('image','./assets/userfile/profile/');

                    if(isset($image['upload_data'])){

                        $_POST['cover_image'] = $image['upload_data']['file_name'];

                            $image_name = $_POST['cover_image']; 

                    }

                }

            }

 

            unset($_POST['image']);

            $post = $this->common->getField('user',$_POST);   

            $info = $this->common->updateData('user',$post,array('id'=>$_POST['user_id']));

            $this->response(true,"Your Profile Is Updated Sucessfully.",array('image'=>$image_name,'type'=>$_POST['type'],'user_id'=>$_POST['user_id']));                   

        }

        else{

        $this->response(false,"There Is a Problem, Please Try Again.",array('userinfo'=>(object)array()));

        }

   }

////////////fan profile ///////////////

  public function fanProfile()
    {
        
        $subquery = "
        (SELECT COUNT(*) FROM friends WHERE user_id=U.id) AS total_friend ,
        (SELECT Count(*) from goals where find_in_set(redeem_members,U.id)<>0 ) AS total_redeem      
       ";
        //(SELECT COUNT(*) FROM goals WHERE user_id=U.id) AS total_credits ,
        $this->db->select('U.*,G.genre_name,G.genre_image,'.$subquery);
        $this->db->from('user as U');
        $this->db->join('genre_category as G', 'G.genre_id = U.genre_cat','LEFT');
        $this->db->where('U.id',$_POST['user_id']);
        $query = $this->db->get();
       //echo $this->db->last_query();

        $user =  $query->result_array()[0];

        if($user){


        if(!empty($_POST['fans_id'])){

            $fanres = $this->common->getData('friends',array('friends_id'=>$_POST['fans_id'],'user_id'=>$_POST['user_id']),array('single'));
            if(!empty($fanres)){
                $user['is_friend'] ="1"; 
            }else{
                $user['is_friend'] ="0"; 
            }    
        }


        $user['total_credits'] = "0";

        $user['total_shared']="0";

        $user['genre_name']="";

        $user['genre_image']="";

            $this->response(true,"Profile Fetch Successful",array("userinfo" => $user));

        }else{

             $this->response(false,"There Is a Problem, Please Try Again.",array("userinfo" =>array()));

        }           

    }

    

///////////////News Feed List by user_id

 public function newsfeed_list()

    {    

        //$fansid = $_POST['fans_id'];

        if(!empty($_POST['artist_id'])){

            $subquery = "(exists (select 1

                from post_like L

                where L.post_id = P.id and L.user_id = '".$_POST['artist_id']."') ) as is_like ,";

        }else{

            $subquery ="";

        }

        

        $this->db->select('P.*,'.$subquery.'U.profile_image as user_profile_image,U.full_name as user_full_name');

        $this->db->from('post as P');

        $this->db->join('user as U', 'P.user_id = U.id');

        $this->db->where('P.user_id',$_POST['artist_id']);

        $query = $this->db->get();

        $post_list =  $query->result_array();

        if(!empty($post_list)){

        foreach ($post_list as $key => $value) {

        $r=$this->common->getData('post_image',array('post_id'=>$value['id']),array('','field'=>'image'));



           if(!empty($r))

           {

                $post_list[$key]['post_images']=$r;

           }

           else

           {

                $post_list[$key]['post_images']=array();

           }

          

        }

         $this->response(true,"Post List",array('post_list'=>$post_list)); 

    }else{

         $this->response(false,"There is a problem, please try again.",array('post_list'=>array())); 

    }

}

//////////////////////concert booking /////////////////

   public function concert_booking()

   {

    $fansid = $_POST['user_id'];

    $concertid = $_POST['concert_id'];

    if(!empty($_POST['user_id'])){

          $_POST['created_at'] = date('Y-m-d H:i:s'); 

            $concertbooking = $this->common->getField('concert_booking',$_POST); 

        $result = $this->common->insertData('concert_booking',$concertbooking);

            $concerts_id = $this->db->insert_id();



        }else{

             $this->response(false,"Id field is mandatory"); 

             exit();

        }

                  

        $this->response(true,"Concert Books successfully");

   }

////////////////////////Concert booked by user ////////////////////

   public function concertbooked_byuser()

   {

      $user_id = $_POST['user_id'];

       $this->db->select('C.*,CB.user_id as booked_by');

        $this->db->from('concert_booking  CB');

         $this->db->join('concerts C', 'C.concert_id = CB.concert_id','LEFT');

        $this->db->where('CB.user_id',$user_id);

        $query = $this->db->get();

        $detail =  $query->result_array();


        if($detail){

            foreach ($detail as $key => $value) {
               $value['is_booked'] = "1";
               $details[] = $value;
            }
            $this->response(true,"Booking Fetch Successful",array("bookinginfo" => $details));

        }else{

             $this->response(false,"There Is a Problem, Please Try Again.",array("bookinginfo" => array()));

        }

   }

/////////////pinboard/////////////

public function get_pinboard()

   {

        if(!empty($_POST['user_id'])){

            $subquery = "(exists (select 1

                from post_like L

                where L.post_id = P.id and L.user_id = '".$_POST['user_id']."') ) as is_like ,
                 (exists (select 1
                from pinboard Pin
                where Pin.post_id = P.id and Pin.user_id = '".$_POST['user_id']."') ) as is_saved ,";

        }else{

            $subquery ="";

        }



        $this->db->select('P.*,'.$subquery.'U.profile_image as user_profile_image,U.full_name as user_full_name');

        $this->db->from('pinboard as Pin');

        $this->db->join('post as P', 'Pin.post_id = P.id');

        $this->db->join('user as U', 'U.id = P.user_id');

        $this->db->where('Pin.user_id',$_POST['user_id']);

        $query = $this->db->get();

        $pin_list =  $query->result_array();



        if(!empty($pin_list)){

        foreach ($pin_list as $key => $value) {

        $r=$this->common->getData('post_image',array('post_id'=>$value['id']),array('','field'=>'image'));

    

           if(!empty($r))

           {

                $pin_list[$key]['post_images']=$r;

           }

           else

           {

                $pin_list[$key]['post_images']=array();

           }

          

        }

         $this->response(true,"pinboard List",array('post_list'=>$pin_list)); 

    }else{

         $this->response(false,"There is a problem, please try again.",array('pin_list'=>array())); 

    }

}

/////////////add_pinboard////////////////

public function add_pinboard()
  {
     if(!empty($_POST['user_id'])){
          $_POST['created_at'] = date('Y-m-d H:i:s'); 

            $savedata =  $this->common->getData('pinboard',array('user_id'=>$_POST['user_id'],'post_id'=>$_POST['post_id']),array('single'));

             if(!empty($savedata)){
                  $result=$this->common->deleteData('pinboard',array('id'=>$savedata['id']));  
                  $message = "Unsaved Post Successfully";
             }else{
                $pin = $this->common->getField('pinboard',$_POST); 
                $result = $this->common->insertData('pinboard',$pin);
                $pinid = $this->db->insert_id();
                $message = "Saved Post Successfully";
             }
            $this->response(true,$message);
        }else{
             $this->response(false,"There is a problem, please try again."); 
             exit();
        }
  }
//////////////////// redeem_checkout /////////
public function redeem_check()
     {
         if(!empty($_POST['user_id']))
         {
            $_POST['created_at'] = date('Y-m-d H:i:s'); 
            $redeem= $this->common->getField('redeem_checkout',$_POST); 
            $result = $this->common->insertData('redeem_checkout',$redeem);
            $checkid = $this->db->insert_id();

        }else{
             $this->response(false,"Id's field is mandatory"); 
             exit();
        }
                  
        $this->response(true,"Redeem code successfully added");
    }
     
///////////Media////////////////////////

public function get_media()
 {
   $new_array = array();
    $base_url = base_url('assets/userfile/profile/');
    $base_url2 = base_url('assets/post/');
    $base_url3 = base_url('assets/concerts/');
    if(!empty($_POST['user_id'])){
    $tables = array("user", "post_image", "concerts");
    foreach ($tables as $table)
    {   
         $col = "user_id";
        if($table == "user"){
            $col = "id";
            $user_id = $_POST['user_id'];
        }
        $sql = "select * from $table where $col = '".$user_id."'";
        $query = $this->db->query($sql);
        $imagedata = $query->result_array();
      foreach ($imagedata as $key => $value) 
        { 
         if(!empty($value))
            {
                $new = array();
                if(!empty($value['profile_image'])) {
                    $new['image'] = $base_url . $value['profile_image'];
                }
                if(!empty($value['cover_image'])) {
                    $new['image'] = $base_url . $value['cover_image'];
                }
                if(!empty($value['image'])) {
                    $new['image'] = $base_url2 . $value['image'];
                }
                if(!empty($value['concert_image'])) {
                    $new['image'] = $base_url3 . $value['concert_image'];
                }

                if(!empty($new)) {
                       $new_array[]  = $new;
                }
          }
       } 
     }
         $this->response(true,"All images",array('media'=>$new_array)); 
    }else{
         $this->response(false,"There is a problem, please try again.",array('media'=>array())); 
    }
  } 
///////////////////////////////////notification/////////////////////////
public function get_notification()
     {
        $user_id = $_POST['user_id'];

        $data =  $this->common->getData('notification',array('sender_id'=>$user_id),array('sort_by'=>'created_at','sort_direction'=>'desc')); 
         if(!empty($data))
        {
            
        $this->response(true,"Notification send Successfully",array('notification'=>$data));

        }else
        {
            $this->response(false,"No notification found");

        } 
     }
///////////////////////////Leave Group ////////////////////////
public function leave_group()
     {
        $user_id = $_POST['user_id'];
        $group_id = $_POST['group_id'];

         $create_group =  $this->common->getData('create_group',array('id'=>$group_id,'find_in_set("'.$user_id.'",members) <>'=>0),array('single')); 
             if(!empty($create_group)){
                    $members=explode(',',$create_group['members']);
                    $index = array_search($user_id,$members);
                    if($index !== false){
                        unset($members[$index]);
                    }
                    $members=implode(',',$members);

           $update =  $this->common->updateData('create_group',array('members' =>$members),array('id' => $group_id));
             }
        if(!empty($update))
            {
                $this->response(true,"Successfully Leave group",array());

            }else{
                $this->response(false,"There is a problem, please try again.",array());
            }
    }
///////////////////////////////////Hall of Fame ///////////////////////
public function hall_of_fame()
     {
        $user_id = $_POST['user_id'];
        $this->db->select('F.*,U.*');
        $this->db->from('follower as F');
        $this->db->join('user as U','U.id = F.fans_id');
        $this->db->where('F.artist_id',$user_id);
        $this->db->order_by('F.id','desc');
        $this->db->limit('3');
        $query = $this->db->get();
        $fandata =  $query->result_array();

       if(!empty($fandata))
        {
             foreach($fandata as $key => $value) {          
                $sql = " SELECT G.* FROM goals G  where user_id = '".$user_id."' and FIND_IN_SET('".$value['fans_id']."',redeem_members) "; 
                $query = $this->db->query($sql);
                $credit_list = $query->result_array()[0];    
                if(!empty($credit_list)){

                    $userdetail  = user_detail($value['fans_id']);
                    $credit_list['full_name'] = $userdetail['full_name'];
                    $credit_list['email'] = $userdetail['email'];
                    $credit_list['total_like'] = $userdetail['total_like'];
                    $credit_list['profile_image'] = $userdetail['profile_image'];
                    $credit_list['fans_id'] = $userdetail['id'];
                    $allcredits[] = $credit_list;
                }else{
                     //$allcredits[] = array();
                }
                
            }

                $sql2 = " SELECT D.*,U.full_name,U.email,U.profile_image,U.id as donator_id FROM donate_bits D LEFT JOIN user U ON U.id  = D.donate_to     where D.donate_by = '".$user_id."'"; 
                $query = $this->db->query($sql2);
                $donate = $query->result_array();  

                if(!empty($donate)){
                    $donate_list =   $donate ;
                }else{
                      $donate_list =   array();
                }


           $this->response(true,"Successfully",array('top_fan'=>$fandata,'credits'=>$allcredits,'donaters'=>$donate_list));

        }else
        {
            $this->response(false,"No hall of fame found");

        } 
     }

///////////////////////////////////Hall of Fame ///////////////////////
public function hall_of_fame_fans()
     {
        $user_id = $_POST['fans_id'];
        $this->db->select('F.*,U.*');
        $this->db->from('friends as F');
        $this->db->join('user as U','U.id = F.friends_id');
        $this->db->where('F.user_id',$user_id);
        $this->db->order_by('F.id','desc');
        $this->db->limit('3');
        $query = $this->db->get();
        $fandata =  $query->result_array();

       if(!empty($fandata))
        {
             foreach($fandata as $key => $value) {          
                $sql = " SELECT G.* FROM goals G  where user_id = '".$user_id."' and FIND_IN_SET('".$value['friends_id']."',redeem_members) "; 
                $query = $this->db->query($sql);
                $credit_list = $query->result_array()[0];    
                if(!empty($credit_list)){

                    $userdetail  = user_detail($value['friends_id']);
                    $credit_list['full_name'] = $userdetail['full_name'];
                    $credit_list['email'] = $userdetail['email'];
                    $credit_list['total_like'] = $userdetail['total_like'];
                    $credit_list['profile_image'] = $userdetail['profile_image'];
                    $credit_list['fans_id'] = $userdetail['id'];
                    $allcredits[] = $credit_list;
                }else{
                     $allcredits[] = array();
                }
                
            }

                $sql2 = " SELECT D.*,U.full_name,U.email,U.profile_image,U.id as donator_id FROM donate_bits D LEFT JOIN user U ON U.id  = D.donate_to     where D.donate_by = '".$user_id."'"; 
                $query = $this->db->query($sql2);
                $donate = $query->result_array();  

                if(!empty($donate)){
                	// foreach ($donate as $key => $value) {
                		
                	// }
                    $donate_list =   $donate ;
                }else{
                      $donate_list =   array();
                }

           $this->response(true,"Successfully",array('top_fan'=>$fandata,'credits'=>$allcredits,'donaters'=>$donate_list));

        }else
        {
            $this->response(false,"No  hall of fame found");

        } 
     }
///////////////////////////testing api /////////////////////
   public function test_file(){

       // if(isset($_FILES['file'])){
       //           $singer_names = $this->common->do_upload('file','./assets/testing/');
       //          if(isset($singer_names['upload_data'])){
       //              $_POST['file'] = $singer_names['upload_data']['file_name'];
       //          }
       //       }

        // Path to move uploaded files
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
            } catch (Exception $e) {
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
public function reels_share(){

     if(!empty($_POST['user_id'])){

          
            $share = $this->common->getField('reels_share',$_POST); 
            $result = $this->common->insertData('reels_share',$share);
            $shareid = $this->db->insert_id();
             
             $this->response(true,"Successfully Sent!",array());
        }else{
             $this->response(false,"Not Sent!"); 
             exit();
        }
  }
///////////////////////////artist_page_share ///////// 
  public function artist_page_share(){

     if(!empty($_POST['user_id'])){

          
            $share = $this->common->getField('artist_page_share',$_POST); 
            $result = $this->common->insertData('artist_page_share',$share);
            $shareid = $this->db->insert_id();
             
             $this->response(true,"Successfully Sent!",array());
        }else{
             $this->response(false,"Not Sent!"); 
             exit();
        }
  }
public function add_credits(){

     $song_no = $_POST['song_no'];
     if(!empty($_POST['user_id'])){


//id  refer_id    fans_id artist_id   amount  
             if($song_no == 0){

             }

             if($song_no == 1){

             }
             if($song_no == 2){

             }
             if($song_no == 3){

             }

        $share = $this->common->getField('credits',$_POST); 
        $result = $this->common->insertData('credits',$share);

           $this->response(true,"Successfully Sent!",array());
        }else{
             $this->response(false,"Not Sent!"); 
             exit();
        }
    
}


}