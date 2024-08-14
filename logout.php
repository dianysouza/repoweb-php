<?php
	session_start('repoweb');
	session_unset('repoweb');
	session_destroy('repoweb');

	header('location: index.php');