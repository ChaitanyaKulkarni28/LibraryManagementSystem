<?php
	include 'assets/connect.php';
	
	$isbn=$_GET["isbn"];
	
	$sql2 = "select * from book_loans where isbn='$isbn' and date_in is null";
	$result2 = mysqli_query($db,$sql2);
	$row2 = mysqli_fetch_array($result2);
	
	if($result2->num_rows > 0)
	{
		echo "Book is not available for checkout";	
	}
	else
	{
		echo "Book is available!!";
	}
	
?>