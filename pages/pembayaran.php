<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
<?php
$pembayaran = new Pembayaran();
$akses = $login->cek_akses("");
if(isset($_GET['tambah'])){
	if($akses == 1){
		$pembayaran->tambah_pembayaran();
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['edit'])){
	if($akses == 1){
		$pembayaran->edit_pembayaran($_GET['edit']);
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['hapus'])){
	if($akses == 1){
		$pembayaran->hapus_pembayaran($_GET['hapus']);
	}else{
		$login->no_akses();
	}
}else{
	?>
		<table border=1 class="table">
			<tr>
				<td style='text-align: center;' colspan=10><h2>Daftar Metode Pembayaran</h2></td>
			</tr>
			<tr>
				<th>No</th>
				<th>Metode</th>
				<?php if($akses == 1){ echo '<th>Aksi</th>';}?>
			</tr>
			<?php
			$pembayaran->get_data($akses);
			if($akses == 1){
			?>
			<tr><td style="text-align: center;" colspan="3"><a class="btn btn-primary" href="?page=pembayaran&tambah">Tambah Metode Pembayaran</a></td></tr>
			<?php
			}
			?>
		</table>
	<?php
}
?>
</div>
