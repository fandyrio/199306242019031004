<?php
	namespace Controllers;
	use config\ErrorHandler;
	abstract class Controller
	{
		
		public $request;
		public $base_view_path;
		public function __construct(){
			//return $_POST[$request];
			$this->base_view_path="view/";
		}
		public function data_a(){
			return $_POST['data_a'];
		}
		public function request(){
			return true;
		}
		public static function setLinkAPI(){
			$env="live";
			if($env==="local"){
				//$link="";
			}else{
				$link="http://103.226.55.159/json/";
			}
			return $link;
		}
		
		public function view($view, $data=array())
		{
			$final_path=$this->base_view_path.''.$view.'.php';
			if(file_exists($final_path)){
				$num_data=count($data);
				if($num_data>0){
					foreach ($data as $key => $value) {
						$$key=$value;
					}
				}
				ob_start();
				include $final_path;
				$output = ob_get_clean();
				print $output;
			}else{
				echo "File not existed";
				require 'view/404.html';
			}
		}
		public function response(){
			echo "response";
		}
		//public function request()
	}


?>