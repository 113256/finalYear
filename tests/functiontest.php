<?php
include('../functions/string.php');
include('copiedFunctions.php');

class functionTest extends PHPUnit_Framework_TestCase
{

	
	//test functions must start with "test"
	public function testNormalize(){
		$unNormalized = "+@Aabc";
		$result = normalize($unNormalized);
		$this->assertEquals("aabc",$result);
	}

	public function testNormalizeCase(){
		$unNormalized = "+@Aabc";
		$result = normalizeCaseSen($unNormalized);
		$this->assertEquals("Aabc",$result);
	}

	public function testEmpty(){
		 //if(empty($field) or str_replace(" ", "", $field)=='N/A' or $field=='0.0' or $field=='0' or $field==' '){
		$empty1 = "N/A";
		$empty2 = " ";
		$empty3= "";
		$empty4 = "0.0";
		$empty5 = "0";

		$this->assertTrue(IsEmpty($empty1));
		$this->assertTrue(IsEmpty($empty2));
		$this->assertTrue(IsEmpty($empty3));
		$this->assertTrue(IsEmpty($empty4));
		$this->assertTrue(IsEmpty($empty5));
	}

	public function testFuzzymatch(){
		$word1 = "+@abc";
		$word2 = "@@@Abc";
		$this->assertTrue(fuzzy_match($word1,$word2));
	}

	public function testRatingString(){
			
		$this->assertEquals("[1451692800000,1841],[1451692800000,1841],[1451692800000,1841]",printChartData(0, "test"));
		$this->assertEquals("[1451692800000,7.8],[1451692800000,7.8],[1451692800000,7.8]",printChartData(1, "test"));
	}

	public function testSentimentString(){
			
		$this->assertEquals("[1449304204000,3],[1449520204000,4]",printSentiment(0, "test"));
		$this->assertEquals("[1449304204000,1],[1449520204000,1]",printSentiment(1, "test"));
		$this->assertEquals("[1449304204000,17],[1449520204000,12]",printSentiment(2, "test"));
		$this->assertEquals("[1449304204000,21],[1449520204000,17]",printSentiment(3, "test"));
	}



	
}


?>