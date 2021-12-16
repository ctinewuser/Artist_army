<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$admin = $this->session->userdata('admin');
		$this->load->helper('common');
		$this->load->helper('file');
		$this->id = $admin['id'];
        $admin_id=$admin['id'];
	}

	public function approve_user($id)
	{	
		$d = $this->common->updateData('user',array('status'=>1),array('id' => $id));
		 $this->session->set_flashdata('success','Approved.');
		redirect(base_url('admin/userList'));
	}
	public function disapprove_user($id)
	{	
		$d = $this->common->updateData('user',array('status'=>0),array('id' => $id));
		$this->session->set_flashdata('error',' Not Approved.');
		redirect(base_url('admin/userList'));
	}
	public function disapprove_artist($id){
		$d = $this->common->updateData('user',array('status'=>0),array('id' => $id));
		$this->session->set_flashdata('error',' Not Approved.');
		redirect(base_url('admin/artistList'));
	}
	public function approve_artist($id)
	{	
		$d = $this->common->updateData('user',array('status'=>1),array('id' => $id));
		 $this->session->set_flashdata('success','Approved.');
		redirect(base_url('admin/artistList'));
	}
	//Genre List Acceptance Function
	public function disapprove_cat($id)
	{
       $d = $this->common->updateData('genre_category',array('status'=>1),array('genre_id' => $id));
        $this->session->set_flashdata('error','Not Approve.');
		redirect(base_url('admin/catList')); 
	}
	public function approve_cat($id)
	{
		$d = $this->common->updateData('genre_category',array('status'=>0),array('genre_id' => $id));
		$this->session->set_flashdata('success',' Approved.');
		redirect(base_url('admin/catList'));
	}
	///End of the Function
	public function delete_user()
	{
		$id = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		$data = $this->common->getData('user',array('id' => $id), array('single'));
		if($data)
		{
		   $result = $this->common->deleteData('user',array('id'=>$id));
			if($result){
				 $this->session->set_flashdata('success','User deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 	

			if($type == 0){
				redirect(base_url('admin/userList'),'refresh');
			}else{
				redirect(base_url('admin/artistList'),'refresh');
			}		
			
		}
	}

	public function userList()
	{
		$data['user'] = $this->common->getData('user',array('user_type'=>0),array());
	
		$this->adminHtml('Fans List','user-list',$data);
	}
	public function artistList()
	{
	$data['user'] = $this->common->getData('user',array('user_type'=>1),array());
	
		$this->adminHtml('Artist List','artist-list',$data);
	}
	public function makeArtist()
	{
		$id = $this->uri->segment(3);
       $m = $this->common->updateData('user',array('user_type'=>1),array('id' => $id));
		redirect(base_url('admin/userList'));
	}

     public function catList()
	{
	$data['cat'] = $this->common->getData('genre_category',array());
		$this->adminHtml('Genre List','cat-list',$data);
	}
      public function feedList()
      {
      	$data['feed'] = $this->common->getData('post',array());
		$this->adminHtml('Feed List','feed-list',$data);
      }
     
      public function show_pinboard()
      {
          $this->db->select('PB.*');
        $this->db->from('pinboard as PB');
       $this->db->group_by('PB.user_id');
        $query = $this->db->get();
      $pin_list =  $query->result_array();
       $data['pin'] = $pin_list;
		$this->adminHtml('Pin Board List','pinboard-list',$data);
      }
      public function show_concert()
      {
       $data['concert'] = $this->common->getData('concerts',array());
	$this->adminHtml('Concert List','concert-list',$data);
      }
   
		public function goal_list()
		{
			$data['goal'] = $this->common->getData('goals',array());
		$this->adminHtml('Credit Goal List','goal-list',$data);
		}
		public function edit_user()
		{
          $user_id = $this->uri->segment(3);
	$this->form_validation->set_rules('full_name','full_name','required');
	$this->form_validation->set_rules('mobile_number','mobile_number','required');
	$data['user'] = $this->common->getData('user',array('id' => $user_id), array('single'));
		if($this->form_validation->run() == false){	
			$data['user'] = $this->common->getData('user',array('id' => $user_id), array('single'));
			$this->adminHtml('Update User Details','add-user',$data);
		}else{
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    unset($_POST["id"]);
		     if($_POST['password']){
		    	$_POST['password'] = md5($_POST['password']);
		    }else{
		    	$_POST['password'] = $data['user']['password'];
		    }
			$result = $this->common->updateData('user',$_POST,array('id'=>$user_id));	
			if($result){
				 $this->session->set_flashdata('success','Updated successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/userList'),'refresh');
		}
		}
		public function edit_artist()
		{
		$user_id = $this->uri->segment(3);
		$this->form_validation->set_rules('full_name','full_name','required');
		$this->form_validation->set_rules('mobile_number','mobile_number','required');
		$data['user'] = $this->common->getData('user',array('id' => $user_id), array('single'));

			if($this->form_validation->run() == false){	
				$data['user'] = $this->common->getData('user',array('id' => $user_id), array('single'));
				$this->adminHtml('Update Artist Details','add-artist',$data);
			}else{
				unset($_POST["submit"]);
				$id = $this->input->post('id');
			    unset($_POST["id"]);
			    if($_POST['password']){
			    	$_POST['password'] = md5($_POST['password']);
			    }else{
			    	$_POST['password'] = $data['user']['password'];
			    }
			    

				$result = $this->common->updateData('user',$_POST,array('id'=>$user_id));	
				if($result){
					 $this->session->set_flashdata('success','Updated successfully');
				}else{
				$this->session->set_flashdata('danger','Some Error occured.');
				} 			
				redirect(base_url('admin/artistList'),'refresh');
			}
		}
      public function edit_concert()
      {
		$concert_id = $this->uri->segment(3);
		$this->form_validation->set_rules('concert_title','title','required');
		$this->form_validation->set_rules('concert_venue','concert venue','required');
		if($this->form_validation->run() == false){	
			$data['concert'] = $this->common->getData('concerts',array('concert_id' => $concert_id), array('single'));
			$this->adminHtml('Update concert','editconcerts',$data);
		}else{
			unset($_POST["submit"]);
			$id = $this->input->post('concert_id');
		    unset($_POST["concert_id"]);
		     if(!empty($_POST['concert_date'])){
		        $_POST['concert_date'] = date('Y-m-d',strtotime($_POST['concert_date']));
		      }else{
		        $_POST['concert_date'] = date('Y-m-d');
		      }
			$result = $this->common->updateData('concerts',$_POST,array('concert_id'=>$id));	
			if($result){
				 $this->session->set_flashdata('success','Updated successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/show_concert'),'refresh');
		}
      }
    
	public function checkout()
	{
	$data['check'] = $this->common->getData('redeem_checkout',array());

		$this->adminHtml('Redeem Check Out','checkout-page',$data);
	}
	 public function show_bitpack()
      {
        $data['bit'] = $this->common->getData('bit_pack',array());
		$this->adminHtml('Bit Pack List','bitpack-list',$data);
      }
      public function show_reels()
      {
      	 $data['reel'] = $this->common->getData('reels',array());
		$this->adminHtml('Reels List','reel-list',$data);
      }
      public function view_reels()
      {
      	$data['video'] = $this->common->getData('reels',array('id' => $id),array('single'));
		$this->adminHtml('Reels','reels-detail',$data);
      }
	public function edit_bitpack()
	{
		$id = $this->uri->segment(3);
	$this->form_validation->set_rules('bit_name','bit_name','required');
	$this->form_validation->set_rules('amount_in_bit','amount_in_bit','required');
	$this->form_validation->set_rules('amount_in_euro','amount_in_euro','required');
		if($this->form_validation->run() == false){	
			$data['bit'] = $this->common->getData('bit_pack',array('id'=>$id), array('single'));
			$this->adminHtml('Update BitPacks','add-bitpack',$data);   
		}else{
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    unset($_POST["id"]);
		    if($_POST['amount_in_bit']){
				$_POST['bit_amount_d'] = $_POST['amount_in_bit']." bits";
			}
			if($_POST['amount_in_euro']){
				$_POST['euro_amount_d'] = $_POST['amount_in_euro']." euro";
			}
			$result = $this->common->updateData('bit_pack',$_POST,array('id'=>$id));	
			if($result){
				 $this->session->set_flashdata('success','Updated successfully');
			}else{
			$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/show_bitpack'),'refresh');
		}
	}
      public function add_bitpack()
	{
	$this->form_validation->set_rules('bit_name','Bit Pack','required');
		$this->form_validation->set_rules('amount_in_bit','Bit Amount','required');
		$this->form_validation->set_rules('amount_in_euro','Euro Amount','required');
	
	if($this->form_validation->run() == false){	

		$this->adminHtml('Add Bit Pack','add-bitpack',$data);
	}else{
		unset($_POST["submit"]);
		if($_POST['amount_in_bit']){
			$_POST['bit_amount_d'] = $_POST['amount_in_bit']." bits";
		}
		if($_POST['amount_in_euro']){
			$_POST['euro_amount_d'] = $_POST['amount_in_euro']." euro";
		}
	    $post = $this->common->getField('bit_pack',$_POST);
		$result = $this->common->insertData('bit_pack',$post);
		if($result){
			$a = $this->session->set_flashdata('success','Data added successfully');
		}else{
		$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/show_bitpack'),'refresh');
		}
	}
	public function  add_concert()
	{
		$this->form_validation->set_rules('concert_title','concert_title','required');
		$this->form_validation->set_rules('concert_date','concert_date','required');
		$this->form_validation->set_rules('concert_time','concert_time','required');
		$this->form_validation->set_rules('concert_venue','concert_venue','required');
		if($this->form_validation->run() == false){	
		$this->adminHtml('Add Concert','editconcerts',$data);
		}else{
		unset($_POST["submit"]);
		 if(!empty($_POST['concert_date'])){
		    $_POST['concert_date'] = date('Y-m-d',strtotime($_POST['concert_date']));
		  }else{
		    $_POST['concert_date'] = date('Y-m-d');
		  }

		   if(!empty($_POST['concert_time'])){
		    $_POST['concert_time'] = date('H:i:s',strtotime($_POST['concert_time']));
		  }else{
		    $_POST['concert_time'] = date('H:i:s');
		  }

		$post = $this->common->getField('concerts',$_POST);
		$result = $this->common->insertData('concerts',$post);
		if($result){
			$a = $this->session->set_flashdata('success','Data added successfully');
		}else{
		$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/show_concert'),'refresh');
		}
	}
      public function show_postlist()
      {
		$id = $this->uri->segment(3);
		$this->db->select('PB.*,P.*');
		$this->db->from('pinboard as PB');
		$this->db->join('post as P', 'P.id = PB.post_id');
		$this->db->where('PB.user_id',$id);
		$this->db->order_by('P.id','desc');
		$query = $this->db->get();
		$post_list =  $query->result_array();
		$data['postlist'] = $post_list;
		$this->adminHtml('Post List','post-list',$data);
      }

      public function delete_concert()
      {
      	$id = $this->input->post('id');

		 	$data['concert'] = $this->common->deleteData('concerts',array('concert_id'=>$id));		 	
		
			if($data){
				echo '1';
			}else{
				echo '0';
			}
      }
      public function delete_bitpack()
      {
      	$id = $this->input->post('id');

		 	$data['bit'] = $this->common->deleteData('bit_pack',array('id'=>$id));		 	
		
			if($data){
				echo '1';
			}else{
				echo '0';
			}
      }
     public function delete_reelist()
     {
     	$id = $this->input->post('id');

		 	$data['reel'] = $this->common->deleteData('reels',array('id'=>$id));		 	
		
			if($data){
				echo '1';
			}else{
				echo '0';
			}
     }
      public function delete_gencategory()
	{
	    $id = $this->input->post('id');

		 	$data['cat'] = $this->common->deleteData('genre_category',array('genre_id'=>$id));		 	
		
			if($data){
				echo '1';
			}else{
				echo '0';
			}
	}
      public function delete_feed()
	{
		$id = $this->uri->segment(3);
		$data = $this->common->getData('post',array('id' => $id), array('single'));
		if($data)
		{
		   $result = $this->common->deleteData('post',array('id'=>$id));
			if($result){
				 $this->session->set_flashdata('success','Feed deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/feedList'),'refresh');
		}
	}
       public function showImage()
      {
      	$post_id = $this->uri->segment(3);
      	$data['img'] = $this->common->getData('post_image',array('post_id' => $post_id), array('single'));
		$this->adminHtml('Image','show-image',$data);

      }
      public function termServices()
      {
		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{			
		$data['terms'] = $this->common->getData('contact_about',array('id' => '3'), array('single'));
		$this->adminHtml('Update Terms and services','edit-terms',$data);
		}
		else
		{
		$data['data'] = $this->input->post('editor');
		$id = $this->input->post('id');

		$result = $this->common->updateData('contact_about',$data,array('id'=>$id));

		if($result){
		 $this->session->set_flashdata('success','Terms and Conditions update successfully');
		}else{
		$this->session->set_flashdata('danger','Some Error occured.');
		} 			
			redirect(base_url('admin/termServices'),'refresh');
		}
      }

      public function privacyPolicy()
      {
		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{			
		$data['privacy'] = $this->common->getData('contact_about',array('id' => '4'), array('single'));
		$this->adminHtml('Update Terms and services','editprivacypolicy',$data);
		}
		else
		{
		$data['data'] = $this->input->post('editor');
		$id = $this->input->post('id');

		$result = $this->common->updateData('contact_about',$data,array('id'=>$id));

		if($result){
			 $this->session->set_flashdata('success','Privacy Policy update successfully');
		}else{
			$this->session->set_flashdata('danger','Some Error occured.');
		} 			
			redirect(base_url('admin/privacyPolicy'),'refresh');
		}

      }
	
	public function contactUs()
	{

		$data_list['contact'] = $this->common->getData('contact_about',array('id'=>2),array('single'));
	
		$this->adminHtml('Contact Us','contactus-list',$data_list);
	}
	public function aboutUs_page()
	{

		$data_list['about'] = $this->common->getData('contact_about',array('id'=>1),array('single'));
	
		$this->adminHtml('About Us','aboutus-list',$data_list);
	}
	public function edit_genrecategory()
	{

		$genre_id = $this->uri->segment(3);
		$this->form_validation->set_rules('genre_name','genre name','required');

		if($this->form_validation->run() == false){	

		$data['cat'] = $this->common->getData('genre_category',array('genre_id' => $genre_id), array('single'));

		$this->adminHtml('Update Genre','add-genrecat',$data);
		}else{
		unset($_POST["submit"]);

		$id = $this->input->post('genre_id');
		unset($_POST["genre_id"]);

		$result = $this->common->updateData('genre_category',$_POST,array('genre_id'=>$id));		
		if($result){
			$a = $this->session->set_flashdata('success','Data update successfully');
		}else{
			$this->session->set_flashdata('danger','Some Error occured.');
		} 			
			redirect(base_url('admin/catList'),'refresh');
		}
	}
  
	///////
	public function add_genrecat()
	{
		$this->form_validation->set_rules('genre_name','genre name','required');	
		if($this->form_validation->run() == false){	
			$this->adminHtml('Add Genre','add-genrecat',$data);
		}else{
			unset($_POST["submit"]);

		 $post = $this->common->getField('genre_category',$_POST);
		$result = $this->common->insertData('genre_category',$post);
			if($result){
				$a = $this->session->set_flashdata('success','Data added successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/catList'),'refresh');
		}
	}
	public function add_user()
	{
		$this->form_validation->set_rules('full_name','User name','required');
		$this->form_validation->set_rules('date_of_birth','Date Of Birth','required');
		$this->form_validation->set_rules('country_code','Country Code','required');
		$this->form_validation->set_rules('mobile_number','Mobile number','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('address','Address','required');
		if($this->form_validation->run() == false){	
		$this->adminHtml('Add User','add-user',$data);
		}else{
		unset($_POST["submit"]);
		$_POST['password'] = md5($_POST['password']);
		if(!empty($_POST['date_of_birth'])){
		$_POST['date_of_birth'] = date('Y-m-d',strtotime($_POST['date_of_birth']));
		}else{
		$_POST['concert_date'] = date('Y-m-d');
		}
		$post = $this->common->getField('user',$_POST);
		$result = $this->common->insertData('user',$post);
		if($result){
		$a = $this->session->set_flashdata('success','Data added successfully');
		}else{
		$this->session->set_flashdata('danger','Some Error occured.');
		} 			
			redirect(base_url('admin/userList'),'refresh');
		}
	}
  	public function add_artist()
  	{
		$this->form_validation->set_rules('artist_name','Artist name','required');
		$this->form_validation->set_rules('date_of_birth','Date Of Birth','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('country_code','Country Code','required');
		$this->form_validation->set_rules('mobile_number','Mobile number','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('address','Address','required');
		$this->form_validation->set_rules('genre_cat','Genre Categroy','required');
		if($this->form_validation->run() == false){	
		$this->adminHtml('Add Artist','add-artist',$data);
		}else{
		unset($_POST["submit"]);
		$_POST['user_type'] = 1;
		$_POST['password'] = md5($_POST['password']);
		if(!empty($_POST['date_of_birth'])){
		$_POST['date_of_birth'] = date('Y-m-d',strtotime($_POST['date_of_birth']));
		}else{
		$_POST['concert_date'] = date('Y-m-d');
		}
		$post = $this->common->getField('user',$_POST);
		$result = $this->common->insertData('user',$post);
		if($result){
		$a = $this->session->set_flashdata('success','Data added successfully');
		}else{
		$this->session->set_flashdata('danger','Some Error occured.');
		} 			
			redirect(base_url('admin/artistList'),'refresh');
		}
  	}
  public function admineditprofile()
  {
    $admin_id = $this->uri->segment(3);
    $session = $this->session->userdata('admin');
    $data['admin'] = $this->common->getData('admin', array('id' => $admin_id),array('single'));
  
    $this->adminHtml('profile', 'profile-edit', $data);
  }
   public function usereditprofile()
  {
   
    $user_id = $this->uri->segment(3);
    $session = $this->session->userdata('user');
    $data['user'] = $this->common->getData('user', array('id' => $user_id),array('single'));
  
    $this->adminHtml('profile', 'user-edit', $data);
  }
	public function product_quantity()
	{
	$product_id = $this->uri->segment(3);
	$data['product'] = $this->common->getData('product_quantity',array('product_id'=>$product_id));
	$this->adminHtml('Product Quantity List','product-quantity-list',$data);
	}


		public function total_revence()
		{
		$user = $this->common->getData('user',array(),array('count'));
		$follower = $this->common->getData('follower',array(),array('count'));
		$friends = $this->common->getData('friends',array(),array('count'));
		echo json_encode(array('user'=>$user,'follower'=>$follower,'friends'=>$friends),true);

		}

		public function getinvoice_avg($mon)
		{
		$invoices_query = "SELECT SUM(paid_amount) AS AveragePrice from payment_history where monthname(created_date) ='".$mon."'" ;
		$invoices = $this->common->query($invoices_query);

		$sql = $this->db->last_query();

		if($invoices)
		{
		$avg = $invoices;
		} 
		else
		{
		$avg = "0";
		}
		return $avg;
		}

	  public function send_notification($tokens, $message)
	{	
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
				 	'registration_ids' => $tokens,
				 	  "data" => $message
				);
		$headers = array(
			'Authorization:key = AAAAA_p0eoY:APA91bFA-fYFpwSsr_C80kzYPxVYR3nBB6fgfWD6VvvmaMipIA-6S7Tmfd16s5CUkZ8p8f3ik9_NWtnM1CSrkxxdxa27vfm-82JT4trstFfdDOU9VMKHGZdGi6tCdoOz0S9ymHVmgywQ',
			'Content-Type: application/json'
		);
	    return $this->curl($url,$headers,$fields);	
	}
		public function send_notification_ios($tokens,$message,$title,$type)
		{	
		$url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = 'AAAAli86Xtc:APA91bFq8_Nk446lfNtSgIrYt_6HB0Ea62wZoZmkM5LmqIjTPVy0NylOkwPd-QmKeGXsEqRbRUv3fejo7KQe5YE8hX6ShdGNdtDkAI6xl6NF0p85zWdFU8_xut1HV7QrBeNiyeKCvmrR';
		/*	$title = "new notification";*/
		$body = "$message";
		$notification = array('title' =>$title , 'text' => $body,'type' => $type, 'sound' => 'default', 'badge' => '1');
		$fields = array('to' => $tokens, 'notification' => $notification,'priority'=>'high');
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		return $this->curl($url,$headers,$fields);
		} 


		public function send_notification_ios1($tokens,$message,$title,$type,$typee)
		{	

		$url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = 'AAAAli86Xtc:APA91bFq8_Nk446lfNtSgIrYt_6HB0Ea62wZoZmkM5LmqIjTPVy0NylOkwPd-QmKeGXsEqRbRUv3fejo7KQe5YE8hX6ShdGNdtDkAI6xl6NF0p85zWdFU8_xut1HV7QrBeNiyeKCvmrR';
		$body = "$message";
		$data = $typee;
		$notification = array('title' =>$title , 'text' => $body,'type' => $type, 'sound' => 'default', 'badge' => '1');
		$fields = array('to' => $tokens,'data'=> $data,'notification' => $notification,'priority'=>'high');
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		return $this->curl($url,$headers,$fields);
		}
	

		public function Contact_us()
	   {

			$this->form_validation->set_rules('email','email','required');
			$this->form_validation->set_rules('address','address','required');
			$this->form_validation->set_rules('phone_no','phone_no','required');
		if($this->form_validation->run() == false){
		$data['cat'] = $this->common->getData('contact_us',array('id'=>1),array('single'));
		$this->adminHtml('Contact us','contact_us',$data);

		}else
		{			
			
		unset($_POST["submit"]);
		$result = $this->common->updateData('contact_us',$_POST,array('id'=>1));
		if($result){
			$this->flashMsg('success','contact added successfully');
			redirect(base_url('admin/contact_us'));
		}else{
			$this->flashMsg('danger','Some error occured. Please try again');
			redirect(base_url('admin/contact_us'));
		}
		}
	}
	
	public function our_services_customer()
		{

		$this->form_validation->set_rules('heading','heading','required');

		if($this->form_validation->run() == false){
		$data['cat_customer'] = $this->common->getData('our_services',array('id'=>1),array('single'));
		$data['cat_driver'] = $this->common->getData('our_services',array('id'=>2),array('single'));
		$data['cat_provider'] = $this->common->getData('our_services',array('id'=>3),array('single'));
		$this->adminHtml('our services','our_services',$data);

		}else
		{			

		unset($_POST["submit"]);
		$result = $this->common->updateData('our_services',$_POST,array('id'=>1));
		if($result){
			$this->flashMsg('success','Our Services added successfully');
			redirect(base_url('admin/our_services'));
		}else{
			$this->flashMsg('danger','Some error occured. Please try again');
			redirect(base_url('admin/our_services'));
		}
		}
	}
	public function our_services_driver()
	{

		$this->form_validation->set_rules('heading','heading','required');

		if($this->form_validation->run() == false){
		$data['cat_customer'] = $this->common->getData('our_services',array('id'=>1),array('single'));
		$data['cat_driver'] = $this->common->getData('our_services',array('id'=>2),array('single'));
		$data['cat_provider'] = $this->common->getData('our_services',array('id'=>3),array('single'));
		$this->adminHtml('our services','our_services',$data);

		}else
		{			

		unset($_POST["submit"]);
		$result = $this->common->updateData('our_services',$_POST,array('id'=>2));
		if($result){
		$this->flashMsg('success','Our Services added successfully');
		redirect(base_url('admin/our_services'));
		}else{
		$this->flashMsg('danger','Some error occured. Please try again');
		redirect(base_url('admin/our_services'));
		}
		}
	}
	public function our_services_provider()
		{

		$this->form_validation->set_rules('heading','heading','required');

		if($this->form_validation->run() == false){
		$data['cat_customer'] = $this->common->getData('our_services',array('id'=>1),array('single'));
		$data['cat_driver'] = $this->common->getData('our_services',array('id'=>2),array('single'));
		$data['cat_provider'] = $this->common->getData('our_services',array('id'=>3),array('single'));
		$this->adminHtml('our services','our_services',$data);

		}else
		{			

		unset($_POST["submit"]);
		$result = $this->common->updateData('our_services',$_POST,array('id'=>3));
		if($result){
		$this->flashMsg('success','Our Services added successfully');
		redirect(base_url('admin/our_services'));
		}else{
		$this->flashMsg('danger','Some error occured. Please try again');
		redirect(base_url('admin/our_services'));
		}
		}
	}
	
	public function support_questions_driver()
	{
	    $data['category'] = $this->common->getData('support_questions',array('type'=>'driver'),array(''));
		$this->adminHtml('our services','support_list',$data);
	}
	public function support_questions_provider()
	{
	    $data['category'] = $this->common->getData('support_questions',array('type'=>'provider'),array(''));
		$this->adminHtml('our services','support_list',$data);
	}
	public function support_questions_customer()
	{
       $data['category'] = $this->common->getData('support_questions',array('type'=>'user'),array(''));
		$this->adminHtml('our services','support_list',$data);
	}
	
	public function add_support()
	{
	    	$this->form_validation->set_rules('questions','questions','required');
		if($this->form_validation->run() == false){
			$this->adminHtml('Add support','add_support');
		}else{
		  
		    $_POST['type']='Driver';
			$post = $this->common->getField('support_questions',$_POST);
			$result = $this->common->insertData('support_questions',$post);
			if($result){
				$this->session->set_flashdata('success','questions Added Successfully.');

				redirect(base_url('admin/support_questions_driver'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/add_support'));
			}
		}
	}

	  public function edit_support()
	{
	    $id = $this->uri->segment(3);
		$this->form_validation->set_rules('questions','questions','required');
		if($this->form_validation->run() == false){
		 $data['category'] = $this->common->getData('support_questions',array('id'=>$id),array('single'));
			$this->adminHtml('Add questions','add-questions',$data);
		}else{
					   /* $image = ''; 
		       $image1 = $this->common->do_upload('image','./assets/userfile/category/');
                                
                                if(isset($image1['upload_data'])){
                                $image = $image1['upload_data']['file_name'];
                                } 
			
			$_POST['image'] = $image;*/
		    $_POST['type']='Driver';
			$post = $this->common->getField('support_questions',$_POST);
			$result = $this->common->updateData('support_questions',$post,array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','questions Updated Successfully.');

				redirect(base_url('admin/support_questions_driver'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/edit_support'));
			}
		}
	}	

	public function add_support_user()
	{
	    $this->form_validation->set_rules('questions','questions','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add support','add_support');
		}else{
		  
		     $_POST['type']='User';
			$post = $this->common->getField('support_questions',$_POST);
			$result = $this->common->insertData('support_questions',$post);
			if($result){
				$this->session->set_flashdata('success','questions Added Successfully.');

				redirect(base_url('admin/support_questions_customer'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/add_support_user'));
			}
		}
	}
	
	
	  public function edit_support_user()
	{
	    $id = $this->uri->segment(3);
		$this->form_validation->set_rules('questions','questions','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');

		if($this->form_validation->run() == false){
		 $data['category'] = $this->common->getData('support_questions',array('id'=>$id),array('single'));
			$this->adminHtml('Add questions','add-questions',$data);
		}else{
		   /* $image = ''; 
		       $image1 = $this->common->do_upload('image','./assets/userfile/category/');
                                
                                if(isset($image1['upload_data'])){
                                $image = $image1['upload_data']['file_name'];
                                } 
			
			$_POST['image'] = $image;*/


		     $_POST['type']='User';
			$post = $this->common->getField('support_questions',$_POST);
			$result = $this->common->updateData('support_questions',$post,array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','questions Updated Successfully.');

				redirect(base_url('admin/support_questions_customer'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/edit_support_user'));
			}
		}
	}	public function add_support_provider()
	{
	    	$this->form_validation->set_rules('questions','questions','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');


		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add support','add_support');
		}else{
		  

		     $_POST['type']='Provider';
			$post = $this->common->getField('support_questions',$_POST);
			$result = $this->common->insertData('support_questions',$post);
			if($result){
				$this->session->set_flashdata('success','questions Added Successfully.');

				redirect(base_url('admin/support_questions_provider'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/add_support_provider'));
			}
		}
	}
	
	
	  public function edit_support_provider()
	{
	    $id = $this->uri->segment(3);
		$this->form_validation->set_rules('questions','questions','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');


		if($this->form_validation->run() == false){
		 $data['category'] = $this->common->getData('support_questions',array('id'=>$id),array('single'));
			$this->adminHtml('Add questions','add-questions',$data);
		}else{
		   /* $image = ''; 
		       $image1 = $this->common->do_upload('image','./assets/userfile/category/');
                                
                                if(isset($image1['upload_data'])){
                                $image = $image1['upload_data']['file_name'];
                                } 
			
			$_POST['image'] = $image;*/


		    $_POST['type']='Provider';
			$post = $this->common->getField('support_questions',$_POST);
			$result = $this->common->updateData('support_questions',$post,array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','questions Updated Successfully.');

				redirect(base_url('admin/support_questions_provider'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/edit_support_provider'));
			}
		}
	}

		public function about_us1()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
        $data['about_us1'] = $this->common->getData('about_us',array('id'=>1),array('single'));
	    $data['about_us2'] = $this->common->getData('about_us',array('id'=>2),array('single'));
	   
		$this->adminHtml('About us','about_us',$data);

		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('about_us',$_POST,array('id'=>1));
			if($result){
				$this->flashMsg('success','about us added successfully');
				redirect(base_url('admin/about_us'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/about_us'));
			}
		}


	}

	public function about_us2()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
        $data['about_us1'] = $this->common->getData('about_us',array('id'=>1),array('single'));
	    $data['about_us2'] = $this->common->getData('about_us',array('id'=>2),array('single'));
	   
		$this->adminHtml('About us','about_us',$data);

		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('about_us',$_POST,array('id'=>2));
			if($result){
				$this->flashMsg('success','about us added successfully');
				redirect(base_url('admin/about_us'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/about_us'));
			}
		}


	}
		public function home1()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
        $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);

		}
		else
		{		
			unset($_POST["submit"]);
			$result = $this->common->updateData('home',$_POST,array('id'=>1));
			if($result){
				$this->flashMsg('success','about us added successfully');
				redirect(base_url('admin/home'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/home'));
			}
		}


	}
		public function home2()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
        $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('home',$_POST,array('id'=>2));
			if($result){
				$this->flashMsg('success','home added successfully');
				redirect(base_url('admin/home'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/home'));
			}
		}


	}
	public function home3()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
       $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('home',$_POST,array('id'=>3));
			if($result){
				$this->flashMsg('success','home added successfully');
				redirect(base_url('admin/home'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/home'));
			}
		}


	}	public function home4()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
       $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('home',$_POST,array('id'=>4));
			if($result){
				$this->flashMsg('success','home added successfully');
				redirect(base_url('admin/home'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/home'));
			}
		}


	}
	public function home5()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
       $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('home',$_POST,array('id'=>5));
			if($result){
				$this->flashMsg('success','home added successfully');
				redirect(base_url('admin/home'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/home'));
			}
		}


	}
	public function home6()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
       $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('home',$_POST,array('id'=>6));
			if($result){
				$this->flashMsg('success','home added successfully');
				redirect(base_url('admin/home'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/home'));
			}
		}


	}
	public function features1()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>1));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}	public function features2()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>2));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}	public function features3()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>3));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}	public function features4()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>4));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}	public function features5()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>5));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}	

	public function features6()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>6));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}
	
	public function features7()
	{

			$this->form_validation->set_rules('heading1','heading1','required');
			$this->form_validation->set_rules('heading2','heading2','required');
			
		if($this->form_validation->run() == false){
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
		}else
		{			
			
			unset($_POST["submit"]);
			$result = $this->common->updateData('features',$_POST,array('id'=>7));
			if($result){
				$this->flashMsg('success','features added successfully');
				redirect(base_url('admin/features'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/features'));
			}
		}


	}
	
				
	public function features()
	{
	    $data['features1'] = $this->common->getData('features',array('id'=>1),array('single'));
	    $data['features2'] = $this->common->getData('features',array('id'=>2),array('single'));
	    $data['features3'] = $this->common->getData('features',array('id'=>3),array('single'));
	    $data['features4'] = $this->common->getData('features',array('id'=>4),array('single'));
	    $data['features5'] = $this->common->getData('features',array('id'=>5),array('single'));
	    $data['features6'] = $this->common->getData('features',array('id'=>6),array('single'));
	    $data['features7'] = $this->common->getData('features',array('id'=>7),array('single'));
		$this->adminHtml('features','features',$data);
	}
	public function home()
	{
	    $data['home1'] = $this->common->getData('home',array('id'=>1),array('single'));
	    $data['home2'] = $this->common->getData('home',array('id'=>2),array('single'));
	    $data['home3'] = $this->common->getData('home',array('id'=>3),array('single'));
	    $data['home4'] = $this->common->getData('home',array('id'=>4),array('single'));
	    $data['home5'] = $this->common->getData('home',array('id'=>5),array('single'));
	    $data['home6'] = $this->common->getData('home',array('id'=>6),array('single'));
		$this->adminHtml('home','home',$data);
	}
	public function about_us()
	{
	    $data['about_us1'] = $this->common->getData('about_us',array('id'=>1),array('single'));
	    $data['about_us2'] = $this->common->getData('about_us',array('id'=>2),array('single'));
	   
		$this->adminHtml('About us','about_us',$data);
	}				
	public function our_services()
	{
	    $data['cat_customer'] = $this->common->getData('our_services',array('id'=>1),array('single'));
	    $data['cat_driver'] = $this->common->getData('our_services',array('id'=>2),array('single'));
	    $data['cat_provider'] = $this->common->getData('our_services',array('id'=>3),array('single'));
		$this->adminHtml('our services','our_services',$data);
	}

	public function servicelist()
	{
	    $data['cat'] = $this->common->getData('sell_services','',array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('service List','servicelist',$data);
	}	
	public function productlist()
	{
	    $data['product'] = $this->common->getData('sell_products','',array('sort_by'=>'product_id','sort_direction' => 'desc'));
	    $data['link'] = 'admin/productDetail/';
		$this->adminHtml('Product List','product-list',$data);
	}
	
	public function categorylist($id)
	{
	    $data['cat'] = $this->common->getData('sell_category',array('service_id'=>$id),array());
		$this->adminHtml('Category List','categorylist',$data);
	}
	public function subcategorylist($id,$sid)
	{
	    $data['cat'] = $this->common->getData('sell_subcategory',array('service_id'=>$id,'category_id'=>$sid),array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('Sub Category List','subcategorylist',$data);
	}
		public function addservice()
	{
		$this->form_validation->set_rules('name','service name','required');
		if($this->form_validation->run() == false){

			$this->adminHtml('Add service','add-service');
		}else
		{			
			 if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			unset($_POST["submit"]);
			$result = $this->common->insertData('sell_services',$_POST);
			if($result){
				$this->flashMsg('success','service added successfully');
				redirect(base_url('admin/servicelist'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addservice'));
			}
		}
	}

	public function delete_goal()
	{
      $id = $this->uri->segment(3);
		$data = $this->common->getData('goals',array('id' => $id), array('single'));
		if($data)
		{
		   $result = $this->common->deleteData('goals',array('id'=>$id));
			if($result){
				 $this->session->set_flashdata('success','Credit goals deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/goal_list'),'refresh');
		}
	}
	public function addproductquantity()
	{
		$this->form_validation->set_rules('quantity','Quantity','required');
		if($this->form_validation->run() == false){

			$this->adminHtml('Add Product Quantity','add-product-quantity');
		}else
		{
			unset($_POST["submit"]);
			$result = $this->common->insertData('product_quantity',$_POST);
			if($result){
				$this->flashMsg('success','Product Quantity added successfully');
				redirect(base_url('admin/product_quantity'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addproductquantity/'.$_POST['product_id']));
			}
		}
	}	public function editproductquantity()
	{
			$pq=$this->uri->segment(3);
		$this->form_validation->set_rules('quantity','Quantity','required');
		if($this->form_validation->run() == false){
			
			$data['cat'] = $this->common->getData('product_quantity',array('id' => $pq), array('single'));
			$this->adminHtml('Add Product Quantity','add-product-quantity',$data);
		}else
		{			
		    $pro_quantity=$this->common->getData('product_quantity',array('id' => $_POST['id']), array('single'));
			unset($_POST["submit"]);
			$result = $this->common->updateData('product_quantity',$_POST,array('id'=>$_POST['id']));
			if($result){
				$this->flashMsg('success','Product Quantity added successfully');
				redirect(base_url('admin/product_quantity/'.$pro_quantity['product_id']));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addproductquantity/'.$_POST['product_id']));
			}
		}
	}

public function deleteproductquantity()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('product_quantity',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('product_quantity',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Question deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/product_quantity'),'refresh');
    		   
    		    
    		}
    
}

	 public function bookingList()
  {
        $data['category'] = $this->common->getData('user_send_request',array('driver_id>'=>0),array(''));
        foreach ($data['category'] as $key => $value) {
          $array=$this->common->getData('task',array('id'=>$value['task_id']),array('single'));
          $arrays=$this->common->getData('sell_subcategory',array('id'=>$array['sub_category_id']),array('single'));
      
    
         $data['category'][$key]['name']=$arrays['name'];

        }
    $this->adminHtml('Booking List','booking-list',$data);
  }
  public function providerbookingList()
  {
        $data['category'] = $this->common->getData('user_send_request',array('provider_id>'=>0),array(''));
        foreach ($data['category'] as $key => $value) {
          $array=$this->common->getData('task',array('id'=>$value['task_id']),array('single'));
          $arrays=$this->common->getData('sell_subcategory',array('id'=>$array['sub_category_id']),array('single'));
      
    
         $data['category'][$key]['name']=$arrays['name'];

        
           

        }
    $this->adminHtml('Booking List','provider-booking-list',$data);
  }
	public function addcategory($id)
	{
	   $service_id=$this->uri->segment(3);
		$this->form_validation->set_rules('name','category name','required');
		if($this->form_validation->run() == false){

			$this->adminHtml('Add category','add-category');
		}else
		{			
			 if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			unset($_POST["submit"]);
			$_POST['service_id']=$service_id;
			$result = $this->common->insertData('sell_category',$_POST);
			if($result){
				$this->flashMsg('success','Category added successfully');
				redirect(base_url('admin/categorylist/'.$service_id));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addcategory/'.$service_id));
			}
		}
	}

	public function addsubcategory()
	{
	    $subcat_id=$this->uri->segment(5);
	    $service_id=$this->uri->segment(3);
	    $cat_id=$this->uri->segment(4);
		$this->form_validation->set_rules('name','subcategory name','required');
		if($this->form_validation->run() == false){
		    $data['cat'] = $this->common->getData('sell_subcategory',array('id'=>$subcat_id),array('sort_by'=>'id','sort_direction' => 'desc'));
			$this->adminHtml('Add subcategory','add-subcategory',$data);
		}else
		{			
			
			 if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			 unset($_POST["submit"]);
			 	$_POST['service_id']=$service_id;
			 	$_POST['category_id']=$cat_id;
			$result = $this->common->insertData('sell_subcategory',$_POST);
			if($result){
				$this->flashMsg('success','SubCategory added successfully');
				redirect(base_url('admin/subcategorylist/'.$service_id.'/'.$cat_id));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addsubcategory/'.$service_id.'/'.$cat_id));
			}
		}
	}
	
	
		public function editcategory()
	{

		$category_id = $this->uri->segment(4);
		$service_id = $this->uri->segment(3);
		$this->form_validation->set_rules('name','category name','required');
		if($this->form_validation->run() == false){			
		 $data['cat'] = $this->common->getData('sell_category',array('id' =>$category_id),array('single'));
			$this->adminHtml('Update Category','add-category',$data);
		}else{
		    
			 if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    unset($_POST["category_id"]);
			$result = $this->common->updateData('sell_category',$_POST,array('id'=>$id));
						
			if($result){
				$a = $this->flashMsg('success','Category update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/categorylist/'.$service_id),'refresh');
		}
	}
	
	public function edittv()
	{

		$category_id = $this->uri->segment(3);
    	$this->form_validation->set_rules('tv_url',' tv url','required');
		$this->form_validation->set_rules('name','name','required');
		if($this->form_validation->run() == false){			
		 $data['cat'] = $this->common->getData('tv',array('tv_id' =>$category_id),array('single'));
			$this->adminHtml('Update Tv','add-tv',$data);
		}else{
			
			unset($_POST["submit"]);
			if(isset($_FILES))
		    {
		        $video = $this->common->do_uploadvideo('tv_image','./assets/userfile/classfied/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['tv_image']=$video;
    			} 
		    }
			$id = $this->input->post('tv_id');
		    unset($_POST["tv_id"]);
			$result = $this->common->updateData('tv',$_POST,array('tv_id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','Tv update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/tvlist'),'refresh');
		}
	}
	
	public function editradio()
	{

		$category_id = $this->uri->segment(3);
    	$this->form_validation->set_rules('radio_url',' radio url','required');
		$this->form_validation->set_rules('radio_nm','name','required');
		if($this->form_validation->run() == false){			
		 $data['cat'] = $this->common->getData('radio',array('radio_id' =>$category_id),array('single'));
			$this->adminHtml('Update Radio','add-radio',$data);
		}else{
			
			unset($_POST["submit"]);
			if(isset($_FILES))
		    {
		        $video = $this->common->do_uploadvideo('radio_image','./assets/userfile/classfied/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['radio_image']=$video;
    			} 
		    }
			$id = $this->input->post('radio_id');
		    unset($_POST["radio_id"]);
			$result = $this->common->updateData('radio',$_POST,array('radio_id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','radio update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/radiolist'),'refresh');
		}
	}
	
	
	
	public function editsubcategory()
	{

		$service_id = $this->uri->segment(3);
		$cat_id = $this->uri->segment(4);
		$suncat_id = $this->uri->segment(5);
		$this->form_validation->set_rules('name','subcategory name','required');
		if($this->form_validation->run() == false){			
		 $data['subcat'] = $this->common->getData('sell_subcategory');
		 $data['cat'] = $this->common->getData('sell_subcategory',array('id' =>$suncat_id),array('single'));
			$this->adminHtml('Update Subcategory','add-subcategory',$data);
		}else{
			
			if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    //unset($_POST["id"]);
		
			$result = $this->common->updateData('sell_subcategory',$_POST,array('id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','SubCategory update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/subcategorylist/'.$service_id.'/'.$cat_id.'/'.$suncat_id),'refresh');
		}
	}
	public function editsize()
	{

		$s_id = $this->uri->segment(6);
		$service_id = $this->uri->segment(3);
		$cat_id = $this->uri->segment(4);
		$suncat_id = $this->uri->segment(5);
		$this->form_validation->set_rules('size','size name','required');
		if($this->form_validation->run() == false){			
		 $data['subcat'] = $this->common->getData('sell_size');
		 $data['cat'] = $this->common->getData('sell_size',array('id' =>$s_id),array('single'));
			$this->adminHtml('Update size','add-size',$data);
		}else{
			
		
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    //unset($_POST["id"]);
		
			$result = $this->common->updateData('sell_size',$_POST,array('id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','size update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/sizelist/'.$service_id.'/'.$cat_id.'/'.$suncat_id),'refresh');
		}
	}

	public function editproduct()
	{
		$pid = $this->uri->segment(3);
		$this->form_validation->set_rules('name','name','required');
		$this->form_validation->set_rules('regular_price','Regular price','required');
		$this->form_validation->set_rules('sale_price','Sale price','required');

		
		if($this->form_validation->run() == false){			
			$data['product'] = $this->common->getData('sell_products',array('product_id' =>$pid), array('single'));
			$data['images'] = $this->common->getData('sell_product_image',array('product_id' =>$pid), array(''));
/*			$data['category']= $this->common->getdata('category');
            $data['brand']= $this->common->getdata('brand');*/
			$this->adminHtml('Update Product','add-product',$data);;
		}else
		{			 
			       	
			unset($_POST["submit"]);
			$product_id = $this->input->post('product_id');
		    unset($_POST["product_id"]);
			$result = $this->common->updateData('sell_products',$_POST,array('product_id'=>$product_id));
		
			 if(!empty($_FILES['product_image']['name'][0]))
			{

			    	$result1 = $this->common->deleteData('sell_product_image',array('product_id'=>$product_id));
	             $filesCount = count($_FILES['product_image']['name']);
	              $size = 0;
	              for($i = 0; $i < $filesCount; $i++)
	              {
   
		            $_FILES['image']['name']     = $_FILES['product_image']['name'][$i];
	                $_FILES['image']['type']     = $_FILES['product_image']['type'][$i];
	                $_FILES['image']['tmp_name'] = $_FILES['product_image']['tmp_name'][$i];
	                $_FILES['image']['error']     = $_FILES['product_image']['error'][$i];
	                $_FILES['image']['size']     = $_FILES['product_image']['size'][$i];
	                $image = $this->common->do_upload('image','./assets/images/');
        			if (!empty($image['upload_data'])) {
        				$filenm = $image['upload_data']['file_name']; 

        					$resu = $this->common->insertData('sell_product_image',array('product_id'=>$product_id,'images'=>$filenm));
        		
        			}
        		
	              }
	            
			 }
			 if(!empty($_POST['quantity']))
		   {
		       foreach($_POST['quantity'] as $k => $val)
		       {
		           
		          $this->common->insertData('product_quantity',array('product_id'=>$product_id,'quantity'=>$val,'price'=>$_POST['price'][$k])); 
		          
		       }
		       
		   }
			if($result){
				$a = $this->flashMsg('success','Data update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/productlist'),'refresh');
		}
	}
	public function productDetail($pid)
	{
		$data['product'] = $this->common->getData('sell_products',array('product_id' =>$pid), array('single'));
		$data['product_images'] = $this->common->getData('sell_product_image',array('product_id' =>$pid), array(''));
		$this->adminHtml('Product Detail','admin/product-detail',$data);
	}
	public function deleteproduct($c_id){  

        $result = $this->common->deleteData('sell_products',array('product_id'=>$c_id));
        if($result)
        {
          $a = $this->flashMsg('success','Product Deleted successfully');
          redirect('admin/productlist');
        }
	}
	public function deletetestomonials($c_id){  

        $result = $this->common->deleteData('testomonials',array('id'=>$c_id));
        if($result)
        {
          $a = $this->flashMsg('success','Testomonials Deleted successfully');
          redirect('admin/testomonials');
        }
	}
		public function addproduct()
	{
	    
		$this->form_validation->set_rules('category','category','required');
		$this->form_validation->set_rules('name','name','required');
		$this->form_validation->set_rules('regular_price','Regular price','required');
		$this->form_validation->set_rules('sale_price','Sale price','required');
		$this->form_validation->set_rules('short_desc','short description','required');

/*		$this->form_validation->set_rules('long_desc','Long description','required');	*/
		if($this->form_validation->run() == false)
		{
		   
            $data['category']= $this->common->getdata('sell_category');
            $data['subcategory']= $this->common->getdata('sell_subcategory');
            $data['service']= $this->common->getdata('sell_services');

         
			$this->adminHtml('Add Product','add-product',$data);

		}else
		{
	
			$_POST['created_date'] = date('Y-m-d H:i:s');
			
		    $post = $this->common->getField('sell_products',$_POST);
		    $result = $this->common->insertData('sell_products',$post);
		    $product_id = $this->db->insert_id();
		    if(!empty($_FILES["product_image"]))
			{
	             $filesCount = count($_FILES['product_image']['name']);
	              $size = 0;
	              for($i = 0; $i < $filesCount; $i++)
	              {
   
		            $_FILES['image']['name']     = $_FILES['product_image']['name'][$i];
	                $_FILES['image']['type']     = $_FILES['product_image']['type'][$i];
	                $_FILES['image']['tmp_name'] = $_FILES['product_image']['tmp_name'][$i];
	                $_FILES['image']['error']     = $_FILES['product_image']['error'][$i];
	                $_FILES['image']['size']     = $_FILES['product_image']['size'][$i];
	                $image = $this->common->do_upload('image','./assets/images/');
        			if (!empty($image['upload_data'])) {
        				$filenm = $image['upload_data']['file_name']; 
        				$result = $this->common->insertData('sell_product_image',array('product_id'=>$product_id,'images'=>$filenm));      			
        			}
        			
	              }
	            
			 }
		   if(!empty($_POST['quantity']))
		   {
		       foreach($_POST['quantity'] as $k => $val)
		       {
		           
		          $this->common->insertData('product_quantity',array('product_id'=>$product_id,'quantity'=>$val,'price'=>$_POST['price'][$k])); 
		          
		       }
		       
		   }
		     
			if($result){
				$this->flashMsg('success','product added successfully');
				redirect(base_url('admin/productlist'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addproduct'));
			}
		}
	}


	public function dashboard()
	{	
	$data['user'] = $this->common->getData('user',array(),array('count'));
	$data['follower'] = $this->common->getData('follower',array(),array('count'));

	$data['concerts'] = $this->common->getData('goals',array(),array('count'));
    $data['goals'] = $this->common->getData('goals',array(),array('count'));
    
		$this->adminHtml('Dashboard','admin/dashboard',$data);
	}
  public function roleList()
  {
        $data['category'] = $this->common->getData('permission_roles',array(),array(''));
    $this->adminHtml('Roles List','roles-list',$data);
  }  

	public function providers_in_shop($id)
	{
		 $members= $this->common->getData('invitaion',array('shop_id'=>$id));
		 foreach($members as $key => $val)
		 {
		     $data['user'][] = $this->common->getData('provider',array('id'=>$val['provider_id']),array('single'));
	
		 }
		 $this->adminHtml('Provider List','user-list',$data);
	}
		public function adminList()
	{
		$data['user'] = $this->common->getData('admin',array());
		$this->adminHtml('Admin List','admin-list',$data);
	}
	    public function dissuspend_admin($id)
  { 
    $d = $this->common->updateData('admin',array('suspend'=>0),array('id' => $id));
     //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
    redirect(base_url('admin/adminList'));
    //$this->adminHtml('provider List','user-list',$data);
  }

  public function suspend_admin($id)
  { 
    $d = $this->common->updateData('admin',array('suspend'=>1),array('id' => $id));
     //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
    redirect(base_url('admin/adminList'));
    //$this->adminHtml('provider List','user-list',$data);
  }
	public function providerList()
	{
		$data['user'] = $this->common->getData('provider',array());
		$this->adminHtml('Service Provider List','user-list',$data);
	}
	public function driverList(){
			$data['user'] = $this->common->getData('driver',array());
		
		$this->adminHtml('Driver List','user-list',$data);
	}
			public function vehicleList($id)
	{
		$data['user'] = $this->common->getData('vehicle_details',array('driver_id'=>$id));
		$data['vehicle_type'] = $this->common->getData('vehicle_type',array());

		$this->adminHtml('Vehicle List','vehicle-list',$data);
	}


	public function online_userList()
	{
		$data['user'] = $this->common->getData('user',array('show_online_user'=>1));
		$this->adminHtml('User List','user-list',$data);
	}

	public function online_providerList()
	{
		$data['user'] = $this->common->getData('user',array('show_online_user'=>1));
		$this->adminHtml('User List','user-list',$data);
	}

	public function ongoing_services()
	{	
		$provider_id = $this->uri->segment(3);
		$data['services'] = $this->ongoing_service_data_function($provider_id);
		$this->adminHtml('ongoing services','ongoing_services',$data);
	}


	public function send_single_mail($user_id)
	{
		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{
			$data['user_id'] = $user_id;						
			$this->adminHtml('Add Message','send-single-email',$data);
		}
		else
		{
			$user_id = $this->input->post('user_id');
			
			$where = "id = '".$user_id."'";
			$user_result = $this->common->getData('user',$where,array('single'));
			$to_email = $user_result['email'];


			$message = $this->input->post('editor');

			$template = $this->load->view('template/broadcast-email',array('message' => $message),true);
			$send_mail = $this->common->sendMail($to_email,"kutz Updates",$template);
				
			
			if($send_mail){
				$this->session->set_flashdata('success','Data added successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/send_single_mail/'.$user_id));
		}
	}

	

	public function add_message()
	{
		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{						
			$this->adminHtml('Add Message','add-message');
		}
		else
		{

			$where = "login_status = 1";
			$user_result = $this->common->getData('users',$where);
			$user_list="";

			foreach ($user_result as $key => $value) 
			{
				$user_list.= $value['email'].",";
			}
			$user_list = rtrim($user_list,',');
		


			$message = $this->input->post('editor');

			$template = $this->load->view('template/broadcast-email',array('message' => $message),true);
			$send_mail = $this->common->sendMail($user_list,"kutz Updates",$template);
				
			
			if($send_mail){
				$this->session->set_flashdata('success','Data added successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/add_message'));
		}
	}



	public function mailcheck()
	{
			$to = "meenakhsi@mailinator.com";
			$subject = "Registration verification";
			$txt = "Please click to activate your account";
			$headers = "From: info@creativethoughtsinfo.com";
			
			
			mail($to,$subject,$txt,$headers);	
	}




	public function ongoing_service_data_function($provider_id)
	{
		$where_request="USR.provider_id ='".$provider_id."' AND  (USR.status ='1' OR USR.status ='2')";
				$data_array = $this->common->myRequestInfo($where_request);
				if(!empty($data_array))
				{
					return $data_array;
				}
				else
				{
					$data_array = array();
					return $data_array;
				}

    }
	public function profile($id)
	{	
		$data['user'] = $this->common->getData('user',array('id' => $id),array('single'));
		$this->adminHtml('User Profile','user-detail',$data);
	}
	
	public function sp_profile($id)
	{	
		$data['user'] = $this->common->getData('provider',array('id' => $id),array('single'));
		$this->adminHtml('Service Provider Profile','user-detail',$data);
	}
	
	public function sd_profile($id)
	{	
		$data['user'] = $this->common->getData('driver',array('id' => $id),array('single'));


		$this->adminHtml('Driver Profile','user-detail',$data);
	}
		




	public function verify_licence($id)
	{	
		//$data['goverment_info'] = $this->common->updateData('provider',array('verify_licence'=>1),array('id' => $id));
		$d = $this->common->updateData('provider',array('verify_licence'=>1),array('id' => $id));
		  $title = "Verified";
							$type = "Verified";
							/*for  '.$cat_name['services_category_name'].'*/
							$message_push = 'Your Doument is verified by Admin';
							$msg_notification = array(
								"body" => $message_push,
								"title"=>$title
								);
								$body=$message_push;
							 /*print_r($res['device_type']); */
							if($d['device_type']=='Android')
							{ 
						  /*print_r($res['device_token']); die;*/
									$messages_push =  array("notification" => $msg_notification,"notification_type" => $type,"user_id"=>$d['id']);
									$registatoin_id = array();
                                           array_push($registatoin_id, $d['device_token']);
									 $ress=$this->send_notification($registatoin_id,$messages_push); 
								 $this->common->insertData('notification',array('message' => $message_push,'sender_id' => 'Admin','receiver_id' => $d['id'],'created_time'=>date('d-m-Y')),array());
                              
							} /*&& $res['notification_status']=='1'*/
							else if($users['device_type']=='ios')
							{
								 
							   	$messages_push =  array("notification" => $msg_notification,"notification_type" => $type,"user_id"=>$d['id']);
								$registatoin_id = array();
                                array_push($registatoin_id, $d['device_token']);
							    /*$res = $this->send_notification($registatoin_id, $messages_push); */
								$this->send_notification_ios($users['device_token'],$body, $title,$type); 
									 $this->common->insertData('notification',array('message' => $message_push,'sender_id' => 'Admin','receiver_id' => $d['id'],'created_time'=>date('d-m-Y')),array());
								
									 
							}
		$this->adminHtml('License ','license-list',$data);
	}	
	public function satisfy($id)
	{	
		$d = $this->common->updateData('user',array('satisfy'=>1),array('id' => $id));
	   $data['user'] = $this->common->getData('user',array('satisfy'=>'1'),array(''));
		
		$this->adminHtml('Customer List','customer-list',$data);
	}
	
	public function approve($id)
	{	
		$d = $this->common->updateData('provider',array('approve'=>1),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/providerList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function disapprove($id)
	{	
		$d = $this->common->updateData('provider',array('approve'=>0),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/providerList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function suspend($id)
	{	
		$d = $this->common->updateData('provider',array('suspend'=>1),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/providerList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function dissuspend($id)
	{	
		$d = $this->common->updateData('provider',array('suspend'=>0),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/providerList'));
		//$this->adminHtml('provider List','user-list',$data);
	}


	
	public function approve_provider($id)
	{	
		$d = $this->common->updateData('provider',array('approve'=>1),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/providerList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function disapprove_provider($id)
	{	
		$d = $this->common->updateData('provider',array('approve'=>0),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/providerList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function suspend_driver($id)
	{	
		$d = $this->common->updateData('driver',array('suspend'=>1),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/driverList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function dissuspend_driver($id)
	{	
		$d = $this->common->updateData('driver',array('suspend'=>0),array('id' => $id));
	   //$data['user'] = $this->common->getData('provider',array('approve'=>'1'),array(''));
		redirect(base_url('admin/driverList'));
		//$this->adminHtml('provider List','user-list',$data);
	}
	public function edit_address()
	{
	
	    $this->common->updateData('user',array('user_address'=>$_POST['user_address']),array('id' => $_POST['user_id']));
		redirect(base_url('admin/profile/').$_POST['user_id']);
		
	}
	public function license_id($id)
	{	
		$data['certificate_info'] = $this->common->getData('provider',array('id' => $id),array('single'));
		$this->adminHtml('Goverment Id','license-list',$data);
	}


	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('msg','Logged out successfully');
		redirect(base_url('admin-login'));
	}


	public function verify_passport($id)
	{	 
	//$d = $this->common->updateData('provider',array('verify_passport'=>1),array('id' => $id));
     $d = $this->common->updateData('provider',array('verify_passport'=>1),array('id' => $id));
		  $title = "Verified";
							$type = "Verified";
							/*for  '.$cat_name['services_category_name'].'*/
							$message_push = 'Your Doument is verified by Admin';
							$msg_notification = array(
								"body" => $message_push,
								"title"=>$title
								);
								$body=$message_push;
							 /*print_r($res['device_type']); */
							if($d['device_type']=='Android')
							{ 
						  /*print_r($res['device_token']); die;*/
									$messages_push =  array("notification" => $msg_notification,"notification_type" => $type,"user_id"=>$d['id']);
									$registatoin_id = array();
                                           array_push($registatoin_id, $d['device_token']);
									 $ress=$this->send_notification($registatoin_id,$messages_push); 
								 $this->common->insertData('notification',array('message' => $message_push,'sender_id' => 'Admin','receiver_id' => $d['id'],'created_time'=>date('d-m-Y')),array());
                              
							} /*&& $res['notification_status']=='1'*/
							else if($users['device_type']=='ios')
							{
								 
							   	$messages_push =  array("notification" => $msg_notification,"notification_type" => $type,"user_id"=>$d['id']);
								$registatoin_id = array();
                                array_push($registatoin_id, $d['device_token']);
							    /*$res = $this->send_notification($registatoin_id, $messages_push); */
								$this->send_notification_ios($users['device_token'],$body, $title,$type); 
									 $this->common->insertData('notification',array('message' => $message_push,'sender_id' => 'Admin','receiver_id' => $d['id'],'created_time'=>date('d-m-Y')),array());
								
									 
							}
        $data['certificate_info'] = $this->common->getData('provider',array('id' => $id),array('single'));
		$this->adminHtml('certificate','passport-list',$data);
	}
	public function passport_id($id)
	{	
		$data['goverment_info'] = $this->common->getData('provider',array('id' => $id),array('single'));
		$this->adminHtml('Passort','passport-list',$data);
	}


	public function userRequest($userid)
	{
		$data['request_services'] = $this->requestedservices_function($userid);
		
		$this->adminHtml('Requested Service','requested-service',$data);
	}




	public function requestedservices_function($user_id)
	{
		$this->load->helper('common');

		
		$result = $this->common->getUserHistory(array('ser.user_id'=>$user_id));
		
		if($result){
			
			foreach ($result as $key => $value) {
				if($value['service_delivery_type'] == "Per Hour")
				{
					
					$diff = strtotime($value['end_working_hours']) - strtotime($value['start_working_hours']);
					$datetime1 = new DateTime($value['start_working_hours']);
					$datetime2 = new DateTime($value['end_working_hours']);
					$interval = $datetime1->diff($datetime2);
					$minutes = $interval->days * 24 * 60;
					$minutes += $interval->h * 60;
					$minutes += $interval->i;
 					
 					$amount = floor($minutes / 60)*$value['service_rate'];
					$amount += ($minutes % 60)*$value['service_rate']/60;

					
					$ratting = $this->ratting_avg($value['provider_id']);
					$result[$key]['amount'] = $amount;
					$result[$key]['rating'] = $ratting;
					$result[$key]['working_hours'] = convertToHoursMins($minutes) ? convertToHoursMins($minutes) : 0 ;
				}
				else
				{
					
					$service_rate = $value['service_rate'];

					
				
					$ratting = $this->ratting_avg($value['provider_id']);
					$result[$key]['amount'] = $service_rate;
					$result[$key]['rating'] = $ratting;
					$result[$key]['working_hours'] = "";
				}
			}
		
			return $result;
		}else{
			$result = array();
			return $result;
		}
	}



	function distance($lat1, $lon1, $lat2, $lon2, $unit) 
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") 
		{
			return ($miles * 1.609344);
		} 
		else if ($unit == "N") 
		{
			return ($miles * 0.8684);
		} 
		else 
		{
			return $miles;
		}
	}



	public function ratting_avg($provider_id)
	{
		$count_user = $this->common->getData('payment_history',array('user_to'=>$provider_id),array('count'));
		if($count_user)
		{
			$query="SELECT SUM(`rating`) AS rating_count FROM payment_history  WHERE user_to='".$provider_id."'";
			$total_rating = $this->common->query($query);
			$total_rating_user = $total_rating[0]['rating_count'];
			$avg=$total_rating_user/$count_user;
		}
		else
		{
			$avg = "0";
		}
		return $avg;
	}


	public function addPage()
	{
		$this->form_validation->set_rules('description','Description','required');
		if($this->form_validation->run() == false){						
			$this->adminHtml('Add Page','add-page');
		}else{
			$post = $this->common->getField('pages',$_POST);
			
			$result = $this->common->insertData('pages',$post);
			
			if($result){
				$this->session->set_flashdata('success','Data added successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('Admin/pageList'),'refresh');
		}
	}

	public function editPage($name)
	{
		$this->form_validation->set_rules('description','Description','required');
		if($this->form_validation->run() == false){			
			$data['page'] = $this->common->getData('pages',array('name' => $name), array('single'));
			$this->adminHtml('Update Page','add-page',$data);
		}else{
			$post = $this->common->getField('pages',$_POST);			
			$page = $this->common->getData('pages',array('name'=> $post['name']),array('single'));
			if($page){
				$result = $this->common->updateData('pages',$post,array('name'=>$post['name']));
			}
			if($result){
				$a = $this->session->set_flashdata('success','Data update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('Admin/pageList'),'refresh');
		}
	}


	

	public function pageList()
	{
		$data['pages'] = $this->common->getData('pages');
		$this->adminHtml('Page List','page-list',$data);
	}

	public function aboutUs()
	{
		$this->form_validation->set_rules('description','Link','required');
		if($this->form_validation->run() == false){		
		$data['contact'] = $this->common->getData('pages',array('name'=> 'about-us'),array('single'));
			$this->adminHtml('About Us','about-us',$data);
		}else{
			$post = $this->common->getField('pages',$_POST);
			
			$result = $this->common->updateData('pages',$post,array('name' => 'about-us'));
			
			if($result){
				$a = $this->session->set_flashdata('success','Data Update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('Admin/aboutUs'),'refresh');
		}
	}

	public function providerHistory($provider_id)
	{          
        $data['order'] = $services = $this->common->getUserHistory(array('ser.provider_id' =>$provider_id));
       if($data['order']){
			foreach ($data['order'] as $key => $value) {

				$diff = strtotime($value['end_working_hours']) - strtotime($value['start_working_hours']);
				$datetime1 = new DateTime($value['start_working_hours']);
				$datetime2 = new DateTime($value['end_working_hours']);
				$interval = $datetime1->diff($datetime2);
				$minutes = $interval->days * 24 * 60;
				$minutes += $interval->h * 60;
				$minutes += $interval->i;

				$amount = floor($minutes / 60)*$value['service_rate'];
				$amount += ($minutes % 60)*$value['service_rate']/60;

				$data['order'][$key]['amount'] = $amount;
				$data['order'][$key]['rating'] = 3;
				$data['order'][$key]['working_hours'] = convertToHoursMins($minutes);
			}
		}
        $this->adminHtml('Provider services List','requested-service',$data);
    }	

    public function provderservices($userid)
    {
    	$data['services'] = $this->myservices_function($userid);
		$this->adminHtml('Provider services List','provider-services',$data);
    }



     public function myservices_function($userid)
    {
    	$result = $this->common->myservices($userid);
    		
    	if(!empty($result))
    	{
	    	foreach ($result as $key => $value) 
	    	{
                   
                    
                    
                    
	    		$where = "(status = 1 or status = 2)  AND  user_send_request_id = '".$value['booking_id']."'";
	    		$ongoing = $this->common->getData('user_send_request',$where,array('field'=>"count(status) as ongoing","single"));

	    		$where = "(status = 5 or status = 3)  AND  user_send_request_id = '".$value['booking_id']."'";
	    		$complete = $this->common->getData('user_send_request',$where,array('field'=>"count(status) as complete","single"));



	    		$myservicelist[]=array(
			   'my_service_id' => $value['my_service_id'],
			   'provider_id' => $value['provider_id'],
			   'services_category_id' => $value['services_category_id'],
			   'services_category_name' => $value['services_category_name'],
			   'sell_subcategory_id' => $value['sell_subcategory_id'],
			   'sell_subcategory_name' => $value['sell_subcategory_name'],
			   'sell_subcategory_image' => $value['sell_subcategory_image'],
			   'sell_subcategory_image' => $value['sell_subcategory_image'],
			   'service_rate' => $value['service_rate'],
			   'ongoing_projects' => $ongoing['ongoing'],
			   'completed_projects' => $complete['complete']
			    );
	    	}

	    	return $myservicelist;
	    }
	    else
	    {
	    	$myservicelist = array();
	    	return $myservicelist;
	    }
    }
public function file_check($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['image']['name']);
        if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
               
                $this->session->set_flashdata('danger','Please select only gif/jpeg/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
             $this->session->set_flashdata('danger','Please choose a file to upload.');
            return false;
        }
    }
    public function addQuestions()
	{
		$this->form_validation->set_rules('questions','questions','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add questions','add-questions');
		}else{
			$post = $this->common->getField('feedback_questions',$_POST);
			$result = $this->common->insertData('feedback_questions',$post);
			if($result){
				$this->session->set_flashdata('success','questions Added Successfully.');
				redirect(base_url('admin/FeedbackList'));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/addQuestions'));
			}
		}
	} 
	public function addOptions()
	{
	     //$_POST['question_id'] = $this->uri->segment(3);
		$this->form_validation->set_rules('label','label','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add Options','add-options');
		}else{

			$post = $this->common->getField('feedback_questions_option',$_POST);
			$result = $this->common->insertData('feedback_questions_option',$post);
			if($result){
				$this->session->set_flashdata('success','Options Added Successfully.');

				redirect(base_url('admin/viewOptions/'.$_POST['question_id']));
			}else{
				$this->session->set_flashdata('danger','Options Not Added.Please Try Again.');
				redirect(base_url('admin/addOptions/'.$_POST['question_id']));
			}
		}
	}

	public function addBanner()
	{
		$this->form_validation->set_rules('banner_name','Banner','required');
		$this->form_validation->set_rules('image', '', 'callback_file_check');


		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add banner','add-banner');
		}else{
		    $image = ''; 
		       $image1 = $this->common->do_upload('image','./assets/userfile/category/');
                                
                                if(isset($image1['upload_data'])){
                                $image = $image1['upload_data']['file_name'];
                                } 
			
			$_POST['image'] = $image;


		    
			$post = $this->common->getField('banner',$_POST);
			$result = $this->common->insertData('banner',$post);
			if($result){
				$this->session->set_flashdata('success','banner Added Successfully.');

				redirect(base_url('admin/MensbannerList'));
			}else{
				$this->session->set_flashdata('danger','banner Not Added.Please Try Again.');
				redirect(base_url('admin/addBanner'));
			}
		}
	}
	
	public function addWomensBanner()
	{
		$this->form_validation->set_rules('banner_name','Banner','required');
		$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add banner','add-womensbanner');
		}else{
		    			$image = ''; 
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
			
			$_POST['image'] = $image;


		    
			$post = $this->common->getField('banner',$_POST);
			$result = $this->common->insertData('banner',$post);
			if($result){
				$this->session->set_flashdata('success','banner Added Successfully.');

				redirect(base_url('admin/WomensbannerList'));
			}else{
				$this->session->set_flashdata('danger','banner Not Added.Please Try Again.');
				redirect(base_url('admin/addWomensBanner'));
			}
		}
	}     public function addKidsBanner()
	{
		$this->form_validation->set_rules('banner_name','Banner','required');
		$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add banner','add-kidsbanner');
		}else{
		    			$image = ''; 
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
			
			$_POST['image'] = $image;


		    
			$post = $this->common->getField('banner',$_POST);
			$result = $this->common->insertData('banner',$post);
			if($result){
				$this->session->set_flashdata('success','banner Added Successfully.');

				redirect(base_url('admin/KidsbannerList'));
			}else{
				$this->session->set_flashdata('danger','banner Not Added.Please Try Again.');
				redirect(base_url('admin/addKidsBanner'));
			}
		}
	} 
	public function addMenCategory()
	{
		$this->form_validation->set_rules('services_category_name','Category','required');
		$this->form_validation->set_rules('services_category_price','Price','required');
		$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add Category','add-mencategory');
		}else{
		    			$image = ''; 
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
			
			$_POST['services_category_image'] = $image;
		    $_POST['services_category_id']=1;
		    $_POST['sell_subcategory_name']=$_POST['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$_POST['services_category_price'];
		    
			$post = $this->common->getField('service_men_category',$_POST);
			$result = $this->common->insertData('service_men_category',$post);

			$_POST['services_category_id']=1;
		    $_POST['sell_subcategory_name']=$_POST['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$_POST['services_category_price'];
			$posts = $this->common->getField('sell_subcategory',$_POST);
			$results = $this->common->insertData('sell_subcategory',$posts);

			if($result){
				$this->session->set_flashdata('success','Category Added Successfully.');
				redirect(base_url('admin/menCategoryList'));
			}else{
				$this->session->set_flashdata('danger','Category Not Added.Please Try Again.');
				redirect(base_url('admin/addMenCategory'));
			}
		}
	}  
	public function addWomenCategory()
	{
		$this->form_validation->set_rules('services_category_name','Category','required');
			$this->form_validation->set_rules('services_category_price','Price','required');
			$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add Category','add-womencategory');
		}else{
		    		    			$image = ''; 
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
			
			$_POST['services_category_image'] = $image;
			$post = $this->common->getField('service_women_category',$_POST);
			$result = $this->common->insertData('service_women_category',$post);
			$_POST['services_category_id']=2;
		    $_POST['sell_subcategory_name']=$_POST['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$_POST['services_category_price'];
			$posts = $this->common->getField('sell_subcategory',$_POST);
			$results = $this->common->insertData('sell_subcategory',$posts);
			if($result){
				$this->session->set_flashdata('success','Category Added Successfully.');
				redirect(base_url('admin/womenCategoryList'));
			}else{
				$this->session->set_flashdata('danger','Category Not Added.Please Try Again.');
				redirect(base_url('admin/addWomenCategory'));
			}
		}
	}	public function addKidsCategory()
	{
		$this->form_validation->set_rules('services_category_name','Category','required');
			$this->form_validation->set_rules('services_category_price','Price','required');
			$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false){
			// $data['category'] = $this->common->getData('services_category');
			$this->adminHtml('Add Category','add-kidscategory');
		}else{
		    		    			$image = ''; 
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
			
			$_POST['services_category_image'] = $image;
			$post = $this->common->getField('service_women_category',$_POST);
			$result = $this->common->insertData('service_kids_category',$post);
			$_POST['services_category_id']=3;
		    $_POST['sell_subcategory_name']=$_POST['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$_POST['services_category_price'];
			$posts = $this->common->getField('sell_subcategory',$_POST);
			$results = $this->common->insertData('sell_subcategory',$posts);
			if($result){
				$this->session->set_flashdata('success','Category Added Successfully.');
				redirect(base_url('admin/kidsCategoryList'));
			}else{
				$this->session->set_flashdata('danger','Category Not Added.Please Try Again.');
				redirect(base_url('admin/addKidsCategory'));
			}
		}
	}


	  public function editQuestions()
	{
	    $id = $this->uri->segment(3);
	    $type = $this->uri->segment(4);
		 if($type=='User')
		{
		$add='FeedbackList';

		}
		if($type=='Provider')
		{
		$add='FeedbackListForprovider';
		}
		if($type=='Driver')
		{
		$add='FeedbackListFordriver';
		}

		$this->form_validation->set_rules('questions','questions','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');


		if($this->form_validation->run() == false){
		
		 $data['category'] = $this->common->getData('feedback_questions',array('id'=>$id),array('single'));
			$this->adminHtml('Add questions','add-questions',$data);
		}
		else{
		



			$post = $this->common->getField('feedback_questions',$_POST);
		
			$result = $this->common->updateData('feedback_questions',array('questions'=>$_POST['questions']),array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','questions Updated Successfully.');

				redirect(base_url('admin/'.$add));
			}else{
				$this->session->set_flashdata('danger','questions Not Added.Please Try Again.');
				redirect(base_url('admin/'.$add));
			}
		}
	}
	public function editOptions()
	{
	    $id=$this->uri->segment(3);
	    $question_id=$this->uri->segment(4);
		$this->form_validation->set_rules('label','label','required');
		//$this->form_validation->set_rules('image', '', 'callback_file_check');
		if($this->form_validation->run() == false)
		{
		 $data['category'] = $this->common->getData('feedback_questions_option',array('id'=>$id),array('single'));
			$this->adminHtml('Edit Options','add-options',$data);
		}
		else
		{
			$post = $this->common->getField('feedback_questions_option',$_POST);
			$result = $this->common->updateData('feedback_questions_option',array('label'=>$_POST['label']),array('id'=>$id));
			if($result)
			{
				$this->session->set_flashdata('success','options Updated Successfully.');
				redirect(base_url('admin/viewOptions/'.$question_id));
			}
			else
			{
				$this->session->set_flashdata('danger','options Not Added.Please Try Again.');
				redirect(base_url('admin/addOptions'));
			}
		}
	}
	
	
	
	
	
	
	public function editBanner()
	{
		$id = $this->uri->segment(3);
		
		$this->form_validation->set_rules('banner_name','Banner','required');
		if($this->form_validation->run() == false){
			 $data['category'] = $this->common->getData('banner',array('id'=>$id),array('single'));
			$this->adminHtml('Add banner','add-banner',$data);
		}else{
		    			
		    			//$image = ''; 


			
			$d = $this->common->getData('banner',array('id'=>$_POST['id']),array('single'));
				
				$image = $d['image'];
			
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			}
		
			$_POST['image'] = $image;
		    
		    
			$post = $this->common->getField('banner',$_POST);
			$result = $this->common->updateData('banner',$post,array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','banner Updated Successfully.');
				redirect(base_url('admin/MensbannerList'));
			}else{
				$this->session->set_flashdata('danger','banner Not Updated.Please Try Again.');
				redirect(base_url('admin/addBanner'));
			}
		}
	}	
	public function editWomensBanner()
	{
		$id = $this->uri->segment(3);
		
		$this->form_validation->set_rules('banner_name','Banner','required');
		if($this->form_validation->run() == false){
			 $data['category'] = $this->common->getData('banner',array('id'=>$id),array('single'));
			$this->adminHtml('Add banner','add-womensbanner',$data);
		}else{
		    			
		    			//$image = ''; 


			
			$d = $this->common->getData('banner',array('id'=>$_POST['id']),array('single'));
				
				$image = $d['image'];
			
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			}
			
			
			$_POST['image'] = $image;
		    
		    
			$post = $this->common->getField('banner',$_POST);
			$result = $this->common->updateData('banner',$post,array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','banner Updated Successfully.');
				redirect(base_url('admin/womensbannerList'));
			}else{
				$this->session->set_flashdata('danger','banner Not Updated.Please Try Again.');
				redirect(base_url('admin/addWomensBanner'));
			}
		}
	}
		public function editKidsBanner()
	{
		$id = $this->uri->segment(3);
		
		$this->form_validation->set_rules('banner_name','Banner','required');
		if($this->form_validation->run() == false){
			 $data['category'] = $this->common->getData('banner',array('id'=>$id),array('single'));
			$this->adminHtml('Add banner','add-kidsbanner',$data);
		}else{
		    			
		    			//$image = ''; 


			
			$d = $this->common->getData('banner',array('id'=>$_POST['id']),array('single'));
				
				$image = $d['image'];
			
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			}
			
			$_POST['image'] = $image;
		    
		    
			$post = $this->common->getField('banner',$_POST);
			$result = $this->common->updateData('banner',$post,array('id'=>$_POST['id']));
			if($result){
				$this->session->set_flashdata('success','banner Updated Successfully.');
				redirect(base_url('admin/kidsbannerList'));
			}else{
				$this->session->set_flashdata('danger','banner Not Updated.Please Try Again.');
				redirect(base_url('admin/addKidsBanner'));
			}
		}
	}	

 //////////Upload Bulk songs //////////
	public function uploadfolder(){

     $this->adminHtml('Upload Images', 'uploadsongs-list', $data);
 
    }
   public function songsList(){
  
	
     $data['songs'] = $this->common->getData('songs',array(),array()); 
     $this->adminHtml('Songs List', 'songs-list', $data);
 
    }
    public function uploadfolder_songs(){

 if(!empty($_FILES['file']['name'][0]))
			{			    
			    	
	             $filesCount = count($_FILES['file']['name']);
	              $size = 0;

	              for($i = 0; $i < $filesCount; $i++)
	              {
		            $_FILES['image']['name']     = $_FILES['file']['name'][$i];
	                $_FILES['image']['type']     = $_FILES['file']['type'][$i];
	                $_FILES['image']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
	                $_FILES['image']['error']     = $_FILES['file']['error'][$i];
	                $_FILES['image']['size']     = $_FILES['file']['size'][$i];


	                $image = $this->common->do_upload('image','./assets/songs/');

	                	 if(isset($image['upload_data'])){
                              $images = $image['upload_data']['file_name'];
                              $img[] = $image['upload_data']['file_name'];

                        $result = $this->common->insertData('songs',array('song_name'=>$_FILES['image']['name'],'song_upload_name'=>$images));

                                } 					
        		
	              }

	              if(!empty($img)){

	              		$msg =  "1";
	             
	              }
	            
			 }else{
			 	$msg = "0";

			 } 

			 echo $msg;     

}
	/////End/////
	public function editMenCategory()
	{
		$id = $this->uri->segment(3);
		$this->form_validation->set_rules('services_category_name','Category','required');
			$this->form_validation->set_rules('services_category_price','Price','required');
		if($this->form_validation->run() == false)
		{			
			$data['category'] = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
			$this->adminHtml('Update Category','add-mencategory',$data);
		}
		else
		{
			$idd = $this->input->post('id');
				$d = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $idd), array('single'));

				$image = $d['sell_subcategory_image'];

		    	
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
		
				
			
			  
		
			$_POST['services_category_image'] = $image;
			$data['services_category_name'] = $this->input->post('services_category_name');
			$data['services_category_price'] = $this->input->post('services_category_price');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('service_men_category',$data,array('sell_subcategory_id'=>$id));

            $_POST['services_category_id']=1;
		    $_POST['sell_subcategory_name']=$data['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$data['services_category_price'];
			$posts = $this->common->getField('sell_subcategory',$_POST);
			$results = $this->common->updateData('sell_subcategory',$posts,array('sell_subcategory_id'=>$id));


			
			if($result){
				 $this->session->set_flashdata('success','Category update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/menCategoryList'),'refresh');
		}
	}
	
	
	
	public function editWomenCategory()
	{
		/*print_r($_FILES['image']);
		die;*/
		$id = $this->uri->segment(3);
		$this->form_validation->set_rules('services_category_name','Category','required');
			$this->form_validation->set_rules('services_category_price','Price','required');
		if($this->form_validation->run() == false)
		{			
			$data['category'] = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
			$this->adminHtml('Update Category','add-womencategory',$data);
		}
		else
		{

				$idd = $this->input->post('id');
				/*print_r($idd);
		         die;*/
				$d = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $idd), array('single'));

				$image = $d['sell_subcategory_image'];
			
		    	//$image='';
			if(!empty($_FILES['image'])){
				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
			
				
			
			
			
			$_POST['services_category_image'] = $image;
			$data['services_category_name'] = $this->input->post('services_category_name');
				$data['services_category_price'] = $this->input->post('services_category_price');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('service_women_category',$data,array('sell_subcategory_id'=>$id));
			
			 $_POST['services_category_id']=2;
		    $_POST['sell_subcategory_name']=$data['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$data['services_category_price'];
			$posts = $this->common->getField('sell_subcategory',$_POST);
			$results = $this->common->updateData('sell_subcategory',$posts,array('sell_subcategory_id'=>$id));


			if($result){
				 $this->session->set_flashdata('success','Category update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/womenCategoryList'),'refresh');
		}
	}	
	public function editKidsCategory()
	{
		$id = $this->uri->segment(3);
		$this->form_validation->set_rules('services_category_name','Category','required');
		if($this->form_validation->run() == false)
		{			
			$data['category'] = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
			$this->adminHtml('Update Category','add-kidscategory',$data);
		}
		else
		{	
			$idd = $this->input->post('id');
				$d = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $idd), array('single'));

				$image = $d['sell_subcategory_image'];
		    	//$image='';
			if(!empty($_FILES['image'])){

				$image1 = $this->common->do_upload('image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = $image1['upload_data']['file_name'];
				}
			} 
		
			$_POST['services_category_image'] = $image;
			$data['services_category_name'] = $this->input->post('services_category_name');
				$data['services_category_price'] = $this->input->post('services_category_price');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('service_kids_category',$data,array('sell_subcategory_id'=>$id));
			 $_POST['services_category_id']=3;
		    $_POST['sell_subcategory_name']=$data['services_category_name'];
		    $_POST['sell_subcategory_image']=$_POST['services_category_image'];
		    $_POST['sevice_price']=$data['services_category_price'];
			$posts = $this->common->getField('sell_subcategory',$_POST);
			$results = $this->common->updateData('sell_subcategory',$posts,array('sell_subcategory_id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Category update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/kidsCategoryList'),'refresh');
		}
	}
public function deleteQuestions1()
{
    	$id = $this->uri->segment(3);
    	$type = $this->uri->segment(4);
        
if($type=='User')
{
$add='FeedbackList';

}
if($type=='Provider')
{
$add='FeedbackListForprovider';
}
if($type=='Driver')
{
$add='FeedbackListFordriver';
}



    		$data = $this->common->getData('feedback_questions',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('feedback_questions',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Question deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/'.$add),'refresh');
    		   
    		    
    		}
    
}




public function deleteQuestions()
{
    	$id = $this->uri->segment(3);
        



    		$data = $this->common->getData('support_questions',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('support_questions',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Question deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/support_questions_driver'),'refresh');
    		   
    		    
    		}
    
}public function deleteQuestions_user()
{
    	$id = $this->uri->segment(3);
        



    		$data = $this->common->getData('support_questions',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('support_questions',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Question deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/support_questions_user'),'refresh');
    		   
    		    
    		}
    
}public function deleteQuestions_provider()
{
    	$id = $this->uri->segment(3);
        



    		$data = $this->common->getData('support_questions',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('support_questions',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Question deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/support_questions_provider'),'refresh');
    		   
    		    
    		}
    
}

public function deleteOptions()
{
    	    $id = $this->uri->segment(3);
    	    $question_id = $this->uri->segment(4);
    		$data = $this->common->getData('feedback_questions_option',array('id'=>$id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('feedback_questions_option',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Options deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/viewOptions/'.$question_id),'refresh');
    		   
    		    
    		}
    
}


public function deleteMenCategory()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('sell_subcategory',array('sell_subcategory_id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Category deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/menCategoryList'),'refresh');
    		   
    		    
    		}
    
}

public function deleteWomenCategory()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('sell_subcategory',array('sell_subcategory_id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Category deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/womenCategoryList'),'refresh');
    		   
    		    
    		}
    
}public function deleteKidsCategory()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('sell_subcategory',array('sell_subcategory_id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Category deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/kidsCategoryList'),'refresh');
    		   
    		    
    		}
    
}
public function deleteMensBanner()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('banner',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('banner',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Banner deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/MensBannerList'),'refresh');
    		   
    		    
    		}
    
}
public function deleteWomensBanner()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('banner',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('banner',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Banner deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/WomensBannerList'),'refresh');
    		   
    		    
    		}
    
}public function deleteKidsBanner()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('banner',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('banner',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Banner deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/KidsBannerList'),'refresh');
    		   
    		    
    		}
    
}
public function delete_provider()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('provider',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('provider',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Provider deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/providerList'),'refresh');
    		   
    		    
    		}
    
}
public function delete_driver()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('driver',array('id' => $id), array('single'));
    		if($data)
    		{
    		   	$result = $this->common->deleteData('driver',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Driver deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/driverList'),'refresh');
    		   
    		    
    		}
    
}

public function delete_vehicle()
{
    	$id = $this->uri->segment(3);
    		$data = $this->common->getData('vehicle_details',array('id' => $id), array('single'));
    		if($data)
    		{
    			$driver_id=$data['driver_id'];
    		   	$result = $this->common->deleteData('vehicle_details',array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Vehicle deleted successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/vehicleList/'.$driver_id),'refresh');
    		   
    		    
    		}
    
}




	public function edit_service_charges()
	{
		

		$this->form_validation->set_rules('charges','charges','required');
		if($this->form_validation->run() == false)
		{			
			$data['terms'] = $this->common->getData('service_charges',array('id' => '1'), array('single'));
			$this->adminHtml('Update Service charges','edit-service_charges',$data);
		}
		else
		{
			
			$data['charges'] = $this->input->post('charges');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('service_charges',$data,array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Service charges update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/edit_service_charges'),'refresh');
		}

	}
		public function edit_vendor_charges()
	{
		

		$this->form_validation->set_rules('charges','charges','required');
		if($this->form_validation->run() == false)
		{			
			$data['terms'] = $this->common->getData('vendor_charges',array('id' => '1'), array('single'));
			$this->adminHtml('Update Vendor charges','edit-vendor_charges',$data);
		}
		else
		{
			
			$data['charges'] = $this->input->post('charges');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('vendor_charges',$data,array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Vendor charges update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/edit_vendor_charges'),'refresh');
		}

	}
	public function edit_delivery_charges()
	{
		

		$this->form_validation->set_rules('charges','charges','required');
		if($this->form_validation->run() == false)
		{			
			$data['terms'] = $this->common->getData('delivery_charges',array('id' => '1'), array('single'));
			$this->adminHtml('Update Service charges','edit-service_charges',$data);
		}
		else
		{
			
			$data['charges'] = $this->input->post('charges');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('delivery_charges',$data,array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Service charges update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/edit_delivery_charges'),'refresh');
		}

	}

		public function edit_term_services()
	{
		

		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{			
			$data['terms'] = $this->common->getData('contact_about',array('id' => '3'), array('single'));
			$this->adminHtml('Update Terms and services','edit-terms',$data);
		}
		else
		{
			
			$data['data'] = $this->input->post('editor');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('contact_about',$data,array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Terms and Conditions update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/edit_term_services'),'refresh');
		}

	}


	public function edit_privacy_policy()
	{
		

		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{			
			$data['privacy'] = $this->common->getData('contact_about',array('id' => '4'), array('single'));
			$this->adminHtml('Update Terms and services','edit_privacy_policy',$data);
		}
		else
		{
			
			$data['data'] = $this->input->post('editor');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('contact_about',$data,array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Privacy Policy update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/edit_privacy_policy'),'refresh');
		}

	}


	public function edit_licenses()
	{
		

		$this->form_validation->set_rules('editor','Info','required');
		if($this->form_validation->run() == false)
		{			
			$data['licenses'] = $this->common->getData('licenses_tbl',array('id' => '1'), array('single'));
			$this->adminHtml('Update License','edit_licenses',$data);
		}
		else
		{
			
			$data['info'] = $this->input->post('editor');
			$id = $this->input->post('id');
		
			$result = $this->common->updateData('licenses_tbl',$data,array('id'=>$id));
			
			if($result){
				 $this->session->set_flashdata('success','Licenses update successfully');
			}else{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/edit_licenses'),'refresh');
		}

	}




	public function feedbackList()
	{
        $data['category'] = $this->common->getData('feedback_questions',array('user_type'=>'User'),array(''));
		$this->adminHtml('Feedback List','feedback-list',$data);
	}
		public function FeedbackListForprovider()
	{
        $data['category'] = $this->common->getData('feedback_questions',array('user_type'=>'Provider'),array(''));
		$this->adminHtml('Feedback List','feedback-list',$data);
	}
		public function FeedbackListFordriver()
	{
        $data['category'] = $this->common->getData('feedback_questions',array('user_type'=>'Driver'),array(''));
		$this->adminHtml('Feedback List','feedback-list',$data);
	}
	public function viewOptions($id)
	{
        $data['category']=$this->common->getData('feedback_questions_option',array('question_id'=>$id),array(''));
		$this->adminHtml('Option List','option-list',$data);
	}
	public function menCategoryList()
	{
		$data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>1),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Mens Category List','category-list',$data);
	}	
	public function womenCategoryList()
	{
		$data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>2),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Womens Category List','category-women-list',$data);
	}	public function kidsCategoryList()
	{
		$data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>3),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Kids Category List','category-kids-list',$data);
	}

	public function elite_mensservice($id)
	{	
		$d = $this->common->updateData('sell_subcategory',array('user_type'=>'elite'),array('sell_subcategory_id' => $id));
	  $data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>1),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Mens Category List','category-list',$data);
	}
	public function user_mensservice($id)
	{	
		$d = $this->common->updateData('sell_subcategory',array('user_type'=>'user'),array('sell_subcategory_id' => $id));
	  $data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>1),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Mens Category List','category-list',$data);
	}
		public function elite_womensservice($id)
	{	
		$d = $this->common->updateData('sell_subcategory',array('user_type'=>'elite'),array('sell_subcategory_id' => $id));
	 $data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>2),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Womens Category List','category-women-list',$data);
	}	
		public function user_womensservice($id)
	{	
		$d = $this->common->updateData('sell_subcategory',array('user_type'=>'user'),array('sell_subcategory_id' => $id));
	 $data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>2),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Womens Category List','category-women-list',$data);
	}
		public function elite_kidsservice($id)
	{	
		$d = $this->common->updateData('sell_subcategory',array('user_type'=>'elite'),array('sell_subcategory_id' => $id));
	 $data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>3),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Kids Category List','category-kids-list',$data);
	}	
	public function user_kidsservice($id)
	{	
		$d = $this->common->updateData('sell_subcategory',array('user_type'=>'user'),array('sell_subcategory_id' => $id));
	 $data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>3),array('sort_by'=>'services_category_id','sort_direction' => 'desc'));
		$this->adminHtml('Kids Category List','category-kids-list',$data);
	}
	public function MensBannerList()
	{
		$data['category'] = $this->common->getData('banner',array('services_category_id'=>1),array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('Mens Banner List','banner-list',$data);
	}
		public function WomensBannerList()
	{
		$data['category'] = $this->common->getData('banner',array('services_category_id'=>2),array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('Womens Banner List','womensbanner-list',$data);
	}	
	public function KidsBannerList()
	{
		$data['category'] = $this->common->getData('banner',array('services_category_id'=>3),array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('Kids Banner List','kidsbanner-list',$data);
	}	
	public function CustomerList()
	{
		$data['user'] = $this->common->getData('user',array('satisfy'=>'1'),array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('Satistied Customer List','user-list',$data);
	}

/*	public function subCategoryList($id)
	{
		$data['category'] = $this->common->getData('sell_subcategory',array('services_category_id'=>$id),array('sort_by'=>'sell_subcategory_id','sort_direction' => 'desc'));
		$this->adminHtml('Sub Category List','subcategory-list',$data);
	}
*/
/*	public function addSubCategory($cat_id)
	{
		$this->form_validation->set_rules('sell_subcategory_name','Sub Category','required');
		if($this->form_validation->run() == false){
			$data['category'] = $this->common->getData('sell_subcategory');
			$this->adminHtml('Add Sub Category','add-subcategory',$data);
		}else{
			$image = ''; 
			if(!empty($_FILES['category_image'])){
				$image1 = $this->common->do_upload('category_image','./assets/userfile/category/');
				
				if(isset($image1['upload_data'])){
					$image = 'assets/userfile/category/'.$image1['upload_data']['file_name'];
				}
			} 
			
			$_POST['sell_subcategory_image'] = $image;
			$_POST['services_category_id'] = $cat_id;
			$post = $this->common->getField('sell_subcategory',$_POST);
			$result = $this->common->insertData('sell_subcategory',$post);
			if($result){
				$this->session->set_flashdata('success','Sub category Added Successfully.');
				redirect(base_url('admin/subCategoryList/'.$cat_id));
			}else{
				$this->session->set_flashdata('danger','Category Not Added.Please Try Again.');
				redirect(base_url('admin/subCategoryList/'.$cat_id));
			}
		}	
	}*/



/*	public function editSubCategory()
	{
		$sub_category_id = $this->uri->segment(3);
		$category_id = $this->uri->segment(4);
		$this->form_validation->set_rules('sell_subcategory_name','Sub Category','required');
		if($this->form_validation->run() == false)
		{			
			$data['sub_category'] = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $sub_category_id), array('single'));
			$this->adminHtml('Update Sub Category','add-subcategory',$data);
		}
		else
		{
			$id = $this->input->post('id');

			if(!empty($_FILES['category_image']['name']))
            {

				$image = $this->common->do_upload('category_image','./assets/userfile/category/');
				
				
				if (isset($image['upload_data'])) 
				{

					$image = 'assets/userfile/category/'.$image['upload_data']['file_name'];
					$data['sell_subcategory_image'] = $image;
				}
				else
				{
					$this->flashMsg('danger','File formate are Not Supported');
					
					redirect(base_url('admin/subCategoryList/'.$this->input->post('services_category_id')),'refresh');
				}
			}
			else
			{
				
				$sub_category_detail = $this->common->getData('sell_subcategory',array('sell_subcategory_id' => $id), array('single'));
				$data['sell_subcategory_image']= $sub_category_detail['sell_subcategory_image'];
			}

			$data['sell_subcategory_name'] = $this->input->post('sell_subcategory_name');

			
			$data['service_delivery_type'] = $this->input->post('service_delivery_type');
			 $data['services_category_id'] = $this->input->post('services_category_id');
				
			$result = $this->common->updateData('sell_subcategory',$data,array('sell_subcategory_id'=>$id));

		

		
			
			if($result)
			{
				 $this->session->set_flashdata('success','Sub Category update successfully');
			}
			else
			{
				$this->session->set_flashdata('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/subCategoryList/'.$this->input->post('services_category_id')),'refresh');
		}
	}*/

	public function paymentHistory($userid)
	{	
		$data['payment'] = $this->paymentHistory_function($userid,$_REQUEST['type']);

		if($_REQUEST['type'] == 0){  // user
			$this->adminHtml('Payment List','payment-history',$data);
		}else{	// 1 provider
			$this->adminHtml('Payment List','payment-history-provider',$data);
		}
	}



	public function paymentHistory_provider_year($userid)
	{	
		$data['year'] = $this->get_year_payment_funation($userid);
		$data['userid'] = $userid;
		$this->adminHtml('Payment List','payment-history-provider',$data);
	}



	public function get_year_payment_funation($user_id)
	{
		
		$result = $this->common->query("SELECT DISTINCT YEAR(created_at) as year FROM payment_history where user_to = '".$user_id."'");
		if(!empty($result))
		{

			return $result;
		}
		else
		{
			$result = array();
			return $result;
		}
		
		
	}



	public function weekly_list()
	{
		$year = $this->uri->segment(3);
		$provider_id = $this->uri->segment(4);
		$data['payment_data'] = $this->payment_history_by_year_function($year,$provider_id);
		

		$this->adminHtml('Wikly List','wikley-list',$data);
	}



	function payment_history_by_year_function($year,$provider_id)
	{
		
			for ($i=1; $i < 13 ; $i++) 
			{ 
				$result_multi_week = $this->weeks_in_month($i,$year);
				
				// multi week array
				foreach ($result_multi_week as $key_multi_week => $value_multi_week) 
				{
					$result_single_week = $result_multi_week[$key_multi_week];
					$array_size_sigle_week = sizeof($result_multi_week[$key_multi_week])-1;
					$total_amount =0;
					$request_count =0;

					//week array
					foreach ($result_single_week as $key_single_week => $value_single_week) 
					{
						$where_payment = "user_to = '".$provider_id."' AND created_at LIKE '".$value_single_week."%'";
						$result_payment = $this->common->getData('payment_history',$where_payment);
						
						// data array
						if(!empty($result_payment))
						{
							foreach ($result_payment as $key_payment => $value_payment) 
							{
								$total_amount+=  $value_payment['amount'];
								$request_count++;
							}
						}
					} //  // end  week loop

					if($total_amount != 0)
					{
						$start_date =   date('F d', strtotime($result_single_week[0]));
						$end_date =   date('F d', strtotime($result_single_week[$array_size_sigle_week]));
						$main_array[] = array('total_amount'=>$total_amount,'start_date'=>$start_date,'request_count'=>$request_count,'end_date'=>$end_date);
					}
				} // end multiple week loop
			} // end month loop

			if(!empty($main_array))
			{ 
				return $main_array;
			}
			else
			{
				$main_array = array();
				return $main_array;
			}
		
	}



	function weeks_in_month($month, $year)
	{
	    $dates = [];

	    $week = 1;
	    $date = new DateTime("$year-$month-01");
	    $days = (int)$date->format('t'); // total number of days in the month

	    $oneDay = new DateInterval('P1D');

	    for ($day = 1; $day <= $days; $day++) {
	        $dates["Week $week"] []= $date->format('Y-m-d');

	        $dayOfWeek = $date->format('l');
	        if ($dayOfWeek === 'Saturday') {
	            $week++;
	        }

	        $date->add($oneDay);
	    }

	    return $dates;
	}

   function payment_history_by_year($year)
  {
    
      for ($i=1; $i < 13 ; $i++) 
      { 
        $result_multi_week = $this->weeks_in_month($i,$year);
      
        // multi week array
        foreach ($result_multi_week as $key_multi_week => $value_multi_week) 
        {
          $result_single_week = $result_multi_week[$key_multi_week];
          $array_size_sigle_week = sizeof($result_multi_week[$key_multi_week])-1;
          $total_amount =0;
          $request_count =0;

          //week array
          foreach ($result_single_week as $key_single_week => $value_single_week) 
          {
            $where_payment = "created_at LIKE '".$value_single_week."%'";
            $result_payment = $this->common->getData('payment_history',$where_payment);
            
            // data array
            if(!empty($result_payment))
            {
              foreach ($result_payment as $key_payment => $value_payment) 
              {
                $total_amount+=  $value_payment['paid_amount'];
                $request_count++;
              }
            }
          } //  // end  week loop

          if($total_amount != 0)
          {
            $start_date =   date('F d', strtotime($result_single_week[0]));
            $end_date =   date('F d', strtotime($result_single_week[$array_size_sigle_week]));
            $main_array[] = array('total_amount'=>$total_amount,'start_date'=>$start_date,'request_count'=>$request_count,'end_date'=>$end_date);
          }
        } // end multiple week loop
      } // end month loop

      if(!empty($main_array))
      { 
        return $main_array;
      }
      else
      {
        $main_array = array();
        return $main_array;
      }
    
  }
	public function earning_page()
	{
		$this->adminHtml('Earning page','earning-page');
	}

	public function paymentHistory_function($user_id,$type)
	{
		if($type == 0){  // user
			$where['user_from'] = $user_id;
			$result = $this->common->payHistory($where);
		}else{	// 1 provider
			$where['user_to'] = $user_id;
			$result = $this->common->payHistory($where);
		}
		
		if($result)
		{
			return $result;
		}
		else
		{
			$result = array();
			return $result;
		}
	}
	
		public function addVendor()
	{
		$this->form_validation->set_rules('full_name','name','required');	
		$this->form_validation->set_rules('email','email','trim|required|valid_email|is_unique[vendor.email] ',

		 		array('is_unique' => 'email already exist')

		);

		$this->form_validation->set_rules('phone_number','Phone number','trim|required|is_unique[vendor.phone_number] ',

		 		array('is_unique' => 'Phone number already exist')

		);
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('country_code','country code','required');		
		if($this->form_validation->run() == false){
			$this->adminHtml('Add Vendor','add-vendor');
		}else
		{			
			$image = $this->common->do_upload('document_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['document_image']=$image;
			}

			//$data['image'] = $this->input->post('image');
			 unset($_POST["submit"]);
			$_POST['password'] = md5($_POST['password']);
			$_POST['status']=1;
			$result = $this->common->insertData('vendor',$_POST);
			$user_id = $this->db->insert_id();			
			$email = base64_encode($_POST["email"]);
			/*$message ="<div style='font-size: 17px; font-weight: bold; background: rgb(238, 238, 238) none repeat scroll 0px 0px; color: rgb(0, 0, 0); padding: 15px 30px;'><p>Hello,</p>
				                 Please  click below link to rest your password<br><a href=".base_url().'home/resetpassword/?em='.$email.">Click here</a> to reset your password.<br>     
				                <p>Thank you,
				                <br>
				                Grahuk Team</p>";
			
			$result = $this->common->custom_send_mail($_POST['email'],'tanuja.ctinfotech@gmail.com','Reset password',$message);*/
			
			if($result){
				$this->flashMsg('success','vendor added successfully');
				redirect(base_url('admin/VendorList'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addVendor'));
			}
		}
	}
	
	public function editvendor()
	{

		$id = $this->uri->segment(3);
		$this->form_validation->set_rules('full_name','name','required');	
		$this->form_validation->set_rules('email','email','required');
		$this->form_validation->set_rules('phone_number','Phone number','required');
		$this->form_validation->set_rules('country_code','country code','required');
		$this->form_validation->set_rules('phone_number','Phone number','required');
		if($this->form_validation->run() == false){			
			$data['vendor'] = $this->common->getData('vendor',array('vendor_id' => $id), array('single'));
			$this->adminHtml('Update Vendor','add-vendor',$data);
		}else{

			 if(!empty($_FILES['document_image']['name'][0]))

              {

			
			  $image = $this->common->do_upload('document_image','./assets/userfile/profile');
			
				if (isset($image['upload_data'])) {
					$image = $image['upload_data']['file_name'];
					$_POST['document_image']=$image;
					unset($_POST["submit"]);
				}

			}		
			
			unset($_POST["submit"]);
			$id = $this->input->post('vendor_id');
		    unset($_POST["vendor_id"]);
			$result = $this->common->updateData('vendor',$_POST,array('vendor_id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','Vendor update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/VendorList'),'refresh');
		}
	}
	
	public function get_lat_long($address){
	$address = str_replace(" ", "+", $address);
    $apiKey="AIzaSyB1z--MsIgNIb29QcOu46wo-8nHYgR0I0o";
    $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false&key=AIzaSyB1z--MsIgNIb29QcOu46wo-8nHYgR0I0o");
    $json = json_decode($json);
	$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
	}
	
	
	public function addShop()
	{
		$this->form_validation->set_rules('shop_name','Shop name','required');	
	
		if($this->form_validation->run() == false){
		
			$data['vehicle_type'] = $this->common->getData('vendor',array(), array(''));
			$data['category_type'] = $this->common->getData('ondemand_category',array(), array(''));
			$this->adminHtml('Add Shop','add-shop',$data);
		}else
		{			
			$image = $this->common->do_upload('shop_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['shop_image']=$image;
			}

          $latlong=$this->get_lat_long($_POST['address']);
          
    /*      print_r($latlong);
          die;*/
                        $map=explode(',' ,$latlong);
                        $_POST['latitude']=$map[0];
                        $_POST['longitude']=$map[1]; 

			//$data['image'] = $this->input->post('image');
			 unset($_POST["submit"]);
		
			$result = $this->common->insertData('shop',$_POST);
			$user_id = $this->db->insert_id();			
			
	
			
			if($result){
				$this->flashMsg('success','Shop added successfully');
				redirect(base_url('admin/ShopList'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addShop'));
			}
		}
	}
	
	public function editShop()
	{

		$id = $this->uri->segment(3);
			$this->form_validation->set_rules('shop_name','Shop name','required');	
		
		if($this->form_validation->run() == false){

			$data['vendor'] = $this->common->getData('shop',array('id' => $id), array('single'));
			$data['vehicle_type'] = $this->common->getData('vendor',array(), array(''));
			$data['category_type'] = $this->common->getData('ondemand_category',array(), array(''));
			$this->adminHtml('Add Shop','add-shop',$data);
			
		}else{


		

			
			$image = $this->common->do_upload('shop_image','./assets/userfile/profile/');
			if (!empty($image['upload_data']['file_name'][0])) {
				$image = $image['upload_data']['file_name'];
				$_POST['shop_image']=$image;
			}

			//$data['image'] = $this->input->post('image');
			 unset($_POST["submit"]);
		
			$result = $this->common->updateData('shop',$_POST,array('id'=>$id));
			
			
			
			if($result){
				$a = $this->flashMsg('success','Shop update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/ShopList'),'refresh');
		
	}
}
public function addDriver()
	{
		$this->form_validation->set_rules('full_name','name','required');	
		$this->form_validation->set_rules('email','email','trim|required|valid_email|is_unique[vendor.email] ',

		 		array('is_unique' => 'email already exist')

		);

		$this->form_validation->set_rules('mobile_number','Mobile number','trim|required|is_unique[vendor.phone_number] ',

		 		array('is_unique' => 'Phone number already exist')

		);
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_rules('country_code','country code','required');		
		if($this->form_validation->run() == false){
			$this->adminHtml('Add Driver','add-driver');
		}else
		{			
			$image = $this->common->do_upload('profile_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['profile_image']=$image;
			}

			//$data['image'] = $this->input->post('image');
			 unset($_POST["submit"]);
			$_POST['password'] = md5($_POST['password']);
			$_POST['profile_status']=3;
			$_POST['created_at'] = date('Y-m-d H:i:s');
			$result = $this->common->insertData('driver',$_POST);
			$user_id = $this->db->insert_id();			
			$email = base64_encode($_POST["email"]);
			/*$message ="<div style='font-size: 17px; font-weight: bold; background: rgb(238, 238, 238) none repeat scroll 0px 0px; color: rgb(0, 0, 0); padding: 15px 30px;'><p>Hello,</p>
				                 Please  click below link to rest your password<br><a href=".base_url().'home/resetpassword/?em='.$email.">Click here</a> to reset your password.<br>     
				                <p>Thank you,
				                <br>
				                Grahuk Team</p>";
			
			$result = $this->common->custom_send_mail($_POST['email'],'tanuja.ctinfotech@gmail.com','Reset password',$message);*/
			
			if($result){
				$this->flashMsg('success','driver added successfully');
				redirect(base_url('admin/driverList'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addDriver'));
			}
		}
	}
	
	public function editDriver()
	{

		$id = $this->uri->segment(3);
		$this->form_validation->set_rules('full_name','name','required');	
		$this->form_validation->set_rules('email','email','required');
		$this->form_validation->set_rules('mobile_number','Phone number','required');
		$this->form_validation->set_rules('country_code','country code','required');

		if($this->form_validation->run() == false){			
			$data['vendor'] = $this->common->getData('driver',array('id' => $id), array('single'));
			$this->adminHtml('Update Driver','add-driver',$data);
		}else{

			 if(!empty($_FILES['document_image']['name'][0]))

              {

			
			  $image = $this->common->do_upload('document_image','./assets/userfile/profile');
			
				if (isset($image['upload_data'])) {
					$image = $image['upload_data']['file_name'];
					$_POST['document_image']=$image;
					unset($_POST["submit"]);
				}

			}		
			
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    unset($_POST["vendor_id"]);
			$result = $this->common->updateData('driver',$_POST,array('id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','Driver update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/DriverList'),'refresh');
		}
	}
	public function addVehicle()
	{

		$_POST['driver_id']=$this->uri->segment(3);
		$this->form_validation->set_rules('vehicle_company','vehicle company','required');	
		$this->form_validation->set_rules('model_name','model name','required');		
		if($this->form_validation->run() == false){
			$data['vendor'] = $this->common->getData('vehicle_details',array('driver_id' =>$_POST['driver_id']), array('single'));
			$data['vehicle_type'] = $this->common->getData('vehicle_type',array(), array(''));

			$this->adminHtml('Add Vehicle','add-vehicle',$data);
		}else
		{		

			$image = $this->common->do_upload('image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['image']=$image;
				$_POST['status']=1;
			}


			$image = $this->common->do_upload('licence_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['licence_image']=$image;
				$_POST['status']=2;
			}

			$image = $this->common->do_upload('licence_back_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['licence_back_image']=$image;
				$_POST['status']=2;
			}


			$image = $this->common->do_upload('insurance_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['insurance_image']=$image;
				$_POST['status']=3;
			}

			$image = $this->common->do_upload('rc_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['rc_image']=$image;
				$_POST['status']=5;
			}

			$_POST['year_of_vehicle']=$_POST['year_of_vehicle'];
			//$data['image'] = $this->input->post('image');
			 unset($_POST["submit"]);
			//$_POST['created_at'] = date('Y-m-d H:i:s');
			$result = $this->common->insertData('vehicle_details',$_POST);
			$user_id = $this->db->insert_id();			
		
			
		
			if($user_id){
				$this->flashMsg('success','Vehicle added successfully');
				redirect(base_url('admin/vehicleList/'.$_POST['driver_id']));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addVehicle/').$_POST['driver_id']);
			}
		}
	}
	
	public function editVehicle()
	{

		$id = $this->uri->segment(3);
		$_POST['driver_id']=$this->uri->segment(3);
		$this->form_validation->set_rules('vehicle_company','vehicle_company','required');	
		$this->form_validation->set_rules('model_name','model_name','required');		
		if($this->form_validation->run() == false){
			$data['vendor'] = $this->common->getData('vehicle_details',array('id' =>$id), array('single'));
			$data['vehicle_type'] = $this->common->getData('vehicle_type',array(), array(''));

			$this->adminHtml('Add Vehicle','add-vehicle',$data);
		}else
		{	

			$image = $this->common->do_upload('image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['image']=$image;
			}


			$image = $this->common->do_upload('licence_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['licence_image']=$image;
			}

			$image = $this->common->do_upload('licence_back_image','./assets/userfile/profile/');
			if (isset($image['upload_data'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['licence_back_image']=$image;
			}

			$image = $this->common->do_upload('insurance_image','./assets/userfile/profile/');
			if (!empty($image['upload_data']['file_name'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['insurance_image']=$image;
			}


			$image = $this->common->do_upload('rc_image','./assets/userfile/profile/');
			if (!empty($image['upload_data']['file_name'])) {
				$image = $image['upload_data']['file_name'];
				$_POST['rc_image']=$image;
			}


			//$data['image'] = $this->input->post('image');
			 unset($_POST["submit"]);
			//$_POST['created_at'] = date('Y-m-d H:i:s');
			$result = $this->common->updateData('vehicle_details',$_POST,array('id'=>$id));
			//$user_id = $this->db->insert_id();			
		
			 
			if($result){
				$veh=$this->common->getData('vehicle_details',array('id' =>$id), array('single'));
				$this->flashMsg('success','Vehicle Updated successfully');
				redirect(base_url('admin/vehicleList/'.$veh['driver_id']));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/editVehicle/').$id);
			}
		}
	}
	
	public function deletevendor($id){  // Tanuja created

        $result = $this->common->deleteData('vendor',array('vendor_id'=>$id));
        if($result)
        {
          $a = $this->flashMsg('success','Vendor Deleted successfully');
          redirect('admin/VendorList');
        }
	}
			public function deleteshop($id){  // Tanuja created

        $result = $this->common->deleteData('shop',array('id'=>$id));
        if($result)
        {
          $a = $this->flashMsg('success','Shop Deleted successfully');
          redirect('admin/ShopList');
        }
	}	
	public function deletecategory(){  // Meenakshi created
     $id = $this->input->post('id');
        $result = $this->common->deleteData('sell_category',array('id'=>$id));
        if($result)
        {
      		echo 1;
        }
        else
        {
        	echo 0;
        }
	}
		public function deletesubcategory(){  // Meenakshi created
			$id = $this->input->post('id');
        $result = $this->common->deleteData('sell_subcategory',array('id'=>$id));
        if($result)
        {
      		echo 1;
        }
        else
        {
        	echo 0;
        }
	}
	
	public function vendorDetail($id)
	{

		$data['vendor'] = $this->common->getData('vendor',array('vendor_id' => $id), array('single'));
	
		$this->adminHtml('Vendor Detail','admin/vendor-detail',$data);
	}
	
	public function VendorList()
	{
		
		$data['vendor'] = $this->common->getData('vendor','',array('sort_by'=>'vendor_id','sort_direction' => 'desc'));
		$data['link'] = 'admin/vendorDetail/';
		$this->adminHtml('Vendor List','admin/vendor-list',$data);
	}	public function ShopList()
	{
		
		$data['shop'] = $this->common->getData('shop',array(),array('sort_by'=>'vendor_id','sort_direction' => 'desc'));
		//$data['link'] = 'admin/vendorDetail/';
		$this->adminHtml('Shop List','admin/shop-list',$data);
	}
    public function chat()
	{

		$this->adminHtml('chat','admin/chat_view',$data);
	}


 public function search_user()
 {
  sleep(2);
  if($this->input->post('search_query'))
  {
   $data = $this->common->search_user_data($this->session->userdata('id'), $this->input->post('search_query'));
   $output = array();
   if(!empty($data))
   {
    foreach($data as $row)
    {
     //$request_status = $this->common->Check_request_status($this->session->userdata('id'), $row['id']);

 
      $output[] = array(
       'id'  =>$row['id'],
       'full_name' => $row['full_name'],
       'image'=> $row['image'],
       'user_type'=> $row['user_type'],
       'is_request_send'=> 'Accept'
      );
      
    }
   }
   echo json_encode($output);
  }
 }
 public function send_request()
 {
  sleep(2);
  if($this->input->post('send_userid'))
  {
   $data = array(
    'sender_id'  => $this->input->post('send_userid'),
    'receiver_id' => $this->input->post('receiver_userid')
   );
   $this->common->Insert_chat_request($data);
  }
 }

function load_notification()
 {
  sleep(2);
  if($this->input->post('action'))
  {
   $data = $this->common->Fetch_notification_data($this->session->userdata('id'));
   $output = array();
   if($data->num_rows() > 0)
   {
    foreach($data->result() as $row)
    {
     $userdata = $this->common->Get_user_data($row->sender_id);

     $output[] = array(
      'user_id'  => $row->sender_id,
      'first_name' => $userdata['first_name'],
      'last_name'  => $userdata['last_name'],
      'profile_picture' => $userdata['profile_picture'],
      'chat_request_id' => $row->chat_request_id
     );
    }
   }
   echo json_encode($output);
  }
 }
 
 public function accept_request()
 {
  if($this->input->post('chat_request_id'))
  {
   $update_data = array(
    'chat_request_status' => 'Accept'
   );
   $this->common->Update_chat_request($this->input->post('chat_request_id'), $update_data);
  }
 }
 
  public function load_chat_user()
  {
   sleep(2);
   if($this->input->post('action'))
   {
    $session =  $this->session->userdata('admin');
    $sender_id = 0;
    $receiver_id = '';
    $data = $this->common->Fetch_chat_user_data($sender_id);

    if(!empty($data))
    {
    foreach($data as $row)
    {
     if($row['id'] == $sender_id)
     {
      $receiver_id = $row['id'];
      if($row['user_type']=='User')
       {
       	$user_type ='user';
       } 
        if($row['user_type']=='Driver')
       {
       	$user_type ='driver';
       } 
        if($row['user_type']=='Provider')
       {
       	$user_type ='provider';
       }
   	}
     else
     {
      $receiver_id = $row['id'];
       if($row['user_type']=='User')
       {
       	$user_type ='user';
       } 
        if($row['user_type']=='Driver')
       {
       	$user_type ='driver';
       } 
        if($row['user_type']=='Provider')
       {
       	$user_type ='provider';
       }
	}
     $userdata = $this->common->Get_user_data($receiver_id,$user_type);
     $output[] = array(
      'receiver_id'  => $receiver_id,
      'first_name'  => $userdata['first_name'],
      'profile_picture' => $userdata['profile_picture'],
      'user_type' => $userdata['user_type'],
      'mobile_number' => $userdata['mobile_number']
     );
    }
   }
   echo json_encode($output);
  }
 }
 
 public function send_chat()
 {
   $session =  $this->session->userdata('admin');
   if($this->input->post('receiver_id'))
   {
   $data = array(
    'sender_id'  => 0,
    'sender_type'  => 'admin',
    'receiver_id' => $this->input->post('receiver_id'),
    'receiver_type' => $this->input->post('receiver_type'),
    'chat_messages_text' => $this->input->post('chat_message'),
    'chat_messages_status' => 'no',
    'chat_messages_datetime'=> date('Y-m-d H:i:s')
   );

   $this->common->Insert_chat_message($data);

  }
 }
 
 public function load_chat_data()
 {
  $session =  $this->session->userdata('admin');
  if($this->input->post('receiver_id'))
  {
   $receiver_id = $this->input->post('receiver_id');
   $receiver_type = $this->input->post('receiver_type');
   $session =  $this->session->userdata('admin');
   $sender_id = 0;
   $sender_type = 'admin';
   if($this->input->post('update_data') == 'yes')
   {
    $this->common->Update_chat_message_status($sender_id);
   }
   $chat_data = $this->common->Fetch_chat_data($sender_id,$sender_type, $receiver_id,$receiver_type);
   if($chat_data->num_rows() > 0)
   {
    foreach($chat_data->result() as $row)
    {
     $message_direction = '';
     if($row->sender_id == $sender_id && $row->sender_type == $sender_type)
     {
      $message_direction = 'right';
     }
     else
     {
      $message_direction = 'left';
     }
     $date = date('D M Y H:i', strtotime($row->chat_messages_datetime));
     $output[] = array(
      'chat_messages_text' => $row->chat_messages_text,
      'chat_messages_datetime'=> $date,
      'message_direction'  => $message_direction
     );
    }
   }
   echo json_encode($output);
  }
 }
 
 public function check_chat_notification()
 {
  if($this->input->post('user_id_array'))
  {
   $session =  $this->session->userdata('admin');
  
   $receiver_id = $session['id'];

   $this->common->Update_login_data();

   $user_id_array = explode(",", $this->input->post('user_id_array'));

   $output = array();

   foreach($user_id_array as $sender_id)
   {
    if($sender_id != '')
    {
     $status = "offline";
     $last_activity = $this->common->User_last_activity($sender_id);

     $is_type = '';

     if($last_activity != '')
     {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');

      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);

      if($last_activity > $current_timestamp)
      {
       $status = 'online';
       $is_type = $this->common->Check_type_notification($sender_id, $receiver_id, $current_timestamp);
      }
     }

     $output[] = array(
      'user_id'  => $sender_id,
      'total_notification' => $this->common->Count_chat_notification($sender_id, $receiver_id),
      'status'  => $status,
      'is_type'  => $is_type
     );
    }
   }
   echo json_encode($output);
  }
 }
 

public function import(){
        $data = array();
        $memData = array();
        
        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_checks');
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;
                
                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');
                    
                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    
                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row){ $rowCount++;
                            
                            // Prepare data for DB insertion
                            $memData = array(
                                'vendor_id' => 0,
                                'category' => $row['category'],
                                'name' => $row['name'],
                                'currency' => $row['currency'],
                                'regular_price' => $row['regular_price'], 
                                'sale_price' => $row['sale_price'],
                                'product_quantity' => $row['product_quantity'],
                                'product_description' => $row['product_description'],
                                'short_desc' => $row['short_desc'],
                                'long_desc' => $row['long_desc'],
                                'region' => $row['region'],
                                'ABV' => $row['ABV'],
                            );
                            
                            // Check whether email already exists in the database
                            $con = array(
                                'where' => array(
                                    'name' => $row['name']
                                ),
                                'returnType' => 'count'
                            );
                            $prevCount = $this->common->getRows($con);
                            
                            if($prevCount > 0){
                                // Update member data
                                $condition = array('name' => $row['name']);
                                $update = $this->common->update($memData, $condition);
                                
                                if($update){
                                    $updateCount++;
                                }
                            }else{
                                // Insert member data
                                $insert = $this->common->insert($memData);
                                
                                if($insert){
                                    $insertCount++;
                                }
                            }
                        }
                        
                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Members imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                        $this->session->set_userdata('success_msg', $successMsg);
                    }
                }else{
                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                }
            }else{
                $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('admin/productlist');
    }
    
    /*
     * Callback function to check file value and type during validation
     */
    public function file_checks($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }
    
    
    public function testomonials()
	{
	    $data['cat'] = $this->common->getData('testomonials',array(),array('sort_by'=>'id','sort_direction' => 'desc'));
		$this->adminHtml('Testomonials List','testomonials',$data);
	}
		public function addtestomonials()
	{

		$this->form_validation->set_rules('heading1','heading1','required');
		$this->form_validation->set_rules('heading2','heading2','required');
		if($this->form_validation->run() == false){
		    $data['cat'] = $this->common->getData('testomonials',array('id'=>$subcat_id),array('sort_by'=>'id','sort_direction' => 'desc'));
			$this->adminHtml('Add testomonials','add-testomonials',$data);
		}else
		{			
			
			 if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			 unset($_POST["submit"]);
			 
			$result = $this->common->insertData('testomonials',$_POST);
			if($result){
				$this->flashMsg('success','testomonials added successfully');
				redirect(base_url('admin/testomonials'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addtestomonials'));
			}
		}
	}	
	public function edittestomonials()
	{

		$service_id = $this->uri->segment(3);
			$this->form_validation->set_rules('heading1','heading1','required');
		$this->form_validation->set_rules('heading2','heading2','required');
		if($this->form_validation->run() == false){			
		 $data['subcat'] = $this->common->getData('testomonials');
		 $data['cat'] = $this->common->getData('testomonials',array('id' =>$service_id),array('single'));
			$this->adminHtml('Update testomonials','add-testomonials',$data);
		}else{
			
			if(isset($_FILES))
		    {
		        $video = $this->common->do_upload('image','./assets/images/');
    			if (isset($video['upload_data'])) {
    				$video = $video['upload_data']['file_name'];
    				$_POST['image']=$video;
    			} 
		    }
			unset($_POST["submit"]);
			$id = $this->input->post('id');
		    //unset($_POST["id"]);
		
			$result = $this->common->updateData('testomonials',$_POST,array('id'=>$id));		
			if($result){
				$a = $this->flashMsg('success','testomonials update successfully');
			}else{
				$this->flashMsg('danger','Some Error occured.');
			} 			
			redirect(base_url('admin/testomonials'),'refresh');
		}
	}
    
     public function adminprofile()
  {
    ///chandni 11/09/2020
     $admin_id = $this->uri->segment(3);
    $session = $this->session->userdata('admin');
    $data['admin_id'] = $admin_id ;
    $data['admin'] = $this->common->getData('admin', array(
      'id' => $admin_id) , array('single'));
  /*  $data['services'] = $this->common->getData('service_offer_subcategory', array(
      'created_by' => $admin_id) , array(''));*/
    $this->adminHtml('profile', 'profile', $data);
  }
  
  public function edit_admin_profile()
  {
    ///chandni 11/09/2020
    $session = $this->session->userdata('admin');
    $admin_id = $this->uri->segment(3);
    $this->form_validation->set_rules('first_name', 'first Name', 'required');
    $d = $this->common->getData('admin', array('id' => $admin_id),array('single'));

    if ($this->form_validation->run() == false)
    {

      $data['admin'] = $this->common->getData('admin', array('id' => $admin_id));
     
      $this->adminHtml('profile', 'profile-edit', $data);
    }
    else
    {
      
      $image = $d['image'];
      $password = $d['password'];

      if (!empty($_FILES['image']))
      {
        $image1 = $this->common->do_upload('image', './assets/userfile/profile/');
        if (isset($image1['upload_data']))
        {
          $image = $image1['upload_data']['file_name'];
        }
      }
      if (!empty($_POST['password']))
        {
          $password = md5($_POST['password']);
        }
      $_POST['image'] = $image;
      $_POST['password'] = $password;
     
      $admin_id = $_POST['admin_id'];
      $post = $this->common->getField('admin', $_POST);
      $result = $this->common->updateData('admin', $post, array('id' => $admin_id));
      if ($result)
      {
      
        $this->session->set_flashdata('success', 'Profile Updated Successfully.');
        redirect(base_url('admin/adminprofile/').$admin_id);
      }
      else
      {
        $this->session->set_flashdata('danger', 'Profile Not Updated.Please Try Again.');
        redirect(base_url('admin/admineditprofile/').$admin_id);
      }
    }
  }

  public function add_admin_profile()
  {
    ///chandni 11/09/2020
    $this->form_validation->set_rules('first_name', 'first_name', 'required');
    $this->form_validation->set_rules('last_name', 'last_name', 'required');
   /* $this->form_validation->set_rules('email','Email', 'required|trim|callback_validate_adminemail');*/
    $this->form_validation->set_rules('password', 'password', 'required');
    if ($this->form_validation->run() == false)
    {
      $data['allroles'] = $this->common->getData('permission_roles',array(''), array(''));
      $this->adminHtml('profile', 'profile-edit', $data);
    }
    else
    {

      if (!empty($_FILES['image']))
      {
        $image1 = $this->common->do_upload('image', './assets/userfile/profile/');
        if (isset($image1['upload_data']))
        {
          $image = $image1['upload_data']['file_name'];
        }
      }
      $_POST['image'] = $image;
      $_POST['password'] = md5($_POST['password']);
      if(!empty($_POST['role_id'])){
        $role_id = $_POST['role_id'];
      }
      $_POST['created_at'] = date('Y-m-d');
      $post = $this->common->getField('admin', $_POST);
      $result = $this->common->insertData('admin', $post);
      $admin_id = $this->db->insert_id();
      if ($result)
      {
        $sizeof = sizeof($role_id);
          for($i=0;$i<$sizeof;$i++){
              $datadetail = array('role_id'=>$role_id[$i],'admin_id'=>$admin_id,'created_at'=>date('Y-m-d'),'created_time'=>date('H:i:s'));
              $result1 = $this->common->insertData('user_permission_map',$datadetail);
          }

        $this->session->set_flashdata('success', 'Profile Added Successfully.');
        redirect(base_url('admin/adminprofile/').$admin_id);
      }
      else
      {
        $this->session->set_flashdata('danger', 'Profile Not Added.Please Try Again.');
        redirect(base_url('admin/admineditprofile/').$admin_id);
      }
    }
  }

     ///////Report User List  Function created by Naincy 17/08/21/////
     
     public function post_report()
     {
       $data['report'] = $this->common->getData('report_user',array('type'=>0));
		$this->adminHtml('Post Report','reportusers-list',$data);
     }
      public function artist_report()
     {
       $data['report'] = $this->common->getData('report_artist',array());
	$this->adminHtml('Artist Report ','reportartist-list',$data);
     }

      public function block_report()
     {
       $data['report'] = $this->common->getData('report_user',array());
      
		$this->adminHtml('Block User List','blockusers-list',$data);
     }

     public function unblock_report_user()
     {
     	$id = $this->uri->segment(3);

     	$artist_report = $this->uri->segment(4);
     	if(!empty($artist_report)){

     		$result = $this->common->deleteData('report_artist', array('id' =>$artist_report));
     	}
     	
       $result = $this->common->deleteData('report_user', array('id' =>$id));
       $this->session->set_flashdata('success',' User UnBlocked.');
       redirect(base_url('admin/block_report'));
    
     }

     public function block_user()
     {
     	 $id = $this->uri->segment(3);
        $d = $this->common->updateData('report_user',array('type'=>1),array('id' => $id));
		$this->session->set_flashdata('error',' User Blocked.');
		redirect(base_url('admin/post_report'));
     }
     public function block_artist()
     {
		$id = $this->uri->segment(3);
		$d =  $this->common->getData('report_artist', array('id'=>$id),array('single'));

		$arr = array("user_id"=>$d['user_id'],"block_id"=>$d['block_id'],"type"=>1,"artist_report"=>$d['id']);
		$update = $this->common->updateData('report_artist',array('status'=>1),array('id' => $id));
		$insert = $this->common->insertData('report_user',$arr);
		redirect(base_url('admin/artist_report'));
     }
    
  //    public function unblock_user()
  //    {
  //    	 $id = $this->uri->segment(3);
  //       $d = $this->common->updateData('report_user',array('type'=>0),array('id' => $id));
		// $this->session->set_flashdata('success',' User UnBlocked.');
		// redirect(base_url('admin/block_report'));
  //    }
     ////End ///
      public function addRoles()
  {
    $this->form_validation->set_rules('role_name', 'Role Name', 'required');
    $this->form_validation->set_rules('permission_id[]','Add Permission','required');
    if ($this->form_validation->run() == false)
    {
      $data['permission'] = $this->common->getData('permissions_list', array(),array(''));
      $data['allmenu'] = $this->common->getData('permission_menulist',array(''), array(''));

      $this->adminHtml('Add Roles', 'add-roles',$data);
    }
    else
    {
      
      $_POST['created_at'] = date('Y-m-d');
      if(!empty($this->input->post('permission_id'))){
        $permission_id = $this->input->post('permission_id');
      }
      $post = $this->common->getField('permission_roles', $_POST);
      $result = $this->common->insertData('permission_roles', $post);
      $role_id = $this->db->insert_id();

       if($role_id > 0){ 
        $sizeof = sizeof($permission_id);
          for($i=0;$i<$sizeof;$i++){
              $explode = explode('-', $permission_id[$i]);
              $datadetail = array('role_id'=>$role_id,'menu_id'=>$explode[0],'permission_id'=>$explode[1],'created_at'=>date('Y-m-d'));
              $result1 = $this->common->insertData('permission_role_map',$datadetail);
          }
 
        $this->session->set_flashdata('success', 'roles Added Successfully.');
        redirect(base_url('admin/roleList'));
      }
      else
      {
        $this->session->set_flashdata('danger', 'roles Not Added.Please Try Again.');
        redirect(base_url('admin/addRoles'));
      }
    }
  }
  public function graph_chart()
  {
      $data =array (
  'month' => 
  array (
    0 => '04',
    1 => '05',
    2 => '06',
    3 => '07',
  ),
  'customer' => 
  array (
    0 => 212,
    1 => 6475,
    2 => 74,
    3 => 0,
  ),
  'year' => 
  array (
    0 => '2021',
    1 => '2021',
    2 => '2021',
    3 => '2021',
  ),
  'driver_price' => 
  array (
    0 => 8,
    1 => 4483,
    2 => 30,
    3 => 0,
  ),
);
      echo json_encode($data, TRUE);
    }     
    
  public function editRoles()
  {
    $id = $this->uri->segment(3);
    $this->form_validation->set_rules('role_name', 'role_name', 'required');
     $this->form_validation->set_rules('permission_id[]','Add Permission','required');
    if ($this->form_validation->run() == false)
    {
      $data['role'] = $this->common->getData('permission_roles', array(
        'role_id' => $id) , array( 'single'));

     $data['permission'] = $this->common->getData('permissions_list', array(),array(''));
      $data['allmenu'] = $this->common->getData('permission_menulist',array(''), array(''));
      $this->adminHtml('Edit Roles Permission', 'add-roles', $data);
    }
    else
    {
      if(!empty($this->input->post('permission_id'))){
        $permission_id = $this->input->post('permission_id');
      }
      $post = $this->common->getField('permission_roles', $_POST);
      $result = $this->common->updateData('permission_roles', $post, array(
        'role_id' => $_POST['id']
      ));
      if($result)
      {
        $result1 = $this->common->deleteData('permission_role_map',array('role_id'=>$_POST['id']));
        if($result1){
            $sizeof = sizeof($permission_id);
            for($i=0;$i<$sizeof;$i++){
              $explode = explode('-', $permission_id[$i]);
                $datadetail = array('role_id'=>$_POST['id'],'menu_id'=>$explode[0],'permission_id'=>$explode[1],'created_at'=>date('Y-m-d'));
                $result11 = $this->common->insertData('permission_role_map',$datadetail);              
            }
          }

        $this->session->set_flashdata('success', 'Roles and permission Updated Successfully.');
        redirect(base_url('admin/roleList'));
      }
      else
      {
        $this->session->set_flashdata('danger', 'Roles and permission Not Added.Please Try Again.');
        redirect(base_url('admin/editRoles'));
      }
    }
  }
  public function deleteRoles()
  {
    $id = $this->uri->segment(3);
    $data = $this->common->getData('permission_roles', array('role_id' => $id),array('single'));
    if ($data)
    {
      $result = $this->common->deleteData('permission_roles', array(
        'role_id' => $id
      ));
      $result1 = $this->common->deleteData('permission_role_map', array(
        'role_id' => $id
      ));
      if ($result)
      {
        $this->session->set_flashdata('success','Roles deleted successfully');
      }
      else
      {
        $this->session->set_flashdata('danger', 'Some Error occured.');
      }
      redirect(base_url('admin/roleList') , 'refresh');
    }
  }
        public function permission_denied(){
       $this->adminHtml('Permission', 'permission_denied', $data);
    }
}
