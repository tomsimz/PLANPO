<?php
	session_start();

	require_once("../db/connection.php");

	session_destroy();
	header("location:../index.html");
?>