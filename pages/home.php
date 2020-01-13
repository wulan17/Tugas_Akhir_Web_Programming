<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
<?php
include_once 'classes/pembelian.php';
include_once 'classes/pegawai.php';
include_once 'classes/pelanggan.php';
include_once 'classes/barang.php';
include_once 'classes/pembayaran.php';
$home = new Home();
$akses = $login->cek_akses("7,4,2");
$akses2 = $login->cek_akses("7");
$pembelian = new pembelian();
if($akses == 1){
	if(isset($_GET['tambah'])){
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=10><h2>Tambah Pembelian</h2></td>';
		echo '</tr>';
		$pembelian->tambah_pembelian();
		echo '</table>';
	}elseif(isset($_GET['faktur'])){
		if(isset($_GET['hapusbarang'])){
			echo '<table border=1 class="table">';
			echo '<tr>';
			echo '<td style="text-align: center;" colspan=10><h2>Hapus Barang?</h2></td>';
			echo '</tr>';
			$pembelian->hapus_barang($_GET['faktur'],$_GET['hapusbarang']);
			echo '</table>';
		}elseif(isset($_GET['tbarang'])){
			echo '<table border=1 class="table">';
			echo '<tr>';
			echo '<td style="text-align: center;" colspan=2><h2>Pembelian</h2></td>';
			echo '</tr>';
			$pembelian->tambah_barang($_GET['faktur']);
			echo '</table>';
		}else{
			echo '<table border=1 class="table">';
			echo '<tr>';
			echo '<td style="text-align: center;" colspan=10><h2>Pembelian</h2></td>';
			echo '</tr>';
			$pembelian->new_faktur_temp($_GET['faktur']);
			echo '</table>';
		}
	}elseif(isset($_GET['pembayaran'])){
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=10><h2>Pembelian</h2></td>';
		echo '</tr>';
		$pembelian->pembayaran($_GET['pembayaran'],$_POST['pembayaran']);
		echo '</table>';
	}elseif(isset($_GET['hapus'])){
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=10><h2>Hapus Pembelian?</h2></td>';
		echo '</tr>';
		$pembelian->hapus_pembelian($_GET['hapus']);
		echo '</table>';
	}elseif(isset($_GET['validasi'])){
		if($akses2 == 1){
			$pembelian->validasi($_GET['validasi']);
		}else{
			$login->no_akses();
		}
	}else{
		if(isset($_GET['rincian']) and !empty($_GET['rincian'])){
			$pembelian->fullfaktur($_GET['rincian']-1);
			$pembelian->rincian($_GET['rincian']-1);
		}else{
			?>
			<table border=1 class="table">
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
			$pembelian->faktur();
			?>
			<tr><td style="text-align: center;" colspan=8><a class="btn btn-primary" href="?page=pembelian&selesai">Selengkapnya</a></td></tr>
			</table>
			<table border=1 class="table">
			<tr>
				<td style='text-align: center;' colspan=7><h2>Daftar Pembelian Tertunda</h2></td>
				<td style='text-align: center;'><a class="btn btn-primary" href="?page=home&tambah">Pembelian Baru</a></td>
			</tr>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>No Polisi</th>
				<th>Costumer</th>
				<th>Operator</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>

			<?php
			$pembelian->faktur_temp($akses2);
			?>
		</table>
		<?php
		}
	}	
}else{
	if(isset($_GET['rincian']) and !empty($_GET['rincian'])){
			$pembelian->fullfaktur($_GET['rincian']-1);
			$pembelian->rincian($_GET['rincian']-1);
		}else{
			?>
			<table border=1 class="table">
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
			$pembelian->faktur();
			?>
			<tr><td style="text-align: center;" colspan=8><a class="btn btn-primary" href="?page=pembelian&selesai">Selengkapnya</a></td></tr>
			</table>
			<table border=1 class="table">
			<tr>
				<td style='text-align: center;' colspan=7><h2>Daftar Pembelian Tertunda</h2></td>
				<td style='text-align: center;'><a class="btn btn-primary" href="?page=home&tambah">Pembelian Baru</a></td>
			</tr>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>No Polisi</th>
				<th>Costumer</th>
				<th>Operator</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>

			<?php
			$pembelian->faktur_temp($akses2);
			?>
		</table>
		<?php
		}
}
?>
</div>