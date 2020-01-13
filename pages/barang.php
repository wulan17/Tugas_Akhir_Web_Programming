<?php
$barang = new Barang();
$akses = $login->cek_akses("7,5,4,2");
$akses2 = $login->cek_akses("7,5,2");
if($login->cek_login() == 0){
	header("Location: ?");
}
if(isset($_GET['tambah'])){
	if($akses == 1){
		$barang->tambah_barang();
	}else{
		$login->no_akses();
	}
}elseif(isset($_GET['edit']) and !empty($_GET['edit'])){
	if($akses == 1){
		$barang->edit_barang($_GET['edit']);
	}else{
		$login->no_akses();
	}
}elseif(isset($_POST['tersedia']) and !empty($_POST['tersedia'])){
	$barang->tersedia($_POST['tersedia']);
	header('Location: ?page=barang');
}elseif(isset($_POST['tidak_tersedia']) and !empty($_POST['tidak_tersedia'])){
	$barang->tidak_tersedia($_POST['tidak_tersedia']);
	header('Location: ?page=barang');
}else{
?>
<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">
	<table border=1 class="table">
	<?php
	if(isset($_GET['faktur']) and !empty($_GET['faktur'])){
		$pembelian->fullfaktur($_GET['faktur']-1);
	}else{
		?>
		<tr>
			<td style='text-align: center;' colspan=6><h2>Daftar Barang</h2></td>
		</tr>
		<tr>
			<th>ID Barang</th>
			<th>Nama Barang</th>
			<th>Harga</th>
			<th>Terjual</th>
			<th>Status</th>
			<?php
			if($akses2 == 1){
				echo '<th>Aksi</th>';
			}
			?>
		</tr>
		<?php
		$barang->get_data($akses,$akses2);
	}
	if($akses2 == 1){
		?>
		<tr style="text-align: center;">
			<td colspan="6"><a class="btn btn-primary" href="?page=barang&tambah">Tambah Barang</a></td>
		</tr>
		<?php
		}
		?>
	</table>
</div>
<?php
}
?>