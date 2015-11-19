<?php
class myClass
{
	private $my_string;

	public function __construct($my_string)
	{
		$this->my_string = $my_string;
	}

	public function getString()
	{
		return $this->my_string;
	}

}
