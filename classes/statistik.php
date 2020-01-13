<?php
class Statistik{
	private $conn;
	public function __construct(){
		global $conn;
		$this->conn = $conn;
	}
	public function get_barang(){
		$query = $this->conn->query("select count(*) from barang");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_pegawai(){
		$query = $this->conn->query("select count(*) from pegawai");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_pelanggan(){
		$query = $this->conn->query("select count(*) from pelanggan");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_faktur(){
		$query = $this->conn->query("select count(*) from faktur");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_faktur_temp(){
		$query = $this->conn->query("select count(*) from faktur_temp");
		$data = $query->fetch_array();
		return $data[0];
	}
	public function get_pembelian(){
		$query = $this->conn->query("select sum(pembelian_jumlah_barang) from pembelian");
		$data = $query->fetch_array();
		return $data[0];
	}
}
?>