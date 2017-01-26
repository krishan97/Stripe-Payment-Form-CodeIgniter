<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe_payment  {
	 
	function makePayment($stripeKey,$stripeToken,$amount){   // Stripe Secret Key, Stripe Token, Amount
 			try{
				require 'stripe/Stripe.php';
			 Stripe::setApiKey($stripeKey);
			 $charge =Stripe_Charge::create(array(
				"amount" => $amount*100,
				"currency" => "GBP",
				"card" =>$stripeToken,
				"description" => "pay for demo"
			));  
			 return    $arr=array('success'=>1,'error'=>0);
			}catch(Stripe_CardError $e) {
					$arr=array('error'=>1,'success'=>0,'msg'=>"Card errors are the most common type of error you should expect to handle. They result when the user enters a card that can't be charged for some reason.");	
							return $arr;
				}  catch (Stripe_InvalidRequestError $e) {
				  // Invalid parameters were supplied to Stripe's API
						 $arr=array('error'=>1,'success'=>0,'msg'=>"Invalid parameters were supplied to Stripe's API");	
							return $arr;
				} catch (Stripe_AuthenticationError $e) {
					  $arr=array('error'=>1,'success'=>0,'msg'=>"Authentication with Stripe's API failed");	
							return $arr;
				} catch (Stripe_ApiConnectionError $e) {
				  // Network communication with Stripe failed
					$arr=array('error'=>1,'success'=>0,'msg'=>"Network communication with Stripe failed");	
							return $arr;
				} catch (Stripe_Error $e) {
					$arr=array('error'=>1,'success'=>0,'msg'=>$e->getMessage());		
					return $arr;
					
				} catch (Exception $e) {
					 $arr=array('error'=>1,'success'=>0,'msg'=>"Something else happened, completely unrelated to Stripe");
						return $arr;
				}
	}

}

?>
