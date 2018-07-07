<?php 
namespace App\Library;
use \stdClass as stdClass;
use \SoapClient as SoapClient;

class MobitelSms  {
    /**
     * Make client well Mobitel has made their backend with SoapClient we just want to include it on our class
     * @return SoapClient
    */
    public function bridge(){
        ini_set("soap.wsdl_cache_enabled", "0");
        $bridge = new SoapClient("http://smeapps.mobitel.lk:8585/EnterpriseSMS/EnterpriseSMSWS.wsdl");
        return $bridge;
    }

    /**
     * This will Make new session to Fire SMS 
     * @return SessionResponse from Mobitel 
    */
    public function sessionMake(){

        //make bridge connection with mobitel before access Session
        $bridge = $this->bridge();

        //create customer with username & password provided by Mobitel
        $customer = new stdClass();
        $customer->id = ''; //ingore this Mobitel will take care of this 
        $customer->username = 'USERNAME';
        $customer->password = 'PASSWORD';
        $customer->customer = ''; //ingore this that;s Mobitel's stuff :P

        //create session for you / your customer based on credintials 
        $makeSession = new stdClass();
        $makeSession->arg0 = $customer;

        //new object for session response from Mobitel
        $makeSessionResponse = new stdClass();

        //map session response with Soap aka Bridge 
        $makeSessionResponse = $bridge->createSession($makeSession);

        //well what else you need you are ready to go ;) 
        return $makeSessionResponse->return;
    }



    public function fireSms($session, $text, $number){
        $client = $this->bridge(); //get client

        $aliasObj=new stdClass();
        $aliasObj->alias="ALIAS";
        $aliasObj->customer="";
        $aliasObj->id="";

        $smsMessage= new stdClass();
        $smsMessage->message=$text;
        $smsMessage->messageId="";
        $smsMessage->recipients=$number;
        $smsMessage->retries="";
        $smsMessage->sender=$aliasObj;
        $smsMessage->sequenceNum="";
        $smsMessage->status="";
        $smsMessage->time="";
        $smsMessage->type="";
        $smsMessage->user="";

        $sendMessages=new stdClass();
        $sendMessages->arg0=$session;
        $sendMessages->arg1=$smsMessage;

        $sendMessagesResponse=new stdClass();
        $sendMessagesResponse=$client->sendMessages($sendMessages);

        return $sendMessagesResponse->return;
    }

    public function sessionRenew($session){
        $client = $this->bridge(); //get client

        $renewSession=new stdClass();
        $renewSession->arg0=$session;
        $renewSessionResponse=new stdClass();
        $renewSessionResponse=$client->renewSession($renewSession);
        
        return $renewSessionResponse;
    }

    public function sessionClose($session){
        $client = $this->bridge(); //get client

        $closeSession=new stdClass();
        $closeSession->arg0=$session;
        $client->closeSession($closeSession);
    }

    public function sessionCheck($session){
        $client = $this->bridge(); //get client

        $isSession= new stdClass();
        $isSession->arg0=$session;
        $isSessionResponse=new stdClass();
        $isSessionResponse= $client->isSession($isSession);
        return $isSessionResponse;
    }

    public function statusCheck(){
        $client = $this->bridge(); //get client
        $user = new stdClass();
        $user->id = '';
        $user->username='USERNAME';
        $user->password='PASSWORD';
        $user->customer = '';
        $serviceTest=new stdClass();
        $serviceTest->arg0=$user;
        return $client->serviceTest($serviceTest);
    }

    public function statusDelivery($session, $alias){
        $client = $this->bridge(); //get client
        $aliasObj=new stdClass();
        $aliasObj->alias=$alias;
        $getDeliveryReports=new stdClass();
        $getDeliveryReports->arg0=$session;
        $getDeliveryReports->arg1=$aliasObj;
        $getDeliveryReportsResponse=new stdClass();
        $getDeliveryReportsResponse->return="";
        $getDeliveryReportsResponse=$client->getDeliveryReports($getDeliveryReports);
        if(property_exists($getDeliveryReportsResponse,'return'))
        return $getDeliveryReportsResponse->return;
        else return NULL;
    }
}
