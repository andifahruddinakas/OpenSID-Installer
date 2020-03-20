<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form method="post">
	<h2 class="text-center">PENGATURAN DASAR WEBSITE DESA</h2>
	
	<div id="body">
		<input type="hidden" name="db_host" value="<?= DB_HOST; ?>" />
		<input type="hidden" name="db_name" value="<?= DB_NAME; ?>" />
		<input type="hidden" name="db_user" value="<?= DB_USER; ?>" />
		<input type="hidden" name="db_pass" value="<?= DB_PASS; ?>" />
		<input type="hidden" name="db_port" value="<?= DB_PORT; ?>" />
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Website Desa</label>
			<div class="col-sm-7">
				<input type="text" name="website" class="form-control" value="<?= site_url(); ?>" required />
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Nama Desa</label>
			<div class="col-sm-7">
				<input type="text" name="nama" class="form-control" required />
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Kepala Desa</label>
			<div class="col-sm-7">
				<input type="text" name="kepala" class="form-control" required />
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Email Desa</label>
			<div class="col-sm-7">
				<input type="email" name="email" class="form-control" />
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Telepon Desa</label>
			<div class="col-sm-7">
				<input type="text" name="telepon" class="form-control" />
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Default Timezone</label>
			<div class="col-sm-7">
				<select class="form-control col-sm-12" name="timezone" required>
					<option value="Asia/Jakarta" selected>Asia/Jakarta</option>
					<option value="Asia/Makassar">Asia/Makassar</option>
					<option value="Asia/Jayapura">Asia/Jayapura</option>
				</select>
			</div>
		</div>
	</div>
	<hr>
	<div class="action text-center">
		<input type="hidden" name="act" value="langkah_2">
		<button type="submit" class="btn btn-lg btn-success">Selanjutnya</button>
	</div>
</form>