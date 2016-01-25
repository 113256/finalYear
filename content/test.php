<?php

require("../includes/connect.php");
		require("../includes/string.php");

$rowCountQuery = "SELECT COUNT(*) FROM moviename";
		$rowCount = mysqli_query($conn, $rowCountQuery);
		$row = mysqli_fetch_array($rowCount);
		echo $row[0];

?>