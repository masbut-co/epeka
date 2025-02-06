<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("../views/template/head"); ?>

<body class="bg-dark">

	<div class="container">
		<div class="card card-register mx-auto mt-5 mb-5">
			<div class="card-header"><h4 style="text-align: center;">Voting Online</h4></div>
			<div class="card-body">
				<div id="alert"></div>
				<?php if ($this->session->flashdata('success') == TRUE) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center; font-weight: bold;">
						Terima kasih! Voting berhasil dilakukan!
					</div>
                    <a href="https://bpsdm.pu.go.id/sipeka/">
                        <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;"> SELESAI </button>
                    </a>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php $this->load->view("../views/template/javascript"); ?>

</body>

</html>