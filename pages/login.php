<?php
if(isset($_POST['login'])){
	if((isset($_POST['username']) and isset($_POST['password'])) and (empty($_POST['username']) and empty($_POST['password']))){
		$user_kosong = 1;
		$pass_kosong = 1;
	}elseif(isset($_POST['username']) and empty($_POST['username'])){
		$user_kosong = 1;
	}elseif(isset($_POST['password']) and empty($_POST['password'])){
		$pass_kosong = 1;
	}else{
		$login->log_in($_POST['username'],$_POST['password']);
	}
}
?>
<div class="d-flex justify-content-center">
	<form action="?page=login" method="post">
		<table width="80%" class="login btn-secondary">
			<tr class="btn-primary">
				<td rowspan=10></td>
				<td colspan=3><br/></td>
				<td rowspan=10></td>
			</tr>
			<tr class="btn-success">
				<td rowspan="8"></td>
			</tr>
			<tr>
				<td colspan="2"><b>Silahkan Masuk untuk Mengakses Website</b></td>
			</tr>
			<tr>
				<?php
				if($login->user_salah == 1){
					echo '<td colspan="2" style="background:red;">Maaf Username yang anda masukkan belum terdaftar.</td>';
				}elseif($login->pass_salah == 1){
					echo '<td colspan="2" style="background:red;">Maaf Password yang anda masukkan salah.</td>';
				}else{
					echo '<td colspan="2"><br/></td>';
				}
				?>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" name="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];}?>" placeholder="Username" required />
				</td>
			</tr>
			<tr>
				<?php if(isset($user_kosong) and $user_kosong == 1){
					echo '<td colspan="2" style="background:red;">Mohon masukkan username anda</td>';
				}else{
					echo '<td colspan="2"><br/></td>';
				}
				?>
			</tr>
			<tr>
				<td colspan="2">
					<input type="password" name="password" value="<?php if(isset($_POST['password'])){echo $_POST['password'];}?>" placeholder="Password" required />
				</td>
			</tr>
			<tr>
				<?php if(isset($pass_kosong) and $pass_kosong == 1){
					echo '<td colspan="2" style="background:red;">Mohon masukkan password anda</td>';
				}else{
					echo '<td colspan="2"><br/></td>';
				}
				?>
			</tr>
			<tr>
				<td colspan=2><input class="btn btn-primary" type="submit" name="login" value="Masuk" /></td>
			</tr>
			<tr class="btn-primary">
				<td colspan=3><br/></td>
			</tr>
		</table>
	</form>
</div>