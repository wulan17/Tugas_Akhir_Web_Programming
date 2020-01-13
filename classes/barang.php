<?php
class Barang{
	private $status;
	private $err;
	private $conn;
	public function __construct(){
		global $conn;
		$this->conn = $conn;
	}
	public function nama($id){
		$query = $this->conn->query("select Barang_nama from barang where idBarang=".$id);
		$data = $query->fetch_array();
		return $data[0];
	}
	public function harga($id){
		$query = $this->conn->query("select Barang_harga from barang where idBarang=".$id);
		$data = $query->fetch_array();
		return $data[0];	
	}
	public function get_data($akses1,$akses2){
		$query = $this->conn->query("select * from barang");
		while($data = $query->fetch_array()){
			echo "<tr>";
			echo "<td style='text-align: center;'>".$data[0]."</td>";
			echo "<td>".$data[1]."</td>";
			echo "<td style='text-align: center;'>".$data[2]."</td>";
			echo "<td style='text-align: center;'>".$this->terjual($data[0])."</td>";
			echo "<td style='text-align: center;'><form action='?page=barang' method='POST'>";
			if($akses1 == 1){
				if($data[3] == 1){
					echo '<input type="hidden" name="tidak_tersedia" value="'.$data[0].'" /><input type="submit" class="btn btn-success" value="Tersedia" />';
				}else{
					echo '<input type="hidden" name="tersedia" value="'.$data[0].'" /><input type="submit" class="btn btn-danger" value="Tidak Tersedia" />';
				}
			}else{
				if($data[3] == 1){
					echo '<span class="btn btn-success">Tersedia</span>';
				}else{
					echo '<span class="btn btn-danger">Tidak Tersedia</span>';
				}
			}
			echo "</form></td>";
			if($akses2 == 1){
				echo '<td style="text-align:center;">';
				echo '<a class="btn btn-success" href="?page=barang&edit='.$data[0].'">Edit</a>';
				echo '</td>';
			}
			echo "</tr>";
		}
	}
	private function last_id(){
		$query = $this->conn->query("select idBarang from barang order by idBarang desc limit 1");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function tambah($nama,$harga){
		$query = $this->conn->query("insert into barang Values(".($this->last_id()+1).",'".$nama."',".$harga.",1)");
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $query->error();
		}
	}
	public function update($id,$nama,$harga){
		$query = $this->conn->query("update barang set Barang_nama='".$nama."',Barang_harga='".$harga."' where idBarang=".$id);
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $query->error();
		}
	}
#	public function hapus($id){
#		global $this->conn;
#		$query = $this->conn->query("delete from barang where idBarang=".$id);
#		if($query){
#			$status = 1;
#		}else{
#			$status = 0;
#			$err = $query->error();
#		}	
#	}
	private function terjual($id){
		$query = $this->conn->query("select sum(pembelian_jumlah_barang) from pembelian where idBarang=".$id);
		$data = $query->fetch_array();
		if($data[0] >= 1){
			return $data[0];
		}else{
			return 0;
		}
	}
	public function tambah_barang(){
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=barang&tambah" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Tambah Barang</h2></td>';
		echo '</tr>';
		if(isset($_POST['tambah'])){
			$nama = $_POST['nama'];
			$harga = $_POST['harga'];
			$this->tambah($nama,$harga);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil menambah barang</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menambah barang</b></td></tr>';
			}
			echo '<tr style="text-align: center;"><td colspan=2><a class="btn btn-primary" href="?page=barang">Kembali</a></td></tr>';
		}else{
			?>
		<tr>
			<td>Nama Barang</td>
			<td><input type="text" name="nama" placeholder="Nama Barang" /></td>
		</tr>
		<tr>
			<td>Harga Barang</td>
			<td><input type="text" name="harga" placeholder="Harga Barang" /></td>
		</tr>
		<tr>
			<td style="text-align:center" colspan=2>
				<input class="btn btn-success" type="submit" name="tambah" value="Tambah" />
				<a class="btn btn-warning" href="?page=barang">Kembali</a>
			</td>
		</tr>
		</table>
		</form>
		</div>
		<?php
		}
	}
	public function edit_barang($id){
		$query = $this->conn->query("select * from barang where idBarang=".$id);
		$data = $query->fetch_array();
		echo '<div style="margin-left: 5%;margin-right:5%;padding:20px;background: lightgrey;height: 100%">';
		echo '<form action="?page=barang&edit='.$id.'" method="POST">';
		echo '<table border=1 class="table">';
		echo '<tr>';
		echo '<td style="text-align: center;" colspan=2><h2>Edit Barang</h2></td>';
		echo '</tr>';
		if(isset($_POST['edit'])){
			$nama = $_POST['nama'];
			$harga = $_POST['harga'];
			$this->update($id,$nama,$harga);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil memperbarui data</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn btn-warning" style="text-align:center;" colspan=2><b>Gagal memperbarui data</b></td></tr>';
			}
			echo '<tr>';
			echo '<td>Nama Barang</td>';
			echo '<td><input type="text" name="nama" value="'.$_POST["nama"].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Harga Barang</td>';
			echo '<td><input type="text" name="harga" value="'.$_POST["harga"].'" />';
			echo '</tr>';
		}else{
			echo '<tr>';
			echo '<td>Nama Barang</td>';
			echo '<td><input type="text" name="nama" value="'.$data[1].'" />';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Harga Barang</td>';
			echo '<td><input type="text" name="harga" value="'.$data[2].'" />';
			echo '</tr>';
		}
		echo '<tr>';
		echo '<td style="text-align:center" colspan=2><input class="btn btn-success" type="submit" name="edit" value="Perbarui" /> ';
		echo '<a class="btn btn-warning" href="?page=barang">Kembali</a></td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';
	}
	public function tersedia($id){
		$query = $this->conn->prepare("update barang set tersedia=1 where idBarang=".$id);
		$query->execute();
	}
	public function tidak_tersedia($id){
		$query = $this->conn->prepare("update barang set tersedia=0 where idBarang=".$id);
		$query->execute();
	}
}
?>