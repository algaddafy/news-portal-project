<?php 

include 'config.php';

if($_SESSION['user_role'] == '0'){
  header("location: post.php");
}

$rcv_id = $_GET['id'];

$query = "DELETE FROM user WHERE user_id = '{$rcv_id}'";

$result = mysqli_query($connection,$query);

if($result){
	header("location: users.php");
}else{
	echo "Can't Delete User.";
}

mysqli_close($connection);

?>