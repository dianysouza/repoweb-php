<?php
	try
	{
		$username = 'root';
		$password = 'usbw';
		$conexao = new PDO('mysql:host=localhost:3307;dbname=db_repoweb', $username, $password);
		
		$timeZone = mysql_query("set time_zone = '-03:00'");

		mysql_set_charset('utf8');
		ini_set('default_charset','UTF-8');

		setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

		date_default_timezone_set( 'America/Sao_Paulo' );
	}
	catch(PDOException $e)
	{
		echo "Falha ao conectar com o banco de dados: ".$e->getMessage();
	}
?>