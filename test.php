<?php
include('includes/string.php');
/*$a=5;
echo "'$a' b c";
$url = $_SERVER['PHP_SELF'];
if(strpos($url, "tesst")!=false){
	echo "found";
}

$needle = "href";
$haystack = "jackhrf=adas";
if (strrpos($haystack, $needle)==false){
	echo "not foundl";
} else {
	echo "sdasd";
}*/

//mysql database variables which we connect to 
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'final year';
   // $tablename = 'testHalf';
    
    try {
        $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    } catch (Exception $e ) {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


    /*$i=2;

	echo $i."<br>";


	$rowCountQuery = "SELECT COUNT(*) FROM testHalf";
	$rowCount = mysqli_query($conn, $rowCountQuery);
	$rowCountRow = mysqli_fetch_array($rowCount);
	$rowCount = $rowCountRow[0];
	echo "number of rows is ".$rowCount."<br>";
	$count = ceil($rowCount/2);

	echo "count ".$count."<br>";

	if($i == 1){
		$selectQuery = "SELECT id FROM testHalf LIMIT $count";
	} else if($i == 2){
		//(SELECT * FROM table ORDER BY id DESC LIMIT 50) ORDER BY id ASC
		$selectQuery = "SELECT * FROM (
						    SELECT * FROM testHalf ORDER BY id DESC LIMIT $count
						) sub
						ORDER BY id ASC";
	}
	$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

	while ($row = mysqli_fetch_array($selectResult)){
		echo $row['id']."<br>";
	}
*/

	$i=2;
	$counter = 1;

	$rowCountQuery = "SELECT COUNT(*) FROM imdb";
		$rowCount = mysqli_query($conn, $rowCountQuery);
		$rowCountRow = mysqli_fetch_array($rowCount);
		$rowCount = $rowCountRow[0];
		echo "number of rows is ".$rowCount."<br>";
		$count = ceil($rowCount/2);
		echo "updating ".$count." rows<br>";

		if($i == 1){
			$selectQuery = "SELECT * FROM imdb LIMIT $count";
		} else if($i == 2){
			//(SELECT * FROM table ORDER BY id DESC LIMIT 50) ORDER BY id ASC
			$selectQuery = "SELECT * FROM (
							    SELECT * FROM imdb ORDER BY movieId DESC LIMIT $count
							) sub
							ORDER BY movieId ASC";
		}
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		while ($row = mysqli_fetch_array($selectResult)){
			if(IsEmpty($row['imdbID'])){
				continue;
			}
			echo $counter." ";
			$counter++;
			echo $row['movieId']." ".$row['imdbID']."<br>";

		}
?>