<?php require_once("../config/constants.php") ?>
<?php require_once("../business/Database_handler.class.php") ?>
<?php require_once("../business/Phpmailer.class.php") ?>
<?php

	$code = htmlentities($_GET['code']);
  

	$sql1 = "SELECT * FROM sub_subscribers WHERE confirmation_code = :code";
	$params = array(':code' => $code);
	$result1 = DatabaseHandler::GetAll($sql1, $params);

	if($result1) {

		$flag = 1;
		if ($result1[0]['is_Valid'] == 1) {
			echo "<script type='text/javascript'>alert('Email-id already Validated!'); window.location.href = 'index.php';</script>";
		} else {
			$sql2 = "UPDATE sub_subscribers SET is_Valid = 1 WHERE confirmation_code = :code AND isdeleted = 0";
			$result2 = DatabaseHandler::Execute($sql2, $params);
			if ($result2){
				$sql_sel = "SELECT * FROM sub_subscriptions WHERE subscriber_id = :email AND isdeleted = 0";
				$params = array(':email' => $result1[0]['email']);
				$result_sel = DatabaseHandler::GetAll($sql_sel, $params);
				for ($i = 0; $i < count($result_sel); $i++) {
					$sql3 = "UPDATE sub_subscriptions SET is_Valid = 1 WHERE id = :id";
					$params = array(':id' => $result_sel[$i]['id']);
					$result3 = DatabaseHandler::Execute($sql3, $params);
				}
			}
			else if(!$result3) {
				echo "<script type='text/javascript'>alert('Error inserting data to the table\nquery:$sql2'); window.location.href = 'index.php';</script>";
			} else {
				echo "<script type='text/javascript'>alert('Your account has been activated!); window.location.href = 'index.php';</script>";
			}
		}
	} else {
		echo "<script type='text/javascript'>alert('Wrong Confirmation code'); window.location.href = 'index.php';</script>";
	}


mysql_close($connection);


?>