<?php

$smtphost = "smtp.falconide.com";
$smtpusername = "workabroadfal";
$smtpassword = "f03%ba0fbcb48";
$smtpport = "25";

$smtphost_high = "";


$email_data = array(
        "to"    => "charm@workabroad.ph",
        "cc"     => "",
        "bcc"     => "",
        "subject"   => "Charm Local Test",
        "from"    => "syria@workabroad.ph",
        "from_name" => "WorkAbroad",
        "msg"   => "This is a test only",
        "file_list" => "",
        "file_path" => ""
);

sendViaMailer($email_data);


function sendViaMailer_High_Volume($data) {

  global $smtphost_high,$smtpusername,$smtpassword,$smtpport;
  require_once("PHPMailerAutoload.php");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $smtphost_high;
    $mail->Username = $smtpusername;
    $mail->Password = $smtpassword;
    $mail->Port = $smtpport;
    $mail->SMTPDebug = 3;

  if($data['from'] == 'admin@workabroad.ph'){
      $data['from'] = 'noreply@workabroad.ph';
    }else{
      $data['from'] = $data['from'];
    }

    $fromEMAIL = explode(";",$data['from']);
    $from = $fromEMAIL[0];
    $mail->FromName = $data['from_name'];
    $mail->From = $from;

   $emails = preg_split("/(,|;)/", $data['to']);
   for($e = 0; $e < count($emails); $e++){
     if($emails[$e]) {
       $mail->AddAddress($emails[$e]);
     }
   }
    if($data['cc']) {
      $emailscc = preg_split("/(,|;)/", $data['cc']);
      for($c = 0; $c < count($emailscc); $c++){
        if($emailscc[$c]) {
          $mail->AddCC($emailscc[$c]);
        }
      }
    }
    if($data['bcc']) {
      $emailsbcc = preg_split("/(,|;)/", $data['bcc']);
      for($b = 0; $b < count($emailsbcc); $b++){
        if($emailsbcc[$b]) {
          $mail->AddBCC($emailsbcc[$b]);
        }
      }
    }

    /** Attachment from form directly
     1. $_FILES['uploadname'];
    **/
    if($data['file_list']){
      if(is_array($data['file_list']['name'])){
        $total = count($data['file_list']['name']);
        for($i=0;$i<$total;$i++){
          if($data['file_list']['error'][$i] == UPLOAD_ERR_OK){
            $mail->AddAttachment($data['file_list']['tmp_name'][$i],
                                     $data['file_list']['name'][$i]);
          }
        }
      }
      else{
          if($data['file_list']['error'] == UPLOAD_ERR_OK){
            $mail->AddAttachment($data['file_list']['tmp_name'],
                                     $data['file_list']['name']);
          }
      }
    }

    /** Attachment from remote/local path **/
    if($data['file_path']){
      if(is_array($data['file_path'])){
        $total = count($data['file_path']);
        for($i=0;$i<$total;$i++){
          $arrFile = explode("/", $data['file_path'][$i]);
          $filename = end($arrFile);
          $mail->AddStringAttachment(file_get_contents($data['file_path'][$i]), $filename);
        }
      }
      else{
        $arrFile = explode("/", $data['file_path']);
        $filename = end($arrFile);
        $mail->AddStringAttachment(file_get_contents($data['file_path']), $filename);
      }
    }

    $mail->AddReplyTo($from);
    $mail->IsHTML(true);


    $mail->Subject = $data['subject'];
    $mail->AltBody = "This is the body in plain text for non-HTML mail clients";      
    $mail->Body = stripslashes($data['msg']);


    $ext = 0;
    if($mail->Send()){
      return true;
    } else {
      return false;
    }
    $mail->ClearAddresses();
  }

function sendViaMailer($data) {

  global $smtphost,$smtpusername,$smtpassword,$smtpport;
  require_once("PHPMailerAutoload.php");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $smtphost;
    $mail->Username = $smtpusername;
    $mail->Password = $smtpassword;
    $mail->Port = $smtpport;
    $mail->SMTPDebug = 3;

  if($data['from'] == 'admin@workabroad.ph'){
      $data['from'] = 'noreply@workabroad.ph';
    }else{
      $data['from'] = $data['from'];
    }

    $fromEMAIL = explode(";",$data['from']);
    $from = $fromEMAIL[0];
    $mail->FromName = $data['from_name'];
    $mail->From = $from;

   $emails = preg_split("/(,|;)/", $data['to']);
   for($e = 0; $e < count($emails); $e++){
     if($emails[$e]) {
       $mail->AddAddress($emails[$e]);
     }
   }
    if($data['cc']) {
      $emailscc = preg_split("/(,|;)/", $data['cc']);
      for($c = 0; $c < count($emailscc); $c++){
        if($emailscc[$c]) {
          $mail->AddCC($emailscc[$c]);
        }
      }
    }
    if($data['bcc']) {
      $emailsbcc = preg_split("/(,|;)/", $data['bcc']);
      for($b = 0; $b < count($emailsbcc); $b++){
        if($emailsbcc[$b]) {
          $mail->AddBCC($emailsbcc[$b]);
        }
      }
    }
    if($data['file_list']){
      if(is_array($data['file_list']['name'])){
        $total = count($data['file_list']['name']);
        for($i=0;$i<$total;$i++){
          if($data['file_list']['error'][$i] == UPLOAD_ERR_OK){
            $mail->AddAttachment($data['file_list']['tmp_name'][$i],
                                     $data['file_list']['name'][$i]);
          }
        }
      }
      else{
          if($data['file_list']['error'] == UPLOAD_ERR_OK){
            $mail->AddAttachment($data['file_list']['tmp_name'],
                                     $data['file_list']['name']);
          }
      }
    }

    if($data['file_path']){
      if(is_array($data['file_path'])){
        $total = count($data['file_path']);
        for($i=0;$i<$total;$i++){
          $arrFile = explode("/", $data['file_path'][$i]);
          $filename = end($arrFile);
          $mail->AddStringAttachment(file_get_contents($data['file_path'][$i]), $filename);
        }
      }
      else{
        $arrFile = explode("/", $data['file_path']);
        $filename = end($arrFile);
        $mail->AddStringAttachment(file_get_contents($data['file_path']), $filename);
      }
    }

    $mail->AddReplyTo($from);
    $mail->IsHTML(true);
    $mail->Subject = $data['subject'];
    $mail->AltBody = "This is the body in plain text for non-HTML mail clients";      
    $mail->Body = stripslashes($data['msg']);
    $ext = 0;
    if($mail->Send()){
      return true;
    } else {
      return false;
    }
    $mail->ClearAddresses();
  }
?>