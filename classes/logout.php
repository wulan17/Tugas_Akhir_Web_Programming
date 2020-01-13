<?php
class Logout{
	function out(){
		setcookie("username","",time()-60*60*24*6004);
		header("Location: ?");
	}
}
?>