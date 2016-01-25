<?php
	$dir = new DirectoryIterator(dirname("../sentiment/4got10.php"));
	foreach ($dir as $fileinfo) {
	    if (!$fileinfo->isDot()) {
	        //var_dump($fileinfo->getFilename());
	        $name = $fileinfo->getFilename();
	        $file = file_get_contents("../sentiment/".$name);
			
			$allArray = explode("/", $file);
			//print_r($allArray);
			array_pop($allArray);
			$highestNeutral = 0;

			$resultArray = [];


			foreach ($allArray as $field){
				$array = explode(";", $field);
				//print_r($array);
				$neutral = $array[2];
				//$total = $array[3];
				//$positive = $array[0];
				//$negative = $array[1];

				if($neutral > $highestNeutral){
					$highestNeutral = $neutral;
				}
	    	}

	    	if($highestNeutral == 0){
	    		$highestNeutral = 15;
	    	}

	    	reset($allArray);
	    	foreach ($allArray as $field){

	    		$temp = [];

				$array = explode(";", $field);
				$neutral = $array[2];
				$total = $array[3];
				$positive = $array[0];
				$negative = $array[1];
				$date = $array[4];

				if($total == 0){
					$rand = rand($highestNeutral, $highestNeutral+5);
					$neutral = $rand;
					$total = $rand;
				}

				$temp[0]= $positive;
				$temp[1] = $negative;
				$temp[2] = $neutral;
				$temp[3] = $total;
				$temp[4] = $date;

				$tempString = implode(";", $temp); //turn array with a string, each array index separated by ";"
				$resultArray[] = $tempString;

	    	}

	    	$result = implode("/", $resultArray);
	    	$result.="/";

	    	$filename = "../sentiment/".$name;

			if(file_put_contents($filename,$result) !=false){
			    echo "appended (".basename($filename).")";
			}else{
			    echo "Cannot create file (".basename($filename).")";
			}

	}
}
	


?>