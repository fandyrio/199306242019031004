<?php
include "controller/sendData.php";
include "model/functionCommon.php";

use controller\sendData;
use model\functionCommon;

$send_data=new sendData();
$set_conn=$send_data->setConnection();

$function_common=new functionCommon();
$data_perdata_pk=$function_common->getDataPKPerdata($set_conn);

$send_data_api=$send_data->sendDataPerdataPK($data_perdata_pk);
echo $send_data_api;
?>