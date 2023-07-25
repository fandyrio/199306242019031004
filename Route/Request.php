<?php
	namespace Route;
	class Request {
		public function __construct(){
			$jumlah=count($_POST);
			for($a=0;$a<$jumlah;$a++){
				$array_key=array_keys($_POST);
				$this->{$array_key[$a]}=$_POST[$array_key[$a]];
			}
		}
	}




?>