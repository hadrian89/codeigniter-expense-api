<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class CreditCardBill extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model('Credit_card_bill');
    }

    public function getcardbill_post()
    {
        $userid = $this->post('userid');

        $q = array('user_id' => $userid);
        $val = $this->Credit_card_bill->get_all($q)->result_array();
        $invalidUser = ['status' => 'No record found'];

        if($this->Credit_card_bill->get_all($q)->num_rows() == 0){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $newArr = [];
            $kk=0;
            $cards = array_unique(array_column($val,'card_bank'));
            foreach($cards as $v=>$card){
                $newArr[$kk]['bank']=$card;
                $newArr2 = [];
                foreach($val as $k=>$array){
                    //echo $card.'=>'.$array->card_bank.'<br/>';
                    if($array['card_bank'] === $card) {
                    array_push($newArr2,$array);
                    }
                }
                $newArr[$kk]['data']=$newArr2;
                $kk++;
            }
        
            $this->set_response($newArr, REST_Controller::HTTP_OK); //This is the respon if success
        }
    }

    public function addbill_post()
    {


        $user_id = $this->post('userid');
        $card_id = $this->post('card_id');
        $card_bank = $this->post('card_bank');
        $credit_limit = $this->post('credit_limit');
        $available_limit = $this->post('available_limit');
        $total_amnt = $this->post('total_amnt');
        $min_due = $this->post('min_due');
        $due_date = $this->post('due_date');
        $bill_date = $this->post('bill_date');
        $status = $this->post('status');

        $where = array('user_id' => $user_id);
        $data = array(
            'user_id'=>$user_id,
            'card_id'=>$card_id,
            'card_bank'=>$card_bank,
            'total_amnt'=>$total_amnt,
            'credit_limit'=>$credit_limit,
            'available_limit'=>$available_limit,
            'total_amnt'=>$total_amnt,
            'min_due'=>$min_due,
            'due_date'=>$due_date,
            'bill_date'=>$bill_date,
            'status'=>$status,
        );
    
        // echo '<prE>';
        // print_r($status);
        // exit;

        $q = array('user_id' => $user_id);
        $val = $this->Credit_card_bill->add($data);
        $invalidUser = ['status' => 'could not add'];
        
        if(!$val){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $output = $val; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
    }

    public function updatebill_post()
    {
        $billid = $this->post('billid');
        $user_id = $this->post('userid');
        $card_id = $this->post('card_id');
        $card_bank = $this->post('card_bank');
        $credit_limit = $this->post('credit_limit');
        $available_limit = $this->post('available_limit');
        $total_amnt = $this->post('total_amnt');
        $min_due = $this->post('min_due');
        $due_date = $this->post('due_date');
        $bill_date = $this->post('bill_date');
        $status = $this->post('status');

        $where = array('id' => $billid);
        $data = array(
            'user_id'=>$user_id,
            'card_id'=>$card_id,
            'card_bank'=>$card_bank,
            'total_amnt'=>$total_amnt,
            'credit_limit'=>$credit_limit,
            'available_limit'=>$available_limit,
            'total_amnt'=>$total_amnt,
            'min_due'=>$min_due,
            'due_date'=>$due_date,
            'bill_date'=>$bill_date,
            'status'=>$status,
        );
    
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card_bill->update($where,$data)) // call the method from the model
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

    public function deletebill_post()
    {
        $billid = $this->post('billid');
       
        $where = array('id' => $billid);
      
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card_bill->delete($where)) // call the method from the model
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
