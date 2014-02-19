<?php 
    class DirCreator
    {
		private  $type = '';
		private  $value = 0;
		private  $dir;
		
		public function __construct($t = 0,$v = 0)
		{
			$this -> type = $t;
			$this -> value = (int)$v;
			   
		}
		public function generateStructure($path)
		{
			if($this -> type == 'nav' || $this -> type == 'subnav')  
					$this -> dirStructure($path);
			   
		}
		public function dirStructure($path)
		{      
		/*      $conn_id = @ftp_connect("localhost");
				if(!$conn_id) {
						return false;
				}
				if (@ftp_login($conn_id, FTP_USER, FTP_PASS)) {
							   
				}
		*/
				mkdir($path, 0777, true);
				chdir($path);
				mkdir("includes", 0777, true );
				mkdir("images", 0777, true );
				mkdir("uploads", 0777, true);
				mkdir("images/banner", 0777, true);
				mkdir("images/gridimage", 0777, true    );
				fopen("index.php", 'w');
				if($this -> type == 'subnav'){
						$contents = "<?php require_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/html_head.php'); \nrequire_once('includes/css.php'); \nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/site_head.php'); \nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/nav.php');\nrequire_once('includes/content.php');\nrequire_once('includes/js.php');\nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/site_footer.php');\n?>";
				}
				if($this -> type == 'nav'){
						$contents = "<?php require_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/html_head.php');\nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/site_head.php'); \nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/nav.php');\nrequire_once('includes/content.php');\nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'/includes/site_footer.php');\n?>";
						chdir("includes");
						fopen("side_nav.php", 'w');
						chdir("../");
				}
			   
				$filename = "index.php";
				if (is_writable($filename)) {

						if (!$handle = fopen($filename, 'a')) {
								 echo "Cannot open file ($filename)";
								 exit;
						}

						if (fwrite($handle, $contents) === FALSE) {
								echo "Cannot write to file ($filename)";
								exit;
						}
						fclose($handle);
				}
				chdir("includes");
				fopen("content.php", 'w');
				
				if($this -> type == 'subnav') {
						fopen("css.php", 'w');
						fopen("js.php", 'w');
				}
		}
	   
		public function copyDir($src, $dst) {
				if(is_dir($src))
				{
						$dir = opendir($src);
						@mkdir($dst);
						while(false !== ( $file = readdir($dir)) ) {
								if (( $file != '.' ) && ( $file != '..' )) {
										if ( is_dir($src . '/' . $file) ) {
												$this -> copyDir($src . '/' . $file,$dst . '/' . $file);
										}
										else {
												copy($src . '/' . $file,$dst . '/' . $file);
										}
								}
						}
						closedir($dir);
				}
				else
						return false;
				return true;
		}
	   
		public function removeDir($dir) {
				foreach(glob($dir . '/*') as $file) {
						if(is_dir($file))
								$this -> removeDir($file);
						else
								unlink($file);
				}
				rmdir($dir);
				return true;
		}
	   
		public function renameDir($src, $des)
		{
				if(is_dir($src))
				{
						rename($src, $des);
				}
				else
						return false;
				return true;
		}
    }
    ?>

