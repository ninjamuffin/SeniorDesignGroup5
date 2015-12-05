<?php
class formClass
{
	private $form_string; //a string entered by the user

	public function __construct($form_string) //constructor
	{
		$this->form_string = $form_string;
	}

	public function getString()
	{
		return $this->form_string;
	}

	public function checkStringLength($string, $len)
	{
		return (strlen($string) < $len);
	}

	public function myEncrypt($salt)
	{
		return crypt($this->form_string, $salt);
	}

	public function isEmail()
	{
		$endings=array(".com", ".edu");
		foreach ($endings as &$s) {
		 $count = substr_count($this->form_string, $s);
		 if ($count == 1)
			return true;
			
		}
		return false;
	}

	public function getNumSymbols()
	{
		$symbols=array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")");
		$count = 0;
		foreach ($symbols as &$s) {
		 $count += substr_count($this->form_string, $s);
		}
		return $count;
	}
}
?>
