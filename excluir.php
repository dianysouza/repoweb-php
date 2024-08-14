<?php
	include ("banco.php");
	session_start('repoweb');
	
	if (!(isset($_SESSION['usuario']) && isset($_SESSION['senha'])))
	{
		header('Location: index.php');
	}
	else
	{
		$id = $_GET['id'];
		
		$query = $conexao->prepare("delete from tb_projeto where cd_projeto = :id");
		$query->bindParam(':id', $id);
		$query->execute();
		
		header('Location: projetos.php');
	}
?>