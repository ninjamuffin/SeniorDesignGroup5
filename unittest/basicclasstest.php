<?php
class MyClassTest extends PHPUnit_Framework_TestCase
{

	public function testTheConstructor()
	{
		$a = new MyClass("hello world");
		$this->assertEquals("hello world", $a->getString());
	}
}
?>
