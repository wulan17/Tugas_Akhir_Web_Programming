<?php
class Pembelian{
	private $conn;
	private $status;
	private $err;
	private $pegawai;
	private $pelanggan;
	private $waktu;
	private $barang;
	private $pembayaran;
	private $login;
	public function __construct(){
		global $conn;
		global $waktu;
		global $login;
		$this->conn = $conn;
		$this->pegawai = new Pegawai();
		$this->pelanggan = new Pelanggan();
		$this->waktu = $waktu;
		$this->barang = new Barang();
		$this->pembayaran = new Pembayaran();
		$this->login = $login;
	}
	private function namapegawai($id){
		$query = $this->conn->query("select idpegawai from menjabat_sebagai where idmenjabat_sebagai=".$id);
		$data = $query->fetch_array();
		$idpegawai = $data['idpegawai'];
		return $this->pegawai->nama($idpegawai);
	}
	public function faktur(){
		$query = $this->conn->query("select * from faktur order by idFaktur desc limit 5");
		$i = 1;
		while($data = $query->fetch_array()){
			echo "<tr>";
			echo "<th>".$i."</th>";
			echo "<td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td>";
			echo "<td>".$this->waktu->fulljam($data['Faktur_tgl'])."</td>";
			echo "<td>".$data['no_polisi']."</td>";
			echo "<td>".$this->pembayaran->jpembayaran($data['idpembayaran'])."</td>";
			echo "<td>".$this->pelanggan->nama($data['no_polisi'])."</td>";
			echo "<td>".$this->namapegawai($data['operator'])."</td>";
			echo "<td><a class='btn btn-primary' href='?page=home&rincian=".($data[0]+1)."'>Rincian</a></td>";
			echo "</tr>";
			$i++;
		}
	}
	public function faktur_lengkap($page){
		$halaman = 10;
		$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
		$query = $this->conn->query("select * from faktur order by idFaktur desc limit ".$mulai.", ".$halaman);
		if($page>1){
			$i = (($page-1)*$halaman)+1;
		}else{
			$i = 1;
		}
		while($data = $query->fetch_array()){
			echo "<tr>";
			echo "<th>".$i."</th>";
			echo "<td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td>";
			echo "<td>".$this->waktu->fulljam($data['Faktur_tgl'])."</td>";
			echo "<td>".$data['no_polisi']."</td>";
			echo "<td>".$this->pembayaran->jpembayaran($data['idpembayaran'])."</td>";
			echo "<td>".$this->pelanggan->nama($data['no_polisi'])."</td>";
			echo "<td>".$this->namapegawai($data['operator'])."</td>";
			echo "<td><a class='btn btn-primary' href='?page=home&rincian=".($data[0]+1)."'>Rincian</a></td>";
			echo "</tr>";
			$i++;
		}
		$sql = $this->conn->prepare("select * from faktur");
		$sql->execute();
		$sql->store_result();
		$total = $sql->num_rows();
		$pages = ceil($total/$halaman);
		if($pages>1){
			echo '<tr><td style="padding-left: 20px;" colspan=8>Halaman : ';
			if($page != 1){
				echo '<a href="?page=pembelian&selesai&halaman='.$pages.'"><< </a>';
				echo '<a href="?page=pembelian&selesai&halaman='.($page-1).'"><</a>';
			}else{
				echo '<< <';
			}
			for ($i=1; $i<=$pages ; $i++){
				if($i == $page){
					echo $i;
				}else{
					?>
					<a href="?page=pembelian&selesai&halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
					<?php
				}
			}
			if($page != $pages){
				echo '<a href="?page=pembelian&selesai&halaman='.($page+1).'">></a>';
				echo '<a href="?page=pembelian&selesai&halaman='.$pages.'"> >></a>';
			}else{
				echo '> >>';
			}
			echo '</td></tr>';
		}
	}
	public function faktur_temp($akses){
		$sql = "select * from faktur_temp order by idFaktur_temp desc limit 10";
		$check = $this->conn->prepare($sql);
		$check->execute();
		$check->store_result();
		$query = $this->conn->query($sql);
		$i = 1;
		if($check->num_rows() >= 1){
			while($data = $query->fetch_array()){
				echo "<tr>";
				echo "<th>".$i."</th>";
				echo "<td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td>";
				echo "<td>".$this->waktu->fulljam($data['Faktur_tgl'])."</td>";
				echo "<td>".$data['no_polisi']."</td>";
				echo "<td>".$this->pelanggan->nama($data['no_polisi'])."</td>";
				echo "<td>".$this->namapegawai($data['operator'])."</td>";
				if($data['idpembayaran'] != 0){
					$status = "Menunggu Validasi";
				}else{
					$status = "Menunggu Pembayaran";
				}
				echo "<td>".$status."</td>";
				echo "<td>";
				if($data["idpembayaran"] == 0){
					echo '<a class="btn btn-success" href="?page=home&faktur='.$data[0].'">Lanjut</a>';
				}else{
					echo "<a class='btn btn-primary' href='index.php?page=home&faktur=".($data[0])."'>Rincian</a>";
				}
				if($akses == 1){
					if($data["idpembayaran"] != 0){
						echo "  <a class='btn btn-success' href='index.php?page=home&validasi=".($data[0])."'>Validasi</a>";
					}else{
						echo "  <a class='btn btn-danger' href='index.php?page=home&hapus=".($data[0])."'>Hapus</a>";
					}
				}
				echo "</td>";
				echo "</tr>";
				$i++;
			}
			echo '<tr><td style="text-align: center;" colspan=7><a class="btn btn-primary" href="?page=pembelian&tertunda">Selengkapnya</a></td></tr>';
		}else{
			echo '<tr><th colspan=8>Tidak ada transaksi yang tertunda</th></tr>';
		}
	}
	public function faktur_temp_lengkap($akses,$page){
		$halaman = 10;
		$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
		$sql = "select * from faktur_temp order by idFaktur_temp desc limit ".$mulai.", ".$halaman;
		$check = $this->conn->prepare($sql);
		$check->execute();
		$check->store_result();
		$query = $this->conn->query($sql);
		$i = 1;
		if($check->num_rows() >= 1){
			while($data = $query->fetch_array()){
				echo "<tr>";
				echo "<th>".$i."</th>";
				echo "<td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td>";
				echo "<td>".$this->waktu->fulljam($data['Faktur_tgl'])."</td>";
				echo "<td>".$data['no_polisi']."</td>";
				echo "<td>".$this->pelanggan->nama($data['no_polisi'])."</td>";
				echo "<td>".$this->namapegawai($data['operator'])."</td>";
				if($data['idpembayaran'] != 0){
					$status = "Menunggu Validasi";
				}else{
					$status = "Menunggu Pembayaran";
				}
				echo "<td>".$status."</td>";
				echo "<td>";
				if($data["idpembayaran"] == 0){
					echo '<a class="btn btn-success" href="?page=home&faktur='.$data[0].'">Lanjut</a>';
				}else{
					echo "<a class='btn btn-primary' href='index.php?page=home&faktur=".($data[0])."'>Rincian</a>";
				}
				if($akses == 1){
					if($data["idpembayaran"] != 0){
						echo "  <a class='btn btn-success' href='index.php?page=home&validasi=".($data[0])."'>Validasi</a>";
					}else{
						echo "  <a class='btn btn-danger' href='index.php?page=home&hapus=".($data[0])."'>Hapus</a>";
					}
				}
				echo "</td>";
				echo "</tr>";
				$i++;
			}
			$sql = $this->conn->prepare("select * from faktur_temp");
			$sql->execute();
			$sql->store_result();
			$total = $sql->num_rows();
			$pages = ceil($total/$halaman);
			if($pages>1){
				echo '<tr><td style="padding-left: 20px;" colspan=8>Halaman : ';
				if($page != 1){
					echo '<a href="?page=pembelian&tertunda&halaman='.$pages.'"><< </a>';
					echo '<a href="?page=pembelian&tertunda&halaman='.($page-1).'"><</a>';
				}else{
					echo '<< <';
				}
				for ($i=1; $i<=$pages ; $i++){
					if($i == $page){
						echo $i;
					}else{
						?>
						<a href="?page=pembelian&tertunda&halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
						<?php
					}
				}
				if($page != $pages){
					echo '<a href="?page=pembelian&tertunda&halaman='.($page+1).'">></a>';
					echo '<a href="?page=pembelian&tertunda&halaman='.$pages.'"> >></a>';
				}else{
					echo '> >>';
				}
				echo '</td></tr>';
			}
		}else{
			echo '<tr><th colspan=8>Tidak ada transaksi yang tertunda</th></tr>';
		}
	}
	public function fullfaktur($id){
		$query = $this->conn->query("select * from faktur where idFaktur=".$id);
		$data = $query->fetch_array();
		echo '<table border=1 class="table">';
		echo "<tr><td style='text-align: center;' colspan=2><h2>Rincian Pembelian</h2></td></tr>";
		echo "<tr><th>Tanggal</th><td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td></tr>";
		echo "<tr><th>Jam</th><td>".$this->waktu->fulljam($data['Faktur_tgl'])."</td></tr>";
		echo "<tr><th>No Polisi</th><td>".$data['no_polisi']."</td></tr>";
		echo "<tr><th>Jenis Customer</th><td>".$this->pemilik($data['idcustomer'])."</td></tr>";
		echo "<tr><th>Jenis Pembayaran</th><td>".$this->pembayaran->jpembayaran($data['idpembayaran'])."</td></tr>";
		echo "<tr><th>Customer</th><td>".$this->pelanggan->nama($data['no_polisi'])."</td></tr>";
		echo "<tr><th>Operator</th><td>".$this->namapegawai($data['operator'])."</td></tr>";
		echo "<tr><th>Diperiksa Oleh</th><td>".$this->namapegawai($data['diperiksa_oleh'])."</td></tr>";
		echo "<tr><th>Sales</th><td>".$this->namapegawai($data['sales'])."</td></tr>";
		echo "<tr><th>Jumlah Total</th><td>".$data['Faktur_total_transaksi']."</td></tr>";
		echo "<tr><th>Jumlah dibayar</th><td>".$data['Faktur_jumlah_dibayar']."</td></tr>";
		echo "<tr><th>Jumlah kembalian</th><td>".$data['Faktur_uang_kembalian']."</td></tr>";
		echo "</table>";
	}
	public function fullfaktur_temp($id){
		$query = $this->conn->query("select * from faktur where idFaktur=".$id);
		$data = $query->fetch_array();
		echo '<table border=1 class="table">';
		echo "<tr><td style='text-align: center;' colspan=2><h2>Rincian Pembelian</h2></td></tr>";
		echo "<tr><th>Tanggal</th><td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td></tr>";
		echo "<tr><th>Jam</td><th>".$this->waktu->fulljam($data['Faktur_tgl'])."</td></tr>";
		echo "<tr><th>No Polisi</th><td>".$data['no_polisi']."</td></tr>";
		echo "<tr><th>Jenis Customer</th><td>".$this->pemilik($data['idcustomer'])."</td></tr>";
		echo "<tr><th>Jenis Pembayaran</th><td>".$this->pembayaran->jpembayaran($data['idpembayaran'])."</td></tr>";
		echo "<tr><th>Customer</th><td>".$this->pelanggan->nama($data['no_polisi'])."</td></tr>";
		echo "<tr><th>Operator</th><td>".$this->namapegawai($data['operator'])."</td></tr>";
		echo "<tr><th>Diperiksa Oleh</th><td>".$this->namapegawai($data['diperiksa_oleh'])."</td></tr>";
		echo "<tr><th>Sales</th><td>".$this->namapegawai($data['sales'])."</td></tr>";
		echo "<tr><th>Jumlah Total</th><td>".$data['Faktur_total_transaksi']."</td></tr>";
		echo "<tr><th>Jumlah dibayar</th><td>".$data['Faktur_jumlah_dibayar']."</td></tr>";
		echo "<tr><th>Jumlah kembalian</th><td>".$data['Faktur_uang_kembalian']."</td></tr>";
		echo "</table>";
	}
	private function pemilik($id){
		$query = $this->conn->query("select customer_deskripsi from customer where idcustomer=".$id);
		$data = $query->fetch_array();
		return $data[0];
	}
	public function rincian($id){
		$query = $this->conn->query("select * from pembelian where idFaktur=".$id);
		$i = 1;
		echo '<table border=1 class="table">';
		echo '<tr><td style="text-align: center;" colspan=10><h2>Rincian Barang</h2></td></tr>';
		echo '<tr><th>No</th><th>Nama Barang</th><th>Jumlah Barang</th><th>Harga Satuan</th><th>Jumlah</th><th>Diskon</th><th>Total</th></tr>';
		while($data = $query->fetch_array()){
			echo '<tr>';
			echo "<th>".$i."</th>";
			echo "<td>".$this->barang->nama($data[2])."</td>";
			echo "<td>".$data[3]."</td>";
			echo "<td>".$this->barang->harga($data[2])."</td>";
			echo "<td>".$data[4]."</td>";
			echo "<td>".$data[5]."</td>";
			echo "<td>".$data[6]."</td>";
			echo "</tr>";
			$i++;
		}
		echo '</table>';
	}
	public function new_faktur_temp($id){
		$query = $this->conn->query("select * from faktur_temp where idFaktur_temp=".$id);
		$data = $query->fetch_array();
		$check = $this->conn->prepare("select * from pembelian_temp where idFaktur_temp=".$id);
		$check->execute();
		$check->store_result();
		if($check->num_rows() > 0){
			$jum_query = $this->conn->query("select sum(pembelian_jumlah_kotor) from pembelian_temp where idFaktur_temp=".$id)->fetch_array();
			$total = $jum_query[0];
		}else{
			$total = 0;
		}
		echo "<tr><th>Tanggal</th><td>".$this->waktu->fulltgl($data['Faktur_tgl'])."</td><th>Jam</th><td colspan=2>".$this->waktu->fulljam($data['Faktur_tgl'])."</td><th colspan=3 style='text-align:center;'>Jumlah Total</th></tr>";
		echo "<tr><th>No Polisi</th><td>".$data['no_polisi']."</td><th>Jenis Customer</th><td colspan=2>".$this->pemilik($data['idcustomer'])."</td>";
		if($data["idpembayaran"] != 0){
			echo "<td style='text-align:center;' colspan=3 rowspan=4>".$total."</td>";
		}else{
			echo "<td style='text-align:center;' colspan=3 rowspan=2>".$total."</td>";
		}
		echo "</tr>";
		echo "<tr><th>Customer</th><td>".$this->pelanggan->nama($data['no_polisi'])."</td><th>Sales</th><td colspan=2>".$this->namapegawai($data['sales'])."</td></tr>";
		if($data["idpembayaran"] != 0){
			echo "<tr><th>Jenis Pembayaran</th><td>".$this->pembayaran->jpembayaran($data['idpembayaran'])."</td><th>Operator</th><td colspan=2>".$this->namapegawai($data['operator'])."</td></tr>";
			echo "<tr><th>Jumlah dibayar</th><td style='text-align:center;'>".$data['Faktur_jumlah_dibayar']."</td><th>Jumlah kembalian</th><td style='text-align:center;' colspan=2>".$data['Faktur_uang_kembalian']."</td></tr>";
		}
		$sql = "select * from pembelian_temp where idFaktur_temp=".$id;
		$check = $this->conn->prepare($sql);
		$check->execute();
		$check->store_result();
		$query = $this->conn->query($sql);
		$i = 1;
		echo '<tr><td style="text-align: center;" colspan=10><h2>Rincian Barang</h2></td></tr>';
		echo '<tr><th>No</th><th>Nama Barang</th><th>Jumlah Barang</th><th>Harga Satuan</th><th>Jumlah</th><th>Diskon</th><th>Total</th><th>Aksi</th></tr>';
		if($check->num_rows() >= 1){
			while($data2 = $query->fetch_array()){
				echo '<tr>';
				echo "<th>".$i."</th>";
				echo "<td>".$this->barang->nama($data2[2])."</td>";
				echo "<td>".$data2[3]."</td>";
				echo "<td>".$this->barang->harga($data2[2])."</td>";
				echo "<td>".$data2[4]."</td>";
				echo "<td>".$data2[5]."</td>";
				echo "<td>".$data2[6]."</td>";
				echo '<td><a class="btn btn-warning" href="?page=home&faktur='.$id.'&hapusbarang='.$data2[0].'">Hapus</a></td>';
				echo "</tr>";
				$i++;
			}
			if($data["idpembayaran"] == 0){
				echo '<tr><th style="text-align:center;" colspan=8><a class="btn btn-success" href="?page=home&faktur='.$id.'&tbarang">Tambah</a></th></tr>';
				echo '<tr>';
				echo '<th style="text-align:right;" colspan=4>Pembayaran</th>';
				echo '<form action="?page=home&pembayaran='.$id.'" method="POST">';
				echo '<td colspan=4><select name="pembayaran">';
				echo '<option>Pilih metode pembayaran</option>';
				$query = $this->conn->query("select * from pembayaran");
				while($data = $query->fetch_array()){
					echo '<option value="'.$data[0].'">'.$data[1].'</option>';
				}
				echo '</select>';
				echo ' <input style="margin-left:15px" type="submit" class="btn btn-success" value="Bayar" />';
				echo '</td>';
				echo '</form>';
				echo '</tr>';
			}else{
				echo '<tr><th style="text-align:center;" colspan=8><a class="btn btn-success" href="index.php?page=home&validasi='.$id.'">Validasi</a></th></tr>';
			}
		}else{
			echo '<tr><th style="text-align:center;" colspan=8>Belum ada barang yang dibeli <a class="btn btn-success" href="?page=home&faktur='.$id.'&tbarang">Tambah</a></th></tr>';
		}
		echo "</table>";
	}
	public function pembayaran($id,$pembayaran){
		$harga = $this->conn->query("select sum(pembelian_jumlah_kotor) from pembelian_temp where idFaktur_temp=".$id)->fetch_array();
		$total = $harga[0];
		$metode = $this->conn->query("select pembayaran_deskripsi from pembayaran where idpembayaran=".$pembayaran)->fetch_array();
		$mp = $metode[0];
		$item = $this->conn->query("select count(*) from pembelian_temp where idFaktur_temp=".$id)->fetch_array();
		$titem = $item[0];
		if(isset($_POST['bayar'])){
			$bayar = $_POST['bayar'];
			$kembali = $bayar-$total;
			if($bayar<$total){
				echo '<form action="?page=home&pembayaran='.$id.'" method="POST">';
				echo '<tr><td colspan=2 class="btn-danger">Uang anda tidak cukup</td></tr>';
				echo '<tr><td>Total Harga</td><td>'.$total.'</td></tr>';
				echo '<tr><td>Metode Pembayaran</td><td>'.$mp.'</td></tr>';
				if($pembayaran == 1){
					echo '<tr><td>Masukkan Jumlah Uang</td><td><input name="bayar" type="number" value="'.$bayar.'" /></td></tr>';
				}else{
					echo '<tr><td>Jumlah Bayar</td><td>'.$total.'</td></tr>';
					echo '<input type="hidden" name="bayar" value="'.$total.'" />';
				}
				echo '<tr><td colspan=2 style="text-align:center;"><input type="submit" class="btn btn-success" value="Konfirmasi" /><a style="margin-left:15px;" class="btn btn-warning" href="?page=home&faktur='.$id.'">Batal</a></td></tr>';
				echo '</form>';
			}else{
				$query = $this->conn->query("update faktur_temp set Faktur_total_transaksi=".$total.",pembelian_total_item=".$titem.",Faktur_jumlah_dibayar=".$bayar.",Faktur_uang_kembalian=".$kembali.",idpembayaran=".$pembayaran." where idFaktur_temp=".$id);
				if($query){
					echo '<tr><td colspan=2 class="btn-success" style="text-align:center;"><h2><b>Pembayaran Berhasil</b></h2><br/></td></tr>';
					echo '<tr><td>Total</td><td>'.$total.'</td></tr>';
					echo '<tr><td>Bayar</td><td>'.$bayar.'</td></tr>';
					echo '<tr><td>Kembalian</td><td>'.$kembali.'</td></tr>';
					echo '<tr><td colspan=2 style="text-align:center;"><a class="btn btn-primary" href="?page=home">Kembali ke beranda</a></td></tr>';
				}else{
					echo '<tr><td colspan=2 class="btn-danger" style="text-align:center;"><h2><b>Pembayaran Berhasil</b></h2><br/></td></tr>';
					echo '<tr><td>Total</td><td>'.$total.'</td></tr>';
					echo '<tr><td>Bayar</td><td>'.$bayar.'</td></tr>';
					echo '<tr><td>Error</td><td>'.$this->conn->err.'</td></tr>';
					echo '<tr><td colspan=2 style="text-align:center;"><a class="btn btn-primary" href="?page=home">Kembali ke beranda</a></td></tr>';
				}
			}
		}else{
			echo '<form action="?page=home&pembayaran='.$id.'" method="POST">';
			echo '<tr><td>Total Harga</td><td>'.$total.'</td></tr>';
			echo '<tr><td>Metode Pembayaran</td><td>'.$mp.'</td></tr>';
			if($pembayaran == 1){
				echo '<tr><td>Masukkan Jumlah Uang</td><td><input name="bayar" type="number" /></td></tr>';
			}else{
				echo '<tr><td>Jumlah Bayar</td><td>'.$total.'</td></tr>';
				echo '<input type="hidden" name="bayar" value="'.$total.'" />';
			}
			echo '<input type="hidden" name="pembayaran" value="'.$pembayaran.'" />';
			echo '<tr><td colspan=2 style="text-align:center;"><input type="submit" class="btn btn-success" value="Konfirmasi" /><a style="margin-left:15px;" class="btn btn-warning" href="?page=home&faktur='.$id.'">Batal</a></td></tr>';
			echo '</form>';
		}
	}
	public function tambah_barang($id){
		if(isset($_POST['tambah'])){
			$barang = $_POST['barang'];
			$jumlah = $_POST['jumlah'];
			$databarang = $this->conn->query("select * from barang where idBarang=".$barang);
			$data = $databarang->fetch_array();
			$subjumlah = ($data[2]*$jumlah);
			if($subjumlah > 500000){
				$diskon = ($subjumlah*20)/100;
			}else{
				$diskon = 0;
			}
			$total = $subjumlah-$diskon;
			$query = $this->conn->query("insert into pembelian_temp Values(idpembelian,".$id.",".$barang.",".$jumlah.",'".$subjumlah."',".$diskon.",".$total.")");
			if($query){
				$this->status = 1;
				header('Location: ?page=home&faktur='.$id);
			}else{
				$this->status = 0;
				$this->err = $subjumlah.$this->conn->error;
			}
		}
		if($this->status == 0 and !empty($this->err)){
			echo '<tr><td colspan=2 class="btn-danger">'.$this->err.'</td></tr>';
		}
		echo '<form action="?page=home&faktur='.$id.'&tbarang" method="POST">';
		echo '<tr>';
		echo '<td>Barang</td>';
		echo '<td>';
		echo '<select name="barang">';
		echo '<option>Pilih</option>';
		$query = $this->conn->query("select * from barang where tersedia=1");
		while($data = $query->fetch_array()){
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Jumlah</td>';
		echo '<td><input type="number" name="jumlah" placeholder="Jumlah" /></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan=2>';
		echo '<input class="btn btn-success" type="submit" name="tambah" value="Tambah" />';
		echo '  <a class="btn btn-warning" href="?page=home&faktur='.$id.'">Kembali</a>';
		echo '</td>';
		echo '</tr>';
		echo '</form>';
	}
	private function tambah($pembeli,$customer,$sales){
		$tgl = $this->waktu->date_now();
		$operator = $this->pegawai->get_idmenjabat($this->login->get_myid());
		$query = $this->conn->query("insert into faktur_temp Values(idFaktur_temp,'".$tgl."',0,'".$pembeli."',0,".$customer.",".$operator.",0,0,".$sales.",0)");
		if($query){
			$last_id = $this->conn->query("select LAST_INSERT_ID() from faktur_temp")->fetch_array();
			$this->idfaktur = $last_id[0];
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function hapus($id){
		$query1 = $this->conn->query("delete from pembelian_temp where idFaktur_temp=".$id);
		$query2 = $this->conn->query("delete from faktur_temp where idFaktur_temp=".$id);
		if($query1 and $query2){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	private function hapusbarang($id){
		$query = $this->conn->query("delete from pembelian_temp where idpembelian=".$id);
		if($query){
			$this->status = 1;
		}else{
			$this->status = 0;
			$this->err = $this->conn->error;
		}
	}
	public function tambah_pembelian(){
		if(isset($_POST['tambah'])){
			$pembeli = $_POST['pembeli'];
			$customer = $_POST['customer'];
			$sales = $_POST['sales'];
			$this->tambah($pembeli,$customer,$sales);
			if($this->status == 1){
				header("Location: ?page=home&faktur=".$this->idfaktur);
			}else{
				echo '<tr class="btn-warning"><td style="text-align:center;" colspan=2>'.$this->err.'</td></tr>';
			}
		}
		echo '<form action="?page=home&tambah" method="POST">';
		echo '<tr>';
		echo '<td>Pelanggan</td>';
		echo '<td>';
		echo '<select name="pembeli">';
		echo '<option>Pilih</option>';
		$query = $this->conn->query("select * from pelanggan");
		while($data = $query->fetch_array()){
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Jenis Customer</td>';
		echo '<td>';
		echo '<select name="customer">';
		echo '<option>Pilih</option>';
		$query = $this->conn->query("select * from customer");
		while($data = $query->fetch_array()){
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Sales</td>';
		echo '<td>';
		echo '<select name="sales">';
		echo '<option>Pilih</option>';
		$query = $this->conn->query("select * from pegawai where idpegawai in (select idpegawai from menjabat_sebagai where idjabatan=4)");
		while($data = $query->fetch_array()){
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td style="text-align:center;" colspan=2><input class="btn btn-success" type="submit" name="tambah" value="Tambah" />  <a class="btn btn-warning" href="?page=home">Kembali</a></td>';
		echo '</tr>';
		echo '</form>';
	}
	public function hapus_pembelian($id){
		if(isset($_POST['confirm'])){
			$this->hapus($id);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil manghapus pembelian</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menghapus pembelian</b></td></tr>';
			}
			echo '<tr><td style="text-align:center;"><a class="btn btn-success" href="?page=home">Kembali</a></td></tr>';
		}else{
			echo '<form action="?page=home&hapus='.$id.'" method="POST">';
			echo '<tr>';
			echo '<td style="text-align:center;"><input class="btn btn-danger" type="submit" name="confirm" value="Ya" /> ';
			echo '<a class="btn btn-success" href="?page=home">Tidak</a></td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table>';
		echo '</div>';
	}
	public function hapus_barang($idfaktur,$id){
		if(isset($_POST['confirm'])){
			$this->hapusbarang($id);
			if($this->status == 1){
				echo '<tr><td class="btn-success" style="text-align:center;" colspan=2><b>Berhasil manghapus pembelian</b></td></tr>';
			}elseif($this->status == 0){
				echo '<tr><td class="btn-danger" style="text-align:center;" colspan=2><b>Gagal menghapus pembelian</b></td></tr>';
			}
			echo '<tr><td style="text-align:center;"><a class="btn btn-success" href="?page=home&faktur='.$idfaktur.'">Kembali</a></td></tr>';
		}else{
			echo '<form action="?page=home&faktur='.$idfaktur.'&hapusbarang='.$id.'" method="POST">';
			echo '<tr>';
			echo '<td style="text-align:center;"><input class="btn btn-danger" type="submit" name="confirm" value="Ya" /> ';
			echo '<a class="btn btn-success" href="?page=home&faktur='.$idfaktur.'">Tidak</a></td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table>';
		echo '</div>';
	}
	private function last_idfaktur(){
		$query = $this->conn->query("select idFaktur from faktur order by idFaktur desc limit 1");
		$data = $query->fetch_array();
		return $data[0];
	}

	private function last_idpembelian(){
		$query = $this->conn->query("select idpembelian from pembelian order by idpembelian desc limit 1");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function validasi($id){
		$query1 = $this->conn->query("select * from faktur_temp where idFaktur_temp=".$id);
		$data1 = $query1->fetch_array();
		$query2 = $this->conn->query("select * from pembelian_temp where idFaktur_temp=".$id);
		$last_id = ($this->last_idfaktur()+1);
		$insert1 = $this->conn->query("insert into faktur Values(".$last_id.",'".$data1['Faktur_tgl']."',".$data1['Faktur_total_transaksi'].",'".$data1['no_polisi']."',".$data1['idpembayaran'].",".$data1['idcustomer'].",".$data1['operator'].",".$data1['Faktur_jumlah_dibayar'].",".$data1['Faktur_uang_kembalian'].",".$this->pegawai->get_idmenjabat($this->login->get_myid()).",".$data1['sales'].",".$data1['pembelian_total_item'].")");
		if($insert1){
			while($data2 = $query2->fetch_array()){
				$this->conn->query("insert into pembelian Values(".($this->last_idpembelian()+1).",".$last_id.",".$data2['idbarang'].",".$data2['pembelian_jumlah_barang'].",".$data2['pembelian_sub_jumlah'].",".$data2['pembelian_diskon'].",".$data2['pembelian_jumlah_kotor'].")");
			}
			$this->conn->query("delete from faktur_temp where idFaktur_temp=".$id);
			$this->conn->query("delete from pembelian_temp where idFaktur_temp=".$id);
			header('Location: ?page=home');
		}else{
			echo $this->conn->error;
		}
	}
}
?>