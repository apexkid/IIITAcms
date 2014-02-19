<?php
session_start();
ob_start();
require_once("config/constants.php");

require_once("models/database.php");
require_once("models/session.php");

require_once("api/cms_functions.php");
require_once('api/filewrite_functions.php');

require_once("business/Database_handler.class.php");
require_once("business/Link.class.php");
require_once("business/Error_handler.class.php");
require_once('business/Logger.class.php');
 
	ErrorHandler::SetHandler();
	
	if(isset($_POST['cancel'])){
		header("Location:/");
	}
	if(isset($_POST['submit'])){
		if(chk_user( $_POST['user'], $_POST['userp'] )){
			$_SESSION['_iiita_cms_username_'] = $_POST['user'];
			$result = login($_POST['user']);
			if ($result) {
				$ip = "";
				$ip = $_SERVER['REMOTE_ADDR'];
                Logger::logLogin($_SESSION['_iiita_cms_username_'], $ip);
            }                        
		}
		else {
			$message = "<em>Login failed. Incorrect username or password.</em><br/>";
		}
	} else if(isset($_GET['logout']) && $_GET['logout']==1 ){
		$message="You are now successfully logged out...<br/>";
	}
 
?>

<?php

if(isset($_GET['type'])) {
	$type = $_GET['type'];
	$t = $type;
	if($t == 'subnav')
		$t = 'nav';
	if($t == 'rpanelcontent')
		$t = 'rpanel';
	if(!chk_privilege($t)) {
		header("Location:/cms");
	}
}
?>

<?php require_once "../includes/html_head.php" ;
	echo "<title>".SITE_TITLE." | Content Management System</title>";
?>
<?php require_once "../includes/site_head.php" ?>
<?php require_once "../includes/nav.php" ?>
<link rel="stylesheet" type="text/css" href="css/cmsStyle.css"></link>	
<script type ="text/javascript" src="js/jquery.js"></script>
<script type ="text/javascript" src="datepicker/jquery.jdpicker.js"></script>
<link rel="stylesheet" href="datepicker/jdpicker.css" type="text/css" media="screen" />

	<div class="cms_container">
		<br/>
		<div class="span2 sideNav">
			
			<?php if(chk_privilege('nav'))
				echo '<a href="?type=nav&action=generate">
				<div class="sideNavItem">
					<p> Navigation </p>
				</div>
			</a>';
			?>
			<?php if(chk_privilege('footer'))
				echo '<a href="?type=footer&action=generate">
				<div class="sideNavItem">
					<p> Footer </p>
				</div>
			</a>';
			?>
			<?php if(chk_privilege('rpanel'))
				echo '<a href="?type=rpanel&action=generate">
				<div class="sideNavItem">
					<p> Right Panel </p>
				</div>
			</a>';
			?>
			<?php if(chk_privilege('carousel'))
				echo '<a href="?type=carousel&action=generate">
				<div class="sideNavItem">
					<p> Carousel </p>
				</div>
			</a>';
			?><?php if(chk_privilege('tenders'))
				echo '<a href="?type=tenders&action=generate">
				<div class="sideNavItem">
					<p> Tenders </p>
				</div>
			</a>';
			?><?php if(chk_privilege('news'))
				echo '<a href="?type=news&action=generate">
				<div class="sideNavItem">
					<p> News </p>
				</div>
			</a>';
			?><?php if(chk_privilege('events'))
				echo '<a href="?type=events&action=generate">
				<div class="sideNavItem">
					<p> Events </p>
				</div>
			</a>';
			?><?php if(chk_privilege('announcements'))
				echo '<a href="?type=announcements&action=generate">
				<div class="sideNavItem">
					<p> Announcements </p>
				</div>
			</a>';
			?><?php if(chk_privilege('subscriptions'))
				echo '<a href="?type=subscriptions&action=generate">
				<div class="sideNavItem">
					<p> Subscription System </p>
				</div>
			</a>';
			?><?php if(chk_privilege('query'))
				echo '<a href="?type=query&action=generate">
				<div class="sideNavItem">
					<p> Query </p>
				</div>
			</a>';
			?><?php if(chk_privilege('settings'))
				echo '<a href="?type=settings&action=generate">
				<div class="sideNavItem">
					<p> Settings </p>
				</div>
			</a>';
			?>
			
			<?php if(chk_privilege('gfiles'))
				echo "<a href='?type=gfiles&action=generate'>
				<div class='sideNavItem'>
					<p> Global View </p>
				</div>
			</a>";
			?>
			<?php
			if(chk_privilege('user_accounts'))
				echo "<a href='?type=user_accounts&action=generate'>
				<div class='sideNavItem'>
					<p> User Accounts </p>
				</div>
			</a>";
			?>
			<br/>
		</div>
		

		<div class="span11 content">
			
		<?php

			if (logged_in()) {
					echo "<div style='float:right;'>";
				echo "<a href='/cms'><button class='btn ' style=' margin-right:10px;'>Home</button></a>";
				echo "<a href='change_pass.php?user={$_SESSION['_iiita_cms_username_']}' ><button class='btn btn-info' style=' margin-right:10px;'>Change Password</button></a>";
				echo "<a href='logout.php'><button class='btn btn-danger ' style=' margin-right:10px;'>Logout</button></a>";
				echo "</div>";
				if(isset($_GET['action']))
					require_once('models/action.php');
				else {
					
				}
			} else {
				require_once('models/login.php');
			}
			flush();
			ob_flush();
			ob_end_clean();
		?>
		
		</div>
	</div>
</body>	
</html>