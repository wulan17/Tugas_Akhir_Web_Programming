<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title;?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="inc/css/bootstrap.min.css" />
		<link rel="stylesheet" href="inc/css/style.css" />
		<script src="inc/js/bootstrap.min.js"></script>
		<script src="inc/js/jquery.min.js"></script>
	</head>
	<body>
		<header class="navbar navbar-expanded-sm navbar-dark bg-dark fixed-top">
			<ul class="navbar-nav">
				<li class="navbar-item"><a class="nav-link" href="?page=home">Beranda</a></li>
			</ul>
			<?php
			if($login->cek_login() == 1){
				echo '<span class=".justify-content-right">';
				echo '<a class="btn btn-danger" href="?page=logout">Keluar</a>';
				echo '</span>';
			}
			?>
		</header>
		<?php
		if($login->cek_login() == 1){
			include_once "inc/left_panel.php";
			echo '<div class="body">';
		}
		?>