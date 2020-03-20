<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form method="post">
	<h2 class="text-center">PENGATURAN BASIS DATA</h2>
	
	<div id="body">
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Nama Basis data</label>
			<div class="col-sm-7">
				<input type="text" name="db_name" value="opensid" class="form-control" required />
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Port Basis data</label>
			<div class="col-sm-7">
				<input type="text" name="db_port" value="3306" class="form-control" required />
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Nama pengguna</label>
			<div class="col-sm-7">
				<input type="text" name="db_user" value="root" class="form-control" required />
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Sandi</label>
			<div class="col-sm-7">
				<input type="text" name="db_pass" value="" class="form-control" />
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-5 col-form-label">Host Basis data</label>
			<div class="col-sm-7">
				<input type="text" name="db_host" value="localhost" class="form-control" required />
			</div>
		</div>
	</div>
	<hr>
	<div class="action text-center">
		<input type="hidden" name="act" value="langkah_1">
		<button type="submit" class="btn btn-lg btn-success">Hubungkan Ke Basis data</button>
	</div>
</form>