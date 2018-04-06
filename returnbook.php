<?php
	include 'assets/connect.php';
	
	$isbn=$_GET["isbn"];
	
	$sql2 = "select datediff(curdate(),due_date)*0.25 as fine from book_loans where isbn='$isbn'";// and card_id='$cid'";
	$result2 = mysqli_query($db,$sql2);
	$row2 = mysqli_fetch_array($result2);
	$f = $row2['fine'];
	
	if($row2['fine'] > 0)
	{
		echo $row2['fine'];	
	}
	else
	{
		echo "0";
	}
	
?>