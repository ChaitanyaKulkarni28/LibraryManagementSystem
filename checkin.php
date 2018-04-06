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
function bookreturn(x,c)
{
	var p = confirm("Do you want to return this book with ISBN = "+x+" for card ID = "+c+"?");
	if(p == true)
	{
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET","returnbook.php?isbn="+x,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				
				var1 =  xmlhttp.responseText
				pay = confirm("Amount you need to pay is: "+var1+" $. Pay?");
				
				if(pay == true)
				{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.open("GET","returnbookquery.php?isbn="+x+"&cid="+c+"&finetopay="+var1,true);
					xmlhttp.send();
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							//document.getElementById("searchresults")=xmlhttp.responseText;
							confirm(xmlhttp.responseText);						
							
						}
					}
				}
			}
		}
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
              <li><a href="check-dues.php">Check For Dues</a></li> <!-- Add new li for new page and page link in href -->
		<!---	  <li><a href="book-issue.php">Issue a book</a></li> -->
              <li class="active"><a href="checkin.php">Check in book</a></li>
			  <li><a href="newborrower.php">Register new borrower</a></li>
         </ul>
        </div>
    </nav>
    <div class="row content-row">
      
        <div class="col-md-12">
          <p class="content-title">Check in a Book</p>
        </div>
        <div class="col-md-12">
          <form method="post" class="dues">
            <p align="center">
            <table>
              <tr>
                <td>
                  <label>Card ID: </label>
                </td>
                <td>
                  <input type="text" name="isbn">
                </td>
              </tr>
              <!---<tr>
                <td>
                  <label>Borrower Name: </label>
                </td>
                <td>
                  <input type="text" name="borrower-name">
                </td>
              </tr>
              <tr>
                <td>
                  <label>Borrower card no.: </label>
                </td>
                <td>
                  <input type="text" name="card-id">
                </td>
              </tr> -->
              
            </table>
            <p align="center">
            
            <input type="submit" name="checkin" value="Get all"></p>
          </form>
        </div>
		
		
       
        <div class"col-md-12">
         <?php
		  include 'assets/connect.php';
		  if(isset($_POST['checkin']))
		  {
			$card_id = $_POST['isbn'];	
			//$cid = $_POST['card-id'];
			
			/*if(isset($_POST['isbn']))
			{
				echo "Enter your borrower id!!!"; 
			}*/
			
			echo "<div class=\"col-md-12 search-res\">
									<table id=\"showhide\"  style=\"table-layout:fixed;\">
									<thead>
									  <tr>
										<th>Borrower ID</th>
										<th>Borrower Name</th>
										<th>ISBN</th>	
										<th>Title BOOK</th>	
										<th>Check IN</th>	
									  </tr>
									</thead>";
							echo "<tbody>";
							
			$sql55 = "select bo.card_id, bo.bname, b.isbn, b.title
						from borrower bo inner join book_loans bl
						on bo.Card_ID = bl.card_id inner join book b
						on b.isbn = bl.isbn
						where bo.card_id = '$card_id' and date_in is NULL";

			$res55 = mysqli_query($db,$sql55);
			
			if($res55->num_rows > 0)
				{
							
					while($row = mysqli_fetch_array($res55))
					{
					echo "<tr>";
					echo "<td>" . $row['card_id'] . "</td>";
					echo "<td>" . $row['bname'] . "</td>";
					echo "<td>" . $row['isbn'] . "</td>";
					echo "<td>" . $row['title'] . "</td>";
					echo "<td> <input type='button' name='in' value='Checkin Book' onclick=bookreturn('$row[isbn]','$card_id');></td>";
					//$f = $row['isbn'];
					
					
					//echo "<td> <input type='button' name='checkin' value='CheckIN Book'> </td>";
					echo "</tr>";
					}
					//echo $fn;
				}
				
				else
				{
					echo "Sorry, you don't have any books checked out.";
				}
				
			
			//---------------------------------------------------------------------------------------------------------
			/*
			$sql1 = "select count(*) from book_loans where isbn='$isb' and card_id='$cid' and (due_date < curdate())";
			$result1 = mysqli_query($db,$sql1);
			$row1 = mysqli_fetch_array($result1);
			$i = $row1["count(*)"];

			$sql2 = "select datediff(curdate(),due_date)*0.25 as fine from book_loans where isbn='$isb' and card_id='$cid'";
			$result2 = mysqli_query($db,$sql2);
			$row2 = mysqli_fetch_array($result2);
			$f = $row2["fine"];
			if($i >= 1)
			{
				//$fine = $f * 0.25;
				echo "You have to pay fines ".$f."$";	
			}
			
			else
			{
				$sql = "update book_loans set date_in=curdate() where isbn='$isb' and card_id='$cid'";
				$result = mysqli_query($db,$sql);
				
				if($result)
				{
					echo "Book returned";
				}
				
				else
				{
					echo "Book was not returned please check your ISBN and/or BORROWER ID";
				}
			}*/
				
		  }
		    
			 
		  
		  
		  ?>
        </div>
    </div>
    </div>
 </div>
  
  
  

</body>
</html>