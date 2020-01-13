<?php
class Login{
	public $user_salah;
	public $pass_salah;
	private $string;
	private $conn;
	public function __construct(){
		global $conn;
		$this->conn = $conn;
	}
	public function cek_login(){
		if(isset($_COOKIE['username']) and !empty($_COOKIE['username'])){
			return 1;
		}else{
			return 0;
		}
	}
	public function log_in($user,$pass){
		$username = $this->conn->real_escape_string($user);
		$query = "select * from pegawai where username='".$username."'";
		$check = $this->conn->prepare($query);
		$check->execute();
		$check->store_result();
		if($check->num_rows() == 1){
			$this->user_salah = 0;
			$query_user = $this->conn->query($query);
			$data_user = $query_user->fetch_array();
			if(password_verify($pass, $data_user["password"])){
				$this->pass_salah = 0;
				setcookie("username",$username,time()+60*60*24*6004);
				header("location: ?page=home");
			}else{
				$this->pass_salah = 1;
			}
		}else{
			$this->user_salah = 1;
		}
	}
	public function cek_akses($string){
		$this->string = "0,8,".$string;
		$data = explode(",",$this->string);
		$query = $this->conn->query("select akses from jabatan where idjabatan=(select idjabatan from menjabat_sebagai where idpegawai=(select idpegawai from pegawai where username='".$_COOKIE['username']."'))")->fetch_array();
		$akses = $query[0];	
		if(array_search($akses,$data) != NULL){
			return 1;
		}else{
			return 0;
		}
	}
	public function no_akses(){
		echo '<div>Maaf Anda tidak memiliki hak untuk mengakses halaman ini</div>';
	}
	public function get_myid(){
		$query = $this->conn->query("select idpegawai from pegawai where username='".$_COOKIE['username']."'");
		$data = $query->fetch_array();
		return $data[0];
	}
}
?>