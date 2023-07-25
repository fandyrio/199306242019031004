<?php
namespace Controllers;
use Controllers\Controller;
use Route\Request;
use model\functionCommon;

class HomeController extends Controller {
	public function index()
	{
		$get_data_rekrutmen=$this->getDataRekrutmen("data_rekrutmen.json");
		$get_data_attribute=$this->getAttribut("data_attribut.json");
		$data_rekrutmen=json_decode($get_data_rekrutmen);
		$data_attribut=json_decode($get_data_attribute);
		$jumlah_data=count($data_rekrutmen->response->{'Form Responses 1'});
		$jumlah_attribut=count($data_attribut->response);
		return $this->view('index', ['title'=>'Dashboard Sinkronisasi Data', 'data_rekrutmen'=>json_decode($get_data_rekrutmen), 'jumlah_data'=>$jumlah_data, 'data_attribut'=>json_decode($get_data_attribute), 'jumlah_attribut'=>$jumlah_attribut]);
	}
	public function save(Request $request){
		echo $request->a;
		echo $request->b;
	}
	
	public function getDataRekrutmen($end_point)
	{
			$link=parent::setLinkAPI();
			$curl = curl_init();
		    curl_setopt_array($curl, array(
		    CURLOPT_URL => $link."/".$end_point,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => '',
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 0,
		    CURLOPT_FOLLOWLOCATION => true,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => 'GET',
		   
		    ));
		    $response = curl_exec($curl);
		    if($response===null){
		    	throw new ErrorHandler($curl);
		    }
		    $decode=json_decode($response);
		    curl_close($curl);
		    $arr=['response'=>json_decode($response), 'status'=>'valid', 'msg'=>'data available'];
		    return json_encode($arr);
	}
	public function getAttribut($end_point){
		$link=parent::setLinkAPI();
			$curl = curl_init();
		    curl_setopt_array($curl, array(
		    CURLOPT_URL => $link."/".$end_point,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => '',
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 0,
		    CURLOPT_FOLLOWLOCATION => true,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => 'GET',
		   
		    ));
		    $response = curl_exec($curl);
		    if($response===null){
		    	throw new ErrorHandler($curl);
		    }
		    $decode=json_decode($response);
		    curl_close($curl);
		    $arr=['response'=>json_decode($response), 'status'=>'valid', 'msg'=>'data available'];
		    return json_encode($arr);
	}
	
}
?>