<?php
namespace Route;
use Route\Route;
class Router extends Route{
	public static function count_route($method) {
		$data=parent::countRoute($method);
		return $data;
	}
	public static function matchMethod($method){
		//Membandingkan antara method yang di ambil dari Router:: dengan Method yang didapatkan dari URI
		$getMethod=self::getMethod();
		if($getMethod === $method){
			return true;
		}
		return false;
	}
	public static function beforeAccess(){
        return true;
    }
	public static function getMethod()
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	public static function goto($end_point)
	{
		parent::contentToRender();
	}
	public static function get($end_point, $controller_method)
	{
		$matchMethod=self::matchMethod('get');
		if($matchMethod){
			#Menghitung jumlah 
			$num_call=self::count_route('get');
			parent::validateRequest($end_point, $controller_method, $num_call);
		}
	}
	public static function post($end_point, $controller_method)
	{
		$matchMethod=self::matchMethod('post');
		if($matchMethod){
			$num_call=self::count_route('post');
			parent::validateRequest($end_point, $controller_method, $num_call);
		}
	}
}
?>