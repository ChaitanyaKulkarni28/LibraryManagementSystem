<!DOCTYPE html>
<html lang="en">
<head>
  <title>Library</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style1.css">
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery-3.2.1.min.js"></script>
</head>

<script>
function checkduespay(fine,card,loanid)
{
	var p = confirm("Are you sure you want to Check in and Pay fine of "+fine+"$ for the Card ID "+card+" ?");
	if(p==true)
	{
		var xmlhttp="";
		if (window.XMLHttpRequest)
		{  
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		}	
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				confirm(xmlhttp.responseText);   
			}	  
		}  
		xmlhttp.open("GET","check_dues_query.php?loan_id="+loanid,true);  
		xmlhttp.send();
	}
}
</script>


<div class="container-fluid">
  <div class="row title-row">
    <div class="col-md-12">
      <p class="page-title">My Library</p>
    </div>
  </div>
 </div>
 <div class="row">
  <div class="col-md-12">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li  class="active"><a href="check-dues.php">Check For Dues</a></li> <!-- Add page link in href -->
          <!---    <li><a href="book-issue.php">Issue a book</a></li> -->
			  <li><a href="checkin.php">Checkin a book</a></li>
			  <li><a href="newborrower.php">Register new borrower</a></li>
         </ul>
        </div>
    </nav>
    <div class="row content-row">
      
        <div class="col-md-12">
          <p class="content-title">Check If You Have Any Dues</p>
        </div>
        <div class="col-md-12">
          <form method="post" class="dues">
            <p align="center">
            <label>Enter your Card ID: </label>
            <input type="text" name="id">
            <input type="submit" name="search" value="Check"></p>
			<p align="center">
			<input type="submit" name="fine-update" value="Update Fines"></p>
          </form>
        </div>
		
		
		<?php
			include 'assets/connect.php';
			if(isset($_POST['fine-update']))
			{
			$l='';
			$d='';
			
			$sql1 = "select loan_id,due_date from book_loans where due_date<curdate() and date_in is null";
			$result1 = mysqli_query($db,$sql1);
			if ($result1->num_rows > 0) 
			{
				while($row1 = $result1->fetch_assoc())
				{
					$l=$row1['loan_id'];
					$d=$row1['due_date'];
					$sql2 = "select loan_id from fines where loan_id=$l and paid=0";
					$result2 = mysqli_query($db,$sql2);
					if($result2->num_rows > 0)
					{	
						$sql4="update fines set fine_amt=((SELECT DATEDIFF(curdate(),'$d'))*0.25) where loan_id=$l";
						$res4 = mysqli_query($db,$sql4); 
						if($res4)
						{
							echo "Update Successfull.";
						}
					}
					else
					{
						$sql3="insert into fines values($l,((SELECT DATEDIFF(curdate(),'$d'))*0.25),FALSE)";
						$res3 = mysqli_query($db,$sql3); 
						if($res3)
						{
							echo "Insert Update Successfull.";
						}
					}
				}
			}
			
			}
			
			if(isset($_POST['search']))
			{
				$cardno = $_POST['id'];
				if(!empty($_POST['id']))
				{	
			
					echo "<div class=\"col-md-12 search-res\">
									<table id=\"showhide\"  style=\"table-layout:fixed;\">
									<thead>
									  <tr>
										<th>LOAN ID</th>
										<th>CARD ID</th>
										<th>ISBN</th>	
										<th>FINE AMOUNT</th>	
										<th>PAY FINE</th>		
									  </tr>
									</thead>";
					echo "<tbody>";
					
					$sql44 = "select * from book_loans INNER JOIN fines on book_loans.loan_id = fines.loan_id and book_loans.card_id='$cardno'
							AND book_loans.date_in is null";
					$res44 = mysqli_query($db,$sql44);
					
					if($res44)
						{
									
							while($row44 = mysqli_fetch_array($res44))
							{
							echo "<tr>";
							echo "<td>" . $row44['loan_id'] . "</td>";
							echo "<td>" . $row44['card_id'] . "</td>";
							echo "<td>" . $row44['isbn'] . "</td>";
							echo "<td>" . $row44['fine_amt'] . "</td>";
							if($row44['fine_amt'] > 0)
							{
								echo "<td> <input type='button' name='payb' value='Pay' onclick=checkduespay('$row44[fine_amt]','$cardno','$row44[loan_id]'); ></td>";
								
							}	
							echo "</tr>";
							}
						}
				}
				
				$sql11="select sum(fine_amt) from fines natural join book_loans where card_id='$cardno' and paid=0 group by card_id";
				$result11 = mysqli_query($db,$sql11);
				$row11 = $result11->fetch_assoc();
				$i11 = $row11['sum(fine_amt)'];
				if($i11>0)
					
					echo "<div align='center' style ='font:30px/21px Arial,tahoma,sans-serif;color:#ff0000'>Total due = $i11 $.</div>";
				else
					echo "<div align='center' style ='font:30px/21px Arial,tahoma,sans-serif;color:#ff0000'>No Dues!!!</div>";
			}
		?>
        <div class"col-md-12">
         
        </div>
    </div>
    </div>
 </div>
  

</body>
</html>