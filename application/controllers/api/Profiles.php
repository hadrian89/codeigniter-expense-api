<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Profiles extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        // $this->load->model('Credit_card');
        $this->load->model('Users');
        $this->load->model('Profile');
    }

    public function getprofile_post()
    {
        $userid = $this->post('userid');
        
        $q = array('user_id' => $userid);
        $q1 = array('id' => $userid);
        $val = $this->Profile->get($q)->row();
        $invalidUser = ['status' => 'Invalid User'];
        
        if($this->Profile->get($q)->num_rows() == 0){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $users = $this->Users->get_user($q1)->row();
            $val->mobile = $users->mobile; 
            $output = $val; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
    }

    public function addcard_post()
    {
        $user_id = $this->post('userid');
        $bank_name = $this->post('bank_name');
        $card_number = $this->post('card_number');
        $credit_limit = $this->post('credit_limit');
        $available_limit = $this->post('available_limit');
        $status = $this->post('status');

        $where = array('user_id' => $userid);
        $data = array(
            'user_id'=>$user_id,
            'bank_name'=>$bank_name,
            'card_number'=>$card_number,
            'credit_limit'=>$credit_limit,
            'available_limit'=>$available_limit,
            'status'=>$status,
        );
    
        // echo '<prE>';
        // print_r($status);
        // exit;

        $q = array('user_id' => $userid);
        $val = $this->Credit_card->add($data);
        $invalidUser = ['status' => 'Invalid User'];
        
        if(!$val){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $output['cards'] = $val; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
    }

    public function updateprofile_post()
    {
        $userid = $this->post('userid');
        $firstname = $this->post('firstname');
        $lastname = $this->post('lastname');
        $dob = $this->post('dob');
        $email = $this->post('email');
        $pan = $this->post('pan');

        $where = array('user_id' => $userid);
        $data = array(
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'dob'=>$dob,
            'email'=>$email,
            'pan'=>$pan,
        );
    
        $invalidUser = ['status' => 'Could not update'];

        if($this->Profile->update($where,$data)) // call the method from the model
        {
            // update successful
            $output = 'success'; //This is the output token
                $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else
        {
            // update not successful
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }

    }

    public function deletecard_post()
    {
        $cardid = $this->post('cardid');
       
        $where = array('id' => $cardid);
      
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card->delete($where)) // call the method from the model
        {
            // update successful
            $output['cards'] = 'success'; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else
        {
            // update not successful
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
}
