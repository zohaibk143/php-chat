<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('google_login_model');
	}

	function index()
	{
		$this->login();
	}

	function login()
	{
		/* $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
 
        $userIp=$this->input->ip_address();
     
        $secret = $this->config->item('google_secret');
   
        $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
		$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
         
        $status= json_decode($output, true);
			//var_dump($status);exit;
		if ($status['success']) {
			
		}else{
            $this->session->set_flashdata('flashError', 'Sorry Google Recaptcha Unsuccessful!!');
        } */
		include_once FCPATH . "vendor\\autoload.php";

		$google_client = new Google_Client();

		$google_client->setClientId('183217528467-i2mc9pnr2ql3u972kka0h8p87qvi6man.apps.googleusercontent.com');

		$google_client->setClientSecret('o3xg7mizc5tGVPDg9kCsopne');

		$google_client->setRedirectUri('http://localhost/chat/google_login/login');

		$google_client->addScope('email');

		$google_client->addScope('profile');
		
		 if ($google_client->isAccessTokenExpired()) {
			 
		 }
		if(isset($_GET["code"]))
		{ 
			$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
			//echo "<br>token:<br>";
			//var_dump($token);exit;
			//var_dump($google_client->fetchAccessTokenWithRefreshToken($token));exit;
			if(!isset($token["error"]))
			{
				$google_client->setAccessToken($token['access_token']);

				$this->session->set_userdata('access_token', $token['access_token']);

				$google_service = new Google_Service_Oauth2($google_client);

				$data = $google_service->userinfo->get();

				$current_datetime = date('Y-m-d H:i:s');

				if($this->google_login_model->Is_already_register($data['id']))
				{
					//update data
					$user_data = array(
						'login_oauth_uid' => $data['id'],
						'first_name'  => $data['given_name'],
						'last_name'   => $data['family_name'],
						'email_address'  => $data['email'],
						'profile_picture' => $data['picture'],
						'updated_at'  => $current_datetime
					);

					$this->google_login_model->Update_user_data($user_data, $data['id']);
				}
				else
				{
					//insert data
					$user_data = array(
						'login_oauth_uid' => $data['id'],
						'first_name'  => $data['given_name'],
						'last_name'   => $data['family_name'],
						'email_address'  => $data['email'],
						'profile_picture' => $data['picture'],
						'created_at'  => $current_datetime
					);

					$this->google_login_model->Insert_user_data($user_data);
				}
			
				//$this->session->set_userdata('user_data', $user_data);

				$user_id = $this->google_login_model->Get_user_id($data['id']);

				$login_data = array(
				 'user_id'  => $user_id,
				 'last_activity' => $current_datetime
				);

				$login_id = $this->google_login_model->Insert_login_data($login_data);

				$this->session->set_userdata('username', ucfirst($data['given_name']) . ' ' . ucfirst($data['family_name']));

				$this->session->set_userdata('user_id', $user_id);

				$this->session->set_userdata('login_id', $login_id);
			}
		}
		$login_button = '';
		if(!$this->session->userdata('access_token'))
		{
			//print_r($google_client->createAuthUrl());exit;
			//$login_button = '<a href="'.$google_client->createAuthUrl().'"><img width="200px" src="'.base_url().'assets/sign-in-with-google.png" /></a>';
			$login_button = '<a href="'.$google_client->createAuthUrl().'">Log In</a>';
			$data['login_button'] = $login_button;
			$this->load->view('google_login', $data);
		}
		else
		{
			/* $service = new Google_Service_PeopleService($google_client);
			$optParams = array(
			  'pageSize' => 10,
			  'personFields' => 'names,emailAddresses',
			);
			$results = $service->people_connections->listPeopleConnections('people/me', $optParams);
			print_r($results);exit; */
			redirect('chat');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('access_token');

		$this->session->unset_userdata('user_id');

		$this->session->unset_userdata('login_id');

		redirect('google_login/login');
	}
 
}
?>