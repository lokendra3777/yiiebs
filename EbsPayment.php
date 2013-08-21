<?php

Yii::import("ext.yiiebs.CryptRC4");
class EbsPayment{

	public $ACCOUNT_ID = "";
	public $SECRET = "";
	public $RETURN_URL = "";
	public $CANCEL_URL = "";


	private $endpoint;
	private $mode; // TEST | LIVE

	///////Response state
	public $responseCode;  /// Response from payment gateway '0' means sucess
	public $responseMessage; // Response message from payment gateway
	public $referenceNumber;  // the merchant reference number that was passed with request
	public $gateway_transaction_id; // unique transaction id generated for this request by payment gateway


	function __construct($RETURN_URL, $CANCEL_URL=null, $ACCOUNT_ID=null,$SECRET=null,$mode = null) {
		if(!$ACCOUNT_ID){
			$this->ACCOUNT_ID  = Yii::app()->params['ebs']['account_id'];
			$this->SECRET  = Yii::app()->params['ebs']['secret'];
			$this->mode = Yii::app()->params['ebs']['mode'];
			
		}else{
			$this->ACCOUNT_ID = $ACCOUNT_ID;
			$this->SECRET = $SECRET;
			$this->mode = $mode;
		}
		
		
		$this->RETURN_URL =  $RETURN_URL."?DR={DR}";
		
		if(!$CANCEL_URL){
		   $this->CANCEL_URL =  $RETURN_URL."?DR={DR}";;
		}else{
			 $this->CANCEL_URL =  $CANCEL_URL."?DR={DR}";;
		}
		
		
		$this->endpoint =  "https://secure.ebs.in/pg/ma/sale/pay";



	}


	
	public function  parseResponse(){

		$method = "parseResponse ";


		$final = array();
		$secret_key =  $this->SECRET;	 // Your Secret Key

		$params = $_GET;

		if(isset($_GET['DR'])) {
			$DR = preg_replace("/\s/","+",$_GET['DR']);
			$rc4 = new CryptRC4($secret_key);
				

			$QueryString = $DR;
			$QueryString = base64_decode($DR,false);
			$rc4->decrypt($QueryString);
			$QueryString = explode('&',$QueryString);

				
			foreach($QueryString as $param){
				$param = explode('=',$param);
				$final[$param[0]] = urldecode($param[1]);
			}
		}

		if(!$final || count($final)==0){
			$this->responseCode = "500";
			$this->responseMessage = "Payment failure";

			return $final;
		}

		$this->responseCode = isset($final['ResponseCode'])?$final['ResponseCode']:false;
		$this->responseMessage = isset($final['ResponseMessage'])?$final['ResponseMessage']:false;
		$this->reference_number = isset($final['MerchantRefNo'])?$final['MerchantRefNo']:false;
		$this->gateway_transaction_id = isset($final['TransactionID'])?$final['TransactionID']:false;

		if($this->responseCode == '0'){
			$this->responseMessage = "Payment success - Transaction Id:".$this->gateway_transaction_id;
		}


		return $final;
			

	}

	
	
	
   public function getPaymentFormParams($reference_number, $amount, $name, $address, $city, $state, $country, $postal_code, $phone){
		$params=array();
		 
		$params['$reference_number'] = reference_number;
		$params['$amount'] = $amount;
		$params['$name'] = $name;
		$params['$address'] = $address;
		$params['$city'] = $city;
		$params['$state'] = $state;
		$params['$country'] = $country;
		$params['$postal_code'] = $postal_code;
		$params['$phone'] = $phone;
		 
		 
		$ebs_post = $this->getParams($params);
		 
		
		 
		return $ebs_post;
		 
	}

	public function getPaymentForm($reference_number, $amount, $name, $address, $city, $state, $country, $postal_code, $phone){
		$params=array();
		 
		$params['$reference_number'] = reference_number;
		$params['$amount'] = $amount;
		$params['$name'] = $name;
		$params['$address'] = $address;
		$params['$city'] = $city;
		$params['$state'] = $state;
		$params['$country'] = $country;
		$params['$postal_code'] = $postal_code;
		$params['$phone'] = $phone;
		 
		 
		$ebs_post = $this->getParams($params);
		 
		$content = Yii::app()->controller->renderPartial("//ebs/demo/paymentForm", array('ebs_post'=>$ebs_post), false);
		 
		return $content;
		 
	}
		



	public function getParams($params=array()){

		$config = Yii::app()->params['ebs'];

		$ebs_gateway = $this->endpoint;
		$account_id = $config['account_id'];
		$return_url = $this->RETURN_URL;
		$mode = $this->mode;
		$secret_key =  $config['secret'];


		$reference_no = $params['reference_no'];
		$amount = $params['amount'];



		$hash = $secret_key."|".$account_id."|".$amount."|".$reference_no."|".$return_url."|".$mode;
		$secure_hash = md5($hash);

		$ebs_post = array();

		$ebs_post['reference_no'] = $params['reference_no'];
		$ebs_post['ebs_gateway'] = $ebs_gateway;
		$ebs_post['account_id'] = $account_id;
		$ebs_post['return_url'] = $return_url;
		$ebs_post['mode'] = $mode;


		$ebs_post['amount'] = $params['amount'];

		$ebs_post['hash'] = $hash;
		$ebs_post['secure_hash'] = $secure_hash;
		$ebs_post['description'] = $params['description'];
		$ebs_post['name'] = $params['name'];

		$ebs_post['address'] = $params['address'];
		$ebs_post['city'] = $params['city'];
		$ebs_post['state'] = $params['state'];

		$ebs_post['country'] = $params['country'];
		$ebs_post['postal_code'] = $params['postal_code'];
		$ebs_post['phone'] = $params['phone'];
		$ebs_post['email'] = $params['email'];

		return $ebs_post;
			
	}

}