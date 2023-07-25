<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    
</head>

<body class="body-bg">

    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- main wrapper start -->
    <div class="horizontal-main-wrapper">
        <!-- main header area start -->
        <div class="mainheader-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <h2>LAPORAN REKRUTMEN</h2>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-9 clearfix text-right">
                        <div class="d-md-inline-block d-block mr-md-4">
                            <ul class="notification-area">
                            </ul>
                        </div>
                        <div class="clearfix d-md-inline-block d-block">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main header area end -->
        <!-- header area start -->
        <div class="header-area header-bottom">
            <div class="container">
                
            </div>
        </div>
        <!-- header area end -->
        <!-- page title area end -->
        <div class="main-content-inner">
            <div class="container" style="background-color: white;margin-top: 10px;">
                <div class="row" >
                    <!-- seo fact area start -->
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    
                                ?>
                                <table class="table text-center table-hover table-striped">
                                    <thead class="text-uppercase bg-info">
                                        <tr class="text-white">
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">NIP</th>
                                            <th rowspan="2">Satuan Kerja</th>
                                            <th rowspan="2">Posisi</th>
                                            <th colspan="5">Kemampuan</th>
                                            <th colspan="4">Nilai</th>
                                        </tr>
                                        <tr class="text-white">
                                            <th>Teknis</th>
                                            <th>Mobile Apps</th>
                                            <th>T1</th>
                                            <th>T2</th>
                                            <th>T3</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($x=0;$x<$jumlah_data;$x++){
                                                $no=$x+1;
                                                $t1="-";
                                                $t2="-";
                                                $t3="-";
                                                $file="-";
                                                for($y=0;$y<$jumlah_attribut;$y++){
                                                    
                                                    if((int)$data_attribut->response[$y]->id_pendaftar === (int)$data_rekrutmen->response->{'Form Responses 1'}[$x]->id && $data_attribut->response[$y]->jenis_attr === "nilai_t1"){
                                                        $t1=$data_attribut->response[$y]->value;
                                                    }

                                                    if((int)$data_attribut->response[$y]->id_pendaftar === (int)$data_rekrutmen->response->{'Form Responses 1'}[$x]->id && $data_attribut->response[$y]->jenis_attr === "nilai_t2"){
                                                        $t2=$data_attribut->response[$y]->value;
                                                    }

                                                    if((int)$data_attribut->response[$y]->id_pendaftar === (int)$data_rekrutmen->response->{'Form Responses 1'}[$x]->id && $data_attribut->response[$y]->jenis_attr === "nilai_t3"){
                                                        $t3=$data_attribut->response[$y]->value;
                                                    }
                                                    if((int)$data_attribut->response[$y]->id_pendaftar === (int)$data_rekrutmen->response->{'Form Responses 1'}[$x]->id && $data_attribut->response[$y]->jenis_attr === "url_file"){
                                                        $file="<a href='".$data_attribut->response[$y]->value."'>Lihat</a>";
                                                    }
                                                }
                                                echo "
                                                    <tr>
                                                        <td>".$no."</td>
                                                        <td>".$data_rekrutmen->response->{'Form Responses 1'}[$x]->nama."</td>
                                                        <td>".$data_rekrutmen->response->{'Form Responses 1'}[$x]->nip."</td>
                                                        <td>".$data_rekrutmen->response->{'Form Responses 1'}[$x]->satuan_kerja."</td>
                                                        <td>".$data_rekrutmen->response->{'Form Responses 1'}[$x]->posisi_yang_dipilih."</td>
                                                    
                                                        <td> <b>Bahasa Pemrograman</b> :".$data_rekrutmen->response->{'Form Responses 1'}[$x]->bahasa_pemrograman_yang_dikuasai."<br />
                                                            <b>Database</b> : ".$data_rekrutmen->response->{'Form Responses 1'}[$x]->database_yang_dikuasai."<br />
                                                            <b>Tools</b> : ".$data_rekrutmen->response->{'Form Responses 1'}[$x]->tools_yang_dikuasai."
                                                        </td>
                                                        
                                                        <td>".$data_rekrutmen->response->{'Form Responses 1'}[$x]->pernah_membuat_mobile_apps."</td>
                                                        <td>".$t1."</td>
                                                        <td>".$t2."</td>
                                                        <td>".$t3."</td>
                                                        <td>".$file."</td>
                                                    </tr>
                                                ";
                                            }

                                        ?>
                                        <tr>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <?php



                                ?>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-area">
               <!--  <p>© Copyright 2018. All right reserved. Template by <a href="https://colorlib.com/wp/">Colorlib</a>.</p> -->
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    
    <div class="modal fade" id="exampleModalLong">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quam, repudiandae modi quae adipisci sunt, quaerat nihil est mollitia delectus consequuntur voluptate nesciunt veniam impedit, odio ducimus provident dolore quia obcaecati.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- offset area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- start amcharts -->
   
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- <script src="assets/js/load_data.js"></script> -->
</body>

</html>
