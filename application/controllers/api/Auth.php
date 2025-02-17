<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Users');
        $this->load->model('Profile');
    }

    

    public function login_post()
    {
        $u = $this->post('username'); //Username Posted
        $p = sha1($this->post('password')); //Pasword Posted
        $q = array('username' => $u); //For where query condition
        $kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid
        $val = $this->Users->get_user($q)->row(); //Model to get single data row from database base on username
        
       
        if($this->Users->get_user($q)->num_rows() == 0){
            $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
		$match = $val->password;   //Get password for user from database
        if($p == $match){  //Condition if password matched
        	$token['id'] = $val->id;  //From here
            $token['username'] = $u;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
            $output['token'] = JWT::encode($token,$kunci ); //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }
    }


    public function registration_post()
    {
        $u = $this->post('username'); //Username Posted
        $mobile = $this->post('mobile');
        $p = sha1($this->post('password')); //Pasword Posted
        $q = array('username' => $u); //For where query condition
        //$kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Already registered']; //Respon if login invalid
        
       
        if($this->Users->get_user($q)->num_rows() != 0){
            $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
        $data = array(
            'username'=>$u,
            'mobile'=>$mobile,
            'password'=>$p,
            'status'=>'1',
            'create_time'=>date('Y-m-d H:i:s')
        );

        // echo '<pre>';
        // print_r($data);
        // exit;

        $val = $this->Users->register($data); //Model to get single data row from database base on username
        
        if($val && $val >0){  //Condition if password matched
            $this->Profile->add(array('user_id'=>$val));
        	$output['userid'] = $val; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else {
            $this->set_response("Error while register", REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }
    }

}
