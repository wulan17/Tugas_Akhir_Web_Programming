<?php
include_once 'classes/pelanggan.php';
include_once 'classes/pegawai.php';
include_once 'classes/barang.php';
include_once 'classes/pembayaran.php';
$akses = $login->cek_akses("7,2");
$akses2 = $login->cek_akses("7");
$pembelian = new Pembelian();
if($login->cek_login() == 0){
	header("Location: ?");
}
if(isset($_GET['halaman']) and !empty($_GET['halaman'])){
	$page = $_GET['halaman'];
}else{
	$page = 1;
}

?>
<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
	<table border=1 class="table">
	<?php
	if(isset($_GET['tertunda'])){
		?>
		<tr>
			<td style='text-align: center;' colspan=10><h2>Daftar Pembelian Tertunda</h2></td>
		</tr>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Jam</th>
			<th>No Polisi</th>
			<th>Jenis Pembayaran</th>
			<th>Costumer</th>
			<th>Operator</th>
			<th>Aksi</th>
		</tr>

		<?php
		$pembelian->faktur_temp_lengkap($akses2,$page);
	}else{
		?>
		<tr>
			<td style='text-align: center;' colspan=10><h2>Daftar Pembelian</h2></td>
		</tr>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Jam</th>
			<th>No Polisi</th>
			<th>Jenis Pembayaran</th>
			<th>Costumer</th>
			<th>Operator</th>
			<th>Aksi</th>
		</tr>
		<?php
		$pembelian->faktur_lengkap($page);
	}
	?>
	</table>
</div>
