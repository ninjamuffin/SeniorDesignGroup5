<?php
class FormClassTest extends PHPUnit_Framework_TestCase
{
	public function testStringIsConstructed()
	{
		$a = new FormClass("hello world");
		$this->assertEquals("hello world", $a->getString());
	}

	public function testCheckStringLength()
	{
		$a = new FormClass("hello world");
		$b = new FormClass("this string is too long.");
		$myLen = 15;
		$aResult = $a->checkStringLength($a->getString(), $myLen);
		$bResult = $b->checkStringLength($b->getString(), $myLen);
		$this->assertEquals(true, $aResult);
		$this->assertEquals(false, $bResult);
	}

	public function testMyEncrypt()
	{
		$mySalt = "i'm super salty about phpunit";
		$a = new FormClass("i am a string.");
		$classEncrypted = $a->myEncrypt($mySalt);
		$encrypted = crypt($a->getString(), $mySalt);
		$this->assertEquals($encrypted, $classEncrypted);
	}

	public function testIsEmail()
	{
		$a = new FormClass("howdy");
		$b = new FormClass("example.com");
		$c = new FormClass("gonzaga.edu");

		$this->assertEquals(false, $a->isEmail());
		$this->assertEquals(true, $b->isEmail());
		$this->assertEquals(true, $c->isEmail());
	}

	public function testGetNumSymbols()
	{
		$a = new FormClass("what the !#$@");
		$b = new FormClass("im a good boy");

		$this->assertEquals(4, $a->getNumSymbols());
		$this->assertEquals(0, $b->getNumSymbols());
	}
}
?>
