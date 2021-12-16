<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function checkLogin()
	{
		$admin = $this->session->userdata('admin');
		if(empty($admin)){ 
			//redirect(base_url('admin-login'));
		}else{
			redirect(base_url('admin/dashboard'));
		}
	}

	public function index()
	{		
		$this->checkLogin();
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('login');
		}else{
		           if(!empty($_POST['remember'])) {
			          $result= $this->common->updateData('admin',array('remember'=>$_POST['remember']),array('email'=>$_POST['email'],'password'=>$_POST['password']));
                      setcookie ("email", $_POST['email'], time()+ (10 * 365 * 24 * 60 * 60));  
                      setcookie ("password", $_POST['password'],  time()+ (10 * 365 * 24 * 60 * 60));
                    } else {
                      setcookie ("email","");
                      setcookie ("password","");
                    } 
		     
                    $_POST['password'] = md5($_POST['password']);
                    $result= $this->common->getData('admin',array('email'=>$_POST['email'],'password'=>$_POST['password']),array('single'));
                    $current_datetime = date('Y-m-d H:i:s');
		
			
    			if($result){
    				$this->flashMsg('success','Login Successfull');
    				$this->loginRedirect($result);
    			}else{
    				$this->flashMsg('danger','Invalid login id or password');
    				redirect(base_url('admin-login'));
    			}		
		}
	}


	public function loginRedirect($data)
	{
		//chandni 11/09/2020
	
		if($data['id'] == 1){
			$is_admin = 1;
		}else{
		   $is_admin = 0;
		}
		$admin = array( 
						'id' => $data['id'],
						'email' => $data['email'],
						'full_name' => $data['first_name']." ".$data['last_name'],
						'image' => $data['image'],
						'is_login' => true,
						'is_admin'=>$is_admin,
					
					);//chandni 11/09/2020
		$this->session->set_userdata('admin',$admin);
		redirect(base_url('admin/dashboard'));
	}

	public function logout()
	{
		$this->session->unset_userdata('admin');
		$this->session->set_flashdata('msg','Logged out successfully');
		redirect(base_url('admin-login'));
	}
}
