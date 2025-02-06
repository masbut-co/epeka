<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("../views/template/head"); ?>

<body class="bg-dark">

	<div class="container">
		<div class="card card-register mx-auto mt-5 mb-5">
			<div class="card-header"><h4 style="text-align: center;">Voting Fashion Show</h4></div>
			<?php if ($fashion_aktif != null) { ?>
				<div class="card-body">
					<div id="alert"></div>
					<?php if ($this->session->flashdata('success') == TRUE) { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							Pendaftaran berhasil dilakukan!
						</div>
					<?php } ?>
					<img src="img/fashion.jpg" width="100%" style="margin-bottom: 10px;">
					<div class="alert alert-info fade show" style="border-radius: 30px;">
						<h2 style="text-align: center; margin-bottom: 10px;"><?php echo $fashion_aktif->nama_unit; ?></h2>
					</div>
					<form method="POST" action="lomba/Fashion_show/addVotingFashion" id="form1" enctype="multipart/form-data">
						<input type="hidden" name="id_unit" id="id_unit" value="<?php echo $fashion_aktif->id_unit; ?>">
						<input type="hidden" name="id_lomba" id="id_lomba" value="<?php echo $fashion_aktif->id_kategori; ?>">
						<!-- <div class="form-group">
							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group">
										<h2 style="text-align: center; margin-bottom: 10px;"><?php echo $band_aktif->nama_unit; ?></h2>
									</div>
								</div>
							</div>
						</div> -->
						<div class="form-group">
							<div class="form-row">
								<?php foreach ($fashion_kategori as $fk) { ?>
									<div class="col-md-12" style="margin-bottom: 30px;">
										<div class="form-group">
											<h3 style="text-align: center; margin-bottom: 10px;"><?php echo $fk['nama_kategori']; ?></h3>
											<div class="rating-stars text-center">
												<ul id="stars">
													<li class="star" data-value="1" name="<?php echo $fk['kategori_input']; ?>">
														<i class='fa fa-star fa-fw'></i>
													</li>
													<li class="star" data-value="2" name="<?php echo $fk['kategori_input']; ?>">
														<i class='fa fa-star fa-fw'></i>
													</li>
													<li class="star" data-value="3" name="<?php echo $fk['kategori_input']; ?>">
														<i class='fa fa-star fa-fw'></i>
													</li>
													<li class="star" data-value="4" name="<?php echo $fk['kategori_input']; ?>">
														<i class='fa fa-star fa-fw'></i>
													</li>
													<li class="star" data-value="5" name="<?php echo $fk['kategori_input']; ?>">
														<i class='fa fa-star fa-fw'></i>
													</li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php foreach ($fashion_kategori as $fk) { ?>
							<input type="hidden" name="<?php echo $fk['kategori_input']; ?>" id="<?php echo $fk['kategori_input']; ?>" value="1">
						<?php } ?>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<?php if ($curr_date <= $fashion_aktif->waktu_aktif) { ?>
									<button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">VOTE !!!</button>
								<?php } elseif ($curr_date > $fashion_aktif->waktu_aktif) { ?>
									<button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;" disabled>VOTE !!!</button>
								<?php } ?>
							</div>
							<div class="col-md-4"></div>
						</div>
					</form>
				</div>
			<?php } else { ?>
				<div class="card-body">
					<div class="alert alert-info fade show" style="border-radius: 30px;">
						<h4 style="text-align: center; margin-bottom: 10px;">Belum ada voting yang dibuka</h4>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

	<?php $this->load->view("../views/template/javascript"); ?>

</body>

</html>