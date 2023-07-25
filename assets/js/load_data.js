var timer=null;
async function sendDataAjax(url, jumlah_data_class, last_update_class){
	var tahun, month = 0;
	if(url==="send-data-banding-perdata" || url==="send-data-mediasi"){
		tahun=new Date().getFullYear();
		month=new Date().getMonth()+1;
	}
	if(! $("."+jumlah_data_class).hasClass("loaders")){
		$("."+jumlah_data_class).addClass("loaders");
		$("."+last_update_class).addClass("loaders");
	} 
		const result_ajax=await $.ajax(
		{
			beforeSend:function()
			{
				stopSound();
				$(".loaders").html("<i class='fa fa-circle-o-notch fa-spin fa-fw' style='color:red;font-size:1vw'></i> ");
			},
			url:url,
			data:{tahun:tahun, bulan:month},
			dataType:'JSON',
			type:'POST',
			success:function(data){
				//console.log(data);
				var result=data.response.result;
				if(result===true){
					var jumlah_dikirim=data.send_jumlah;
					var last_update=data.response.last_update;
					var new_date=new Date(last_update);
					var date=new_date.getDate();
					var month=new_date.getMonth()+1;
					if(month<10){
						month="0"+month;
					}
					var year=new_date.getFullYear();
					var hours=new_date.getHours();
					var minutes=new_date.getMinutes();
				}else{
					console.log(data);
					var jumlah_dikirim=0;
					var date=0;var month=0; var year=0; var hours=0; var minutes=0;
					$("#exampleModalLong").modal({backdrop:'static'});
					$(".modal-body").html(data.msg);
				}
				$("."+jumlah_data_class).html(jumlah_dikirim);
				$("."+last_update_class).html(date+"-"+month+"-"+year+"  "+hours+":"+minutes+" wib");
				$("."+jumlah_data_class).removeClass("loaders");
				$("."+last_update_class).removeClass("loaders");
			}, error:function(data){
				playSound(false);
				console.log(data);
				$("."+jumlah_data_class).html("<span class='blink' style='color:red;'>Error</span>")
			}
		});
		
	return result_ajax;
}
async function sendDataStatistik(tahun, bulan, perkara){
	const send_ajax=await $.ajax({
		beforeSend:function(){
			$(".loaders_statistik").html("<i class='fa fa-circle-o-notch fa-spin fa-fw' style='color:red;font-size:1vw'></i>");
		},
		url:"send-statistik-perkara",
		data:{tahun:tahun, perkara:perkara, bulan:bulan},
		dataType:"JSON",
		type:"POST",
		success:function(data){
			console.log(data);
			var status=data.response.save;
			if(status === true){
				var last_update=data.response.last_update;
				var new_date=new Date(last_update);
				var date=new_date.getDate();
				var month=new_date.getMonth()+1;
				if(month<10){
					month="0"+month;
				}
				var year=new_date.getFullYear();
				var hours=new_date.getHours();
				var minutes=new_date.getMinutes();
				
					$(".total_perkara_"+perkara+"_"+bulan).removeClass("loaders_statistik");
					$(".last_update_statistik_"+perkara).removeClass("loaders_statistik");
					$(".total_perkara_"+perkara+"_"+bulan).html(data.jumlah);
					$(".last_update_statistik_"+perkara).html(date+"-"+month+"-"+year+"  "+hours+":"+minutes+" wib");
				
			}
		}, error:function(data){
			console.log(data);
			alert("ERR");
		}
	})
}
async function playSound(result){
	if(result===true){
		$("#success").trigger('load');
		$("#success").trigger('play');
	}else{
		$("#error").trigger('load');
			setInterval(function(){
				$("#error").trigger('play');
			}, 200);
	}
}
function stopSound(){
	$("#success").trigger("stop");
}
var running=async()=>{
	//var tahun=new Date().getFullYear();
	var tahun=2020;
	var bulan=new Date().getMonth()+1;
	console.log("running hukum");
	for(var x=1;x<=12;x++){
		let pidana=await sendDataStatistik(tahun, x, "pidana");
		console.log(x);
	}
	for(var x=1;x<=12;x++){
		let pidana_anak=await sendDataStatistik(tahun, x, "pidana_anak");
	}
	for(var x=1;x<=12;x++){
		let perdata=await sendDataStatistik(tahun, x, "perdata");
	}
	for(var x=1;x<=12;x++){
		let phi=await sendDataStatistik(tahun, x, "phi");
	}
	for(var x=1;x<=12;x++){
		let tipikor=await sendDataStatistik(tahun, x, "tipikor");
	}

	setTimeout(function(){
			running2();
	}, 4000);
}
var running2=async()=>{
	console.log("running perdata");
	let data_pk= await sendDataAjax('send-data-pk-perdata', 'total_permohonan_pk_pdt', 'last_update_pk');
	var result_pk_perdata=data_pk.response.result;
	await playSound(result_pk_perdata);
	let data_eksekusi=await sendDataAjax('send-data-eksekusi-perdata', 'total_permohonan_eksekusi_pdt', 'last_update_eksekusi');
	var result_data_eksekusi=data_eksekusi.response.result;
	await playSound(result_data_eksekusi);
	let data_banding=await sendDataAjax('send-data-banding-perdata', 'total_permohonan_banding_pdt', 'last_update_banding');
	var result_data_banding=data_banding.response.result;
	await playSound(result_data_banding);
	let data_mediasi=await sendDataAjax('send-data-mediasi', 'total_permohonan_mediasi_pdt', 'last_update_mediasi');
	var result_data_mediasi=data_mediasi.response.result;
	await playSound(result_data_mediasi);
	let data_kasasi=await sendDataAjax('send-data-kasasi-perdata', 'total_permohonan_kasasi_pdt', 'last_update_kasasi');
	var result_data_kasasi=data_kasasi.response.result;
	await playSound(result_data_kasasi);
	await runCheck();
	console.log(data_banding);
}
setTimeout(function(){
	running();
}, 3000);

var opacity=0;
setInterval(function(){
	if(opacity===0){
		opacity=1;
	}else{
		opacity=0;
	}
	$(document.getElementsByClassName("blink")).css({'opacity':opacity});

}, 920)


function runCheck(){
	console.log("run check");
	timer=setInterval(function(){
		$.ajax({
			url:'check-ask-update',
			type:'POST',
			dataType:"JSON",
			success:function(data){
				var result=data.response.data;
				var length=result.length;
				if(length > 0){
					stopCheck();
					running();
				}
			},error:function(data){
				console.log(data);
				console.log("Error");
			}
		})
	}, 30000)
}
function stopCheck(){
	clearInterval(timer);
	timer=null;
}
