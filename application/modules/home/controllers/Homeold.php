<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends Base_Controller {
	function __construct()
	{
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->helper('common');
        $this->load->helper(array('form','url','common')); 
	}
	public function index()
	{
	    $data['tittle'] = 'Home page';
	//	$this->frontHtml('Quickkitty','index',$data);
			redirect(base_url('admin_login'));
		

	}
		public function privacy()
	{
	    $data['tittle'] = 'privacy page';
	    $data['terms'] = $this->common->getData('privacy_policy_tbl',array('id'=>1),array('single'));
		$this->frontHtml('Quickkitty','privacy',$data);

	}
			public function terms_and_condition()
	{
	    $data['tittle'] = 'teams page';
	    $data['terms'] = $this->common->getData('terms_condition_tbl',array('id'=>1),array('single'));
		$this->frontHtml('Quickkitty','terms',$data);

	}
	
		public function contacts()
	{
	    $full_name=$_POST['full_name'];
	   
	    $email=$_POST['email'];
	    $message=$_POST['message'];
	    $subject=$_POST['subject'];
	   
	    
	    $_POST['created_at']=date('Y-m-d');
	    $_POST['updated_at']=date('Y-m-d');
	   $_POST['token']=uniqid();
	    
	    
	     $post = $this->common->getField('contacts',$_POST);
			$result = $this->common->insertData('contacts',$post);
			if($result){
			    /********Mail for signup***Start****/
			   
				
			   $mail = $this->common->sendMail($_POST['email'],$_POST['subject'],$_POST['message']);
			    //$this->session->set_flashdata('success','Register Successfully.');
				$this->session->set_flashdata('success','We Will Get Back To You Soon.');
				redirect(base_url('home'));
			}else{
                //$this->session->set_flashdata('danger','Not registered.Please Try Again.');
				$this->session->set_flashdata('error','There Is Some Problem.Please Try Again.');
				redirect(base_url('home'));
					
			}  
	}
	

	public function contact()
	{
	    $data['tittle'] = 'Contact page';
		$this->frontHtml('Quickkitty','contact',$data);
	}

	    
	public function aboutUs()
	{
        $data['tittle'] = 'About page';
		$this->frontHtml('Quickkitty','aboutus',$data);
	}
	
	public function features()
	{
        $data['tittle'] = 'Features page';
		$this->frontHtml('Quickkitty','features',$data);
	}
	
	public function customer()
	{
        $data['tittle'] = 'Customer page';
		$this->frontHtml('Quickkitty','customer',$data);
	}
	public function driver()
	{
        $data['tittle'] = 'Driver page';
		$this->frontHtml('Quickkitty','driver',$data);
	}
	public function serviceprovider()
	{
        $data['tittle'] = 'Serviceprovider page';
		$this->frontHtml('Quickkitty','serviceprovider',$data);
	}
	public function signin()
	{
        $data['tittle'] = 'Signin page';
		$this->frontHtml('Quickkitty','signin',$data);
	}
	
	
	/*public function register()
	{
        $data['tittle'] = 'Register page';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','register',$data);
	}*/


    public function partnerwithus()
	{
        $data['tittle'] = 'Partner With Us';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','joinus',$data);
	}

	
	public function cities()
	{
		
    // Fetch city data based on the specific state 
  
     $res=$this->common->getData('cities',array('state_id'=>$_POST['state_id']),array(''));
    // Generate HTML of city options list 
    if(!empty($res)){ 
        echo '<option value="">Select city</option>'; 
        foreach ($res as $key => $value) 	
       {  
            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">City not available</option>'; 
    } 


	}
	public function register_customer()
	{
        $data['tittle'] = 'Register page';
        $data['user_type'] = 'User';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','register',$data);
	}


	public function register_provider()
	{
        $data['tittle'] = 'Register page';
        $data['user_type'] = 'Provider';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','register',$data);
	}

	public function register_driver()
	{
        $data['tittle'] = 'Register page';
        $data['user_type'] = 'Driver';


        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','register',$data);
	}


	public function login_customer()
	{
        $data['tittle'] = 'Login page';
        $data['user_type'] = 'User';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','signin',$data);
	}

	public function login_driver()
	{
        $data['tittle'] = 'Login page';
        $data['user_type'] = 'Driver';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','signin',$data);
	}

	public function login_provider()
	{
        $data['tittle'] = 'Login page';
        $data['user_type'] = 'Provider';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','signin',$data);
	}


	public function forgetPassword_customer()
	{
        $data['tittle'] = 'Forget Password';
        $data['user_type'] = 'User';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','forget_password',$data);
	}
	
	public function forgetPassword_provider()
	{
        $data['tittle'] = 'Forget Password';
        $data['user_type'] = 'Provider';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','forget_password',$data);
	}

	public function forgetPassword_driver()
	{
        $data['tittle'] = 'Forget Password';
        $data['user_type'] = 'Driver';
        $data['state'] = $this->common->getData('states',array('country_id'=>'231'),array(''));
		$this->frontHtml('Quickkitty','forget_password',$data);
	}


public function profile_update()
	{
		$id = $this->uri->segment(3);
		$type = $this->uri->segment(4);

		if($type=='User')
		 {
              $type='user';
              $data['user'] = $this->common->getData($type,array('id'=>$id),array('single'));
 				$this->frontHtml('Quickkitty','profile-update-user',$data);
		         
			 }
			 if($type=='Driver')
			 {
              $type='driver';
              $data['user'] = $this->common->getData($type,array('id'=>$id),array('single'));

              $data['vehicle'] = $this->common->getData('vehicle_details',array('driver_id'=>$id),array('single'));

			  $this->frontHtml('Quickkitty','profile-update',$data);
			 }
			 if($type=='Provider')
			 {
			 	$type='provider';
			 	$data['user'] = $this->common->getData($type,array('id'=>$id),array('single'));
			 	$data['services'] = $this->common->getData('sell_subcategory',array('service_id'=>1),array(''));
			 	//$data['provider_services'] = $this->common->getData('provider_services',array('user_id'=>$id),array(''));
		 		$this->frontHtml('Quickkitty','profile-update-provider',$data);
			}
	}

public function login1()
	{
		//$data['user'] = $this->session->userdata('user');
		$this->form_validation->set_rules('email','email','required');
		
		if($this->form_validation->run() == false){


        $data['cat'] = $this->common->getData('user',array(),array('single'));
        $data['tittle'] = 'Register page';

		$this->frontHtml('Quickkitty','signin',$data);
		}
		else
		{
			$type = $_POST['user_type'];
			$_POST['password'] = md5($_POST['password']);

	   	  	if($type=='User')
	   	  	{

	   	  		$result = $this->common->getData('user',array('email'=>$_POST['email'],'password'=>$_POST['password']),array('single'));
		  	}
		  	if($type=='Driver')
	   	  	{

	 			$result = $this->common->getData('driver',array('email'=>$_POST['email'],'password'=>$_POST['password']),array('single'));
		 	}

		  	if($type=='Provider')
	   	  	{

	   	  		$result = $this->common->getData('provider',array('email'=>$_POST['email'],'password'=>$_POST['password']),array('single'));
		  	}

		    if($result){

		    	$admin = array( 'email' => $result['email'],
						'id' => $result['id'],
						'full_name' => $result['full_name'],
						'user_type' => $result['user_type'],
						'is_login' => true
					);
				
				$user=$this->session->set_userdata('user',$admin);

				$user=$this->session->userdata('user');

				//print_r($user['id']); die();
				
				
				$this->session->set_flashdata('success','You Are Successfully Login With Quickkitty');
        		 redirect(base_url('home/profile_update/').$user['id'].'/'.$user['user_type']);
            }else{
			
			$this->session->set_flashdata('danger','Wrong email or password');
			if($type=='User')
	   	  	{
        	 redirect(base_url('home/login_customer/'));
        	}
        	if($type=='Provider')
	   	  	{
        	 redirect(base_url('home/login_provider/'));
        	}
        	if($type=='Driver')
	   	  	{
        	 redirect(base_url('home/login_driver/'));
        	}
           }
	    }
    }

public function logout()
   {
	 $user = $this->session->userdata('user');
	 $vehicledata = $this->common->getData('vehicle_details',array('driver_id'=>$user['id']),array('single'));

	if($vehicledata['status']<5)
	{
		
	  	$msg='Greetings!

		We are glad to see you signing up with Quickkitty. You are required to fill all the mandatory details with all the picture of documents.';
	  $template = $this->load->view('template/vehicle-email',array('email' => $user['email'],'full_name'=> $user['first_name'],'msg'=>$msg),true);
		 $this->common->sendMail($user['email'],"Registered Email",$template);

	}
	
	$this->session->sess_destroy();
	$this->session->set_flashdata('msg','Logged out successfully');
	if($user['user_type']=='User')
	{
		redirect(base_url('home/login_customer'));
	}
	if($user['user_type']=='Provider')
	{
		redirect(base_url('home/login_provider'));
	}
	if($user['user_type']=='Driver')
	{
		redirect(base_url('home/login_driver'));
	}
}
public function forgetPassword()
{
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    if ($this->form_validation->run() == FALSE)
    {
      $data['title'] = 'Forget Password';
      //$this->load->view('admin_header');
      $this->frontHtml('Eula', 'forget_password', $data);
    }
    else
    {
      $user = $this->session->userdata('user');
      
      $type = $_POST['user_type'];
      
      if($type=="User")
      {
      	$data = $this->common->getData('user', array('email' => $_POST['email']), array('single'));
      }
      if($type=="Provider")
      {
      	$data = $this->common->getData('provider', array('email' => $_POST['email']), array('single'));
      }
      if($type=="Driver")
      {
      	$data = $this->common->getData('driver', array('email' => $_POST['email']), array('single'));
      }


	  if (!empty($data))
      {
        $token = $this->generateToken();
		$data['token'] = $data['id'] . $token;
        $data['name'] = $data['full_name'];
        $data['user_type'] = $data['user_type'];

       	if($data['user_type']=="User")
       	{
       		$this->common->updateData('user', array('token' => $data['token']), array('id' => $data['id']));
       	}
       	if($data['user_type']=="Provider")
       	{
       		$this->common->updateData('provider', array('token' => $data['token']), array('id' => $data['id']));
       	}
       	if($data['user_type']=="Driver")
       	{
			$this->common->updateData('driver',array('token'=>$data['token']), array('id'=>$data['id']));

       	}
       	$message = $this->load->view('template/reset-mail', $data, true);
        $mail = $this->common->sendMail($_POST['email'], 'Forgot Password', $message);
        if($mail)
        {
          $this->flashMsg('success', "Please check your email with instruction to reset your password. If you Don't receive this e-mail, please check your junk mail folder or contact us for further assistance.");
          redirect(base_url('home/forgetPassword'));
        }
        else
        {
          $this->flashMsg('danger', "Some error occured. Please try again");
          redirect(base_url('home/forgetPassword'));
        }
      }
      else
      {
      	if($type=="User")
      	{
      		$this->flashMsg('danger', "Email does not belong to any account.");
        	redirect(base_url('home/forgetPassword_customer'));
      	}
      	if($type=="Provider")
      	{
      		$this->flashMsg('danger', "Email does not belong to any account.");
        	redirect(base_url('home/forgetPassword_provider'));
      	}
      	if($type=="Driver")
      	{
      		$this->flashMsg('danger', "Email does not belong to any account.");
        	redirect(base_url('home/forgetPassword_driver'));
      	}  
      }
    }
  }

  public function generateToken()
  {
    $seed = str_split('abcdefghijklmnopqrstuvwxyz' . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized;
    $rand = '';
    foreach (array_rand($seed, 8) as $k)
    {
      $rand .= $seed[$k];
    }
    return md5(microtime() . $rand);
  }


  public function add_vehicle()
  	{
       if(isset($_FILES['image'])){
				$image = $this->common->do_upload('image','./assets/userfile/profile/');
				if(isset($image['upload_data'])){
					$_POST['image'] = $image['upload_data']['file_name'];
				}
			}
  	//$_POST['driver_id'] = $this->uri->segment(3);
	//$_POST['user_type'] = $this->uri->segment(4);
	 $_POST['color']=$_POST['color'];
	 $_POST['year_of_vehicle']=$_POST['year_of_vehicle'];
  	 $post = $this->common->getField('vehicle_details',$_POST);
	 $result = $this->common->insertData('vehicle_details',$post);
	 

	 $userid = $this->db->insert_id();
		if(!empty($result)){
				$admin = array('vehicle_id' => $userid,
	);
	$this->session->set_userdata('vehicle',$admin);
    echo $userid;
    } 
		else
		{
				echo 0;
		}

} 


public function edit_vehicle()
{

	//echo $_FILES['image1']; die();

	if(!empty($_FILES['image1'])){
		
		$image = $this->common->do_upload('image1','./assets/userfile/profile/');
			if(isset($image['upload_data'])){
			$_POST['image'] = $image['upload_data']['file_name'];
		}
	}

	$post = $this->common->getField('vehicle_details',$_POST);

	$result = $this->common->updateData('vehicle_details',$post,array('driver_id'=>$_POST['driver_id']));



	if(!empty($result)){
		$this->session->set_flashdata('success','Your data saved successfully.');
		$admin = array('vehicle_id' => $_POST['vehicle_id']);
		echo 1;
	
	    $this->session->set_userdata('vehicle',$admin);
    } 
	else
	{
		echo 0;
	}
}

public function update_vehicle()
 {
	if($_FILES['licence_image']){
	$image = $this->common->do_upload('licence_image','./assets/userfile/profile/');
		if($image['upload_data']){
			$_POST['licence_image'] = $image['upload_data']['file_name'];
		}
	}

	if($_FILES['licence_back_image']){
						
	$image = $this->common->do_upload('licence_back_image','./assets/userfile/profile/');
	if($image['upload_data']){
	$_POST['licence_back_image'] = $image['upload_data']['file_name'];
		}
	}
	$post = $this->common->getField('vehicle_details',$_POST);

	$result = $this->common->updateData('vehicle_details',$post,array('id'=>trim($_POST['vehicle_id'])));

	if(!empty($result)){
		$admin = array('vehicle_id' => $_POST['vehicle_id'],
	);
	$this->session->set_userdata('vehicle',$admin);
    echo 1;
    } 
	else
	{
		echo 0;
	}

}


public function edit_licence()
 {


	if(!empty($_FILES['licence_image1'])){
	$image = $this->common->do_upload('licence_image1','./assets/userfile/profile/');
		if($image['upload_data']){
			$_POST['licence_image'] = $image['upload_data']['file_name'];
		}
	}

	if(!empty($_FILES['licence_back_image1'])){
						
	$image = $this->common->do_upload('licence_back_image1','./assets/userfile/profile/');
	if($image['upload_data']){
	$_POST['licence_back_image'] = $image['upload_data']['file_name'];
		}
	}
	$post = $this->common->getField('vehicle_details',$_POST);

	$result = $this->common->updateData('vehicle_details',$post,array('id'=>$_POST['vehicle_id']));

	//echo $this->db->last_query(); die();


	if(!empty($result)){
		$this->session->set_flashdata('success','Your data saved successfully.');
		$admin = array('vehicle_id' => $_POST['vehicle_id'],
	);
	$this->session->set_userdata('vehicle',$admin);
    echo 1;
    } 
	else
	{
		echo 0;
	}

}





public function update_insurance()
 {
	if(isset($_FILES['insurance_image'])){
		$image = $this->common->do_upload('insurance_image','./assets/userfile/profile/');
			if(isset($image['upload_data'])){
				$_POST['insurance_image'] = $image['upload_data']['file_name'];
			}
	}
					
  	
  	 $post = $this->common->getField('vehicle_details',$_POST);
	 $result = $this->common->updateData('vehicle_details',$post,array('id'=>trim($_POST['vehicle_id'])));
	 
	if(!empty($result)){
				$admin = array('vehicle_id' => $_POST['vehicle_id'],
						
					);
		$this->session->set_userdata('vehicle',$admin);
            
            
            echo 1;
        	


		} 
		else
		{
				echo 0;
		}

}


public function edit_insurance()
 {
	if(!empty($_FILES['insurance_image1'])){
		$image = $this->common->do_upload('insurance_image1','./assets/userfile/profile/');
			if(isset($image['upload_data'])){
				$_POST['insurance_image'] = $image['upload_data']['file_name'];
			}
	}
					
  	
  	 $post = $this->common->getField('vehicle_details',$_POST);
	 $result = $this->common->updateData('vehicle_details',$post,array('id'=>trim($_POST['vehicle_id'])));
	 
	if(!empty($result)){
		$this->session->set_flashdata('success','Your data saved successfully.');
				$admin = array('vehicle_id' => $_POST['vehicle_id'],
						
					);
		$this->session->set_userdata('vehicle',$admin);
            
            
            echo 1;
        	


		} 
		else
		{
				echo 0;
		}

}






public function update_rc()
  {


			if(isset($_FILES['rc_image'])){
				$image = $this->common->do_upload('rc_image','./assets/userfile/profile/');
				if(isset($image['upload_data'])){
					$_POST['rc_image'] = $image['upload_data']['file_name'];
				}
			}
				if(isset($_FILES['rc_back_image'])){
				$image = $this->common->do_upload('rc_back_image','./assets/userfile/vehicle/');
				if(isset($image['upload_data'])){
					$_POST['rc_back_image'] = $image['upload_data']['file_name'];
				}
			}
					
  	
  	 $post = $this->common->getField('vehicle_details',$_POST);
	 $result = $this->common->updateData('vehicle_details',$post,array('id'=>trim($_POST['vehicle_id'])));
	 
		if(!empty($result)){
				$admin = array('vehicle_id' => $_POST['vehicle_id'],
		);
		$this->session->set_userdata('vehicle',$admin);
              $user = $this->common->getData('driver',array('id'=>$_POST['driver_id']),array('single'));
		            	$msg='Thanks for enrolling your application as Quickkitty Driver. Your application is under review. We will notify on your email once it is approved with all background verifications.';
					$template = $this->load->view('template/register-email',array('email' => $user['email'],'full_name' => $user['full_name'],'msg'=>$msg),true);
					$this->common->sendMail($user['email'],"Registered Email",$template);
            
            echo 1;
        	


		} 
		else
		{
				echo 0;
		}

}




public function edit_rc()
  {
	if(!empty($_FILES['rc_image1'])){
		$image = $this->common->do_upload('rc_image1','./assets/userfile/profile/');
			if(isset($image['upload_data'])){
					$_POST['rc_image'] = $image['upload_data']['file_name'];
			}
	}
	     /*if(isset($_FILES['rc_back_image'])){
				$image = $this->common->do_upload('rc_back_image','./assets/userfile/vehicle/');
				if(isset($image['upload_data'])){
					$_POST['rc_back_image'] = $image['upload_data']['file_name'];
				}
			}*/
					
  	
  	 $post = $this->common->getField('vehicle_details',$_POST);
	 $result = $this->common->updateData('vehicle_details',$post,array('id'=>trim($_POST['vehicle_id'])));
	 
		if(!empty($result)){
				$admin = array('vehicle_id' => $_POST['vehicle_id'],
		);
		$this->session->set_userdata('vehicle',$admin);
              $user = $this->common->getData('driver',array('id'=>$_POST['driver_id']),array('single'));
		            	$msg='You are details are successfully saved.';
					$template = $this->load->view('template/register-email',array('email' => $user['email'],'full_name' => $user['full_name'],'msg'=>$msg),true);
					$this->common->sendMail($user['email'],"Registered Email",$template);
            
            echo 1;
        	


		} 
		else
		{
				echo 0;
		}

}
public function resetPassword()
  {

	$this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('confPassword', 'Password Confirmation', 'required|matches[password]');
    if ($this->form_validation->run() == FALSE)
    {
      $data['title'] = 'Reset Password';
      $this->frontHtml('Eula', 'forget_password', $data);
    }
    else
    {
      $type = $_POST['user_type'];
	  $_POST['password'] = md5($_POST['password']);

	  if($type=="User")
	  {
	  	$update = $this->common->updateData('user', array('token' => "", 'password' => $_POST['password']), array('token' => $_GET['token']));
	  }
	   if($type=="Provider")
	  {
	  	$update = $this->common->updateData('provider', array('token' => "", 'password' => $_POST['password']), array('token' => $_GET['token']));
	  }
	   if($type=="Driver")
	  {
	  	$update = $this->common->updateData('driver', array('token' => "", 'password' => $_POST['password']), array('token' => $_GET['token']));
	  }
	  
	  if($update)
      {
      	if($type=="User")
      	{
      		 $this->flashMsg('success', "Password Changed Successfully");
        	 redirect(base_url('home/login_customer'));
      	}
      	if($type=="Provider")
      	{
      		 $this->flashMsg('success', "Password Changed Successfully");
        	 redirect(base_url('home/login_provider'));
      	}
      	if($type=="Driver")
      	{
      		 $this->flashMsg('success', "Password Changed Successfully");
        	 redirect(base_url('home/login_driver'));
      	}
	}
      else
      {
        $this->flashMsg('danger', "Link expired. Please reset password again");
        redirect(base_url('home/resetPassword?token='.$_GET['token']));
      }
    }
  }




  public function otp1()
{

	$this->form_validation->set_rules('otp','otp','required');
	if($this->form_validation->run() == false){
		$data['user'] = $this->session->userdata('user');

		$this->frontHtml('Quickkitty','otp',$data);

	}else
	{
	$user = $this->session->userdata('register');


	$mobile_otp =$_POST['otp'];

	//$country_code = $_POST['country_code'];
	$phone_number = $user['country_code'].$user['mobile_number'];
	//Parse
	//Sinch API Details
	$key = "11b56022-f833-4f80-96ea-9cdb5100628c";
	$secret = "oQItpJBAjEKspSfeK+sPGA==";

	//Query
	$users = "application\\" . $key . ":" . $secret;
	//$message = array('identity'=>array('type'=>'number','endpoint'=>$phone_number),'metadata'=>array('os'=>'rest','platform'=>'N/A'),'method'=>'sms');
	$message = array('method'=>'sms','sms'=>array('code'=>$mobile_otp));
	$data = json_encode($message);
	//https://verificationapi-v1.sinch.com/verification/v1/verifications
	$ch = curl_init('https://verificationapi-v1.sinch.com/verification/v1/verifications/number/'.$phone_number);
	//curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_USERPWD,$users);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	//Results
	$result = curl_exec($ch);

	if(curl_errno($ch)) {
	//echo 'Curl error: ' . curl_error($ch);
	} else {
	// echo $result;
	}
	curl_close($ch);


	//$results = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));


	$res=json_decode($result,true);

	if($res['status']=='SUCCESSFUL'){

	if($user['user_type']=='User')
	{
	$result = $this->common->insertData('user',array('email'=>$user['email'],'full_name'=>$user['full_name'],'address'=>$user['address'],'password'=>md5($user['password']),'mobile_number'=>$user['mobile_number'],'country_code'=>$user['country_code'],'date_of_birth'=>$user['date_of_birth'],'created_at'=>$user['created_at'],'state'=>$user['state'],'city'=>$user['city'],'pincode'=>$user['pincode'],'otp'=>$mobile_otp));
	$userid = $this->db->insert_id();

	if($user['email'] != ""){
	$template = $this->load->view('template/verify-email',array('email' => $user['email'],'full_name' => $user['full_name'],'id' => $userid,'user_type' => 'provider','msg'=>$msg),true);
	$this->common->sendMail($user['email'],"Registered Email",$template);
	}
	$this->session->set_flashdata('success','You Are Successfully Registered On Quickkitty');
	$this->session->sess_destroy('user');
	redirect(base_url('home/login_customer/'));
	}
	if($user['user_type']=='Provider')
	{
	$result = $this->common->insertData('provider',array('email'=>$user['email'],'full_name'=>$user['full_name'],'address'=>$user['address'],'password'=>md5($user['password']),'mobile_number'=>$user['mobile_number'],'country_code'=>$user['country_code'],'date_of_birth'=>$user['date_of_birth'],'created_at'=>$user['created_at'],'state'=>$user['state'],'city'=>$user['city'],'pincode'=>$user['pincode'],'otp'=>$mobile_otp));


	$userid = $this->db->insert_id();
	if($user['email'] != ""){
	$template = $this->load->view('template/verify-email',array('email' => $user['email'],'full_name' => $user['full_name'],'id' => $userid,'user_type' => 'provider','msg'=>$msg),true);
	$this->common->sendMail($user['email'],"Registered Email",$template);
	}
	$this->session->set_flashdata('success','You Are Successfully Registered On Quickkitty');
	$this->session->sess_destroy('user');
	redirect(base_url('home/login_provider/'));

	}
	if($user['user_type']=='Driver')
	{

	$response=$this->api_checker($user['email']);
	
	$user['password']=md5($user['password']);
	$result = $this->common->insertData('driver',array('email'=>$user['email'],'full_name'=>$user['full_name'],'address'=>$user['address'],'password'=>$user['password'],'mobile_number'=>$user['mobile_number'],'country_code'=>$user['country_code'],'date_of_birth'=>$user['date_of_birth'],'created_at'=>$user['created_at'],'state'=>$user['state'],'city'=>$user['city'],'pincode'=>$user['pincode'],'otp'=>$mobile_otp,'candidate_id'=>$response));
	$userid = $this->db->insert_id();
	if($user['email'] != ""){

	$template = $this->load->view('template/verify-email',array('email'=>$user['email'],'full_name'=>$user['full_name'],'id'=>$userid,'user_type'=>'driver','msg'=>$msg),true);
	$this->common->sendMail($user['email'],"Registered Email",$template);
	$res=$this->invitation_send($response);
	}

	$this->session->set_flashdata('success','You Are Successfully Registered On Quickkitty');
	$this->session->sess_destroy('user');
	redirect(base_url('home/login_driver/'));

	}
	}
	else{

	$this->session->set_flashdata('error','OTP does not match');
	redirect(base_url('home/register'));
	}
	}

}
public function register1()
{

	$this->form_validation->set_rules('email','email','required');
	$this->form_validation->set_rules('address','address','required');
	$this->form_validation->set_rules('mobile_number','mobile_number','required');
	if($this->form_validation->run() == false){

		$data['cat'] = $this->common->getData('user',array(),array('single'));
		$data['tittle'] = 'Register page';
		$this->session->set_flashdata('error','Please Fill All The Mandatory Fields');
		$this->frontHtml('Quickkitty','register',$data);

	}else{
	$_POST['full_name']=$_POST['first_name'].' '.$_POST['last_name'];
	unset($_POST["submit"]);
	$country_code = $_POST['country_code'];
	$phone_number = $country_code.$_POST['mobile_number'];
	//Parse
	//Sinch API Details
	$key = "11b56022-f833-4f80-96ea-9cdb5100628c";
	$secret = "oQItpJBAjEKspSfeK+sPGA==";

	//Query
	$user = "application\\" . $key . ":" . $secret;
	$message = array('identity'=>array('type'=>'number','endpoint'=>$phone_number),'metadata'=>array('os'=>'rest','platform'=>'N/A'),'method'=>'sms');
	$data = json_encode($message);
	//https://verificationapi-v1.sinch.com/verification/v1/verifications
	$ch = curl_init('https://verificationapi-v1.sinch.com/verification/v1/verifications');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_USERPWD,$user);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	//Results
	$result = curl_exec($ch);
	if(curl_errno($ch)) {
	// echo 'Curl error: ' . curl_error($ch);
	} else {
	// echo $result;
	}
	curl_close($ch);
$dob=$_POST['dday']-$_POST['dmonth']-$_POST['dyear'];
	
$arr = array($_POST['dday'],$_POST['dmonth'],$_POST['dyear']);
$dob= implode("-",$arr);


	//$result = $this->common->insertData('user',$_POST);
	$admin = array( 'email' => $_POST['email'],
	'full_name' => $_POST['full_name'],
	'user_type' => $_POST['user_type'],
	'address' => $_POST['address'],
	'state' => $_POST['state'],
	'city' => $_POST['city'],
	'pincode' => $_POST['pincode'],
	'date_of_birth' => $dob,
	'created_at'=> date('Y-m-d H:i:s'),
	'password' => $_POST['password'],
	'mobile_number' => $_POST['mobile_number'],
	'country_code' => $_POST['country_code'],
	'is_login' => true
	);

	$result=$this->session->set_userdata('register',$admin);

	$this->session->set_flashdata('success','OTP Send To Your Registered Mobile Number');
	//$this->flashMsg('success','user added successfully');
	redirect(base_url('home/otp'));

	/*$this->flashMsg('danger','Some error occured. Please try again');
	redirect(base_url('home/register1'));*/

	}

}
	    public function resend_otp()
    {
    	$user = $this->session->userdata('register');
       $country_code = $user['country_code'];
        $phone_number = $country_code.$user['mobile_number'];
        //Parse
        //Sinch API Details
        $key = "11b56022-f833-4f80-96ea-9cdb5100628c";    
            $secret = "oQItpJBAjEKspSfeK+sPGA=="; 
    
        //Query
        $user = "application\\" . $key . ":" . $secret;    
        $message = array('identity'=>array('type'=>'number','endpoint'=>$phone_number),'metadata'=>array('os'=>'rest','platform'=>'N/A'),'method'=>'sms');    
        $data = json_encode($message);    
        //https://verificationapi-v1.sinch.com/verification/v1/verifications
        $ch = curl_init('https://verificationapi-v1.sinch.com/verification/v1/verifications');    
        curl_setopt($ch, CURLOPT_POST, true);    
        curl_setopt($ch, CURLOPT_USERPWD,$user);    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));    
        //Results
        $result = curl_exec($ch);    
        if(curl_errno($ch)) {    
             // echo 'Curl error: ' . curl_error($ch);    
        } else {    
             // echo $result;    
        }   
        curl_close($ch);







        $this->session->set_flashdata('success','OTP resend successfully');
          redirect(base_url('home/otp'));
        
    }
public function otp()
{



	$this->form_validation->set_rules('otp','otp','required');
	if($this->form_validation->run() == false){
		$data['user'] = $this->session->userdata('register');

		$this->frontHtml('Quickkitty','otp',$data);

	}else
	{
	$user = $this->session->userdata('register');

        $this->webhook($user);
	$mobile_otp =$_POST['otp'];

	//$country_code = $_POST['country_code'];
	$phone_number = $user['country_code'].$user['mobile_number'];
	//Parse
	//Sinch API Details
	$key = "11b56022-f833-4f80-96ea-9cdb5100628c";
	$secret = "oQItpJBAjEKspSfeK+sPGA==";

	//Query
	$users = "application\\" . $key . ":" . $secret;
	//$message = array('identity'=>array('type'=>'number','endpoint'=>$phone_number),'metadata'=>array('os'=>'rest','platform'=>'N/A'),'method'=>'sms');
	$message = array('method'=>'sms','sms'=>array('code'=>$mobile_otp));
	$data = json_encode($message);
	//https://verificationapi-v1.sinch.com/verification/v1/verifications
	$ch = curl_init('https://verificationapi-v1.sinch.com/verification/v1/verifications/number/'.$phone_number);
	//curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_USERPWD,$users);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	//Results
	$result = curl_exec($ch);

	if(curl_errno($ch)) {
	//echo 'Curl error: ' . curl_error($ch);
	} else {
	// echo $result;
	}
	curl_close($ch);


	//$results = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));


	$res=json_decode($result,true);

	if($res['status']=='SUCCESSFUL'){

	if($user['user_type']=='User')
	{
	$result = $this->common->insertData('user',array('email'=>$user['email'],'full_name'=>$user['full_name'],'address'=>$user['address'],'password'=>md5($user['password']),'mobile_number'=>$user['mobile_number'],'country_code'=>$user['country_code'],'date_of_birth'=>$user['date_of_birth'],'created_at'=>$user['created_at'],'state'=>$user['state'],'city'=>$user['city'],'pincode'=>$user['pincode'],'otp'=>$mobile_otp));
	$userid = $this->db->insert_id();

	if($user['email'] != ""){
	$template = $this->load->view('template/verify-email',array('email' => $user['email'],'full_name' => $user['full_name'],'id' => $userid,'user_type' => 'provider','msg'=>$msg),true);
	$this->common->sendMail($user['email'],"Registered Email",$template);
	}
	$this->session->set_flashdata('success','You Are Successfully Registered On Quickkitty');
	$this->session->sess_destroy('user');
	redirect(base_url('home/login_customer/'));
	}
	if($user['user_type']=='Provider')
	{
	$result = $this->common->insertData('provider',array('email'=>$user['email'],'full_name'=>$user['full_name'],'address'=>$user['address'],'password'=>md5($user['password']),'mobile_number'=>$user['mobile_number'],'country_code'=>$user['country_code'],'date_of_birth'=>$user['date_of_birth'],'created_at'=>$user['created_at'],'state'=>$user['state'],'city'=>$user['city'],'pincode'=>$user['pincode'],'otp'=>$mobile_otp));


	$userid = $this->db->insert_id();
	if($user['email'] != ""){
	$template = $this->load->view('template/verify-email',array('email' => $user['email'],'full_name' => $user['full_name'],'id' => $userid,'user_type' => 'provider','msg'=>$msg),true);
	$this->common->sendMail($user['email'],"Registered Email",$template);
	}
	$this->session->set_flashdata('success','You Are Successfully Registered On Quickkitty');
	
	$this->session->sess_destroy('user');
	redirect(base_url('home/login_provider/'));


	}
	if($user['user_type']=='Driver')
	{

	$response=$this->api_checker($user['email']);


	$user['password']=md5($user['password']);
	$result = $this->common->insertData('driver',array('email'=>$user['email'],'full_name'=>$user['full_name'],'address'=>$user['address'],'password'=>$user['password'],'mobile_number'=>$user['mobile_number'],'country_code'=>$user['country_code'],'date_of_birth'=>$user['date_of_birth'],'created_at'=>$user['created_at'],'state'=>$user['state'],'city'=>$user['city'],'pincode'=>$user['pincode'],'otp'=>$mobile_otp,'candidate_id'=>$response));
	$userid = $this->db->insert_id();
	$res=$this->invitation_send($response);
	
	if($user['email'] != ""){

	$template = $this->load->view('template/verify-email',array('email'=>$user['email'],'full_name'=>$user['full_name'],'id'=>$userid,'user_type'=>'driver','msg'=>$msg),true);
	$this->common->sendMail($user['email'],"Registered Email",$template);
	



	}

	$this->session->set_flashdata('success','You Are Successfully Registered On Quickkitty');
	$this->session->sess_destroy('user');
	redirect(base_url('home/login_driver/'));

	}
	}
	else{

	$this->session->set_flashdata('error','OTP does not match');
	redirect(base_url('home/otp'));
	}
	}

}

	
	
	
	
	
	
	
	
	
	
	public function checkMail1()
	{
		$mail = $this->common->sendMail('devendra@mailinator.com','test','hiiii');
		echo "<pre>"; print_r($mail);
	}	
	public function checkmail()
	{
		if($_POST['user_type']=='User'){
		$user_type='user';	
		}if($_POST['user_type']=='Provider'){
		$user_type='provider';	
		}if($_POST['user_type']=='Driver'){
		$user_type='driver';	
		}


		$mail = $this->common->getData($user_type,array('email'=>$_POST['email']),array('single'));
		
		if(!empty($mail))
		{
		echo 1;
		}
		else {
			echo 0;
		}

	}
	public function checknumber()
	{
		if($_POST['user_type']=='User'){
		$user_type='user';	
		}if($_POST['user_type']=='Provider'){
		$user_type='provider';	
		}if($_POST['user_type']=='Driver'){
		$user_type='driver';	
		}

		$mail = $this->common->getData($user_type,array('country_code'=>$_POST['country'],'mobile_number'=>$_POST['phone']),array('single'));
		
		if(!empty($mail))
		{
		echo 1;
		}
		else
		{
			echo 0;
		}

	}
	public function getPage($page)
	{
		$data['page'] = $this->common->getData('pages',array('name' => $page),array('single'));
		$this->frontHtml('Eula','page',$data);
	}
   
  


  public function add_pdetail()
  {


			if(isset($_FILES['profile_image'])){
				$image = $this->common->do_upload('profile_image','./assets/userfile/profile/');
				if(isset($image['upload_data'])){
					$_POST['profile_image'] = $image['upload_data']['file_name'];
				}
			}
  	//$_POST['driver_id'] = $this->uri->segment(3);
	//$_POST['user_type'] = $this->uri->segment(4);
  	 $post = $this->common->getField('provider',$_POST);
	 $result = $this->common->updateData('provider',$post,array('id'=>$_POST['provider_id']));
	 //$userid = $this->db->insert_id();
		if(!empty($result)){
				$admin = array('vehicle_id' => $userid,
						
					);
		$this->session->set_userdata('provider',$admin);
            
            
            echo 1;
        	


		} 
		else
		{
				echo 0;
		}

}  
 public function add_udetail()
{

	if(isset($_FILES['image'])){
	$image = $this->common->do_upload('image','./assets/userfile/profile/');
	if(isset($image['upload_data'])){
	$_POST['profile_image'] = $image['upload_data']['file_name'];
	}
	}
	//$_POST['driver_id'] = $this->uri->segment(3);
	//$_POST['user_type'] = $this->uri->segment(4);
	$post = $this->common->getField('user',$_POST);
	$result = $this->common->updateData('user',$post,array('id'=>$_POST['user_id']));
	//$userid = $this->db->insert_id();
	if(!empty($result)){
	echo 1;
	}
	else
	{
	echo 0;
	}
}
 public function add_card()
  {
    require_once APPPATH."third_party/stripe/init.php";
        //set api key in above file
                
        \Stripe\Stripe::setApiKey($stripe['secret_key']);
            
        $acct =\Stripe\Token::create([
        'card' => [
        'number' => $_POST['card_no'],
        'exp_month' => $_POST['exp'],
        'exp_year' => $_POST['year'],
        'cvc' => $_POST['cvc']
        ]
        ]);
        $token = $acct['id'];
        $user = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));
            
        try
        {
            $bank = $this->common->getData('account_detail',array('user_id'=>$_POST['user_id'],'user_type'=>'user'),array('single'));
            if(!empty($bank) && $bank['card_id'] == "")
            {
                $acct = \Stripe\Customer::create(array(
                        "card" => $token,
                        "description" => "Description",
                        "email" => $user['email']
                    ));
                

            $this->common->updateData('account_detail',array('card_id' => $acct->id,'card_holder'=>$_POST['card_holder']),array('user_id'=>$_POST['user_id']));
                $card_id = $acct->id;
            }

            
            if(!empty($bank) && $bank['card_id'] != "")
            {
                $customer = \Stripe\Customer::retrieve($bank['card_id']);
                //$src = $customer->sources->create(array("source" => $token));

                    $stripe = new \Stripe\StripeClient(
                    $stripe['secret_key']
                    );
                    $src=$stripe->customers->createSource(
                    $bank['card_id'],
                    ['source' => $token]
                    );


                $this->common->updateData('account_detail',array('card_holder'=>$_POST['card_holder']),array('user_id'=>$_POST['user_id'],'user_type'=>'user'));
                $card_id = $src->id;
                  echo 1;

            }
            
            if(empty($bank))
            {
                $acct = \Stripe\Customer::create(array(
                        "card" => $token,
                        "description" => "Description",
                        "email" =>$user['email']
                    ));
                
                $stripe_bank_token = array('user_id' => $_POST['user_id'],'user_type' => 'user','card_id' => $acct->id,'card_holder' => $_POST['card_holder']);

                $card_id = $acct->id;
                $this->common->insertData('account_detail',$stripe_bank_token);                
            }

            $result = $card_id;
              //$this->response(true,"Card Added Successfully");
            echo 1;
        }
        catch (Exception $e)
        {
            $errormsg= "Card information wrong ". $e->getMessage();
            /*$result = $errormsg;
             $this->response(false,$errormsg); */
             echo 0;
        } 





} 
  public function update_pdetail()
  {


			if(isset($_FILES['business_document'])){
				$image = $this->common->do_upload('business_document','./assets/userfile/profile/');
				if(isset($image['upload_data'])){
					$_POST['business_document'] = $image['upload_data']['file_name'];
				}
			}
  	//$_POST['driver_id'] = $this->uri->segment(3);
	//$_POST['user_type'] = $this->uri->segment(4);
  	 $post = $this->common->getField('provider',$_POST);
	 $result = $this->common->updateData('provider',$post,array('id'=>$_POST['provider_id']));
	 //$userid = $this->db->insert_id();
		if(!empty($result)){
				$admin = array('vehicle_id' => $userid,
						
					);
		$this->session->set_userdata('provider',$admin);
            
            
            echo 1;
        	


		} 
		else
		{
				echo 0;
		}

}  
 public function update_services()
  {

		$_POST['services']=explode(',', $_POST['services']);
		$_POST['cost']=explode(',', $_POST['cost']);

		   
			$provi = $this->common->getData('provider_services',array('user_id'=>$_POST['user_id']),array('single'));

           if(!empty($provi)){

             $delete = $this->common->deleteData('provider_services',array('user_id'=>$_POST['user_id']));
            } 	

			foreach ($_POST['services'] as $key => $value) {

				$result = $this->common->insertData('provider_services',array('user_id'=>$_POST['user_id'],'services'=>$value,'cost'=>$_POST['cost'][$key]));

				 $userid[] = $this->db->insert_id();
			}

		 if(!empty($userid)){
             echo 1;
		 } 
		 else
		 {
		 		echo 0;
		 }

} 




   public function add_provider_calender()
   {
        
   
      	$_POST['slot_days']=explode(',', $_POST['slot_days']);
      	$_POST['slot_start_time']=explode(',', $_POST['slot_start_time']);
      	$_POST['slot_end_time']=explode(',', $_POST['slot_end_time']);




            $id = $_POST['provider_id'];
            $provi = $this->common->getData('slot',array('user_id'=>$id,'service_id'=>$_POST['service_id']),array(''));
            if(!empty($provi)){
            $delete = $this->common->deleteData('slot',array('user_id'=>$id,'service_id'=>$_POST['service_id']));
            } 		
            if(!empty($_POST)){
            $slots =  $_POST['slots'];
            $slot_days = $_POST['slot_days'];
            $open = $_POST['Open'];
            $slot_start_time = array_filter($_POST['slot_start_time']);
            $slot_end_time = array_filter($_POST['slot_end_time']);
            $DaySelection = "All";
            $duration = $_POST['duration'];
            $sizeof = sizeof($_POST['slot_start_time']);
            
            
            for($i=0;$i<$sizeof;$i++){
            
            if(empty($_POST['slot_end_time'][$i]))
            {
            $json_encode='[]';
            }
            else
            {
            $slotsarray = $this->getServiceScheduleSlots($duration,$_POST['slot_start_time'][$i],$_POST['slot_end_time'][$i]);
            $json_encode = json_encode($slotsarray,true);
            }
            
            $array = array(
            'user_id'=>$id,
            'user_type'=>"Provider",
            'slots'=> $json_encode,
            'slot_days'=> $slot_days[$i],
            'slot_start_time'=>$_POST['slot_start_time'][$i],
            'slot_end_time'=>$_POST['slot_end_time'][$i],
            'created_at'=>date('d-M-Y'),
            'DaySelection'=>$DaySelection,
            'duration'=>$duration,
            'Open'=> $open,
            'service_id'=> $_POST['service_id'],
            );
            
            
            $result = 	$this->common->insertData('slot',$array);
            $userid[] = $this->db->insert_id();
            
            
            }
		            if(!empty($userid)){



		            	$user = $this->common->getData('provider',array('id'=>$id),array('single'));
		            	$msg='Thanks for enrolling your application as Quickkitty Service Provider. You re application is under review. We will notify on your email once it is approved with all background verifications.';
					$template = $this->load->view('template/register-email',array('email' => $user['email'],'full_name' => $user['full_name'],'msg'=>$msg),true);
					$this->common->sendMail($user['email'],"Registered Email",$template);
		            	echo 1;
		            
		            }
		            else
		            {
		            	echo 0;
		            }
            
            }
        }


        /*public function newsletter()
	    {
	 	  $this->form_validation->set_rules('email','email','required');	
		  if($this->form_validation->run() == false){
			$this->adminHtml('Home','home');
		}else
		 {			
			$_POST['password'] = md5($_POST['email']);
			$result = $this->common->insertData('driver',$_POST);
			if($result){
				$this->flashMsg('success','driver added successfully');
				redirect(base_url('admin/driverList'));
			}else{
				$this->flashMsg('danger','Some error occured. Please try again');
				redirect(base_url('admin/addDriver'));
			}
		 }
	    }

*/




        public function getServiceScheduleSlots($duration,$start,$end)
        {
            $ReturnArray = array ();// Define output
            $StartTime    = strtotime ($start); //Get Timestamp
            $EndTime      = strtotime ($end); //Get Timestamp
            
            $AddMins  = $duration * 60;
            
            while ($StartTime <= $EndTime) //Run loop
            {
            $ReturnArray[] = date ("G:i", $StartTime);
            $StartTime += $AddMins; //Endtime check
            }
            if($ReturnArray[0]=='0:00'){
            $ReturnArray=array();
            }
            return $ReturnArray;
        }


public function card_detail()
{
   

  if(!empty($_POST['stripeToken'])){



						$user = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));


						$payment_id = $statusMsg = ''; 
						$ordStatus = 'error'; 
						 
						// Check whether stripe token is not empty 
						if(!empty($_POST['name'])){ 
						     
						    // Retrieve stripe token, card and user info from the submitted form data 
						    $token  = $_POST['stripeToken']; 
						    $name = $_POST['name']; 
						    $email = $user['email']; 

						    // Include Stripe PHP library 
						   require_once APPPATH."third_party/stripe/init.php";
				        //set api key in above file
				                
				        \Stripe\Stripe::setApiKey($stripe['secret_key']);
						     
						    // Add customer to stripe 
						    try { 
						    						    
						    						    

						        $customer = \Stripe\Customer::create(array( 
						            'email' => $email, 
						            'source'  => $token 
						        )); 
						        	  $stripe_bank_token = array('user_id' => $_POST['user_id'],'user_type' => 'user','card_id' => $customer->id,'card_holder' => $_POST['name']);

                    //$card_id = $customer->id;
                    $this->common->insertData('account_detail',$stripe_bank_token);  

              $user = $this->common->getData('user',array('id'=>$_POST['user_id']),array('single'));
		            	$msg='Thanks for Joining us a Quickkitty Customer. Quickkitty promises to cater all your On demand services and deliveries.';
					$template = $this->load->view('template/register-email',array('email' => $user['email'],'full_name' => $user['full_name'],'msg'=>$msg),true);
					$this->common->sendMail($user['email'],"Registered Email",$template);




                    		echo 1;
                           //$this->session->set_flashdata('success', 'Card Details Added Successfully');

                           
						    }catch(Exception $e) {  

                   
						        $api_error = $e->getMessage();  
						         //$this->session->set_flashdata('error', 'Invalid card details! '.$api_error);

                              echo 2;

						    } 
						               
               
						    }else{ 

                  
                    //$this->session->set_flashdata('error', 'Error on form submission.');
						    echo 3;
						    } 
						   
						
		         }
 
		/* print_r($customer);
		 die;*/
}


public function verify()
{
 $id = $this->uri->segment(3);
 $type = $this->uri->segment(4);

 $result = $this->common->updateData($type,array('email_active'=>1),array('id'=>$id));
$this->session->set_flashdata('success','Successfully verify.');
if($type=='User')
		 {
             redirect(base_url('home/login_customer'));
		         
			 }
			 if($type=='Driver')
			 {
              redirect(base_url('home/login_driver'));
			 }
			 if($type=='Provider')
			 {
			 	redirect(base_url('home/login_provider'));
			}

		
		else
		{
$this->session->set_flashdata('danger','Not verify.');
			redirect(base_url('home'));
		}


				

}





public function api_checker($email)
{

$apikey='e81a7781f0133882bdf604b6a2b3860d39d67e5a';
$apikeyy=base64_encode($apikey);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.checkr.com/v1/candidates",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 1,
  CURLOPT_TIMEOUT => 3,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\n".$email."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic ".$apikeyy,
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "postman-token: a02a1e22-c2b7-6d75-0a06-631c45538be9"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return "cURL Error #:" . $err;
} else {

	$res=json_decode($response,true);
  return $res['id'];
}

}



public function invitation_send($candidate_id)
{
$apikey='e81a7781f0133882bdf604b6a2b3860d39d67e5a';
$apikeyy=base64_encode($apikey);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.checkr.com/v1/invitations",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 1,
  CURLOPT_TIMEOUT => 3,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"candidate_id\"\r\n\r\n".$candidate_id."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"package\"\r\n\r\ndriver_basic\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",

  CURLOPT_HTTPHEADER => array(
    "authorization: Basic ".$apikeyy,
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "postman-token: 71f977ef-0866-7265-42c3-f6f1dcc6783e"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return "cURL Error #:" . $err;
} else {
return $response;
	//$re=json_decode($response);
  //print_r($re['invitation_url']);
}


}


public function webhook($data)
{

$url = 'https://hooks.zapier.com/hooks/catch/5107867/oppvu0e/';

// Create a new cURL resource
$ch = curl_init($url);

// Setup request to send json via POST

$payload = json_encode(array("user" => $data));

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

// Close cURL resource
curl_close($ch);
	
}
}

