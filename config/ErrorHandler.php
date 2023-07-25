<?php
namespace config;

class ErrorHandler extends \Exception 
{
	public function errorMsgQuery(){
		$error_msg= 'Kesalahan pada query di baris '.$this->getLine().' pada file '.$this->getFile().' <b> Pesan Error : '.$this->getMessage().'</b>';
		return $error_msg;
	}
}


?>