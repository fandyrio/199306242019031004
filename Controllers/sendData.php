<?php
namespace Controllers;
require_once("Controller.php");
require_once('model/functionCommon.php');
use model\functionCommon;

	class sendData extends Controller {
		public static function sendDataPerdataPK(){
			$sendDataPerdataPK="Jumlah data kosong";
			$end_point="received-data-pk-perdata";
			$function_common=new functionCommon();
			$data=$function_common->getDataPKPerdata();
			$decode_data=json_decode($data);
			$jumlah_data=count($decode_data->data);
			$data=$decode_data->data;
			if($jumlah_data>0){
				$sendDataPerdataPK=parent::postSendRequestAPI($decode_data, $jumlah_data, $end_point);
			}
			return $sendDataPerdataPK;
		}
	}
?>