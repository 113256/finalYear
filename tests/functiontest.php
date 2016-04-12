<?php
include('../functions/string.php');

class functionTest extends PHPUnit_Framework_TestCase
{
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
}


?>