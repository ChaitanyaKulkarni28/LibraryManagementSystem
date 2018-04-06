<?php

    $dbhost="localhost";
    $dbuser="root";
    $dbpassword="";
    $dbname="library";
    /*$config_sitename="Library";
    $config_baseurl="http://localhost/Project1/csmb_db";
    $config_author="CSMB Team";*/
    
    $db= mysqli_connect($dbhost, $dbuser, $dbpassword);
  
    if(!$db)
        echo "Database not connected successfully";
  
    $dbselect=  mysqli_select_db($db,$dbname);
 
?>
