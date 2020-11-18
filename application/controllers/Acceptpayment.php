<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AcceptPayment extends CI_Controller {

    private string $CustomerName;
    private string $Email;
    private int $CustomerMsisdn;
	private string $Channel;
	
	//private string $CallbackUrl;
	private  $MerchantNumber;
	private  $Amount;
    private string $Description;
    private string $ClientReference;
	private string $ReturnUrl;
	private string $CancellationUrl;

    public function ReceiveRequest(){

		header('Content-Type: application/json');

        $data      = file_get_contents('php://input');
		$curl_data = json_decode($data,true);

		 $post_data = $this->security->xss_clean($curl_data);

		 $this->MerchantNumber  = isset($post_data['MerchantNumber'])?$post_data['MerchantNumber']:null;
		 $this->Amount          = isset($post_data['Amount'])?$post_data['Amount']:null;
		 $this->ReturnUrl       = isset($post_data['ReturnUrl'])?$post_data['ReturnUrl']:"";
		 $this->CancellationUrl = isset($post_data['CancellationUrl'])?$post_data['CancellationUrl']:"";
		 $this->Description     = isset($post_data['Description'])?$post_data['Description']:null;
		 $this->ClientReference = isset($post_data['ClientReference'])?$post_data['ClientReference']:"";

		 $this->load->Model('Model_Retrieval','rt');
		 $duplicate = $this->rt->Get_data_withCondition('payment',['ClientReference'=>$this->ClientReference]);

		 if(empty($this->MerchantNumber)){
  
			echo json_encode(['responseCode'=>5000,'message' => 'Merchant Number is required','status'=>'Error','data'=>'']);

		 }elseif(!is_numeric($this->Amount)){
  
			echo json_encode(['responseCode'=>5000,'message' => 'Invalid Amount','status'=>'Error','data'=>'']);

		 }elseif(($this->Amount < 0.5)){

			echo json_encode(['responseCode'=>5000,'message' => 'Amount should be above CHS0.50 ','status'=>'Error','data'=>'']);

	 	}elseif(empty($this->Amount)){
  
			echo json_encode(['responseCode'=>5000,'message' => 'Amount is required','status'=>'Error','data'=>'']);
	  
	 	}elseif(empty($this->ReturnUrl)){
	  
			echo json_encode(['responseCode'=>5000,'message' => 'Return URL  is required','status'=>'Error','data'=>'']);
	  
		}elseif(empty($this->CancellationUrl)){
	
		echo json_encode(['responseCode'=>5000,'message' => 'Cancellation URL  is required','status'=>'Error','data'=>'']);
	
	    }elseif(empty($this->ClientReference)){

			echo json_encode(['responseCode'=>5000,'message' => 'Reference number is required','status'=>'Error','data'=>'']);
		
		}elseif(!empty($duplicate)){

			echo json_encode(['responseCode'=>5000,'message' => 'Duplicate number should be unique ','status'=>'Error','data'=>'']);
			
		}elseif(empty($this->Description)){

			echo json_encode(['responseCode'=>5000,'message' => 'Description  is required','status'=>'Error','data'=>'']);
		
		}else{
			
			$this->load->Model('Model_Insertion','mt');
			$this->load->Model('Model_Retrieval','rt');
			
			$uuid = $this->rt->GetUUID()[0]['uuid'];
			$uuid = str_replace('-', '', $uuid);

			$data = [
				     'MerchantNumber'  => $this->MerchantNumber,
					 'Amount'          => $this->Amount,
					 'ReturnUrl'       => $this->ReturnUrl,
					 'CancellationUrl' => $this->CancellationUrl,
					 'Description'     => $this->Description,
					 'ClientReference' => $this->ClientReference,
					 'checkoutId'      => $uuid
			];

			$query = $this->mt->FullInsert('payment',$data);
			
			if($query){

				$data = [
						 'checkoutUrl'     => base_url().'pay/'.$uuid,
						 'checkoutId'      => $uuid,
						 'clientReference' => $this->ClientReference,
						 'message'         => ''
				];

				echo json_encode(['responseCode'=>'0000','message' => '','status'=>'Success','data'=>$data]);

			}else{


			}
			
		}
	  
	}


	public function pay(){
		$checkoutID = $this->uri->segment(2);
		$this->load->Model('Model_Retrieval','rt');
	
		$data['info'] = $this->rt->Get_data_withCondition('payment',['checkoutId'=>$checkoutID]);
		$data['checkoutID'] = $checkoutID;
		
		if($data['info']){

		     $this->load->view('pay',$data);

	    }else{
             echo "";
		}
	}
	

	public function payment_initiate()
	{
	  if($_SERVER['REQUEST_METHOD'] != 'POST'){
		  die("404 error");
	  }

	  $this->load->Model('Model_Retrieval','rt');

	  $this->load->library('Apicall');
  
	  $post_data = $this->security->xss_clean($this->input->post());
  
	  if(empty(trim($_POST['phoneNum'])||trim($_POST['amount']))){
  
		echo json_encode(['message' => 'Please all fields are required']);
  
	  }elseif(empty($this->input->post("phoneNum"))){
  
		echo json_encode(['message'=>'Please Enter Recipient Number']);
  
	  }elseif(!is_numeric($this->input->post("phoneNum"))){
  
		echo json_encode(['message' => 'Invalid Recipient Number']);
	  
	//   }elseif(empty($this->input->post("amount"))){
  
	// 	echo json_encode(['message' => 'Please Enter an amount Eg. 10 ']);
  
	  }elseif(empty($this->input->post("network"))){
  
		echo json_encode(['message' => "Something is wrong try again"]);
  
	  }else{

		$data = $this->rt->Get_data_withCondition('payment',['checkoutId'=>$post_data['checkoutId']]);
	 
		if(!empty($data)){

			$recipientPhone = $post_data['phoneNum'];

			$other_array = [
			'action'          => 'MOMO-BILL-PAYMENT', 
			'momo_phone'      => $recipientPhone,
			'customerPhone'   => $data->MerchantNumber,
			'momo_type'       => trim($post_data['network']),
			'momo_amount'     => $data->Amount,
			'momo_token'      => $post_data['token'],
			'billCode'        => $post_data['billCode']
			];
	
			$response = $this->apicall->apirequest($other_array);
			
			//$this->paymentconfirm($transactionID,$token);

			echo $response;

	    }else{
			echo "Code has expired";
		}

	  }
  
	}
  
  
	public function paymentconfirm($transactionID,$token)
	{
	  $this->load->library('Apicall');
  
	  $post_data = $this->security->xss_clean($this->input->post());
  
		$post_array = [
		  'action'          => 'MOMO-BILL-PAYMENT', 
	      'status'          => 'true',
		  'transaction_uid' => $transactionID,
		  'token'           => $token
		];
  
	  $response = $this->apicall->apirequest($post_array);
  
	  echo $response;
	}
	 

}
