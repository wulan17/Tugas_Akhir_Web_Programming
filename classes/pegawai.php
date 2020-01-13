<?php
class Pegawai{
	private $status;
	private $err;
	private $nama;
	private $username;
	private $password;
	private $conn;
	public function __construct(){
		global $conn;
		$this->conn = $conn;
	}
	public function nama($id){
		$query = $this->conn->query("select Pegawai_nama from pegawai where idpegawai=".$id);
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_jabatan($id){
		$query = $this->conn->query("select jabatan_deskripsi from jabatan where idjabatan in (select idjabatan from menjabat_sebagai where idpegawai=".$id.")");
		$data = $query->fetch_row();
		return $data[0];
	}
	public function get_idmenjabat($id){
		$query = $this->conn->query("select idmenjabat_sebagai from menjabat_sebagai where idpegawai=".$id);
		$data = $query->fetch_row();
		return $data[0];
	}
	public function get_data($akses){
		$query = $this->conn->query("select * from pegawai");
		while($data = $query->fetch_array()){
		?>
		<tr>
			<td><?php echo $data["pegawai_nama"];?></td>
			<td><?php echo $data["pegawaialamat"];?></td>
			<td><?php echo $this->get_jabatan($data["idpegawai"]);?></td>
			<td><?php echo $data["username"];?></td>
			<?php if($akses == 1){
				echo '<td style="text-align:center;">';
				echo '<a class="btn btn-success" href="?page=pegawai&edit='.$data["idpegawai"].'">Edit</a>  <a class="btn btn-danger" href="?page=pegawai&hapus='.$data["idpegawai"].'">Hapus</a>';
				echo '</td>';
			}
			?>
		</tr>
		<?php
		}
	}
	private function last_id(){
		$query = $this->conn->query("select idpegawai from pegawai order by idpegawai desc limit 1");
		$data = $query->fetch_array();
		return $data[0];
	}
	private function jabatan_last_id(){
		$query = $this->conn->query("select idmenjabat_sebagai from menjabat_sebagai order by idmenjabat_sebagai desc limit 1");
		$data = $query->fetch_array();
		return $data[0];
	}
	private function tambah($nama,$alamat,$username,$password,$email,$jabatan){
		$this->nama = $conn->real_escape_string($nama);
		$this->username = $conn->real_escape_string($username);
		$this->password = password_hash($password, PASSWORD_DEFAULT);
		$id = ($this->last_id()+1);
		$idjabatan = ($this->jabatan_last_id()+1);
		$query = $this->conn->query("insert into pegawai Values(".$id.",'".$this->nama."','".$alamat."','".$this->username."','".$this->password."','".$email."')");
		$query2 = $this->conn->query("insert into menjabat_sebagai Values(".$idjabatan.",".$jabatan.",".$id.")");
		if($query and $query2){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function update($id,$nama,$alamat,$username,$email,$jabatan){
		$this->nama = $this->conn->real_escape_string($nama);
		$this->username = $this->conn->real_escape_string($username);
		$query = $this->conn->query("update menjabat_sebagai set idjabatan=".$jabatan." where idpegawai=".$id);
		$query2 = $this->conn->query("update pegawai set pegawai_nama='".$this->nama."',pegawaialamat='".$alamat."',username='".$this->username."' where idpegawai=".$id);
		if($query and $query2){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function update_password($passlama,$passbaru){
		$pass1 = password_hash($passlama, PASSWORD_DEFAULT);
		$this->password = password_hash($passlama, PASSWORD_DEFAULT);
		$check = $this->conn->query("select * from pegawai where username='".$_COOKIE['username']."'")->fetch_array();
		$check_pass = $check[4];
		if(password_verify($pass1, $check_pass)){
			$query = $this->conn->query("update pegawai set password='".$this->password."' where username='".$_COOKIE['username']."'");
			if($query){
				$this->status = 1;
			}else{
				$this->status = 0;
				$this->err = $this->conn->error;
			}
		}else{
			$this->status = 0;
		}
	}
	private function hapus($id){
		$query = $this->conn->query("delete from menjabat_sebagai where idpegawai=".$id);
		$query2 = $this->conn->query("delete from pegawai where idpegawai=".$id);
		if($query and $query2){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	public function tambah_pegawai(){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=pegawai&tambah" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Tambah Pegawai</h2></td>';
		echo '</tr>';
		if(isset($_POST['tambah'])){
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$jabatan = $_POST['jabatan'];
			$this->tambah($nama,$alamat,$username,$password,$email,$jabatan);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil menambah pegawai</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menambah pegawai</b></td></tr>';
			}
			echo '<tr style="text-align: center;"><td colspan=2><a class="btn btn-primary" href="?page=pegawai">Kembali</a></td></tr>';
		}else{
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" placeholder="Nama" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Alamat</td>';
			echo '<td><textarea name="alamat" placeholder="Alamat"></textarea>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Username</td>';
			echo '<td><input type="text" name="username" placeholder="Username" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Email</td>';
			echo '<td><input type="text" name="email" placeholder="Email" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Password</td>';
			echo '<td><input type="text" name="password" placeholder="Password" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Jabatan</td>';
			echo '<td>';
			echo '<select name="jabatan">';
			echo '<option>Pilih Jabatan</option>';
			$query = $this->conn->query("select * from jabatan order by akses asc");
			while($data = $query->fetch_array()){
				echo '<option value="'.$data["idjabatan"].'">'.$data["jabatan_deskripsi"].'</option>';
			}
			echo '</select>';
			echo '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center" colspan=2><input class="btn btn-success" type="submit" name="tambah" value="Tambah" /> ';
			echo '<a class="btn btn-warning" href="?page=pegawai">Kembali</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</form>';
		echo '</div>';

	}
	public function edit_pegawai($id){
		$query = $this->conn->query("select * from pegawai where idpegawai=".$id);
		$data = $query->fetch_array();
		$data2 = $this->conn->query("select idjabatan from menjabat_sebagai where idpegawai=".$id)->fetch_array();
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=pegawai&edit='.$id.'" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Edit Pegawai</h2></td>';
		echo '</tr>';
		if(isset($_POST['edit'])){
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$jabatan = $_POST['jabatan'];
			$this->update($id,$nama,$alamat,$username,$email,$jabatan);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil memperbarui data</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal memperbarui data</b></td></tr>';
			}
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" value="'.$_POST["nama"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Alamat</td>';
			echo '<td><textarea name="alamat">'.$_POST["alamat"].'</textarea>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Username</td>';
			echo '<td><input type="text" name="username" value="'.$_POST["username"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Email</td>';
			echo '<td><input type="text" name="email" value="'.$_POST["email"].'" />';
			echo '</tr>';echo '<tr>';
			echo '<td>Jabatan</td>';
			echo '<td>';
			echo '<select name="jabatan">';
			echo '<option>Pilih Jabatan</option>';
			$query = $this->conn->query("select * from jabatan order by akses asc");
			while($data = $query->fetch_array()){
				echo '<option value="'.$data["idjabatan"].'"';
				if($data["idjabatan"] == $_POST["jabatan"]){
					echo 'selected';
				}
				echo '>'.$data["jabatan_deskripsi"].'</option>';
			}
			echo '</select>';
			echo '</td>';
			echo '</tr>';
		}else{
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" value="'.$data["pegawai_nama"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Alamat</td>';
			echo '<td><textarea name="alamat">'.$data["pegawaialamat"].'</textarea>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Username</td>';
			echo '<td><input type="text" name="username" value="'.$data["username"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Email</td>';
			echo '<td><input type="text" name="email" value="'.$data["email"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Jabatan</td>';
			echo '<td>';
			echo '<select name="jabatan">';
			echo '<option>Pilih Jabatan</option>';
			$query = $this->conn->query("select * from jabatan order by akses asc");
			while($data = $query->fetch_array()){
				echo '<option value="'.$data["idjabatan"].'"';
				if($data["idjabatan"] == $data2[0]){
					echo 'selected';
				}
				echo '>'.$data["jabatan_deskripsi"].'</option>';
			}
			echo '</select>';
			echo '</td>';
			echo '</tr>';
		}
		echo '<tr>';
		echo '<td style="text-align:center" colspan=2><input class="btn btn-success" type="submit" name="edit" value="Perbarui" /> ';
		echo '<a class="btn btn-warning" href="?page=pegawai">Kembali</a></td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';

	}
	public function hapus_pegawai($id){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<table border=1 class="table">';
		if(isset($_POST['confirm'])){
			$this->hapus($id);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil manghapus pegawai</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menghapus pegawai</b></td></tr>';
			}
			echo '<tr><td style="text-align:center;"><a class="btn btn-success" href="?page=pegawai">Kembali</a></td></tr>';
		}else{
			echo '<form action="?page=pegawai&hapus='.$id.'" method="POST">';
			echo '<tr>';
			echo '<td style="text-align: center;" colspan=2><h2>Hapus Pegawai?</h2></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center;"><input class="btn btn-danger" type="submit" name="confirm" value="Ya" /> ';
			echo '<a class="btn btn-success" href="?page=pegawai">Tidak</a></td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table>';
		echo '</div>';
	}
}
?>