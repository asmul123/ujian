<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UJIAN SMKN 1 GARUT</title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/Favicon/favicon.ico">
    <!-- ========== COMMON STYLES ========== -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/css/lobipanel/lobipanel.min.css" media="screen">

    <!-- ========== PAGE STYLES ========== -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/css/bootstrap-tour/bootstrap-tour.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/css/main.css" media="screen">
    
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
            <!-- /.container-fluid -->
            <section class="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <?= $this->session->flashdata('alert'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5>Data Ruang</h5>
                                    </div>
                                </div>
                                <div class="panel-body p-20">
                                    <table id="dataSiswaIndex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Ruang</th>
                                                <th class="text-center">Nama Pengguna</th>
                                                <th class="text-center">Kata Sandi</th>
                                                <th class="text-center">Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($dataruang as $data) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td><?= $data->ruang; ?></td>
                                                    <td><?= $data->akses; ?></td>
                                                    <td><?= $data->kode; ?></td>
                                                    <td style="min-width: 175px;">
                                                        <center>
                                                            <div class="btn-group">
                                                                <a href="<?=$data->link_server?>/clogin/fast_login/<?=$data->akses?>/<?=$data->kode?>" class="btn btn-success">Masuk</a>
                                                            </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.section -->
    </div>
</div>
</div>
<!-- /.main-wrapper -->
</div>
<!-- ========== COMMON JS FILES ========== -->
<script src="<?php echo base_url() ?>assets/Theme/js/jquery/jquery-2.2.4.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/jquery-ui/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/bootstrap/bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/lobipanel/lobipanel.min.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/DataTables/DataTables-1.10.13/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/DataTables/DataTables-1.10.13/js/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url() ?>assets/Theme/js/amcharts/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/Theme/js/amcharts/plugins/export/export.css" type="text/css" media="all" />
<script src="<?php echo base_url() ?>assets/Theme/js/amcharts/themes/light.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/bootstrap-tour/bootstrap-tour.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/select2/select2.min.js"></script>
<!-- ========== THEME JS ========== -->
<script src="<?php echo base_url() ?>assets/Theme/js/main.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/script.js"></script>
<script src="<?php echo base_url() ?>assets/Theme/js/switchery/switchery.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url() ?>assets/Theme/js/summernote/summernote.min.js"></script>

<script>
	let baseUrl = "<?php echo base_url() ?>"
	console.log(baseUrl)


	$(".js-states").select2();

	$(".js-states-limit").select2({
		maximumSelectionLength: 2
	});

	$(".js-states-hide").select2({
		minimumResultsForSearch: Infinity
	});

	$('#dataTableSiswa').DataTable({
		'scrollX': true,
		'sort': false
	});

	$('#dataSiswaIndex').DataTable({
		"order": [
			[3, "desc"]
		],
		'scrollX': true,
		'sort': false
	});

	$('input.blue-style').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue'
	});

	$('input.green-style').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green'
	});

	$('input.red-style').iCheck({
		checkboxClass: 'icheckbox_square-red',
		radioClass: 'iradio_square-red'
	});

	$('input.flat-black-style').iCheck({
		checkboxClass: 'icheckbox_flat',
		radioClass: 'iradio_flat'
	});

	$('input.line-style').each(function() {
		var self = $(this),
			label = self.next(),
			label_text = label.text();

		label.remove();
		self.iCheck({
			checkboxClass: 'icheckbox_line-blue',
			radioClass: 'iradio_line-blue',
			insert: '<div class="icheck_line-icon"></div>' + label_text
		});
	});

	$("#tb_tipeuser").DataTable()

	$("#tb_tahunakademik").DataTable()
	// $("#tb_staff").DataTable();
	$("#tb_tanggallaporan").DataTable()
	// $("#tb_staff").DataTable();



	function toggle(source) {
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}

	$('#tb_import').DataTable({
		scrollY: '300px',
		paging: false,
	});

	$('#file').hide();

	$('#file').change(function() {
		$('#filename').html($(this)[0].files[0]['name'])
		// console.log()
	})

	// $('#warning').css("display", "none")


	$('#usertipe').val($('.tipeuserAdd').val())

	// ./modul/FORMAT IMPORT EXCEL.xlsx
</script>
<!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>