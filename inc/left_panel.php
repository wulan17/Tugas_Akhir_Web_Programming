<div class="leftpanel">
	<ul class="navbar-nav">
		<li class="navbar-item"><a href="?page=home">Daftar Pembelian</a></li>
		<li class="navbar-item"><a href="?page=home&tambah">Pembelian Baru</a></li>
		<li class="navbar-item"><a href="?page=pelanggan">Daftar Pelanggan</a></li>
		<li class="navbar-item"><a href="?page=pegawai">Daftar Pegawai</a></li>
		<li class="navbar-item"><a href="?page=barang">Daftar Barang</a></li>
		<li class="navbar-item"><a href="?page=pembayaran">Metode Pembayaran</a></li>
		<li class="navbar-item"><a href="?page=customer">Customer</a></li>
	</ul>
	<?php include_once "classes/statistik.php";
	$statistik = new Statistik();
	?>
	<table class="statistik">
		<tr>
			<th colspan=6>Statistik</th>
		</tr>
		<tr>
			<td>Barang</td>
			<td>:</td>
			<td colspan=3><?php echo $statistik->get_barang();?> jenis</td>
		</tr>
		<tr>
			<td>Pegawai</td>
			<td>:</td>
			<td colspan=3><?php echo $statistik->get_pegawai();?> orang</td>
		</tr>
		<tr>
			<td>Pelanggan</td>
			<td>:</td>
			<td colspan=3><?php echo $statistik->get_pelanggan();?> orang</td>
		</tr>
		<tr>
			<td>Terjual</td>
			<td>:</td>
			<td colspan=3><?php echo $statistik->get_pembelian();?> buah</td>
		</tr>
		<tr>
			<td rowspan=2>Transaksi</td>
			<td rowspan=2>:</td>
			<td>Berhasil</td>
			<td>:</td>
			<td><?php echo $statistik->get_faktur();?> kali</td>
		</tr>
		<tr>
			<td>Tertunda</td>
			<td>:</td>
			<td><?php echo $statistik->get_faktur_temp();?> kali</td>
		</tr>
	</table>
</div>