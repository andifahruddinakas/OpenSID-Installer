<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h2 class="text-center">SELAMAT DATANG DI INSTALASI OPENSID</h2>
<div class="license">
	<div id="body">
		<textarea class="form-control" style="background-color: #fafafa;" readonly><?= license(); ?></textarea>
	</div>
</div>
<hr>
<div class="action">
	<form method="POST">
		<input type="hidden" name="act" value="mulai">
		<button type="submit" class="btn btn-lg btn-success">Mulai Instalasi</button>
	</form>
</div>