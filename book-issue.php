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
              <li class="active"><a href="book-issue.php">Issue a book</a></li>
			  <li><a href="checkin.php">Checkin a book</a></li>
			  <li><a href="newborrower.php">Register new borrower</a></li>

         </ul>
        </div>
    </nav>
    <div class="row content-row">
      
	  <?php
	  $GetIsbn = $_GET['issueisbn'];
	  if(empty($GetIsbn))
	  {
		 $PutI = ""; 
	  }
	  else
	  {
		  $PutIsbn = explode(',',$GetIsbn);
		  $PutI = $PutIsbn[sizeof($PutIsbn)-1];
	  }		  
	  
	  
	  $GetName = $_GET['bkname'];
	   if(empty($GetName))
	  {
		 $PutN = ""; 
	  }
	  else
	  {
		  $PutName = explode(',',$GetName);
		  $PutN = $PutName[sizeof($PutName)-1];
	  }
	  ?>
        <div class="col-md-12">
          <p class="content-title">Issue Book</p>
        </div>
        <div class="col-md-12">
          <form method="post" class="dues">
			
            <p align="center">
            <table>
              <tr>
                <td>
                  <label> Borrower Card ID: </label>
                </td>
                <td>
                  <input type="text" name="cardid">
                </td>
              </tr>
              <tr>
                <td>
                  <label>ISBN: </label>
                </td>
                <td>
                  <input type="text" name="isbn" value="<?php echo $PutI; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <label>Book name: </label>
                </td>
                <td>
                  <input type="text" name="book-name" value="<?php echo $PutN; ?>">
                </td>
              </tr>
              
            </table>
            <p align="center">
            
            <input type="submit" name="sb" value="Issue"></p>
          </form>
        </div>
       
        <div class"col-md-12">
         
        </div>
		
		<?php
		
			include 'assets/connect.php';
			
			if(isset($_POST['sb']))
			{
				if(!empty($_POST['cardid']))
				{
					$x = $_POST['cardid'];
					$sqlcheck = "select Card_ID from borrower where Card_ID = '$x'";
					$sqlcheckres = mysqli_query($db,$sqlcheck);
					if($sqlcheckres->num_rows > 0)
					{	
						$sql = "SELECT max(loan_id) FROM book_loans";
						$result = mysqli_query($db,$sql);
						$row = mysqli_fetch_array($result);
						$id = $row["max(loan_id)"];
						$id = $id+1;
						
						$ib =$_POST['isbn'];
						$sql2 = "SELECT count(*) FROM book_loans WHERE card_id='$x' and date_in is null";
						$result2 = mysqli_query($db,$sql2);
						$row2 = mysqli_fetch_array($result2);
						$i = $row2["count(*)"];
						
						$sql8 = "select count(*) from book_loans where isbn = '$ib' and date_in is null";
						$res8 = mysqli_query($db,$sql8);
						$row8 = mysqli_fetch_array($res8);
						$ct = $row8["count(*)"];
						
						if($ct >= 1)
						{
							echo "Sorry, book is not available for checkout";
						}
						
						else
						{	
							if($i>=3)
							{
								echo "Sorry,you have already reached the limit of 3 books!!";
								//echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
							}
							else
							{
								$sql3 = "INSERT INTO book_loans(loan_id,isbn,card_id,date_out,due_date,date_in) 
									VALUES ('$id','$ib','$x',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 14 DAY),null)";
								if (mysqli_query($db,$sql3) === TRUE) 
								{
									echo "Book Successfully added to your account.";
								//	echo "<br><br><button type='button' onclick=fun();>Go Back to main page";	
								}	
								else
								{
									echo "Invalid Card ID or Card ID does not exixt in database!!!";
								//	echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
								}	
							}
						}
					}
					else
					{
						echo "Please check your borrower ID!!!";
					}						
				}
				else
				{
					echo "Please enter your borrower id.";
				}
			}
		
		?>
    </div>
    </div>
 </div>
  

</body>
</html>