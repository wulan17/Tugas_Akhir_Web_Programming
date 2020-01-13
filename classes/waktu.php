<?php
class Waktu{
	private $time;
	private $now;
	private $format;
	private $nama_hari;
	private $nama_bulan;
	public function __construct(){
		$this->now = time();
		$this->format = "m/d/Y h:i:s A";
		$this->nama_hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu","Ahad");
		$this->nama_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	}
	public function get_time($string){
		$time = strtotime($string);
		return $time;
	}
	public function get_nama_hari($string){
		$this->time = $this->get_time($string);
		return $this->nama_hari[date("N",$this->time)];
	}
	public function get_nama_bulan($string){
		$this->time = $this->get_time($string);
		return $this->nama_bulan[date("n",$this->time)];
	}
	public function fulljam($string){
		$jam = date("h",$this->time);
		$menit = date("i",$this->time);
		$detik = date("s",$this->time);
		$ampm = date("A",$this->time);
		if($ampm == "PM"){
			$jam = $jam+12;
		}
		return $jam.":".$menit.":".$detik;
	}
	public function fulltgl($string){
		$bulan = $this->get_nama_bulan($string);
		$this->time = $this->get_time($string);
		$tanggal = date("d",$this->time);
		$tahun = date("Y",$this->time);
		$hitung = round(($this->now-$this->time)/60);
#		if($hitung<1){
#			$waktu = "Baru Saja";
#		}elseif($hitung>=1 and $hitung<60){
#			$waktu = $hitung." menit yang lalu.";
#		}elseif($hitung>=60 and $hitung<1440){
#			$hitung = round($hitung/60);
#			$waktu = $hitung." jam yang lalu.";
#		}else{
			$waktu = $tanggal." ".$bulan." ".$tahun;
#		}
		return $waktu;
	}
	public function fullwaktu($string){
		$hari = $this->get_nama_hari($string);
		$bulan = $this->get_nama_bulan($string);
		$this->time = $this->get_time($string);
		$tanggal = date("d",$this->time);
		$tahun = date("Y",$this->time);
		$jam = date("h",$this->time);
		$menit = date("i",$this->time);
		$detik = date("s",$this->time);
		$ampm = date("A",$this->time);
		if($ampm == "PM"){
			$jam = $jam+12;
		}
		$hitung = round(($this->now-$this->time)/60);
		if($hitung<1){
			$waktu = "Baru Saja";
		}elseif($hitung>=1 and $hitung<60){
			$waktu = $hitung." menit yang lalu.";
		}elseif($hitung>=60 and $hitung<1440){
			$hitung = round($hitung/60);
			$waktu = $hitung." jam yang lalu.";
		}elseif($hitung>=1440 and $hitung<8568){
			$waktu = $hari.", pukul ".$jam.":".$menit;
		}elseif($hitung == 8568){
			$waktu = "Seminggu yang lalu pukul ".$jam.":".$menit;
		}else{
			$waktu = $hari.", ".$tanggal." ".$bulan." ".$tahun." | Pukul ".$jam.":".$menit;
		}
		return $waktu;
	}
	public function waktu_sekarang(){
		$hari = $this->get_nama_hari($this->now);
		$tanggal = date("d",$this->now);
		$bulan = $this->get_nama_bulan($this->now);
		$tahun = date("Y",$this->now);
		$jam = date("h",$this->now);
		$menit = date("i",$this->now);
		$detik = date("s",$this->now);
		$ampm = date("A",$this->now);
		if($ampm == "PM"){
			$jam = $jam+12;
		}
		return $jam.":".$menit.":".$detik." | ".$hari.", ".$tanggal." ".$bulan." ".$tahun;
	}
	public function date_now(){
		return date($this->format,$this->now);
	}
}