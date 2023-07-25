<?php
namespace model;

use config\ErrorHandler;
use config\conn;

class functionCommon extends conn {
	public static function setConnection(){
		return self::connection();
	}
	public function getDataPKPerdata(){
		try{
			$conn=self::setConnection();
			$data=array();
			$like="%Pdt.%";
			$alur_perkara_id="6";
			$query=mysqli_query($conn, "SELECT
					a.perkara_id,
					d.hakim_nama_pk,
					a.nomor_perkara as perkara_pn,
					b.nomor_perkara_banding,
					c.nomor_perkara_kasasi,
					d.nomor_perkara_pk,
					d.pemohon_pk as pemohon,
					d.permohonan_pk,
					d.pengiriman_berkas_pk,
					d.penerimaan_berkas_pk,
					d.putusan_pk,
					e.tanggal_putusan,
					(SELECT pemberitahuan_putusan_pk from perkara_pk_detil ppd where ppd.perkara_id=a.perkara_id and status_pihak_text = 'Termohon'  group by status_pihak_text) as pemb_put_t,
					(SELECT pemberitahuan_putusan_pk from perkara_pk_detil ppd where ppd.perkara_id=a.perkara_id and status_pihak_text = 'Pemohon'  group by status_pihak_text) as pemb_put_p
					from perkara a
					JOIN perkara_banding b on b.perkara_id=a.perkara_id
					JOIN perkara_kasasi c on c.perkara_id=a.perkara_id
					JOIN perkara_pk d on d.perkara_id=a.perkara_id
					JOIN perkara_putusan e on e.perkara_id=a.perkara_id
					where a.nomor_perkara like '$like' and a.alur_perkara_id <> $alur_perkara_id");
			if($query===false){
				throw new ErrorHandler($conn->error);
			}
			// $query->bind_param("ss", $like, $alur_perkara_id);
			// $query->execute();
			// $result=$query->get_result();
			// $jumlah=$result->num_rows;

			$jumlah=mysqli_num_rows($query);

			if($jumlah>0){
				$msg="Data Available";
				//$data_pk=$result->fetch_all(MYSQLI_ASSOC);
				$x=0;
				while($list_data=mysqli_fetch_array($query)){
					$data[$x]['perkara_id'] = $list_data['perkara_id'];
					$data[$x]['nomor_perkara_pn'] = $list_data['perkara_pn'];
					$data[$x]['nomor_perkara_pt'] = $list_data['nomor_perkara_banding'];
					$data[$x]['majelis_hakim'] = $list_data['hakim_nama_pk'];
					$data[$x]['nomor_perkara_pk']= $list_data['nomor_perkara_pk']  ;
					$data[$x]['nomor_perkara_kasasi']=$list_data['nomor_perkara_kasasi'];
					$data[$x]['pemohon']=$list_data['pemohon'];
					$data[$x]['putusan_pn']=$list_data['tanggal_putusan'];
					$data[$x]['tanggal_permohonan_pk']=$list_data['permohonan_pk'];
					$data[$x]['tanggal_pengiriman_berkas']=$list_data['pengiriman_berkas_pk'];
					$data[$x]['tanggal_penerimaan_berkas']=$list_data['penerimaan_berkas_pk'];
					$data[$x]['putusan_ma']=$list_data['putusan_pk'];
					$data[$x]['tanggal_pemberitahuan_salinan_p']=$list_data['pemb_put_p'];
					$data[$x]['tanggal_pemberitahuan_salinan_t']=$list_data['pemb_put_t'];
					$x++;
				}
			}else{
				$msg="No Data Available";
			}
			$query->close();
			return json_encode(['data'=>$data, 'msg'=>$msg, 'jumlah'=>$jumlah]);
		}catch(ErrorHandler $e){
			if($query){
				$query->close();
			}
			die("error_msg : ".$e->errorMsgQuery());
		}
		
	}
	public function getDataEksekusi(){
		try{
			$data=array();
			$msg="";
			$conn=self::connection();
			$query=mysqli_query($conn, "SELECT 
									nomor_perkara_pn,
									nomor_register_eksekusi,
									pemohon_eksekusi,
									permohonan_eksekusi, 
									jurusita_nama,
									penetapan_perintah_eksekusi_lelang,
									pelaksanaan_eksekusi_lelang,
									penyerahan_hasil_lelang,
									penetapan_teguran_eksekusi, 
									penetapan_teguran_eksekusi, 
									pelaksanaan_teguran_eksekusi,  
									pelaksanaan_sita_eksekusi, 
									penetapan_sita_eksekusi, 
									penetapan_perintah_eksekusi_rill,
									pelaksanaan_eksekusi_rill,
									penetapan_noneksekusi
									from perkara_eksekusi");
			if($query===false){
				throw new ErrorHandler($conn->error);
			}
			// $query->execute();
			// $result=$query->get_result();
			// $jumlah=$result->num_rows;

			$jumlah=mysqli_num_rows($query);

			if($jumlah>0){
				//$data_eksekusi=$result->fetch_all(MYSQLI_ASSOC);
				$x=0;
				while($list_data=mysqli_fetch_array($query)){
					$data[$x]['nomor_perkara_pn']=$list_data['nomor_perkara_pn'];
					$data[$x]['nomor_register_eksekusi']=$list_data['nomor_register_eksekusi'];
					$data[$x]['pemohon_eksekusi']=$list_data['pemohon_eksekusi'];
					$data[$x]['permohonan_eksekusi']=$list_data['permohonan_eksekusi'];
					$data[$x]['jurusita_nama']=$list_data['jurusita_nama'];
					$data[$x]['penetapan_teguran_eksekusi']=$list_data['penetapan_teguran_eksekusi'];
					$data[$x]['pelaksanaan_teguran_eksekusi']=$list_data['pelaksanaan_teguran_eksekusi'];
					$data[$x]['pelaksanaan_sita_eksekusi']=$list_data['pelaksanaan_sita_eksekusi'];
					$data[$x]['penetapan_perintah_eksekusi_lelang']=$list_data['penetapan_perintah_eksekusi_lelang'];
					$data[$x]['pelaksanaan_eksekusi_lelang']=$list_data['pelaksanaan_eksekusi_lelang'];
					$data[$x]['penyerahan_hasil_lelang']=$list_data['penyerahan_hasil_lelang'];
					$data[$x]['penetapan_sita_eksekusi']=$list_data['penetapan_sita_eksekusi'];
					$data[$x]['penetapan_perintah_eksekusi_rill']=$list_data['penetapan_perintah_eksekusi_rill'];
					$data[$x]['pelaksanaan_eksekusi_rill']=$list_data['pelaksanaan_eksekusi_rill'];
					$data[$x]['penetapan_noneksekusi']=$list_data["penetapan_noneksekusi"];
					$x++;
				}
			}else{
				$msg="Data eksekusi tidak ditemukan";
			}
			$conn->close();
			return json_encode(['data'=>$data, 'jumlah'=>$jumlah, 'msg'=>$msg]);
		}catch(ErrorHandler $e){
			if($query){
				$query->close();
			}
			die("error msg : ".$e->errorMsgQuery());
		}
	}

	public function getDataKasasiPerdata()
	{
		try{
			$data=array();
			$msg="";
			$like='%Pdt%';
			$alur_perkara_id=6;
			$conn=self::connection();
			$query=mysqli_query($conn, "SELECT
									a.perkara_id,
									a.nomor_perkara_pn,
									b.nomor_perkara_banding,
									a.nomor_perkara_kasasi,
									a.hakim1_kasasi,
									a.panitera_pengganti_kasasi,
									a.pemohon_kasasi,
									a.putusan_pn,
									b.putusan_banding,
									a.pemberitahuan_putusan_banding,
									a.permohonan_kasasi,
									a.penerimaan_memori_kasasi,
									a.pengiriman_berkas_kasasi,
									a.penerimaan_berkas_kasasi,
									a.putusan_kasasi,
									a.pemberitahuan_putusan_kasasi_pihak1,
									a.pemberitahuan_putusan_kasasi_pihak2
									from perkara_kasasi a
									JOIN perkara_banding b on b.perkara_id=a.perkara_id
									where a.nomor_perkara_pn like '$like'
									and a.alur_perkara_id <> $alur_perkara_id
									order by a.perkara_id");
			if($query===false){
				throw new ErrorHandler($conn->error);
			}
			
			// $query->bind_param("sii", $like, $tahun, $alur_perkara_id);
			// $query->execute();
			// $result=$query->get_result();
			// $jumlah=$result->num_rows;

			$jumlah=mysqli_num_rows($query);

			if($jumlah>0){
				//$data_kasasi=$result->fetch_all(MYSQLI_ASSOC);
				$x=0;
				while($list_kasasi=mysqli_fetch_array($query)) {
					$data[$x]['perkara_id']=$list_kasasi['perkara_id'];
					$data[$x]['nomor_perkara_pn']=$list_kasasi['nomor_perkara_pn'];
					$data[$x]['nomor_perkara_banding']=$list_kasasi['nomor_perkara_banding'];
					$data[$x]['nomor_perkara_kasasi']=$list_kasasi['nomor_perkara_kasasi'];
					$data[$x]['hakim1_kasasi']=$list_kasasi['hakim1_kasasi'];
					$data[$x]['panitera_pengganti_kasasi']=$list_kasasi['panitera_pengganti_kasasi'];
					$data[$x]['pemohon_kasasi']=$list_kasasi['pemohon_kasasi'];
					$data[$x]['putusan_pn']=$list_kasasi['putusan_pn'];
					$data[$x]['putusan_banding']=$list_kasasi['putusan_banding'];
					$data[$x]['pemberitahuan_putusan_banding']=$list_kasasi['pemberitahuan_putusan_banding'];
					$data[$x]['permohonan_kasasi']=$list_kasasi['permohonan_kasasi'];
					$data[$x]['penerimaan_memori_kasasi']=$list_kasasi['penerimaan_memori_kasasi'];
					$data[$x]['pengiriman_berkas_kasasi']=$list_kasasi['pengiriman_berkas_kasasi'];
					$data[$x]['penerimaan_berkas_kasasi']=$list_kasasi['penerimaan_berkas_kasasi'];
					$data[$x]['putusan_kasasi']=$list_kasasi['putusan_kasasi'];
					$data[$x]['pemberitahuan_putusan_kasasi_pihak1']=$list_kasasi['pemberitahuan_putusan_kasasi_pihak1'];
					$data[$x]['pemberitahuan_putusan_kasasi_pihak2']=$list_kasasi['pemberitahuan_putusan_kasasi_pihak2'];
					$x++;
				}
			}else{
				$msg="Data Perkara Kasasi tidak ditemukan";
			}
		}catch(ErrorHandler $e){
			$query->close();
			die("error msg : ".$e->errorMsgQuery());
		}
		return json_encode(['data'=>$data, 'jumlah'=>$jumlah, 'msg'=>$msg]);
	}

	public function getDataMediasi($tahun, $bulan)  
	{
		try{
			$data=array();
			$aktif="Y";
			$mediator="H";
			$msg="";
			$bulan_lalu=$bulan-1;
			$tahun_lalu=$tahun;
			$conn=self::connection();
			if($bulan === 1){
				$bulan_lalu=12;
				$tahun_lalu=$tahun-1;
			}
			$get_data=mysqli_query($conn, "SELECT
										a.nama_gelar, 
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)<=$bulan_lalu and year(b1.dimulai_mediasi)=$tahun_lalu and month(keputusan_mediasi)>$bulan_lalu and year(b1.keputusan_mediasi)=$tahun) as bulan_lalu,
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)=$bulan and year(b1.dimulai_mediasi)=$tahun) as bulan_ini,
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)=$bulan and year(b1.dimulai_mediasi)=$tahun and hasil_mediasi='Y1') as akta_perdamaian,
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)=$bulan and year(b1.dimulai_mediasi)=$tahun and hasil_mediasi='S') as berhasil_sebagian,
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)=$bulan and year(b1.dimulai_mediasi)=$tahun and hasil_mediasi='Y') as berhasil,
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)=$bulan and year(b1.dimulai_mediasi)=$tahun and hasil_mediasi='T') as tidak_berhasil,
										(SELECT count(1) from perkara_mediasi b1 where b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)=$bulan and year(b1.dimulai_mediasi)=$tahun and hasil_mediasi='D') as tidak_dapat_dilaksanakan,
										(SELECT count(1) from perkara_mediasi b1 where (b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)<=$bulan and year(b1.dimulai_mediasi)<=$tahun and month(b1.keputusan_mediasi)>$bulan_lalu and year(b1.keputusan_mediasi)>=$tahun) or (b1.mediator_id=b.mediator_id and b1.mediator_id=a.id and month(b1.dimulai_mediasi)<=$bulan and year(b1.dimulai_mediasi)<=$tahun and b1.keputusan_mediasi is null)) as mediasi_berjalan
										from mediator a
										LEFT JOIN perkara_mediasi b on b.mediator_id=a.id
										where a.aktif='$aktif'
										GROUP by a.nama_gelar");
			// $get_data->bind_param("s", $aktif);
			// $get_data->execute();
			// $result=$get_data->get_result();
			// $jumlah=$result->num_rows;
			$jumlah=mysqli_num_rows($get_data);
			if($jumlah>0){
				//$data_mediasi=$result->fetch_all(MYSQLI_ASSOC);
				$x=0;
				while($list_mediasi=mysqli_fetch_array($get_data)){
					$data[$x]['nama_gelar']=$list_mediasi['nama_gelar'];
					$data[$x]['bulan_lalu']=$list_mediasi['bulan_lalu'];
					$data[$x]['bulan_ini']=$list_mediasi['bulan_ini'];
					$data[$x]['total']=$list_mediasi['bulan_lalu']+$list_mediasi['bulan_ini'];
					$data[$x]['akta_perdamaian']=$list_mediasi['akta_perdamaian'];
					$data[$x]['berhasil_sebagian']=$list_mediasi['berhasil_sebagian'];
					$data[$x]['berhasil']=$list_mediasi['berhasil'];
					$data[$x]['tidak_berhasil']=$list_mediasi['tidak_berhasil'];
					$data[$x]['tidak_dapat_dilaksanakan']=$list_mediasi['tidak_dapat_dilaksanakan'];
					$data[$x]['mediasi_berjalan']=$list_mediasi['mediasi_berjalan'];
					$data[$x]['tahun']=$tahun;
					$x++;
				}
			}else{
				$msg="No data available";
			}
		}catch(ErrorHandler $e){
			$conn->close();
			die("Error msg : ".$e->errorMsgQuery());
		}
		return json_encode(['data'=>$data, 'msg'=>$msg, 'jumlah'=>$jumlah, 'tahun'=>$tahun]);
	}
	public function getDataBanding($tahun){
		try{
			$conn=self::connection();
			$data=array();
			$between_1=1;
			$between_2=11;
			$like="%Pdt%";
			$alur_perkara_id=6;
			$msg="";
			$get_data=mysqli_query($conn, "SELECT
									nomor_perkara_pn as no_perkara,
									nomor_perkara_banding as no_banding, 
									majelis_hakim_banding as hakim_pt,
									panitera_pengganti_banding as panitera_pt,
									pemohon_banding as pemohon,
									putusan_pn as tgl_putus, 
									permohonan_banding,
									case
										when a.pihak_pembanding=1 
										then
											(SELECT tanggal_pemberitahuan_putusan from perkara_putusan_pemberitahuan_putusan b where b.perkara_id=a.perkara_id and pihak=1 limit 1)
										when a.pihak_pembanding=2
										then
											(SELECT tanggal_pemberitahuan_putusan from perkara_putusan_pemberitahuan_putusan b where b.perkara_id=a.perkara_id and pihak=2 limit 1)
										when a.pihak_pembanding=3
										then
											(SELECT tanggal_pemberitahuan_putusan from perkara_putusan_pemberitahuan_putusan b where b.perkara_id=a.perkara_id and pihak=3 limit 1)
										when a.pihak_pembanding=4
										then
											(SELECT tanggal_pemberitahuan_putusan from perkara_putusan_pemberitahuan_putusan b where b.perkara_id=a.perkara_id and pihak=4 limit 1)
										END as pemberitahuan_put_pem,
									(SELECT pemberitahuan_inzage from perkara_banding_detil pbd where pbd.perkara_id=a.perkara_id limit 1) as pemberitahuan_inzage,
									(SELECT pelaksanaan_inzage from perkara_banding_detil pbd where pbd.perkara_id=a.perkara_id limit 1) as pelaksanaan_inzage,pengiriman_berkas_banding,penerimaan_kembali_berkas_banding,putusan_banding,
									(SELECT pemberitahuan_putusan_banding from perkara_banding_detil pbd where pbd.perkara_id=a.perkara_id and status_pihak_id=2 limit 1) as pemberitahuan_putusan_banding_pembanding,
									(SELECT pemberitahuan_putusan_banding from perkara_banding_detil pbd where pbd.perkara_id=a.perkara_id and status_pihak_id=5 limit 1) as pemberitahuan_putusan_banding_terbanding
									FROM
									perkara_banding a
									where nomor_perkara_pn like '$like' and alur_perkara_id <> $alur_perkara_id");
			if($get_data===false){
				throw new ErrorHandler($conn->error);
			}
			// $get_data->bind_param("si",  $like, $alur_perkara_id);
			// $get_data->execute();
			// $result=$get_data->get_result();
			// $jumlah=$result->num_rows;

			$jumlah=mysqli_num_rows($get_data);

			if($jumlah>0){
				$x=0;
				while($list_banding=mysqli_fetch_array($get_data)) {
					$data[$x]['nomor_perkara']=$list_banding['no_perkara'];
					$data[$x]['nomor_perkara_banding']=$list_banding['no_banding'];
					$data[$x]['hakim_banding']=$list_banding['hakim_pt'];
					$data[$x]['pp_banding']=$list_banding['panitera_pt'];
					$data[$x]['pemohon_banding']=$list_banding['pemohon'];
					$data[$x]['tgl_putus']=$list_banding['tgl_putus'];
					$data[$x]['permohonan_banding']=$list_banding['permohonan_banding'];
					$data[$x]['pemberitahuan_putusan_pembanding']=$list_banding['pemberitahuan_put_pem'];
					$data[$x]['pemberitahuan_inzage']=$list_banding['pemberitahuan_inzage'];
					$data[$x]['pelaksanaan_inzage']=$list_banding['pelaksanaan_inzage'];
					$data[$x]['pengiriman_berkas_banding']=$list_banding['pengiriman_berkas_banding'];
					$data[$x]['penerimaan_berkas_banding']=$list_banding['penerimaan_kembali_berkas_banding'];
					$data[$x]['putusan_banding']=$list_banding['putusan_banding'];
					$data[$x]['pemberitahuan_putusan_banding_pembanding']=$list_banding['pemberitahuan_putusan_banding_pembanding'];
					$data[$x]['pemberitahuan_putusan_banding_terbanding']=$list_banding['pemberitahuan_putusan_banding_terbanding'];
					$data[$x]['tahun']=$tahun;
					$x++;
				}
			}else{
				$msg="No data inserted";
			}
		}catch(ErrorHandler $e){
			$conn->close();
			die("Error query ".$e->errorMsgQuery());
		}
		return json_encode(['data'=>$data, 'msg'=>$msg, 'jumlah'=>$jumlah, 'tahun'=>$tahun]);
	}
	public function getStatistikPerkara($tahun, $bulan, $perkara){
		$conn=self::connection();
		if($perkara === "pidana"){
			$alur_perkara_id="(111, 112, 113, 119)";
		}else if($perkara === "pidana_anak"){
			$alur_perkara_id="(118)";
		}else if($perkara === "tipikor"){
			$alur_perkara_id="(115)";
		}else if($perkara === "perdata"){
			$alur_perkara_id="(1,2,7,8)";
		}else if($perkara === "phi"){
			$alur_perkara_id="(6)";
		}
		$get_data_masuk=mysqli_query($conn, "SELECT count(1) as jumlah from perkara where year(tanggal_pendaftaran)=$tahun and month(tanggal_pendaftaran)=$bulan and alur_perkara_id in $alur_perkara_id");
		$fetch_data_masuk=mysqli_fetch_array($get_data_masuk);
		$jumlah_data_masuk=$fetch_data_masuk["jumlah"];

		$get_data_putus=mysqli_query($conn, "SELECT count(1) as jumlah from perkara a join perkara_putusan b on b.perkara_id=a.perkara_id where year(tanggal_putusan)=$tahun and month(tanggal_putusan)=$bulan and alur_perkara_id in $alur_perkara_id");
		$fetch_data_putus=mysqli_fetch_array($get_data_putus);
		$jumlah_data_putus=$fetch_data_putus["jumlah"];

		if((int)$bulan === 1){
			$tahun=$tahun-1;
			$bulan=1;
			$get_data_sisa=mysqli_query($conn, "SELECT count(1) as jumlah from perkara a join perkara_putusan b on b.perkara_id=a.perkara_id where year(tanggal_pendaftaran)=$tahun and year(tanggal_putusan)=$tahun+1 and alur_perkara_id in $alur_perkara_id");
			$fetch_data_sisa=mysqli_fetch_array($get_data_sisa);
			$jumlah_data_sisa=$fetch_data_sisa["jumlah"];
		
		}else{
			//sisa perkara bulan lalu
			$get_data_sisa=mysqli_query($conn, "SELECT count(1) as jumlah from perkara a join perkara_putusan b on b.perkara_id=a.perkara_id where year(tanggal_pendaftaran)=$tahun and month(tanggal_pendaftaran)<=$bulan-1 and alur_perkara_id in $alur_perkara_id and ((year(tanggal_putusan)=$tahun and month(tanggal_putusan)>=$bulan) or (year(tanggal_putusan)>$tahun and month(tanggal_putusan)>=1 ))");

			$get_data_sisa_tahun_lalu=mysqli_query($conn, "SELECT count(1) as jumlah from perkara a join perkara_putusan b on b.perkara_id=a.perkara_id where year(tanggal_pendaftaran)=$tahun-1 and year(tanggal_putusan)=$tahun and month(tanggal_putusan)>=$bulan and alur_perkara_id in $alur_perkara_id");
			$fetch_data_sisa=mysqli_fetch_array($get_data_sisa);
			$fetch_data_sisa_tahun_lalu=mysqli_fetch_array($get_data_sisa_tahun_lalu);
			$jumlah_data_sisa_tahun_ini=$fetch_data_sisa["jumlah"];
			$jumlah_data_sisa_tahun_lalu=$fetch_data_sisa_tahun_lalu["jumlah"];
			$jumlah_data_sisa=$jumlah_data_sisa_tahun_ini+$jumlah_data_sisa_tahun_lalu;
		}
		return json_encode(["jumlah_data_masuk"=>$jumlah_data_masuk, "jumlah_data_sisa"=>$jumlah_data_sisa, "jumlah_data_putus"=>$jumlah_data_putus, "perkara"=>$perkara]);
	}
}
?>