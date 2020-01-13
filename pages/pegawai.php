<?php
$pegawai = new Pegawai();
$akses = $login->cek_akses("7");
if($login->cek_login() == 0){
	header("Location: ?");
}
if(isset($_GET['tambah'])){
	if($akses == 1){
			$pegawai->tambah_pegawai();
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['edit']) and !empty($_GET['edit'])){
	if($akses == 1){
			$pegawai->edit_pegawai($_GET['edit']);
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['hapus']) and !empty($_GET['hapus'])){
	if($akses == 1){
			$pegawai->hapus_pegawai($_GET['hapus']);
	}else{
		$login->no_akses();
	}
}else{
?>
<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
	<table border=1 class="table">
		<tr>
			<td style='text-align: center;' colspan=5><h2>Daftar Pegawai</h2></td>
		</tr>
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Jabatan</th>
			<th>Username</th>
			<?php
			if($akses == 1){
				echo '<th>Aksi</th>';
			}
			?>
		</tr>
		<?php
		$pegawai->get_data($akses);
		if($akses == 1){
		?>
		<tr style="text-align: center;">
			<td colspan="5"><a class="btn btn-primary" href="?page=pegawai&tambah">Tambah Pegawai</a></td>
		</tr>
		<?php
		}
		?>
	</table>
</div>
<?php
}
?>