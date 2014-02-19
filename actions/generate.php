<?php
	
	if($type == 'nav')
	{
		$nav = get_allnav();
		$addLink = Link::addNav();
		
		echo "<a href='{$addLink}'><button class='btn btn-success' value='abc'> Add a Nav </button></a>";
		echo "<br/><p> <i>Click to edit </i></p>";

		echo "<div class='span9'>";
		while($n = mysql_fetch_array($nav))
		{
			$subnav = get_allsubnav($n['id']);
			$addLink = Link::addSubnav($n['id']);
			$editLink = Link::editNav($n['id']);
			$deletelink = Link::delNav($n['id']);
			$activatelink = Link::actNav($n['id']);
			$uploadLink = Link::uploadNav($n['id']);
			
			echo"	
					<table  class='span7 navHolder table table-bordered'>
					<tr>
						<td><a href='{$editLink}'>".ucFirst($n['title'])."</a></td>
						<td "; if($n['isactive']) echo "class='active'>Active"; else echo "class='inactive'>Inactive"; echo "</td>
						<td><a href='{$addLink}'><button class='btn'>Add Subcategory</button></a></td>
						<td><a href='{$uploadLink}'><button class='btn btn-primary'>Uploads</button></a></td>
						<td><a href='{$deletelink}' ><button class='btn btn-danger'>Delete</button></a>	</td>";
						if(!$n['isactive']) echo "<td><a href='{$activatelink}'><button class='btn btn-success'>Activate</button></a></td>";
					echo "</tr>
				
				
					";
				
			while($s = mysql_fetch_array($subnav))
			{
				$editLink = Link::editSubnav($s['id']);
				$deletelink = Link::delSubnav($s['id']);
				$uploadLink = Link::uploadSubNav($s['id']);
				$activatelink = Link::actSubNav($s['id']);
				echo "<div class='subnavHolder'>
			
			<tr style='font-size:12px;'>
				<td>&nbsp;&nbsp;--><a href='{$editLink}'>".ucFirst($s['title'])."</a></td>
				<td ";if($s['isactive']) echo "class='active'>Active"; else echo "class='inactive'>Inactive"; echo "</td>
				<td><a href='{$uploadLink}'><button class='btn btn-primary'>Uploads</button></a></td>
				<td><a href='{$deletelink}' ><button class='btn btn-danger'>Delete</button></a> </td>";
				if(!$s['isactive']) echo "<td><a href='{$activatelink}'><button class='btn btn-success'>Activate</button></a></td>";
			echo "</tr>
		
		</div><br/>";
			}
		
		}
		echo "</table>";
		echo "</div><br/>";
	}
	
	else if($type == 'rpanel')
	{
		$topics = get_rpanel_topics();
		
		$addLink = Link::addRpanelTopic();
		$uploadLink = Link::uploadRpanel();
		
		echo "<a href='{$addLink}'><button class='btn btn-success' value='abc'> Add a Topic </button></a>";
		echo "<br/><br/><p> <i>Click to edit </i></p>";
		echo "<div class='span9 '>";
		echo "<br/><a href='{$uploadLink}'><button class='btn btn-primary' value='abc'> Upload Files</button></a></br/>";
		echo "<table class='span7 navHolder table table-bordered'>";
		while($n = mysql_fetch_array($topics))
		{
			$content= get_rpanel_content($n['id']);
			$addLink = Link::addRpanelContent($n['id']);
			$editLink = Link::editRpanelTopic($n['id']);
			$deletelink = Link::delRpanelTopic($n['id']);
			$activatelink = Link::actRpanelTopic($n['id']);
			$deactivatelink = Link::deactRpanelTopic($n['id']);
			$uploadlink = Link::uploadRpanel($n['id']);
			
			echo "<tr>";
			echo "<td><a href='{$editLink}'>".ucFirst($n['title'])."</a></td>";
			echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc' > Delete </button></a></td>";
			echo "<td><a href='{$addLink}'><button class='btn' value='abc'> Add a subcategory </button> </a></td>";
			if($n['isactive'] != 1)
					echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></br></td>";
				else
					echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></br></td>";
			echo "<td><a href='{$uploadlink}'><button class='btn btn-primary' value='abc'> Upload Icon </button> </a></td>";
			 echo "</tr>";
			 echo "<tr>";
			while($c = mysql_fetch_array($content))
			{
				
				$editLink = Link::editRpanelContent($c['id']);
				$deletelink = Link::delRpanelContent($c['id']);
				$activatelink = Link::actRpanelContent($c['id']);
				$deactivatelink = Link::deactRpanelContent($c['id']);
				
				echo "<tr>";
				echo "<td><a href='{$editLink}'>&nbsp;&nbsp;&nbsp;->".ucFirst($c['title'])."</a></td> ";
				echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a></br></td>";
				if($c['isactive'] != 1)
					echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></br></td>";
				else
					echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></br></td>";
				echo "</tr>";
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
	}
	
	else if($type == 'events')
	{
		$count = get_page_count("events");
		if($count > 1)
		{
			echo " <b >Pages: &nbsp &nbsp </b> ";
		
			for( $i = 1; $i <= $count; $i++) {
				echo "<a href='?type=events&action=generate&page={$i}'>"; if($i==$page) echo "<b>"; echo $i; if($i==$page) echo " </b>"; echo "</a> &nbsp;&nbsp;&nbsp;";
			}
		}
		
		$addLink = Link::addEvent();
		
		echo "<a href='{$addLink}'> <button class='btn btn-success' value='abc'> Add a Event </button></a>";
		echo "<br/><br/><p> <i>Click to edit </i></p>";
		
		$events = get_events($page);
		echo "<div class='span9'>";
		echo "<table class='span7 navHolder table table-striped '>";
		while($n = mysql_fetch_array($events))
		{
			$editLink = Link::editEvent($n['id']);
			$deletelink = Link::delEvent($n['id']);
			$activatelink = Link::actEvent($n['id']);
			$deactivatelink = Link::deactEvent($n['id']);
			$uploadLink = Link::uploadEvent($n['id']);
			
			echo "<tr>";
			echo " <td><a href='{$editLink}'>".ucFirst($n['front_title'])."</a></td>";
			echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a> </td>";		
			if($n['isactive'] != 1)
				echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></td>";
			else
				echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></td>";
			echo "<td><a href='{$uploadLink}'><button class='btn btn-primary' value='abc'> Upload </button></a></td> <br/>";		
			echo "</tr>";
		}
		
		echo "</table>";
		echo "</div>";
		
	}
	
	
	else if($type == 'news')
	{
		$count = get_page_count("news");
		if($count > 1)
		{
			echo " <b style = 'color:#0044DD'>Pages: &nbsp &nbsp </b> ";
		
			for( $i = 1; $i <= $count; $i++) {
				echo "<a href='?type=news&action=generate&page={$i}'>"; if($i==$page) echo "<b>"; echo $i; if($i==$page) echo " </b>"; echo "</a> &nbsp;&nbsp;&nbsp;";
			}
		}
		
		$addLink = Link::addNews();
		
		echo "<a href='{$addLink}'> <button class='btn btn-success' value='abc'> Add a News </button></a>";
		echo "<br/><br/><p> <i>Click to edit </i></p>";
		
		$news = get_news($page);
		echo "<div class='span9'>";
		echo "<table class='span7 navHolder table table-striped'>";
		while($n = mysql_fetch_array($news))
		{
			$editLink = Link::editNews($n['id']);
			$deletelink = Link::delNews($n['id']);
			$activatelink = Link::actNews($n['id']);
			$deactivatelink = Link::deactNews($n['id']);
			echo "<tr>";
			echo "<td> <a href='{$editLink}'>".ucFirst($n['front_title'])."</a></td>";
			echo "<td><a href='{$deletelink}'><button  class='btn btn-danger' value='abc'> Delete </button></a></td>";	
			if($n['isactive'] != 1)
				echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></td>";
			else
				echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></br></td>";	
			echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
	}
	else if($type == 'announcements')
        {
                $count = get_page_count("announcements");
                if($count > 1)
                {
                        echo " <b style = 'color:#0044DD'>Pages: &nbsp &nbsp </b> ";
               
                        for( $i = 1; $i <= $count; $i++) {
                                echo "<a href='?type=announcements&action=generate&page={$i}'>"; if($i==$page) echo "<b>"; echo $i; if($i==$page) echo " </b>"; echo "</a> &nbsp;&nbsp;&nbsp;";
                        }
                }
               
                $addLink = Link::addAnnouncement();
               
                echo "<a href='{$addLink}'> <button class='btn btn-success' value='abc'> Add an Announcement </button></a>";
                echo "<br/><br/><p> <i>Click to edit </i></p>";
               
               
                $announcements = get_announcements($page);
               
                echo "<div class='span9'>";
                echo "<table class='span7 navHolder table table-striped'>";
                while($n = mysql_fetch_array($announcements))
                {
                        $editLink = Link::editAnnouncement($n['id']);
                        $deletelink = Link::delAnnouncement($n['id']);
                        $activatelink = Link::actAnnouncement($n['id']);
                        $deactivatelink = Link::deactAnnouncement($n['id']);
                        $uploadlink = Link::uploadAnnouncement($n['id']);
                       
                        echo "<tr>";
                        echo " <td><a href='{$editLink}'>".ucFirst($n['title'])."</a></td>";
                        echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a></td>";              
                        if($n['isactive'] != 1)
                                echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></td>";
                        else
                                echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></td>";
                        echo "<td><a href='{$uploadlink}'><button class='btn btn-primary' value='abc'> Upload </button></a></td>";
                        echo"</tr>";
                }
        }
       
        else if($type == 'tenders')
        {
                $count = get_page_count("tenders");
                if($count > 1)
                {
                        echo " <b style = 'color:#0044DD'>Pages: &nbsp &nbsp </b> ";
               
                        for( $i = 1; $i <= $count; $i++) {
                                echo "<a href='?type=tenders&action=generate&page={$i}'>"; if($i==$page) echo "<b>"; echo $i; if($i==$page) echo " </b>"; echo "</a> &nbsp;&nbsp;&nbsp;";
                        }
                }
               
                $addLink = Link::addTender();
               
                echo "<a href='{$addLink}'> <button class='btn btn-success' value='abc'> Add a Tender </button></a>";
                echo "<br/><br/><p> <i>Click to edit </i></p>";
               
                $tenders = get_tender($page);
               
                echo "<div class='span9'>";
                echo "<table class='span7 navHolder table table-striped'>";
                while($n = mysql_fetch_array($tenders))
                {
                        $editLink = Link::editTender($n['id']);
                        $deletelink = Link::delTender($n['id']);
                        $activatelink = Link::actTender($n['id']);
                        $deactivatelink = Link::deactTender($n['id']);
                        $uploadlink = Link::uploadTender($n['id']);
                        echo"<tr>";
                        echo " <td><a href='{$editLink}'>".ucFirst($n['title'])."</a></td>";
                        echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a></td>";              
                        if($n['isactive'] != 1)
                                echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></br></td>";
                        else
                                echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></br></td>";
                        echo "<td><a href='{$uploadlink}'><button class='btn btn-primary' value='abc'> Upload </button></a></td>";
                        echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
        }
	
	else if($type == 'carousel')
	{	
		$addLink = Link::addCarousel();
		echo "<a href='{$addLink}'> <button class='btn btn-success' value='abc'> Add a new Carousel </button></a>";
		echo "<br/><br/><p> <i>Click to edit </i></p>";
		
		$carousel = get_carousel();
		echo "<div class='span9'>";
		echo "<table class='span7 navHolder table table-striped'>";
		while($n = mysql_fetch_array($carousel))
		{
		
			$editLink = Link::editCarousel($n['id']);
			$deletelink = Link::delCarousel($n['id']);
			$activatelink = Link::actCarousel($n['id']);
			$deactivatelink = Link::deactCarousel($n['id']);
			$uploadLink = Link::uploadCarousel($n['id']);
			
			echo "<tr>";
			echo "<td><a href='{$editLink}'>".ucFirst($n['overview'])."</a></td>";
			echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a></td>";	
			if($n['isactive'] != 1)
				echo "<td><a href='{$activatelink}'><button class='btn btn-success' value='abc'> Activate </button></a></td>";
			else
				echo "<td><a href='{$deactivatelink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a></td>";
			echo "<td><a href='{$uploadLink}'><button class='btn btn-primary' value='abc'> Upload </button></a> </td><br/>";		
		}
		echo "</table>";
		echo "</div>";
		
	}
	
	else if ($type=='user_accounts')
	{
		$addLink = Link::addUser();
		
		echo "<a href='{$addLink}'> <button class='btn btn-success' value='abc'> New User </button></a>";
		echo "<br/><br/><p> <i>Click to View </i></p>";
		echo "<div class='span9' ><br/>";
		$users = get_all_users();
		echo "<table class='span6 navHolder table table-striped'>";
		while( $u = mysql_fetch_array($users)) {
			if($u['username'] != $_SESSION['_iiita_cms_username_'] && $u['username'] != 'admin') {
				$editLink = Link::editUser($u['id']);
				$deletelink = Link::delUser($u['id']);
				$actlink = Link::actUser($u['id']);
				$deactlink = Link::deactUser($u['id']);
				$changePass = 'change_pass.php?user='.$u['username'];
				
				echo "<tr>";
				echo "<td><a href='{$editLink}'>".ucFirst($u['username'])."</a></td>";
				echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a> </td>";	
				if(!$u['isactive']) 
					echo "<td><a href='{$actlink}'><button class='btn btn-success' value='abc'> Activate </button></a> </td>";		
				else 
					echo "<td><a href='{$deactlink}'><button class='btn btn-warning' value='abc'> DeActivate </button></a> </td>";
				if($_SESSION['_iiita_cms_username_'] == 'admin')
					echo "<td><a href='{$changePass}'><button class='btn btn-info' value='abc'> Change Password </button></a> </td>";		
				echo "</tr>";
			}
			
		}
		echo "</table>";
		echo "</div>";
	}
	
	else if ($type=='subscriptions')
	{
		$topics = get_sub_topics();
		
		$addLink = Link::addSubTopic();
		
		echo "<a href='{$addLink}'><button class='btn btn-success' value='abc'> Add a Topic </button></a>";
		echo "<br/><br/><p> <i>Click to edit </i></p>";
		echo "<div class='span9 '>";
		echo "<table class='span7 navHolder table table-bordered'>";
		while($n = mysql_fetch_array($topics))
		{
			$content= get_sub_content($n['id']);
			$addLink = Link::addSubContent($n['id']);
			$editLink = Link::editSubTopic($n['id']);
			$deletelink = Link::delSubTopic($n['id']);
			$sendLink = Link::sendSubContent($n['id']);
			$showLink = Link::showSubContent($n['id']);
			echo "<tr>";
			echo "<td><a href='{$editLink}'>".ucFirst($n['title'])."</a></td>";
			echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc' > Delete </button></a></td>";
			echo "<td><a href='{$sendLink}'><button class='btn btn-danger' value='abc'> Send Feeds</button></a></br></td>";
			echo "<td><a href='{$addLink}'><button class='btn' value='abc'> Add Content </button> </a></td>";
			echo "<td><a href='{$showLink}'><button class='btn' value='abc'> Show Feeds </button> </a></td>"; 
			 echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
	}
	
	else if ($type=='sub_content')
	{
		$topic_id = $_GET['value'];
		
		echo "<br/><br/><p> <i>Click to View </i></p>";
		echo "<div class='span9 '>";
		echo "<table class='span7 navHolder table table-bordered'>";
		$content= get_sub_content($topic_id);
		$sendLink = Link::sendSubContent($topic_id);
		echo "<tr>";
		while($c = mysql_fetch_array($content))
		{
			$deletelink = Link::delSubContent($c['id']);
			$viewLink = Link::viewSubContent($c['id']);
			echo "<tr>";
			echo "<td><a href='{$viewLink}'>&nbsp;&nbsp;&nbsp;-> ".ucFirst($c['data'])."</a></td> ";
			echo "<td>&nbsp;&nbsp;&nbsp;-> {$c['added_on']}</td> ";
			echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a></br></td>";
			echo "</tr>";
		}
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	else if ($type=='query')
	{
		echo "<div class='span9 '>";
		echo "<table class='span7 navHolder table table-bordered'>";
		$query= get_query();
		echo "<tr>";
		while($c = mysql_fetch_array($query))
		{
			$deletelink = Link::delQuery($c['id']);
			echo "<tr>";
			echo "<td><p>&nbsp;&nbsp;&nbsp;-> ".ucFirst($c['query'])."</p></td> ";
			echo "<td><p>&nbsp;&nbsp;&nbsp;{$c['email']}</p></td> ";
			echo "<td><a href='{$deletelink}'><button class='btn btn-danger' value='abc'> Delete </button></a></br></td>";
			echo "</tr>";
		}
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	else if($type == 'settings') {
		$editLink = Link::editSettings();
		echo "<a href='{$editLink}'><button class='btn btn-success'>Edit CSS and JS</button></a>";
	}
	
	else if ($type=='gfiles')
	{
		$uploadlink = Link::uploadGfiles();
		echo "<a href='{$uploadlink}'> <button class='btn btn-success' value='abc'>Upload Global Files </button></a> <br/>";
		echo "Currently Uploaded files <br/>";
	}
?>