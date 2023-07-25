<?php
namespace config;

class conn {
	public $conn;
	public static function connection(){
		$host="localhost";
		$dbname="sipp";
		$user="root";
		$password="";
		$conn=new \mysqli($host,$user,$password,$dbname);
		if(!$conn)
		{
			error_log(mysqli_connect_error());
			die("connection failed : Hubungi Pengembang");
		}
		else
		{
			return $conn;
		}
	}
	public static function connection2(){
		$host="localhost";
		$dbname="informasi_bagian";
		$user="root";
		$password="";
		$conn=new \mysqli($host,$user,$password,$dbname);
		if(!$conn)
		{
			error_log(mysqli_connect_error());
			die("connection failed : Hubungi Pengembang");
		}
		else
		{
			return $conn;
		}
	}
}
?>