<?php
class DemoController extends Controller
{
	public $layout='//layouts/main';

	public function behaviors()
	{
		return array(

		);
	}

	/**
	 * Render index page
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	
	
   public function actionPaymentGlobal()
	{
		Yii::import("ext.yiiebs.EbsPayment");
		
		 
		$RETURN_URL = Yii::app()->createAbsoluteUrl("//yiiebs/demo/paymentResponse", array());
		
		$ebsPayment = new EbsPayment($RETURN_URL);
		$ebs_post = $ebsPayment->getPaymentFormParams($reference_number, $amount, $name, $address, $city, $state, $country, $postal_code, $phone);
		 
		$this->render('paymentForm', array('ebs_post'=>$ebs_post));

	}
	
	
	public function actionPaymentGlobalResponse()
	{
		Yii::import("ext.yiiebs.EbsPayment");
		$RETURN_URL = Yii::app()->createAbsoluteUrl("//yiiebs/demo/paymentGlobalResponse", array());
		
		$ebsPayment = new EbsPayment($RETURN_URL);
		
		$ebsPayment->parseResponse();
		$this->render('paymentForm', array('payment'=>$ebsPayment));
	}

	
	
	
	/**
	 * Render payment page
	 *

	 */
	public function actionPayment()
	{
		Yii::import("ext.yiiebs.EbsPayment");
		//$mode, $ACCOUNT_ID,$SECRET,$RETURN_URL, $CANCEL_URL;
		if(!Yii::app()->params['ebs']){
		}
		 
		$accountId = Yii::app()->params['ebs']['account_id'];
		$secret = Yii::app()->params['ebs']['secret'];
		$mode = Yii::app()->params['ebs']['mode'];
		 
		$RETURN_URL = Yii::app()->createAbsoluteUrl("//yiiebs/demo/paymentResponse", array());
		$CANCEL_URL = Yii::app()->createAbsoluteUrl("//yiiebs/demo/paymentResponse", array());
		$ebsPayment = new EbsPayment($mode, $accountId, $secret, $RETURN_URL, $CANCEL_URL);
		 
		$ebs_post = $ebsPayment->getParams(array('amount'=>100.00, 'reference_no'=>123));
		 
		$this->render('paymentForm', array('ebs_post'=>$ebs_post));


	}

	public function actionPaymentResponse()
	{
		Yii::import("ext.yiiebs.EbsPayment");
		$accountId = Yii::app()->params['ebs']['account_id'];
		$secret = Yii::app()->params['ebs']['secret'];
		$mode = Yii::app()->params['ebs']['mode'];
		 
		$RETURN_URL = Yii::app()->createAbsoluteUrl("//yiiebs/demo/paymentResponse", array());
		$CANCEL_URL = Yii::app()->createAbsoluteUrl("//yiiebs/demo/paymentResponse", array());
		$ebsPayment = new EbsPayment($mode, $accountId, $secret, $RETURN_URL, $CANCEL_URL);
		 
		$ebsPayment->parseResponse();
		$this->render('paymentForm', array('payment'=>$ebsPayment));
	}


	 

	/**
	 * @return string the full path to the PDF CSS file
	 */
	public function getCssFile()
	{
		return Yii::getPathOfAlias('ext.pdfable.pdfable.assets.css.pdf').'.css';
	}
}
