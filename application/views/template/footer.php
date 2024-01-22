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
	$(function() {
		// Summernote
		$('.textarea').summernote()
	});

	$(function($) {
		var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

		elems.forEach(function(html) {
			var switchery = new Switchery(html);
		});

		// For blue switches
		var blueElems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-blue'));

		blueElems.forEach(function(html) {
			var switchery = new Switchery(html, {
				color: '#3498db'
			});
		});

		// For danger switches
		var dangerElems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-danger'));

		dangerElems.forEach(function(html) {
			var switchery = new Switchery(html, {
				color: '#e74c3c'
			});
		});

		// For warning switches
		var warningElems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-warning'));

		warningElems.forEach(function(html) {
			var switchery = new Switchery(html, {
				color: '#f39c12'
			});
		});

		// For small switches
		var smallElems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-small'));

		smallElems.forEach(function(html) {
			var switchery = new Switchery(html, {
				size: 'small'
			});
		});

		// For large switches
		var largeElems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-large'));

		largeElems.forEach(function(html) {
			var switchery = new Switchery(html, {
				size: 'large'
			});
		});
	});
</script>
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