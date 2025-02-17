<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class CreditCard extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model('Credit_card');
    }

    public function getcard_post()
    {
        $userid = $this->post('userid');

        $q = array('user_id' => $userid);
        $val = $this->Credit_card->get_all($q)->result();
        $invalidUser = ['status' => 'No card found'];
        
        if($this->Credit_card->get_all($q)->num_rows() == 0){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
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
        $card_type = $this->post('card_type');
        $due_date = $this->post('due_date');
        $bill_date = $this->post('bill_date');
        $status = $this->post('status');

        $where = array('user_id' => $userid);
        $data = array(
            'user_id'=>$user_id,
            'bank_name'=>$bank_name,
            'card_number'=>$card_number,
            'credit_limit'=>$credit_limit,
            'available_limit'=>$available_limit,
            'card_type'=>$card_type,
            'due_date'=>$due_date,
            'bill_date'=>$bill_date,
            'status'=>$status,
        );
    
        $q = array('user_id' => $userid);
        $val = $this->Credit_card->add($data);
        $invalidUser = ['status' => 'Invalid User'];
        
        if(!$val){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $output = $val; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
    }

    public function updatecard_post()
    {
        $cardid = $this->post('cardid');
        $bank_name = $this->post('bank_name');
        $card_number = $this->post('card_number');
        $credit_limit = $this->post('credit_limit');
        $available_limit = $this->post('available_limit');
        $card_type = $this->post('card_type');
        $due_date = $this->post('due_date');
        $bill_date = $this->post('bill_date');
        $status = $this->post('status');

        $where = array('id' => $cardid);
        $data = array(
            'bank_name'=>$bank_name,
            'card_number'=>$card_number,
            'credit_limit'=>$credit_limit,
            'available_limit'=>$available_limit,
            'card_type'=>$card_type,
            'due_date'=>$due_date,
            'bill_date'=>$bill_date,
            'status'=>$status,
        );

       
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card->update($where,$data)) // call the method from the model
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
        $user_id = $this->post('user_id');
       
        $where = array('id' => $cardid ,'user_id'=>$user_id);
      
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card->delete($where)) // call the method from the model
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
    
}
