<?php

session_start();

if(!isset($_SESSION["session_username"]))
{
 header("location:login.php");
}
 else
 {
?>
	
<?php include("Includes/header.php"); ?>

<div id="welcome">

<h2>Добро пожаловать, <span><?php echo $_SESSION['useropis'];?> ! </span></h2>
  <p><a href="Includes/logout.php">Выйти</a> из системы</p>

<?php include("index.php"); ?>  
</div>
	
<?php include("includes/footer.php"); ?>
	
<?php } ?>