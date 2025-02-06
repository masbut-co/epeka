$(document).ready(function() {
	$('#unit_lain').hide();
	$('#unit_pusat').hide();
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
		$('#unit_pusat').prop("disabled", false);
	} else {
		$('#unit_pusat').show();
	}

	$('#status_pgw').change(function(){
		$('#form1').find('input, textarea, button, select').prop("disabled", false);
		var status_pgwai = $('#status_pgw').find(":selected").val();
		if (status_pgwai == '-') {
			$('#form1').find('input, textarea, button, select').not("[name=status_pgw]").attr('disabled','disabled');
		} else if (status_pgwai != '0') {
			$("#ktp").html("NIK (Nomor KTP) <span style='color: red;'>*</span>");
		} else {
			$("#ktp").html("NIP (Nomor Induk Pegawai) <span style='color: red;'>*</span>");
		}
	});

	$('#asal_pgw').change(function(){
		$('#unit_lain').hide();
		$('#unit_pusat').hide();
		var asal_pgwai = $('#asal_pgw').find(":selected").val();
		if (asal_pgwai != 0) {
			$('#unit_lain').show();
			$('#unit_pusat').prop("disabled", false);
		} else {
			$('#unit_pusat').show();
		}
	});

	$("#noktp").keyup(function(){
		var nip = $('#noktp').val();
		var jml = $(this).val().length;
		$('#nama').val('');
		$('#gelar_depan').val('');
		$('#gelar_belakang').val('');
		$('#tempat_lahir').val('');
		$('#tgl_lahir').val('');
		$('#alamat').val('');
		$('#email').val('');
		$('#no_hp').val('');
		$('#no_telp').val('');
		$('#nama_instansi').val('');
		$('#alamat_instansi').val('');
		$('#jabatan').val('');
		$('#unit').val('');
		$('#golongan').val('');
		$('#pendidikan').val('');
		$('#jurusan').val('');
		$('#form1').find('input, textarea, button, select').prop("disabled", false);
		if(jml > 17){
			$.ajax({
				type: "GET",
				url: "form-daftar/form/cekNip?nip="+nip,
				dataType: "html",
				success: function(response){
					var obj = $.parseJSON(response);
					var exist = obj[1];
					if (exist == 'ada') {
						var str_kel = obj[0]['pegawai']['kelamin'];
						var res = str_kel.substring(0,1);
						$('#nama').val(obj[0]['pegawai']['nama']);
						$('#gelar_depan').val(obj[0]['pegawai']['gelara']);
						$('#gelar_belakang').val(obj[0]['pegawai']['gelarb']);
						$('#tempat_lahir').val(obj[0]['pegawai']['tempatlahir']);
						$('#tgl_lahir').val(obj[0]['pegawai']['tgllahir']);
						$('#alamat').val(obj[0]['pegawai']['alamatrumah']);
						$('#email').val(obj[0]['pegawai']['email']);
						$('#no_hp').val(obj[0]['pegawai']['nohp']);
						$('#no_telp').val(obj[0]['pegawai']['telprumah']);
						$('#nama_instansi').val(obj[0]['unor_es3']['keterangan']);
						$('#alamat_instansi').val(obj[0]['pegawai']['alamat_kantor']);
						$('#jabatan').val(obj[0]['pegawai']['namjab']);
						$('#unit').val(obj[0]['pegawai']['kdunit']);
						$('#unit').trigger('change');
						$('#jkel').val(res);
						if (res == 'L') {
							$("#laki").prop("checked", true);
							$("#perempuan").prop("checked", false);
						} else if (res == 'P') {
							$("#laki").prop("checked", false);
							$("#perempuan").prop("checked", true);
						}
						
						ar_pend = obj[0]['pendidikan'];
						gol = obj[0]['pangkat'];
						
						$('#golongan').val(obj[0]['pangkat'][gol.length-1]['kdgolongan']);
						$('#golongan').trigger('change');
						$('#pendidikan').val(obj[0]['pendidikan'][ar_pend.length-1]['tktpend']);
						$('#jurusan').val(obj[0]['pendidikan'][ar_pend.length-1]['jurusan']);
						
						$('#namaHelp').html("Jika NIP Tidak Terdaftar, mohon cek NIP.");
					} else if (exist == 'tidak') {
						$('#nama').val(obj[0]['data']['nama']);
						var tgllahir = obj[0]['data']['tglLahir'].split("-").reverse().join("-");
						$('#tgl_lahir').val(tgllahir);
						$('#jabatan').val(obj[0]['data']['jabatanNama']);
					}
				}
			});
		}
	});

	$("#noktp").keyup(function(){
		var nip = $('#noktp').val();
		var jml = $(this).val().length;
		var id_kelas = $('#id_kelas').val();
		$.ajax({
			type: "GET",
			url: "form-daftar/form/cekDiklat?kelas="+id_kelas+"&nip="+nip,
			dataType: "html",
			success: function(response2) {
				if (response2 != '') {
					$('#alert').html(response2);
					$('#form1').find('input, textarea, button, select').not("[name=noktp]").attr('disabled','disabled');
				} else {
					$('#form1').find('input, textarea, button, select').prop("disabled", false);
				}
			}
		});
	});
});