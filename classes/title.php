<?php
class Title{
	public function get_title($page){
		if(isset($_GET['tbarang'])){
			$title_list = array('home'=>"Tambah Barang");
		}elseif(isset($_GET['hapusbarang'])){
			$title_list = array('home'=>"Hapus Barang");
		}elseif(isset($_GET['tambah'])){
			$title_list = array('pelanggan'=>"Tambah Pelanggan",'pegawai'=>"Tambah Pegawai",'pembelian'=>"Tambah Pembelian",'barang'=>"Tambah Barang",'home'=>"Tambah Pembelian",'pembayaran'=>"Tambah Metode Pembayaran",'customer'=>"Tambah Customer");
		}elseif(isset($_GET['edit'])){
			$title_list = array('pelanggan'=>"Edit Pelanggan",'pegawai'=>"Edit Pegawai",'pembelian'=>"Edit Pembelian",'barang'=>"Edit Barang",'pembayaran'=>"Edit Metode Pembayaran",'customer'=>"Edit Customer");
		}elseif(isset($_GET['hapus'])){
			$title_list = array('pelanggan'=>"Hapus Pelanggan",'pegawai'=>"Hapus Pegawai",'pembelian'=>"Hapus Pembelian",'barang'=>"Hapus Barang",'home'=>"Hapus Pembelian",'pembayaran'=>"Hapus Metode Pembayaran",'customer'=>"Hapus Customer");
		}elseif(isset($_GET['faktur']) or isset($_GET['faktur_temp'])){
			$title_list = array('pembelian'=>"Rincian Pembelian",'home'=>'Pembelian');
		}else{
			$title_list = array('home'=>'Beranda','login'=>"Masuk",'pelanggan'=>"Daftar Pelanggan",'pegawai'=>"Daftar Pegawai",'pembelian'=>"Daftar Pembelian",'barang'=>"Daftar Barang",'pembayaran'=>"Daftar Metode Pembayaran",'customer'=>"Daftar Customer");
		}
		return $title_list[$page];
	}
}
?>