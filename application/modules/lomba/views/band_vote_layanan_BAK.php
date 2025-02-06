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

<body class="bg-dark">

	<div class="container">
		<div class="card card-register mx-auto mt-5 mb-5">
			<div class="card-header">
				<h4 style="text-align: center;" id="judulLayanan"></h4>
				<h5 style="text-align: center;" id="judulUnker">
			</div>
			<div class="card-body">
				<div id="alert"></div>

				<form method="POST" action="lomba/Band/addVotingBand" id="form1" enctype="multipart/form-data">
					<input type="hidden" name="id_balai" id="id_balai" value="<?php echo $id_balai; ?>">
					<div class="form-group">
						<label style="font-weight: bold">Pilih Jenis Kegiatan</label>
						<select name ="kgt" id="kgt" class="form-control">
                        <option value="0" id="plh-kgt">-- Pilih Kegiatan --</option>
							<?php foreach($getkgt as $kgt) { ?>
			                	<option value="<?php echo $kgt->id_kegiatan; ?>"><?php echo $kgt->nama_kegiatan; ?></option>
			                <?php } ?>
			            </select>
					</div>

					<!-- <div class="form-group">
						<label style="font-weight: bold">Pilih Kategori Penilaian</label>
						<select name ="kategori" id="kategori" class="form-control">
							<option value="0">-- Pilih Kategori --</option>
			            </select>
					</div> -->

                    <div class="form-group" id="form-gender">	
						<label style="font-weight: bold">Jenis Kelamin</label><br>
						<input type="radio" id="male" name="gender" value="L">
                        <label >Laki-laki</label><br>
                        <input type="radio" id="female" name="gender" value="P">
                        <label >Perempuan</label><br>
					</div>

                    <div class="form-group" id="form-usia">	
						<label style="font-weight: bold">Usia</label>
						<input required type="number" name="usia" class="form-control" placeholder="Contoh : 40">
					</div>

                    <div class="form-group" id="form-pnd">	
						<label style="font-weight: bold">Pendidikan</label><br>
                        <input type="radio" id="female" name="pend" value="SD">
                        <label >SD</label><br>
						<input type="radio" id="male" name="pend" value="SMP">
                        <label >SMP</label><br>
                        <input type="radio" id="female" name="pend" value="SMA">
                        <label >SMA</label><br>
                        <input type="radio" id="female" name="pend" value="S1">
                        <label >S1</label><br>
                        <input type="radio" id="female" name="pend" value="S2">
                        <label >S2</label><br>
                        <input type="radio" id="female" name="pend" value="S3">
                        <label >S3</label><br>
					</div>

					<div class="form-group multi-star">
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
                    <div id="hidden_single_id">
						
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

		// script menangani hover,click, star mark 
        $(document).ready(function(){

            /* 1. Visualizing things on Hover - See next part for action on click */
            $(document).on("mouseover", "#stars li", function() {
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                $(this).addClass('hover');
                }
                else {
                $(this).removeClass('hover');
                }
            });
            
            }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
                $(this).removeClass('hover');
            });
            });

            /* 2. Action to perform on click */
            $(document).on("click", "#stars li", function() {
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');
            
            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }
            
            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }
            
            var kategoriRating = $(this).attr('name');
            var kat_gabung = '#'+kategoriRating;
            $(kat_gabung).val(onStar);
            
            });

        });

		//script behaviour form
		$(document).ready(function() {
			let kategoriArr = [];
			let perRowKategoriArr = [];
			var kat = $('#kategori').val();
			$('.multi-star').hide();
			$('#form-email').hide();
			$('#form-hp').hide();
			$('#button').hide();
			$('#form-usia').hide();
			$('#form-pnd').hide();
			$('#form-gender').hide();


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

            $('#kgt').change(function(){
				$('.multi-star').empty();
				$('#plh-kgt').remove();

                $.ajax({
					url:'<?=base_url()?>balai/di',
					method: 'post',
					data: {id_kegiatan:$(this).val()},
					dataType: 'json',
					success: function(response){
						kategoriArr = [];
						perRowKategoriArr = [];
						var len = response.length;
						var $select = $('#kategori');
						$select.find('option').remove();
						if(len > 0){							
							// Read values
							// $select.append('<option value="0">-- Pilih Kategori --</option>');
							$select.append('<option value="all">Semua Kategori</option>');
							$.each(response,function(key, value)
							{
								// $select.append('<option value=' + value.id_kategori + '>' + value.nama_kategori + '</option>');
								perRowKategoriArr.push(value.nama_kategori);
								perRowKategoriArr.push(value.id_kategori);
								kategoriArr.push(perRowKategoriArr);
								perRowKategoriArr = [];

								$('#hidden_single_id').append(`<input type="hidden" name="nil_`+value.id_kategori+`" id="nil_`+value.id_kategori+`" value="0">`);
							});
						} else {
							$select.append('<option value="0">-- Pilih Kategori --</option>'); // return empty
						}
					}
                }).done(function(){
					$('.multi-star').show();
					$('#form-email').show();
					$('#form-hp').show();
					$('#button').show();
					$('#form-usia').show();
					$('#form-pnd').show();
					$('#form-gender').show();

					var kat = $('#kategori').find(":selected").val();
					// looping setiap nama kategori
					var numm = 0;
					$.each( kategoriArr, function(intIndex,objValue){
						numm++;
						$('.multi-star').append(
							$(`<label style="font-weight: bold" >`+numm+`. `+objValue[0]+`</label>
							<div class="rating-stars text-center">
								<ul id="stars">
									<li class="star" data-value="1" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
										<i class='fa fa-star fa-fw'></i>
										<p style="margin-top: 18px; font-size: 12px;">Sangat Kurang</p>
									</li>
									<li class="star" data-value="2" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
										<i class='fa fa-star fa-fw'></i>
										<p style="margin-top: 18px; font-size: 12px;">Kurang</p>
									</li>
									</li>
									<li class="star" data-value="3" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
										<i class='fa fa-star fa-fw'></i>
										<p style="margin-top: 18px; font-size: 12px;">Baik</p>
									</li>
									<li class="star" data-value="4" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
										<i class='fa fa-star fa-fw'></i>
										<p style="margin-top: 18px; font-size: 12px;">Baik Sekali</p>
									</li>
								</ul>
							</div>
							<textarea class="form-control" type="text" name="saran_`+objValue[1]+`" id="saran_`+objValue[1]+`" placeholder="Ketikkan Saran/Komentar Anda" hidden></textarea>
							`)
							);
						}
					);
				});	
							
			});
			
            // $('#kategori').change(function(){
			// 	var kat = $('#kategori').find(":selected").val();

			// 	if (kat == 0) {
			// 		$('.multi-star').hide();
			// 		$('#form-email').hide();
			// 		$('#form-hp').hide();
			// 		//$('#question-single').hide();
			// 		$('#button').hide();
			// 	} else if (kat == 'all') {
			// 		//$('#question-single').hide();
			// 		$('.multi-star').show();
			// 		$('#form-email').show();
			// 		$('#form-hp').show();
            //         $('#form-gender').show();
			// 		$('#button').show();

            //         // looping setiap nama kategori
            //         $.each(
            //             kategoriArr,
            //             function(intIndex,objValue){
            //             $('.multi-star').append(
            //                 $(`<label style="font-weight: bold" >`+objValue[0]+`</label>
			// 				<div class="rating-stars text-center">
			// 				    <ul id="stars">
            //                         <li class="star" data-value="1" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
            //                             <i class='fa fa-star fa-fw'></i>
            //                             <p style="margin-top: 18px; font-size: 12px;">Sangat Rendah</p>
            //                         </li>
            //                         <li class="star" data-value="2" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
            //                             <i class='fa fa-star fa-fw'></i>
            //                             <p style="margin-top: 18px; font-size: 12px;">Rendah</p>
            //                         </li>
            //                         <li class="star" data-value="3" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
            //                             <i class='fa fa-star fa-fw'></i>
            //                             <p style="margin-top: 18px; font-size: 12px;">Kurang</p>
            //                         </li>
            //                         <li class="star" data-value="4" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
            //                             <i class='fa fa-star fa-fw'></i>
            //                             <p style="margin-top: 18px; font-size: 12px;">Cukup</p>
            //                         </li>
            //                         <li class="star" data-value="5" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
            //                             <i class='fa fa-star fa-fw'></i>
            //                             <p style="margin-top: 18px; font-size: 12px;">Baik</p>
            //                         </li>
            //                         <li class="star" data-value="6" name="nil_`+objValue[1]+`" style="margin-right: 10px;">
            //                             <i class='fa fa-star fa-fw'></i>
            //                             <p style="margin-top: 18px; font-size: 12px;">Baik Sekali</p>
            //                         </li>
			// 					</ul>
			// 				</div>
			// 				<textarea class="form-control" type="text" name="saran_`+objValue[1]+`" id="saran_`+objValue[1]+`" placeholder="Ketikkan Saran/Komentar Anda"></textarea>`)
            //                 );
            //             }
            //         );
                    
			// 	} else {
			// 		$('.multi-star').hide();
			// 		//$('#question-single').show();
			// 		$('#form-email').show();
			// 		$('#form-hp').show();
			// 		$('#button').show();
			// 	}
			// });
		});
		
	</script>

</body>

</html>