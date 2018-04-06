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
		<!---	  <li><a href="book-issue.php">Issue a book</a></li> -->
			  <li><a href="checkin.php">Checkin a book</a></li>
              <li class="active"><a href="newborrower.php">Register new borrower</a></li>
         </ul>
        </div>
    </nav>
    <div class="row content-row">
      
        <div class="col-md-12">
          <p class="content-title">Register new borrower</p>
        </div>
        <div class="col-md-12">
          <form method="post" class="dues">
            <p align="center">
            <table>
              <tr>
                <td>
                  <label>Name: </label>
                </td>
                <td>
                  <input type="text" name="name">
                </td>
              </tr>
              <tr>
                <td>
                  <label>SSN: </label>
                </td>
                <td>
                  <input type="text" name="ssn">
                </td>
              </tr>
              <tr>
                <td>
                  <label>Address: </label>
                </td>
                <td>
                  <input type="text" name="address">
                </td>
              </tr>
			  
			  <tr>
                <td>
                  <label>Phone: </label>
                </td>
                <td>
                  <input type="text" name="phone">
                </td>
              </tr>
              
            </table>
            <p align="center">
            
            <input type="submit" name="register" value="Register"></p>
          </form>
        </div>
       
	    <?php
		
			include 'assets/connect.php';
			if(isset($_POST['register']))
			{
				if(!empty($_POST['name']) && !empty($_POST['ssn']) && !empty($_POST['address']) && !empty($_POST['phone']))
				{	
					$n = $_POST['name'];
					$s = $_POST['ssn'];
					$a = $_POST['address'];
					$p = $_POST['phone'];
					$sql = "select max(card_id) as new from borrower";
					$result=mysqli_query($db,$sql);
					$row = mysqli_fetch_array($result);
					$i = $row['new'];
					$i=$i+1;
					
					$sql2 = "insert into borrower values('$i','$s','$n','$a','$p')";
					$r = mysqli_query($db,$sql2);
					
					if($r)
					{
						//echo "Borrower successfully registered!!!";
						echo "<div align='center' style ='font:30px/21px Arial,tahoma,sans-serif;color:#ff0000'>Borrower successfully registered!!!</div>";
					}
					else
					{
						//echo "SSN already exists!!!";
						echo "<div align='center' style ='font:30px/21px Arial,tahoma,sans-serif;color:#ff0000'> SSN already exists!!!</div>";
					}
				}	
				else
				{
					echo "<div align='center' style ='font:30px/21px Arial,tahoma,sans-serif;color:#ff0000'> Enter all fields!!!</div>";
				}					
			}
		?>
		
        <div class"col-md-12">
         
        </div>
    </div>
    </div>
 </div>
  

</body>
</html>