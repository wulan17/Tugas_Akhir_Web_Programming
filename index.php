<?php
include_once "inc/koneksi.php";
include_once "classes/title.php";
include_once "classes/login.php";
include_once "classes/waktu.php";
$waktu = new Waktu();
$tl = new Title();
$login = new Login();
if(isset($_GET['page']) and $_GET['page'] == "login"){
	$title = $tl->get_title('login');
	include_once "inc/head.php";
	include_once "pages/login.php";
	include_once 'inc/foot.php';
}elseif($login->cek_login() == 1){
	if(isset($_GET['page']) and !empty($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = "home";
	}
	$title = $tl->get_title($page);
	include_once "classes/".$page.".php";
	include_once "inc/head.php";
	include_once "pages/".$page.".php";
	include_once 'inc/foot.php';
}else{
	header("Location: ?page=login");
}
?>