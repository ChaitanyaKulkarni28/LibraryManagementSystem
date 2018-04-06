
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
<body>
 
<script>
function bookcheck(x) {
    
				if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
				else
				{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
					xmlhttp.open("GET","indexbookcheck.php?isbn="+x,true);
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
				      <li class="active"><a href="index.php">Home</a></li>
				      <li><a href="check-dues.php">Check For Dues</a></li> <!-- Add page link in href -->
				<!---      <li><a href="book-issue.php">Issue a book</a></li> -->
					  <li><a href="checkin.php">Checkin a book</a></li>
					  <li><a href="newborrower.php">Register new borrower</a></li>
				</ul>
		    </div>
		</nav>
 		<div class="row content-row">
 			
  			<div class="col-md-12">
  				<p class="content-title">Search for the books you want</p>
  			</div>
  			<div class="col-md-12">
  				<form method="post" class="book-search">
  					<p align="center">
  					<input type="text" name="book-name">
  					<input type="submit" name="searchb" value="Go">
  				</form>
  			</div>
			<p id="demo"></p>			

			<?php
			include 'assets/connect.php';
			if(isset($_POST['searchb']))
			{
				if(!empty($_POST['book-name']))
				{	
			
					echo "<div class=\"col-md-12 search-res\">
									<table id=\"showhide\"  style=\"table-layout:fixed;\">
									<thead>
									  <tr>
										<th>ISBN</th>
										<th>TITLE</th>
										<th>AUTHOR</th>	
										<th>ISSUE A BOOK</th>
										<th>CHECK AVAILABILITY</th>		
									  </tr>
									</thead>";
							echo "<tbody>";
					$bk=$_POST['book-name'];
					
					$parts = explode(" ",$bk);
					$x="";
					for ($i = 0; $i <count($parts); $i++) 
					{
						$parts[$i]=trim($parts[$i]);
						if(strcmp($parts[$i],""))
						{
							//$x.=" '%$parts[$i]%' ";
							$x.=" b.isbn  like '%$parts[$i]%' or b.title like '%$parts[$i]%' or a.name like '%$parts[$i]%' ";
							if($i<count($parts)-1)
								$x.=" or ";
						}
					}
					
					
					/*	$sql12 = "select b.isbn,b.title,GROUP_CONCAT(a.name) as name from book as b inner join book_authors on b.isbn = book_authors.isbn
								  inner join authors as a on book_authors.author_id = a.author_id where  b.isbn  like ($x) or b.title like ($x) 
								  or a.name like ($x) group by isbn";*/
								  
						$sql12 = "select b.isbn,b.title,GROUP_CONCAT(a.name) from book as b NATURAL JOIN book_authors NATURAL JOIN authors
						as a where ($x) group by isbn";		  

						$result=mysqli_query($db,$sql12);
					
					$sql34 = "select isbn from book_loans where date_in is null";
					$nobooks = mysqli_query($db,$sql34);
					$t="";
					if($nobooks->num_rows > 0)
					{
						while($row = $nobooks->fetch_assoc())
						{
							$t.=$row['isbn'];
							$t.=",";
						}
					}
	
						if($result)
						{
									
							while($row = mysqli_fetch_array($result))
							{
							echo "<tr>";
							echo "<td>" . $row['isbn'] . "</td>";
							echo "<td>" . $row['title'] . "</td>";
							echo "<td>" . $row['GROUP_CONCAT(a.name)'] . "</td>";
						//	echo "<td><input type='button' name='search' value='Issue Book' onclick=myFunction('$t$row[isbn]');></td>";
							echo "<td> <a href = 'book-issue.php?issueisbn=$row[isbn]&bkname=$row[title]'> <button>Issue book</button> </a> </td>";
							echo "<td> <input type='button' name='avail' value='Check Availability' onclick=bookcheck('$row[isbn]');></td>";
							// add $t$row[isbn] bkname=$t$row[title]
							echo "</tr>";
							}
						}
					  
					 
				}	
			}
			?>
			
  	</div>
  	</div>
 </div>
  

</body>
</html>
