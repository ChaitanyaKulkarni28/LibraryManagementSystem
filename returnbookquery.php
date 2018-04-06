<?php

	include 'assets/connect.php';

	$isbn=$_GET["isbn"];
	$card = $_GET["cid"];
	$fine = $_GET["finetopay"];
	$sql = "update book_loans set date_in=curdate() where isbn='$isbn' and card_id='$card'";
	$res = mysqli_query($db,$sql);
	
	/*if ($res) 
		echo "Book Successfully Returned.";*/
	
	
	//$date=$parts[2];
	$sql1 = "select loan_id,due_date from book_loans where isbn='$isbn' and card_id=$card";
	$res1= mysqli_query($db,$sql1);
	
	$row1 = $res1->fetch_assoc();
	$l = $row1['loan_id'];
	//$d = $row['due_date'];
	
	$sql3 = "select loan_id from fines where loan_id=$l";
	$res3 = mysqli_query($db,$sql3);
	if($res3->num_rows > 0)
	{	
		$sql4 = "update fines set fine_amt = fine_amt - $fine  where loan_id = '$l'";
		$res4 = mysqli_query($db,$sql4);
		if($res4)
		{
			echo "Fines updated";
		}
	}
	else
	{
		$sql5 = "insert into fines values('$l','$fine','1')";
		$res5 = mysqli_query($db,$sql5);
		if($res5)
		{
			echo "Fines paid";
		}	
	}	
	
?>