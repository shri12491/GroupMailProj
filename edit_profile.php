<?php require_once("includes/global.php");
require("includes/functions.php");
if(isset($_GET['msg'])){$message=$_GET['msg'];}
if($loggedin==0){redirect_to("login.php");
exit();}
if(isset($_POST['submit'])){
//form handling

$lname=$_POST['lname'];
$fname=$_POST['fname'];

$lname=preg_replace("#[^0-9a-z]#i","",$lname);
$fname=preg_replace("#[^0-9a-z]#i","",$fname);
if(isset($_POST['about'])){$about=$_POST['about'];$about=mysql_real_escape_string($about);}
else{$about="";}

if((!$fname)||(!$lname)){
$message="Failed to update details ! You need to enter both firstname and lastname!";}

else{

$query="UPDATE `doctors` SET `firstname`='$fname',`lastname`='$lname',`about`='$about' WHERE username='$session_username'";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
 if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
$message="Yay! You have Updated your profile Sucessfully";
$goto ='profile.php?msg='.$message;
redirect_to($goto);
}

}



if($session_id){

$query="SELECT * FROM doctors WHERE id='$session_id' LIMIT 1";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
$row=$result->fetch_array();
 if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
}else{redirect_to('login.php?msg="error please login again!"');}
include('includes/head.php');
?>
<div class="clear"></div>
<div class="content">
<?php 
echo "<h1 id='dhead'>Hello Dr.".ucfirst($row[2])."! | Update your info</h1><hr/>";?>
<div class="dbody">
<?php 
if(!empty($message)){echo "<p class='error'>".$message."</p>";}
$about=$row['about'];
echo '<form action="edit_profile.php" method="post">About me  :   <br/><textarea cols=105 rows=3 name="about" >'.$about.'</textarea></br>Firstname  :   <input type="text" size=25 maxlength=25 value="'.$row['firstname'].'" name="fname"/></br>Lastname  :   
<input type="text" size=25 maxlength=25 name="lname" value="'.$row['lastname'].'"/></br>
<input type="submit" value="Submit!" name="submit"/>
</form>'; ?><h3><a href='reset_password.php'>Change Password!</a></h3>

</div>
</div>



<?php include('includes/foter.php');

$connection->close();?>


</body></html>