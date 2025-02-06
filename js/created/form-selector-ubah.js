$(document).ready(function() {
	$('#unit_lain').hide();
	$('#unit_pusat').hide();
	var status = $('#status').val();
	
	if (status != 1) {
		$('#form1').find('input, textarea').not("[name=no_hp], [name=no_telp], [name=email], [name=surat], [name=nama_instansi], [name=token]").attr('readonly','readonly');
		$('#form1').find('select').not("[name=no_hp], [name=no_telp], [name=email], [name=surat], [name=nama_instansi], [name=token]").attr('disabled','disabled');
		$('#form1').find("[name=jkel]").attr('disabled','disabled');
	} else if (status == 1) {
		$('#form1').find('input, textarea, button, select').attr('disabled','disabled');
	}
	var status_pgw = $('#status_pgw').find(":selected").val();
	var asal_pgw = $('#asal_pgw').find(":selected").val();
	if (status_pgw == '-') {
		$('#form1').find('input, textarea, button, select').not("[name=status_pgw]").attr('disabled','disabled');
	} else if (status_pgw != '0') {
		$("#ktp").html("NIK (Nomor KTP) <span style='color: red;'>*</span>");
	} else {
		$("#ktp").html("NIP (Nomor Induk Pegawai) <span style='color: red;'>*</span>");
	}

	if (asal_pgw != 0) {
		$('#unit_lain').show();
	} else {
		$('#unit_pusat').show();
	}
});