<?php
	include 'assets/connect.php';
	$l=$_GET["loan_id"];
	
	$sql2 = "update book_loans set date_in=curdate() where loan_id = '$l'";
	$res2 = mysqli_query($db,$sql2);
	
	
	$sql = "update fines set paid=true where loan_id=$l";
	$res = mysqli_query($db,$sql);
	
	if ($res2 && $res) 
		echo "Fine Payment Successfull";
	
?>