<?php
class Pelanggan{
	private $status;
	private $err;
	private $conn;
	public function __construct(){
		global $conn;
		$this->conn = $conn;
	}
	public function nama($string){
		$query = $this->conn->query("select Pelanggan_nama from pelanggan where No_polisi='".$string."'");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_data($akses1,$akses2){
		$query = $this->conn->query("select * from pelanggan");
		while($data = $query->fetch_array()){
		?>
		<tr>
			<td><?php echo $data["Pelanggan_nama"];?></td>
			<td><?php echo $data["Pelanggan_alamat"];?></td>
			<td style="text-align:center"><?php echo $data["No_polisi"];?></td>
			<td><?php echo $data["Pelanggan_jenis_mobil"];?></td>
			<td style="text-align:center"><?php echo $data["Pelanggan_km"];?></td>
			<?php
			if($akses1 == 1){
				echo '<td style="text-align:center;">';
				echo '<a class="btn btn-success" href="?page=pelanggan&edit='.$data["No_polisi"].'">Edit</a>';
				if($akses2 == 1){
					echo '  <a class="btn btn-danger" href="?page=pelanggan&hapus='.$data["No_polisi"].'">Hapus</a>';
				}
				echo '</td>';
			}
			?>
		</tr>
		<?php
		}
	}
	private function tambah($np,$nama,$alamat,$km,$jm){
		$query = $this->conn->query("insert into pelanggan Values('".$np."','".$nama."','".$alamat."',".$km.",'".$jm."')");
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function update($np1,$np2,$nama,$alamat,$km,$jm){
		$query = $this->conn->query("update pelanggan set No_polisi='".$np2."',Pelanggan_nama='".$nama."',Pelanggan_alamat='".$alamat."',Pelanggan_km=".$km.",Pelanggan_jenis_mobil='".$jm."' where No_polisi='".$np1."'");
		$query2 = $this->conn->query("update faktur set No_polisi='".$np2."' where No_polisi='".$np1."'");
		if($query and $query2){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function hapus($np){
		$query = $this->conn->query("delete from pelanggan where No_polisi='".$np."'");
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}	
	}
	public function tambah_pelanggan(){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<table border=1 class="table">';
		echo '<form action="?page=pelanggan&tambah" method="POST">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Tambah Pelanggan</h2></td>';
		echo '</tr>';
		if(isset($_POST['tambah'])){
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$np = $_POST['np'];
			$jm = $_POST['jm'];
			$km = $_POST['km'];
			$this->tambah($np,$nama,$alamat,$km,$jm);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil menambah pelanggan</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menambah pelanggan : '.$this->err.'</b></td></tr>';
			}
			echo '<tr style="text-align: center;"><td colspan=2><a class="btn btn-primary" href="?page=pelanggan">Kembali</a></td></tr>';
		}else{
			?>
			<tr>
				<td>No Polisi</td>
				<td><input type="text" name="np" placeholder="No Polisi" /></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td><input type="text" name="nama" placeholder="Nama" /></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td><textarea name="alamat" placeholder="Alamat"></textarea></td>
			</tr>
			<tr>
				<td>Jenis Mobil</td>
				<td><input type="text" name="jm" placeholder="Jenis Mobil" /></td>
			</tr>
			<tr>
				<td>KM</td>
				<td><input type="text" name="km" placeholder="KM" /></td>
			</tr>
			<tr>
				<td style="text-align:center" colspan=2>
					<input class="btn btn-success" type="submit" name="tambah" value="Tambah" />
					<a class="btn btn-warning" href="?page=pelanggan">Kembali</a>
				</td>
			</tr>
			</form>
		<?php
		}
		echo '</table>';
		echo '</div>';
	}
	public function edit_pelanggan($np1){
		$query = $this->conn->query("select * from pelanggan where No_polisi='".$np1."'");
		$data = $query->fetch_array();
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=pelanggan&edit='.$np1.'" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Edit Pegawai</h2></td>';
		echo '</tr>';
		if(isset($_POST['edit'])){
			$np2 = $_POST['np'];
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$jm = $_POST['jm'];
			$km = $_POST['km'];
			$this->update($np1,$np2,$nama,$alamat,$km,$jm);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil memperbarui data</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal memperbarui data</b></td></tr>';
			}
			echo '<tr>';
			echo '<td>No Polisi</td>';
			echo '<td><input type="text" name="np" value="'.$_POST["np"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" value="'.$_POST["nama"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Alamat</td>';
			echo '<td><textarea name="alamat">'.$_POST["alamat"].'</textarea>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Jenis Mobil</td>';
			echo '<td><input type="text" name="jm" value="'.$_POST["jm"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>KM</td>';
			echo '<td><input type="text" name="km" value="'.$_POST["km"].'" />';
			echo '</tr>';
		}else{
			echo '<tr>';
			echo '<td>No Polisi</td>';
			echo '<td><input type="text" name="np" value="'.$data["No_polisi"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" value="'.$data["Pelanggan_nama"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Alamat</td>';
			echo '<td><textarea name="alamat">'.$data["Pelanggan_alamat"].'</textarea>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Jenis Mobil</td>';
			echo '<td><input type="text" name="jm" value="'.$data["Pelanggan_jenis_mobil"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>KM</td>';
			echo '<td><input type="text" name="km" value="'.$data["Pelanggan_km"].'" />';
			echo '</tr>';
		}
		echo '<tr>';
		echo '<td style="text-align:center" colspan=2><input class="btn btn-success" type="submit" name="edit" value="Perbarui" /> ';
		echo '<a class="btn btn-warning" href="?page=pelanggan">Kembali</a></td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';

	}
	public function hapus_pelanggan($np){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<table border=1 class="table">';
		if(isset($_POST['confirm'])){
			$this->hapus($np);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil menghapus pelanggan</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menghapus pelanggan</b></td></tr>';
			}
			echo '<tr><td style="text-align:center;"><a class="btn btn-success" href="?page=pelanggan">Kembali</a></td></tr>';
		}else{
			
			echo '<form action="?page=pelanggan&hapus='.$np.'" method="POST">';
			echo '<tr>';
			echo '<td style="text-align: center;" colspan=2><h2>Hapus Pelanggan?</h2></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center;"><input class="btn btn-danger" type="submit" name="confirm" value="Ya" /> ';
			echo '<a class="btn btn-success" href="?page=pelanggan">Tidak</a></td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table>';
		echo '</div>';
	}
}
?>