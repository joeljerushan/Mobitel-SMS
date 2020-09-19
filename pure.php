<?php 
  $number = isset($_GET['jcu']);
  $message = isset($_GET['message']);

  if ($number && $message) {
    //create a session with mobitel given username & password
    $session = createSession('','USERNAME','PASSWORD','');

    //send message with created session like this
    sendMessages($session, 'YOUR MASK', $message, array($number), 0);

    //close session & check your phone ;) 
    closeSession($session);
  } else {
    //there is nothing to show here so leave it null
      echo 'nothing to show here!';
  }
  
  //here magic happens DO NOT CHANGE ANYTHING FOR GOD's SAKE
  function getClient()
  {
    ini_set("soap.wsdl_cache_enabled", "0");
    $client = new SoapClient("http://smeapps.mobitel.lk:8585/EnterpriseSMSV3/EnterpriseSMSWS?wsdl");
    return $client;
  }
  
  //create session before send SMS 
  function createSession($id,$username,$password,$customer)
  {
    $client = getClient();
    $user = new stdClass();
    $user->id = $id;
    $user->username = $username;
    $user->password = $password;
    $user->customer = $customer;
    $createSession = new stdClass();
    $createSession->user = $user;
    $createSessionResponse = new stdClass();
    $createSessionResponse = $client->createSession($createSession);
    return $createSessionResponse->return;
  }
  
  //send SMS to number or numbers (you know what i mean!)
  function sendMessages($session,$alias,$message,$recipients,$messageType)
  {
    $client=getClient();
    $smsMessage= new stdClass();
    $smsMessage->message=$message;
    $smsMessage->messageId="";
    $smsMessage->recipients=$recipients;
    $smsMessage->retries="";
    $smsMessage->sender=$alias;
    $smsMessage->messageType=$messageType;
    $smsMessage->sequenceNum="";
    $smsMessage->status="";
    $smsMessage->time="";
    $smsMessage->type="";
    $smsMessage->user="";
    $sendMessages = new stdClass();
    $sendMessages->session = $session;
    $sendMessages->smsMessage = $smsMessage;
    $sendMessagesResponse = new stdClass();
    $sendMessagesResponse = $client->sendMessages($sendMessages);
    return $sendMessagesResponse->return;
  }
  
  //dont forget close session after you use it! 
  function closeSession($session)
  {
    $client = getClient();
    $closeSession = new stdClass();
    $closeSession->session = $session;
    $client->closeSession($closeSession);
  }

?>
