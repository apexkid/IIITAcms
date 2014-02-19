<?php require_once("../config/constants.php") ?>
<?php require_once("../business/Database_handler.class.php") ?>
<?php require_once("../business/Phpmailer.class.php") ?>
<?php
	$code = htmlentities($_GET['unsub_id']);
	
	$sql1 = "SELECT * FROM sub_subscribers WHERE confirmation_code = :code";
	$params = array(':code' => $code);
	$result1 = DatabaseHandler::GetAll($sql1, $params);

	if($result1) {

	$flag = 1;
	if ($result1[0]['isdeleted'] == 1) {
		echo "<script type='text/javascript'>alert('Email-id does not exist in the database!');</script>";
	} else {
		$sql2 = "UPDATE sub_subscribers SET isdeleted = 1, is_Valid = 0 WHERE confirmation_code = :code";
		$params = array(':code' => $code);
		$result2 = DatabaseHandler::Execute($sql2, $params);
		$sql_sel = "SELECT * FROM sub_subscriptions WHERE subscriber_id = :subscriber_id AND is_Valid = 1";
		$params = array(':subscriber_id' => $result1[0]['email']);
		$result_sel = DatabaseHandler::GetAll($sql_sel, $params);
		for ($i = 0; $i < count($result_sel); $i++) {
			$sql3 = "UPDATE sub_subscriptions SET is_Valid = 0, isdeleted = 1 WHERE id = :id";
			$params = array(':id' => $result_sel[$i]['id']);
			$result3 = DatabaseHandler::Execute($sql3, $params);
		}
		echo "<script type='text/javascript'>alert('Your account has been unsubscribed!');</script>";
	}
	} else {
		echo "<script type='text/javascript'>alert('Wrong Unsubscription code!');</script>";
	}


?>