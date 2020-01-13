<?php
class Pembayaran{
	private $conn;
	public function __construct(){
		global $conn;
		$this->conn = $conn;
	}
	public function jpembayaran($id){
		$query = $this->conn->query("select pembayaran_deskripsi from pembayaran where idpembayaran=".$id);
		$data = $query->fetch_array();
		return $data[0];
	}
	private function last_id(){
		$query = $this->conn->query("select idpembayaran from pembayaran order by idpembayaran desc limit 1");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_data($akses){
		$i = 1;
		$query = $this->conn->query("select * from pembayaran");
		while($data = $query->fetch_array()){
			echo '<tr>';
			echo '<td>'.$i.'</td><td>'.$data[1].'</td>';
			if($akses == 1){
				echo '<td style="text-align:center;">';
				echo '<a class="btn btn-success" href="?page=pembayaran&edit='.$data[0].'">Edit</a>';
				echo '  <a class="btn btn-danger" href="?page=pembayaran&hapus='.$data[0].'">Hapus</a>';
				echo '</tr>';
			}
			$i++;
		}
	}
	private function tambah($nama){
		$this->nama = $this->conn->real_escape_string($nama);
		$id = ($this->last_id()+1);
		$query = $this->conn->query("insert into pembayaran Values(".$id.",'".$this->nama."')");
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function update($id,$nama){
		$this->nama = $this->conn->real_escape_string($nama);
		$query = $this->conn->query("update pembayaran set pembayaran_deskripsi='".$this->nama."' where idpembayaran=".$id);
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function hapus($id){
		$query = $this->conn->query("delete from pembayaran where idpembayaran=".$id);
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	public function tambah_pembayaran(){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=pembayaran&tambah" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Tambah Metode Pembayaran</h2></td>';
		echo '</tr>';
		if(isset($_POST['tambah'])){
			$nama = $_POST['nama'];
			$this->tambah($nama);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil Metode Pembayaran</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal Metode Pembayaran</b></td></tr>';
			}
			echo '<tr style="text-align: center;"><td colspan=2><a class="btn btn-primary" href="?page=pembayaran">Kembali</a></td></tr>';
		}else{
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" placeholder="Nama" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center" colspan=2><input class="btn btn-success" type="submit" name="tambah" value="Tambah" /> ';
			echo '<a class="btn btn-warning" href="?page=pembayaran">Kembali</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</form>';
		echo '</div>';

	}
	public function edit_pembayaran($id){
		$query = $this->conn->query("select * from pembayaran where idpembayaran=".$id);
		$data = $query->fetch_array();
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=pembayaran&edit='.$id.'" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Edit Metode Pembayaran</h2></td>';
		echo '</tr>';
		if(isset($_POST['edit'])){
			$nama = $_POST['nama'];
			$this->update($id,$nama);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil memperbarui data</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal memperbarui data</b></td></tr>';
			}
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" value="'.$_POST["nama"].'" />';
			echo '</tr>';
		}else{
			echo '<tr>';
			echo '<td>Nama</td>';
			echo '<td><input type="text" name="nama" value="'.$data["pembayaran_deskripsi"].'" />';
			echo '</tr>';
		}
		echo '<tr>';
		echo '<td style="text-align:center" colspan=2><input class="btn btn-success" type="submit" name="edit" value="Perbarui" /> ';
		echo '<a class="btn btn-warning" href="?page=pembayaran">Kembali</a></td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';

	}
	public function hapus_pembayaran($id){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<table border=1 class="table">';
		if(isset($_POST['confirm'])){
			$this->hapus($id);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil Metode Pembayaran</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal Metode Pembayaran</b></td></tr>';
			}
			echo '<tr><td style="text-align:center;"><a class="btn btn-success" href="?page=pembayaran">Kembali</a></td></tr>';
		}else{
			echo '<form action="?page=pembayaran&hapus='.$id.'" method="POST">';
			echo '<tr>';
			echo '<td style="text-align: center;" colspan=2><h2>Hapus Metode Pembayaran?</h2></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center;"><input class="btn btn-danger" type="submit" name="confirm" value="Ya" /> ';
			echo '<a class="btn btn-success" href="?page=pembayaran">Tidak</a></td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table>';
		echo '</div>';
	}
}