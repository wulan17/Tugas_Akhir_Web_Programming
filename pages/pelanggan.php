<?php
$pelanggan = new Pelanggan();
if($login->cek_login() == 0){
	header("Location: ?");
}
$akses = $login->cek_akses("7,4,2");
$akses2 = $login->cek_akses("7");
if(isset($_GET['tambah'])){
	if($akses == 1){
			$pelanggan->tambah_pelanggan();
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['edit']) and !empty($_GET['edit'])){
	if($akses == 1){
			$pelanggan->edit_pelanggan($_GET['edit']);
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['hapus']) and !empty($_GET['hapus'])){
	if($akses2 == 1){
			$pelanggan->hapus_pelanggan($_GET['hapus']);
	}else{
		$login->no_akses();
	}
}else{
?>
<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
	<table border=1 class="table">
		<tr>
			<td style='text-align: center;' colspan=6><h2>Daftar Pelanggan</h2></td>
		</tr>
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Nomor Polisi</th>
			<th>Jenis Mobil</th>
			<th>KM</th>
			<?php
			if($akses == 1){
				echo '<th>Aksi</th>';
			}
			?>
		</tr>
		<?php
		$pelanggan->get_data($akses,$akses2);
		if($akses == 1){
		?>
		<tr style="text-align: center;">
			<td colspan="6"><a class="btn btn-primary" href="?page=pelanggan&tambah">Tambah Pelanggan</a></td>
		</tr>
		<?php
		}
		?>
	</table>
</div>
<?php
}
?>