<?php require_once("../config/constants.php") ?>
<?php require_once("../business/Database_handler.class.php") ?>
<?php require_once("../business/Phpmailer.class.php") ?>
<?php
	
	$mail  = new PHPMailer();
	$mail->IsSMTP();    // set mailer to use SMTP
	$mail->Host = MAIL_HOST;    // specify main and backup server
	$mail->SMTPAuth = true;    // turn on SMTP authentication
	$mail->Username = MAIL_FROM;    // Gmail username for smtp.gmail.com -- CHANGE --
	$mail->Password = MAIL_FROM_PWD;    // SMTP password -- CHANGE --
	$mail->Port = MAIL_PORT;    // SMTP Port
	
	if (!isset($_POST['Email'])) {
		header('Location:/');
	}
	else {
	$subscriberEmail = htmlentities($_POST['Email']);
	
	$var = $subscriberEmail + strtotime("now");
	$confirmation_code = md5($var);
	$query = "SELECT * FROM sub_subscribers WHERE email = :email";
	$params = array(':email' => $subscriberEmail);
	$result = DatabaseHandler::GetAll($query, $params);
	if ($result) {
		for($i = 0; $i < count($result); $i++) {
			$sql = "UPDATE sub_subscribers SET is_Valid = 0, isdeleted = 1 WHERE id = :id"; //use isactive
			$params = array(':id' => $result[$i]['id']);
			$result_upd = DatabaseHandler::Execute($sql, $params);
		}
	}
	$sql_sel = "SELECT * FROM sub_subscriptions WHERE subscriber_id = :subscriber_id AND isdeleted = 0";
	$params = array(':subscriber_id' => $subscriberEmail);
	$result_sel = DatabaseHandler::GetAll($sql_sel, $params);
	if ($result_sel) {
		for($i = 0; $i < count($result_sel); $i++) {
			$sql1 = "UPDATE sub_subscriptions SET is_Valid = 0, isdeleted = 1 WHERE id = :id";
			$params = array(':id' => $result_sel[$i]['id']);
			$result1 = DatabaseHandler::Execute($sql1, $params);
		}
	}
	
    $sql = "INSERT IGNORE INTO sub_subscribers (email, confirmation_code) VALUES (:subscriberEmail, :confirmation_code)";
	$params = array(':subscriberEmail' => $subscriberEmail, ':confirmation_code' => $confirmation_code);	  
	$result = DatabaseHandler::Execute($sql, $params);
	
	$sql = "SELECT * FROM sub_topics";
	$result = DatabaseHandler::GetAll($sql);
		    
	$topics = $_POST['topic'];
	
	for($i = 0; $i < count($topics); $i++) {
		$v = $topics[$i];
		$sql = "INSERT INTO sub_subscriptions(subscriber_id, topic_id) VALUES (:subscriber_id, :topic_id)";
		$params = array(':subscriber_id' => $subscriberEmail, ':topic_id' => $v);
		$result = DatabaseHandler::Execute($sql, $params);
	}

//Generating an obsfucation
$obsfucation = "";
$token = rand(100, 1000) . "token";
$value = md5(rand(100, 1000));
$obsfucation = $obsfucation . "&token=" . sha1($token) . "&exe=%*%*%*cftomddesttreerx99390&value=" . $value;
$url = 'http://localhost/confirmreg.php?code='.$confirmation_code . $obsfucation;
$unsub_url = 'http://localhost/unsubscribe.php?unsub_id='.$confirmation_code . $obsfucation;
/* This takes the information and lines it up the way you want it to be sent in the email. */

$body = <<<EOD
<br>
<h3>Thank you for subscribing to our newsletters.</h3>
Your email has been added to our system. Please make sure that you click the link in that below to confirm your subscription.


</br><a href = "$url">Click Here to confirm!</a></br></br>


<b>For unsubscribing from IIIT-A Feeds click on the link below.</b></br>
</br><a href = "$unsub_url">Unsubscribe!</a></br></br>

EOD;

$mail->Subject     = 'IIITA Subscription Validation';
$mail->MsgHTML($body);
$mail->SetFrom(FROM_ADDRESS, 'IIITA');
$mail->From = FROM_ADDRESS;    //From Address -- CHANGE --
$mail->FromName = "IIITA-Subscriptions";    //From Name -- CHANGE --
$mail->AddAddress($subscriberEmail, "IIITA feed!!");    //To Address -- CHANGE --

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
if(isset($subscriberEmail))
		echo "<script type='text/javascript'>alert('Successful. You will be e-mailed shortly with a request to confirm your email'); window.location.href = '/index.php';</script>";
		
	mysql_close($connection);
}

?>