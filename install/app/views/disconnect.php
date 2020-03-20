<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form method="post">
	<h2 class="text-center">GAGAL KONEKSI KE BASIS DATA</h2>
	
	<div id="body">
		<p style='text-align:justify;'>Ini bisa berarti bahwa informasi nama pengguna dan sandi dalam folder <code>desa/config/database.php</code> tidak benar, atau kami tak mampu menghubungi server basis data di <code><?= site_url();?></code>. Mungkin server basis data host anda sedang mati.</p>
			<ul>
				<li>Apakah nama pengguna dan sandi sudah benar?</li>
				<li>Apakah nama host sudah benar?</li>
				<li>Apakah server basis data sudah berjalan?</li>
			</ul>
		<p style='text-align:justify;'>Jika tidak mengetahui istilah di atas, sebaiknya menghubungi host anda. Jika Anda masih butuh bantuan, silakan kunjungi :
			<ul>
				<li><a href="https://github.com/afa28/Intallation-OpenSID">Instalasi OpenSID dengan Instalation Manager</a></li>
				<li><a href="https://www.facebook.com/groups/opensid">Forum Pengguna dan Pegiat OpenSID</a></li>
			</ul>
	</div>
	<hr>
	<div class="action text-center">
		<input type="hidden" name="act" value="gagal">
		<button type="submit" class="btn btn-lg btn-success">Coba lagi</button>
	</div>
</form>