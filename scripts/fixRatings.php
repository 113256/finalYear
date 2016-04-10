<?php
	$dir = new DirectoryIterator(dirname("../ratings/tt0005044.php"));
	foreach ($dir as $fileinfo) {
	    if (!$fileinfo->isDot()) {
	        //var_dump($fileinfo->getFilename());
	        $name = $fileinfo->getFilename();
	        $file = file_get_contents("../ratings/".$name);
			
			$allArray = explode("/", $file);
			//print_r($allArray);
			array_pop($allArray);


			$resultArray = [];


			foreach ($allArray as $field){
				$temp = [];
				$array = explode(":", $field);
				//print_r($array);
				$date = $array[0];
				$rating = $array[1];
				$votes = $array[2];

				$rating = str_replace(",", ".", $rating);
				//$votes = str_replace(array(" ","."), "", $votes);
				$votes = preg_replace('/[^\d]+/i', '', $votes);
	    		echo $rating." ".$votes."\n";


				$temp[0]= $date;
				$temp[1] = $rating;
				$temp[2] = $votes;

				$tempString = implode(":", $temp); //turn array with a string, each array index separated by ";"
				$resultArray[] = $tempString;

	    	}

	    	$result = implode("/", $resultArray); 
	    	$result.="/";

	    	$filename = "../ratings/".$name;

			if(file_put_contents($filename,$result) !=false){
			    echo "appended (".basename($filename).")";
			}else{
			    echo "Cannot create file (".basename($filename).")";
			}

			
}
}
	


?>