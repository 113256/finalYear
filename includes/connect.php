<?php 


//mysql database variables which we connect to 
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'final year';
    $tablename = 'movies';
    
    try {
        $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    } catch (Exception $e ) {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
   



?>

    


