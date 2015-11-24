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
		return ($string->strlen() < $len);
	}

	public function myEncrypt()
	{
		return $form_string->encrypt();
	}

	public function isEmail?()
	{
		array endings ([".com", ".edu"]);
		for s in endings {
		 $count = $form_string->substr_count(s);
		 if ($count == 1)
			return true;
		}
		return false;
	}

	public function getNumSymbols()
	{
		array symbols (["!", "@", "#", "$", "%", "^", "&", "*", "(", ")"]);
		$count = 0;
		for s in symbols {
		 $count += $form_string->substr_count(s);
		}
		return $count;
	}
}
?>
