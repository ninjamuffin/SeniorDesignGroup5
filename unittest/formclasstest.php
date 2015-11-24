<?php
class FormClassTest extends PHPUnit_Framework_TestCase
{
	public function testStringIsConstructed()
	{
		$a = new FormClass("hello world");
		$this->assertEquals("hello world", $a->getString());
	}

	public function checkStringLengthTest()
	{
		$a = new FormClass("hello world");
		$b = new FormClass("this string is too long.");
		$myLen = 15;
		$aResult = $a->checkStringLength($a->getString(), $myLen);
		$bResult = $b->checkStringLength($b->getString(), $myLen);
		$this->assertEquals(true, $aResult);
		$this->assertEquals(false, $bResult);
	}

	public function myEncryptTest()
	{
		$a = new FormClass("i am a string.");
		$encrypted = $a->myEcrypt();
		$this->assertEquals($encrypted, $a->getString()->encrypt());
	}

	public function isEmailTest()
	{
		$a = new FormClass("howdy");
		$b = new FormClass("example.com");
		$c = new FormClass("gonzaga.edu");

		$this->assertEquals(false, $a->isEmail?());
		$this->assertEquals(true, $b->isEmail?());
		$this->assertEquals(true, $c->isEmail?());
	}

	public function getNumSymbolsTest()
	{
		$a = new FormClass("what the !#$@");
		$b = new FormClass("im a good boy");

		$this->assertEquals(4, $a->getNumSymbols());
		$this->assertEquals(0, $b->getNumSymbols());
	}
}
?>
