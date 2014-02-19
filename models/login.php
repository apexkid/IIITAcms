<form action="index.php" method="post">
				
				<?php if(isset($message)) echo $message;?><br/>
					  <input  type="text" class='span3' style='height:25px' name="user" id="user" value="" placeholder='Username' >
				
				<br/>
					  <input  type="password" class='span3' style='height:25px'  name="userp" id="pass" value="" placeholder='Password'>
				<br/>
				
				  <input  type="submit" name="submit" class='btn btn-success' value="   Login   " style="height:30px"/>
				  <input  type="submit" name="cancel" class='btn btn-danger' value="   Cancel   " style="height:30px"/>
							
</form>
