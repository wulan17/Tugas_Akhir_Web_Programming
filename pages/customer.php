<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
<?php
$customer = new Customer();
$akses = $login->cek_akses("");
if(isset($_GET['tambah'])){
	if($akses == 1){
		$customer->tambah_customer();
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['edit'])){
	if($akses == 1){
		$customer->edit_customer($_GET['edit']);
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['hapus'])){
	if($akses == 1){
		$customer->hapus_customer($_GET['hapus']);
	}else{
		$login->no_akses();
	}
}else{
	?>
		<table border=1 class="table">
			<tr>
				<td style='text-align: center;' colspan=10><h2>Daftar Customer</h2></td>
			</tr>
			<tr>
				<th>No</th>
				<th>Keterangan</th>
				<?php if($akses == 1){ echo '<th>Aksi</th>';}?>
			</tr>
			<?php
			$customer->get_data($akses);
			if($akses == 1){
			?>
			<tr><td style="text-align: center;" colspan="3"><a class="btn btn-primary" href="?page=customer&tambah">Tambah Customer</a></td></tr>
			<?php
			}
			?>
		</table>
	<?php
}
?>
</div>
