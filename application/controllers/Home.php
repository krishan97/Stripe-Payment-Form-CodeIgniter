<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
        private $stripeSecretKey="sk_test_VuN2YncnftMNDEH4f6YN6BTK"; // Stripe Secret Key
        private $stripePublishKey="pk_test_LbKbT3LNV00JQhBa1iN46uqU"; // Stripe Publishable Key
          public function __construct() { 
	         parent::__construct(); 
	          $this->load->helper(array('form','url')); 
	          $this->load->library(array('form_validation'));
	 }
	public function index()
	{
	        $arr['title']='Stripe Payment | Secure Payment Form';
	        $arr['stripePublishKey']=$this->stripePublishKey;
	        $arr['error']='';
	        $arr['success']='';
	        $this->form_validation->set_rules('cardholdername',"Card Holder's Name",'trim|required');
	        if($this->form_validation->run()==TRUE){
	                 $stripeToken=$this->input->post('stripeToken');
			 $price='30'; 	 //$this->input->post('price') Static price
			 $this->load->library('stripe_payment'); // load stripe payment libaray
		 $response=$this->stripe_payment->makePayment($this->stripeSecretKey,$stripeToken,$price); // call the stripe payment function 
		         if($response['success']==1){  // stripe success
		                $arr['success']= 'Your payment was successful.';
			   $this->load->view('index',$arr);
		         }else if($response['error']==1){  // stripe error
					$data['error']=$response['msg'];
					$this->load->view('index',$data);
				}else{
				        $data['error']='Something goes wrong';
					$this->load->view('index',$data);
			}
			 
		}else{
		        $this->load->view('index',$arr);	
		}
	}
}
