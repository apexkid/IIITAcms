<?php	
	function writeNav()
	{
		
		$content = "<?php	\$url = \$_SERVER['REQUEST_URI'];	\$curr_url = explode (\"/\", \$url);	\$active=\$curr_url[1];	?>
						<div class='header h-nav-header'>
						
								<div class='container h-nav-container' > 
									<ul id='menu'>
									";
	
		
		$nav = get_nav();
		$j=0;
		while($n = mysql_fetch_array($nav))
		{
			$j++;
			$content .= "<div class='spanx'>
				<li <?php if (\$active=='{$n['url']}') echo \" class='active_menu'\"; ?> ><a href='/{$n['url']}/' class='drop'><img src='/images/icons/{$n['icon']}' style='height:20px; width:20px;'/> ".ucFirst($n['title'])." </a><!-- Begin 4 columns Item -->
				
					<div class='dropdown_4columns";if($j > 3) $content	.= " align_right";	$content .= "'><!-- Begin 4 columns container -->
					
						<div class='col_4'>
							<h2>".ucFirst($n['tagline'])."</h2>
						</div>
						
						<div class='col_2'>
						
							<h3>Overview</h3>
								<div >
									
									<p>".ucFirst($n['overview'])."
									</p>
								</div>
						</div>
			
				
						<div class='col_1'>
						
							<h3>Content</h3>
							<ul>";
						
						$subnav = get_subnav($n['id']);
						while($s = mysql_fetch_array($subnav)) {
					$content .="<li><a href='/{$n['url']}/{$s['url']}/'>".ucFirst($s['title'])."</a></li>";
						}
						
				$content .= "</ul>   
							 
						</div>
				
						<div class='col_1'>
						
							<h3>Links</h3>
							<ul>";
						if($n['links'])
						{
								$links = explode (";", $n['links']);
								for($i = 0; $i < count($links); $i++) {
										$link = explode(",", $links[$i]);
										if(count($link) == 2)
												$content .= "<li><a href='{$link[1]}'>".ucFirst($link[0])."</a></li>";
								}
						}
				$content .="</ul>   
							 
						</div>
						
					</div><!-- End 4 columns container -->
				
				</li><!-- End 4 columns Item -->  
				</div>";
			
		}
		$content .= "</ul>
			</div>
	
</div>";
		chdir($_SERVER['DOCUMENT_ROOT']."/includes");
		fopen("nav.php", 'w');
		$filename = "nav.php";
		if (is_writable($filename)) {

				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 exit;
				}

				if (fwrite($handle, $content) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
		}
		//$x = 0;
		//$x = file_put_contents("../nav.php", $content);
		 /*if($x)
			 echo "done";
		 else
			 echo "not done";*/
	} 
	
	
	function writeSubnavFiles($s_id) {
		$s = mysql_fetch_array(get_subnavbyid($s_id));
		$n = mysql_fetch_array(get_navbyid($s['nav_id']));
		$title = SITE_TITLE;
		$content = '<div class="container contenta">
	<title>'. $title .' | ' . ucfirst($n['title']) . ' | '. ucfirst($s['title']) .'</title>
	<div class="span12 sub-banner">
			<img src="images/banner/'; $content .= $s['banner'].'" /> 
	</div>
	<div class="row" style="height:100%">
		<div class="span3 v-nav-container">
				<div class="v-grid v-first" >
						<?php require_once("../includes/side_nav.php");?>
					</div>

		
		</div>
		
		<div class="span8">';
		$content .= $s['content'];
		$content .="		</div>
					</div>
					</div>;";
					
		chdir($_SERVER['DOCUMENT_ROOT']."/".$n['url']."/".$s['url']."/includes");
		$filename = "content.php";
		fopen($filename, 'w');
		if (is_writable($filename)) {

				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 exit;
				}

				if (fwrite($handle, $content) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
		}
		$js_content = "<script>".$s['js']."</script>";
		$filename = "js.php";
		fopen($filename, 'w');
		if (is_writable($filename)) {

				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 exit;
				}

				if (fwrite($handle, $js_content) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
		}
		$css_content = "<style type='css/text' rel='stylesheet'>".$s['css']."</style>";
		$filename = "css.php";
		fopen($filename, 'w');
		if (is_writable($filename)) {

				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 exit;
				}

				if (fwrite($handle, $css_content) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
		}

	}
	
	function writeNavContent($n_id) {
		$n = mysql_fetch_array(get_navbyid($n_id));
		
		$title = SITE_TITLE;
		$content ='<div class="container contenta">
		<title>'. $title .' | ' . ucFirst($n['title']) .'</title>
		
		
		<div class="span12 sub-banner">
			<img src="images/banner/'."{$n['banner']}".'" /> 
		</div>
		<div class="row" style="height:100%">
			<div class="span3 v-nav-container">
					<div class="v-grid v-first" >
							<?php require_once("side_nav.php"); ?>
					</div>
			</div>
			
			<div class="span9">
			<div class="span8 pageHeading">
			<p>' . ucFirst($n['title']) .' | <small><em>
		  ' . ucFirst($n['inner_tagline']) . '
		</em></small></p>
			</div>';
			
			$subnav = get_subnav($n_id);
			$i=0;
			while($s = mysql_fetch_array($subnav)) {
				$i++;
				$content .= "<div class='span4 menu-overview-grid' id='gridElement{$i}' onmouseover='bgWhite(\"gridElement{$i}\"); ; bgResume(\"knowMore{$i}\")' onmouseout='bgResume(\"gridElement{$i}\"); bgWhite(\"knowMore{$i}\");' >
				<a href='{$s['url']}'>
					<div class='gridHeading'>
						<h3>".ucFirst($s['title'])."</h3>
					</div>
					<div class='gridDesc'>
						<div class='gridImage'>
							<img src='{$s['url']}/images/gridImage/{$s['gridimg']}'/>
						</div>
						<div class='gridText'>
							<p>".ucFirst($s['overview'])."</p>
						</div>
				</a>
						<br/>
						<div class='knowMore' id='knowMore{$i}'>
							<a href='{$s['url']}' >know more <img src='../images/iconKnowMore.png' id='iconKnowMore'/> &nbsp;
							</a>
						</div>
					</div>
				
			</div>";
			}
			
			$content .= "	
				</div>
				
			</div>
			<br/><br/>
		</div>";
		
		chdir($_SERVER['DOCUMENT_ROOT']."/".$n['url']."/includes/");
		$filename = "content.php";
		fopen($filename, 'w');
		if (is_writable($filename)) {

				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 exit;
				}

				if (fwrite($handle, $content) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
		}
	}
	
	function writeSideNav($nav_id) {
		
		$nav = mysql_fetch_array(get_navbyid($nav_id));
		$content = "<?php \$url = \$_SERVER['REQUEST_URI'];	\$curr_url = explode ('/', \$url);	\$active=\$curr_url[2];	?>";
		$content .= "<br/><ul class='v-nav' >";
		
		$subnav = get_subnav($nav_id);
		while($s = mysql_fetch_array($subnav)) {
			$url = "/".$nav['url']."/".$s['url'];
			$content .= "<li><a href='{$url}' <?php if (\$active=='{$s['url']}') echo \" class='v-active'\"; ?>>".ucFirst($s['title'])."</a></li>";
		}
		
		$content .= "</ul>";
		
		chdir($_SERVER['DOCUMENT_ROOT']."/".$nav['url']."/includes");
		fopen("side_nav.php", 'w');
		$filename = "side_nav.php";
		if (is_writable($filename)) {

				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 exit;
				}

				if (fwrite($handle, $content) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
		}

		
	}
	
	function writeContent($path, $filename, $content) {
		chdir($_SERVER['DOCUMENT_ROOT'].$path);
		fopen($filename, 'w');
	
		if (is_writable($filename)) {

			if (!$handle = fopen($filename, 'a')) {
				 echo "Cannot open file ($filename)";
				 exit;
			}

			if (fwrite($handle, $content) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
			fclose($handle);
		}
	}
?>