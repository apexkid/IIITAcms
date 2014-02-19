<?php require_once("/config/constants.php") ?>
<?php require_once("/business/Database_handler.class.php") ?>
<?php require_once("/business/Phpmailer.class.php") ?>
<?php
	
	$mail  = new PHPMailer();
	$mail->IsSMTP();    // set mailer to use SMTP
	$mail->Host = MAIL_HOST;    // specify main and backup server
	$mail->SMTPAuth = true;    // turn on SMTP authentication
	$mail->Username = MAIL_FROM;    // Gmail username for smtp.gmail.com -- CHANGE --
	$mail->Password = MAIL_FROM_PWD;    // SMTP password -- CHANGE --
	$mail->Port = MAIL_PORT;    // SMTP Port
		
		$topic_id = htmlentities($_GET['value']);
		if(!is_numeric($topic_id))
			exit();
		$qry = "SELECT * FROM sub_content WHERE topic_id = :topic_id AND is_Sent = 0 AND isdeleted=0";
		$params = array(':topic_id' => $topic_id);
		$result = DatabaseHandler::GetAll($qry, $params);
		$qry1 = "SELECT subscriber_id FROM sub_subscriptions WHERE topic_id = :topic_id AND is_Valid = 1 AND isdeleted = 0";
		
		$flag = 0;
		for ($i = 0; $i < count($result); $i++) {
			$result1 = DatabaseHandler::GetAll($qry1, $params);
			if ($result1) {
				for ($k = 0; $k < count($result1); $k++) {
					$qry_un = "SELECT * FROM sub_subscribers WHERE email = :email";
					$params = array(':email' => $result1[$k]['subscriber_id']);
					$result_un = DatabaseHandler::GetAll($qry_un, $params);
					$unsub_url = $result_un[0]['confirmation_code'];
					$qry_t = "SELECT * FROM sub_subscriptions WHERE subscriber_id = :subscriber_id AND isdeleted = 0 AND is_Valid = 1";
					$params = array(':subscriber_id' => $result1[$i]['subscriber_id']);
					$result_t = DatabaseHandler::GetAll($qry_t, $params);
					$topics = "";
					for ($j = 0; $j < count($result_t); $j++) {
						$qry_top = "SELECT * FROM sub_topics WHERE id = :id";
						$params = array(':id' => $result_t[$j]['topic_id']);
						$result_top = DatabaseHandler::GetAll($qry_top, $params);
						if (!$topics) 
							$topics = $result_top[0]['title'];
						else 
							$topics = $topics. ', '.$result_top[0]['title'];
					}
				
					$body = "
					This is an auto-generated mail from IIIT-A Subsctiptions!".'\n'."{$result[$i]['data']}</br>
						<b>For unsubscribing from IIIT-A Feeds click on the link below.</b></br>
						</br><a href = '$unsub_url'>Unsubscribe!</a></br></br>
						/n</br>To Edit your subscriptions, you will need to subscribe again with the desired topics!</br>
						You are currently subscribed to: {$topics}.</br>
					";
				
					$mailto = $result1[$k]['subscriber_id'];
					$mail->Subject = '[NEW] IIIT-A Feeds';
					$mail->MsgHTML($body);
					$mail->SetFrom(FROM_ADDRESS, 'IIITA');
					$mail->From = FROM_ADDRESS;    //From Address -- CHANGE --
					$mail->FromName = "IIITA-Subscriptions";    //From Name -- CHANGE --
					$mail->AddAddress($subscriberEmail, "IIITA feed!!");    //To Address -- CHANGE --
					if(!$mail->Send()) {
						echo "Message could not be sent. <p>";
						echo "Mailer Error: " . $mail->ErrorInfo;
						exit;
					}
				}
				$upd_qry = "UPDATE sub_content SET is_Sent = 1 WHERE id = :id";
				$params = array(':id' => $result[$i]['id']);
				$result_qry = DatabaseHandler::Execute($upd_qry, $params);
			}
			else {
				echo "Content could not be emailed! SQL Error!";
				$flag = 1;
			}
		}
		if ($flag == 0) {
			echo "Sent Successfully!";
		}
		
?>