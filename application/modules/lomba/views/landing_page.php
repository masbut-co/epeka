<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("../views/template/head"); ?>

<body class="bg-dark">

	<div class="container">
		<div class="card card-register mx-auto mt-5 mb-5">
			<div class="card-header">
                <h4 style="text-align: center;">ePEKA</h4>
                <h5 style="text-align: center;">Sistem Informasi Penanganan Keluhan</h5>
                <!-- <h5 style="text-align: center;">Menu box Kepuasaan Pelanggan</h5> -->
            </div>
			<div class="card-body">
				<div id="alert"></div>
					<div class="form-group">
						<label style="font-weight: bold">Pilih Unit Kerja:</label>
                        <a href="./balai?balai=0">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Sekretariat Badan Pengembangan Sumber Daya Manusia</button>
                        </a>
                        <a href="./balai?balai=10">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Pusat Pengembangan Talenta</button>
                        </a>
                        <a href="./balai?balai=11">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Pusat Pengembangan Kompetensi Sumber Daya Air dan Permukiman</button>
                        </a>
                        <a href="./balai?balai=12">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Pusat Pengembangan Kompetensi Jalan, Perumahan, dan Pengembangan Infrastruktur Wilayah</button>
                        </a>
                        <a href="./balai?balai=13">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Pusat Pengembangan Kompetensi Manajemen</button>
                        </a>
						<a href="./balai?balai=1">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah I Medan</button>
                        </a>
                        <a href="./balai?balai=2">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah II Palembang</button>
                        </a>
                        <a href="./balai?balai=3">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah III Jakarta</button>
                        </a>
                        <a href="./balai?balai=4">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah IV Bandung</button>
                        </a>
                        <a href="./balai?balai=5">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah V Yogyakarta</button>
                        </a>
                        <a href="./balai?balai=6">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah VI Surabaya</button>
                        </a>
                        <a href="./balai?balai=7">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah VII Banjarmasin</button>
                        </a>
                        <a href="./balai?balai=8">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah VIII Makassar</button>
                        </a>
                        <a href="./balai?balai=9">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Pengembangan Kompetensi Wilayah IX Jayapura</button>
                        </a>
                        <a href="./balai?balai=14">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-bottom: 10px; border-radius: 25px;">
                            Balai Penilaian Kompetensi</button>
                        </a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php $this->load->view("../views/template/javascript"); ?>

	<script type="text/javascript">
	</script>

</body>

</html>