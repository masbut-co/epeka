<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("../views/template/head"); ?>

<body class="bg-dark">

	<div class="container">
		<div class="card card-register mx-auto mt-5 mb-5">
			<div class="card-header"><h4 style="text-align: center;">Hasil Voting Standup</h4></div>
			<?php if ($standup_aktif != null) { ?>
				<div class="card-body">
					<div id="alert"></div>
					<?php if (($standup_aktif->jlh_vote) >= 100) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<b>Oooops!!</b> Kuota voting sudah penuh :(, vote untuk UNOR selanjutnya ya!
						</div>
					<?php } ?>
					<?php if ($this->session->flashdata('success') == TRUE) { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							Pendaftaran berhasil dilakukan!
						</div>
					<?php } ?>
					<img src="img/standup.jpg" width="100%" style="margin-bottom: 10px;">
					<div class="alert alert-info fade show" style="border-radius: 30px;">
						<h2 style="text-align: center; margin-bottom: 10px;"><?php echo $standup_aktif->nama_unit; ?></h2>
					</div>
					<?php if ($curr_date > $standup_aktif->waktu_aktif) { ?>
						<form method="POST" action="lomba/Standup/addVotingStandup" id="form1" enctype="multipart/form-data">
							<div class="form-group">
								<div class="form-row">
									<div class="col-md-6" style="margin-bottom: 30px;">
										<h3 style="text-align: center; margin-bottom: 10px;">Total Nilai</h3>
										<h1 style="text-align: center; font-size: 70px;"><?php echo $total_nilai; ?></h1>
									</div>
									<div class="col-md-6" style="margin-bottom: 30px;">
										<h3 style="text-align: center; margin-bottom: 10px;">Jumlah Voter</h3>
										<h1 style="text-align: center; font-size: 70px;"><?php echo $standup_aktif->jlh_vote; ?></h1>
									</div>
								</div>
							</div>
						</form>
					<?php } ?>
				</div>
			<?php } else { ?>
				<div class="card-body">
					<div class="alert alert-info fade show" style="border-radius: 30px;">
						<h4 style="text-align: center; margin-bottom: 10px;">Belum ada hasil voting</h4>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

	<?php $this->load->view("../views/template/javascript"); ?>

</body>

</html>