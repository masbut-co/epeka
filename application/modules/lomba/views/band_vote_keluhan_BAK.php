<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("../views/template/head"); ?>
<script src="https://www.google.com/recaptcha/api.js?render=6Le1IXwqAAAAALa3ZbonaoFaUvQArd5A5U4Yqm1l"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Le1IXwqAAAAALa3ZbonaoFaUvQArd5A5U4Yqm1l', {action:'validate_captcha'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
</script>
<script>
	function validateForm() {
		var x = document.forms["keluhanForm"]["keluhan"].value;
		if (x == "" || x == null) {
			alert("Keluhan harus di isi");
			return false;
		}
	}
</script>

<body class="bg-dark">

	<div class="container">
		<div class="card card-register mx-auto mt-5 mb-5">
			<div class="card-header">
				<h4 style="text-align: center;" id="judulLayanan"></h4>
				<h5 style="text-align: center;" id="judulUnker">
			</div>
			<div class="card-body">
				<div id="alert"></div>

				<form method="POST" name="keluhanForm" action="lomba/Band/addKeluhanBand" id="form1" enctype="multipart/form-data" onsubmit="return validateForm()">
					<input type="hidden" name="id_balai" id="id_balai" value="<?php echo $id_balai; ?>">

                    <!-- <div class="form-group" id="form-gender">	
						<label style="font-weight: bold">Jenis Kelamin</label><br>
						<input type="radio" id="male" name="gender" value="L">
                        <label >Laki-laki</label><br>
                        <input type="radio" id="female" name="gender" value="P">
                        <label >Perempuan</label><br>
					</div> -->

                    <div class="form-group" id="form-usia">	
						<label style="font-weight: bold">Keluhan/Saran/Kritik</label>
						<input required type="text" name="keluhan" class="form-control">
					</div>

					<div class="form-group" id="form-usia">	
						<label style="font-weight: bold">Bukti Foto/Gambar</label>
						<input type="file" id="gambar" name="gambar">
					</div>

					<div class="form-group" id="form-email">	
						<label style="font-weight: bold">E-mail</label>
						<input type="email" name="email" class="form-control" placeholder="Contoh : saya@gmail.com">
					</div>
					<div class="form-group" id="form-hp">	
						<label style="font-weight: bold">No HP</label>
						<input required type="number" name="nohp" class="form-control" placeholder="Contoh : 0987656789876">
						<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
						<input type="hidden" name="action" value="validate_captcha">
					</div>
						
                    </div>
					<div class="row" id="button">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;"> KIRIM </button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php $this->load->view("../views/template/javascript"); ?>

	<script type="text/javascript">

		//script behaviour form
		$(document).ready(function() {
			let judulUnker = <?php echo $_GET['balai']; ?>;
            let judulLayanan = '<?php echo $_GET['layanan']; ?>';
			switch (judulUnker) {
				case 0:
					document.getElementById("judulUnker").innerHTML = 'Sekretariat Badan Pengembangan Sumber Daya Manusia';
					break;
				case 1:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah I Medan';
					break;
				case 2:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah II Palembang';
					break;
				case 3:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah III Jakarta';
					break;
				case 4:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah IV Bandung';
					break;
				case 5:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah V Yogyakarta';
					break;
				case 6:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah VI Surabaya';
					break;
				case 7:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah VII Banjarmasin';
					break;
				case 8:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah VIII Makasar';
					break;
				case 9:
					document.getElementById("judulUnker").innerHTML = 'Balai Pengembangan Kompetensi Wilayah IX Jayapura';
					break;
				case 10:
					document.getElementById("judulUnker").innerHTML = 'Pusat Pengembangan Talenta';
					break;
				case 11:
					document.getElementById("judulUnker").innerHTML = 'Pusat Pengembangan Kompetensi Sumber Daya Air dan Permukiman';
					break;
				case 12:
					document.getElementById("judulUnker").innerHTML = 'Pusat Pengembangan Kompetensi Jalan, Perumahan, dan Pengembangan Infrastruktur Wilayah';
					break;
				case 13:
					document.getElementById("judulUnker").innerHTML = 'Pusat Pengembangan Kompetensi Manajemen';
					break;
				case 14:
					document.getElementById("judulUnker").innerHTML = 'Balai Penilaian Kompetensi';
					break;
				default:
					document.getElementById("judulUnker").innerHTML = 'Tidak Ada Unit kerja';
					break;
			}
            switch (judulLayanan) {
                case 'skm':
                    document.getElementById("judulLayanan").innerHTML = 'Survei Kepuasan Masyarakat (SKM)';
                    break;
                case 'keluhan':
                    document.getElementById("judulLayanan").innerHTML = 'Box Keluhan';
                    break;
                case 'internal':
                    document.getElementById("judulLayanan").innerHTML = 'Survei Layanan Internal';
                    break;
                default:
                    break;
            }
		});
		
	</script>

</body>

</html>