<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class CreditCardEmi extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model('Credit_card_emi');
    }

    public function getcardemi_post()
    {
        $userid = $this->post('userid');

        $q = array('user_id' => $userid);
        $val = $this->Credit_card_emi->get_all($q)->result_array();
        $invalidUser = ['status' => 'No record found'];

        if($this->Credit_card_emi->get_all($q)->num_rows() == 0){
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

    public function addemi_post()
    {
        $user_id = $this->post('userid');
        $card_id = $this->post('card_id');
        $card_bank = $this->post('card_bank');

        $description = $this->post('description');
        $principal_amnt = $this->post('principal_amnt');
        $emi_amnt = $this->post('emi_amnt');
        $tenure = $this->post('tenure');
        $booked_date = $this->post('booked_date');
        $outstanding_principle = $this->post('outstanding_principle');
        $status = $this->post('status');

        $where = array('user_id' => $user_id);
        $data = array(
            'user_id'=>$user_id,
            'card_id'=>$card_id,
            'card_bank'=>$card_bank,
            'emi_amnt'=>$emi_amnt,
            'description'=>$description,
            'principal_amnt'=>$principal_amnt,
            'tenure'=>$tenure,
            'booked_date'=>$booked_date,
            'outstanding_principle'=>$outstanding_principle,
            'status'=>$status,
        );
    
        // echo '<prE>';
        // print_r($status);
        // exit;

        $q = array('user_id' => $user_id);
        $val = $this->Credit_card_emi->add($data);
        $invalidUser = ['status' => 'could not add'];
        
        if(!$val){
            $this->response($invalidUser, REST_Controller::HTTP_NOT_FOUND);
        }else{
            $output = $val; //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
    }

    public function updateemi_post()
    {
        $emiid = $this->post('emiid');
        $user_id = $this->post('userid');
        $card_id = $this->post('card_id');
        $card_bank = $this->post('card_bank');
        $description = $this->post('description');
        $principal_amnt = $this->post('principal_amnt');
        $emi_amnt = $this->post('emi_amnt');
        $tenure = $this->post('tenure');
        $booked_date = $this->post('booked_date');
        $outstanding_principle = $this->post('outstanding_principle');
        $status = $this->post('status');

        $where = array('id' => $emiid);
        $data = array(
            'user_id'=>$user_id,
            'card_id'=>$card_id,
            'card_bank'=>$card_bank,
            'emi_amnt'=>$emi_amnt,
            'description'=>$description,
            'principal_amnt'=>$principal_amnt,
            'tenure'=>$tenure,
            'booked_date'=>$booked_date,
            'outstanding_principle'=>$outstanding_principle,
            'status'=>$status,
        );
    
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card_emi->update($where,$data)) // call the method from the model
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

    public function deleteemi_post()
    {
        $emiid = $this->post('emiid');
       
        $where = array('id' => $emiid);
      
        $invalidUser = ['status' => 'Invalid Task'];

        if($this->Credit_card_emi->delete($where)) // call the method from the model
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
