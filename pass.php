<form action="#" method="get">
	<input type="text" name="p" placeholder="Password" />
	<input type="submit" value="Generate" />
</form>
<?php
if(isset($_GET['p'])){
	$pass = password_hash($_GET['p'], PASSWORD_DEFAULT);
	echo "<textarea>".$pass."</textarea>";
}
?>