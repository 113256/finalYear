<?php 
	function normalize($s){
		$lower = strtolower($s);
		$trim = trim( preg_replace( "/[^0-9a-z]+/i", " ", $lower ) );
		return str_replace(" ", "", $trim);
	}

	//URL IN SERVER IS CASE SENSITIVE	
	function normalizeCaseSen($s){
		//$lower = strtolower($s);
		$trim = trim( preg_replace( "/[^0-9a-zA-Z]+/i", " ", $s ) );
		return str_replace(" ", "", $trim);
	}

	function fuzzy_match($x,$y){
		return normalize($x)==normalize($y);
	}


		function IsEmpty($field) {
			    //code to be executed;
			    if(empty($field) or $field=='N/A' or $field=='0.0' or $field=='0' or $field==' '){
			    	return true;
			    } else {
			    	return false;
			    }
			}



	function downloadPoster($movieId, $posterUrl){

		//require("includes/connect.php");
		set_time_limit(3600);


		$filename = normalize($movieId);
		$file = '../poster/'.$filename.'.jpg';


		if(!empty($posterUrl)){
			echo $file."made <br>";
			if(!file_exists($file)){
				copy($posterUrl, $file);
			} else {
				echo "already exists";
			}
			
		}else{
			echo "EMPTY <br>";
		}
			

		}

	



		function contains($str, array $arr)
		{
		    foreach($arr as $a) {
		        if (stripos($str,$a) !== false) return true;
		    }
		    return false;
		}


		$stopwords = array("a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although","always","am","among", "amongst", "amoungst", "amount",  "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around", "as",  "at", "back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "eight", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the");




		function calcAverageRating($meta, $imdb, $tomato, $tomatoUser){
			if(IsEmpty($meta) or IsEmpty($imdb) or IsEmpty($tomato) or IsEmpty($tomatoUser)){
	 		//$average = "N/A";
	 		if(IsEmpty($meta) and IsEmpty($tomato) and IsEmpty($tomatoUser)){
	 			$average = $imdb*10;
	 		} else if(IsEmpty($imdb) and IsEmpty($tomato) and IsEmpty($tomatoUser)){
	 			$average = $meta;
	 		}else if(IsEmpty($meta) and IsEmpty($imdb) and IsEmpty($tomato) ) {
	 			$average = $tomatoUser/5*100;
	 		} else if (IsEmpty($tomato) and IsEmpty($tomatoUser)){
	 			$metaWeighting = ($meta/100)*50;
	 			$imdbWeighting = ($imdb/10)*50;
	 			$average = $metaWeighting + $imdbWeighting;
	 		} else if (IsEmpty($meta)){

			 	$imdbWeighting = ($imdb/10)*50;
				$tomatoWeighting  = ($tomato/10)*34;	
				$tomatoUserWeighting = ($tomatoUser/5)*16;
				$average =  $imdbWeighting + $tomatoWeighting + $tomatoUserWeighting;
	 		} else if (IsEmpty($tomato)){
	 			$metaWeighting = ($meta/100)*33;
	 			$imdbWeighting = ($imdb/10)*34;
	 			$tomatoUserWeighting = ($tomatoUser/5)*33;
	 			$average = $metaWeighting + $imdbWeighting + $tomatoUserWeighting;
	 		} else {
	 			$average = 0;
	 		}
	 	} else {
		  $metaWeighting = ($meta/100)*25;
	 	  $imdbWeighting = ($imdb/10)*25;
		$tomatoWeighting  = ($tomato/10)*34;	
		$tomatoUserWeighting = ($tomatoUser/5)*16;
	  $average = $metaWeighting + $imdbWeighting + $tomatoWeighting + $tomatoUserWeighting;
		}
			return $average;						
		}



	

?>