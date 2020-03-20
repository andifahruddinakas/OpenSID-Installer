<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form method="post">
	<h2 class="text-center">PENGATURAN PENGGUNA</h2>
	
	<div id="body">
		<input type="hidden" name="db_host" value="<?= DB_HOST; ?>" />
		<input type="hidden" name="db_name" value="<?= DB_NAME; ?>" />
		<input type="hidden" name="db_user" value="<?= DB_USER; ?>" />
		<input type="hidden" name="db_pass" value="<?= DB_PASS; ?>" />
		<input type="hidden" name="db_port" value="<?= DB_PORT; ?>" />
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Nama pengguna</label>
			<div class="col-sm-7">
				<input type="text" name="user" class="form-control" maxlength="15" minlength="5" required />
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Sandi</label>
			<div class="col-sm-7">
				<input type="password" name="pass" class="form-control" maxlength="20" minlength="6" required />
			</div>
		</div>
	</div>
	<hr>
	<div class="action text-center">
		<input type="hidden" name="act" value="langkah_3">
		<button type="submit" class="btn btn-lg btn-success">Selesai</button>
	</div>
</form>