<?php
	include ("banco.php");
	session_start('repoweb');
	
	if (isset($_POST['btn_ok']))
	{
		$usuario = ($_POST['usuario']);
		$senha = ($_POST['senha']);
		$query = $conexao->prepare("select nm_usuario and ds_senha from tb_admin where nm_usuario = :usuario and ds_senha = :senha");
		$query->bindParam(':usuario', $usuario);
		$query->bindParam(':senha', $senha);
		$query->execute();
		if ($query->rowCount() > 0)
		{
			$_SESSION['logado'] = '1';
			$_SESSION['usuario'] = $usuario;
			$_SESSION['senha'] = $senha; 
			setcookie('usuario', $usuario,time()+60*60*24*30);
			setcookie('senha', $senha, time()+60*60*24*30);
		}
		else
		{
			echo "<script> alert('Nome de Usuario e/ou senha inválidos!'); </script>";
		}
	}
	
	$id = $_GET['id'];
	
	$query = $conexao->query("select * from tb_projeto where cd_projeto = $id");
	$update = $conexao->query("UPDATE tb_projeto set qt_acesso = qt_acesso + 1 where cd_projeto = $id");
	
	$retorno = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>RepoWEB | Visualização de Projeto</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Didact+Gothic" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>
	<body>
		<header>
			<img class="desk" src="img/logo.png" onclick="parent.location='index.php'" style="cursor:pointer;"/>
			<img class="mob" src="img/logo-white-ver.png" onclick="parent.location='index.php'" style="cursor:pointer;"/>
			<div class="login">
				<?php
					if (isset($_SESSION['usuario']) && isset($_SESSION['senha']))
					{
						echo "<br><label>Bem vindo, ".$_SESSION['usuario'].". <a href='logout.php'>(Sair)</a></label>";
					}
					else
					{
				?>
				<center>Carregamento de Projetos</center>
				<form class="login" method="POST" action="">
					<input type="text" placeholder="Usuário" name="usuario" maxlength="45"/>
					<input type="password" placeholder="Senha" name="senha" maxlength="16"/>
					<input type="submit" name="btn_ok" value="OK"/>
				</form>
				<?php
					}
				?>
			</div>
		</header>
		<div>
			<?php
				if ($query->rowCount() > 0)
				{
					?>
						<br>
						<form>
							<div class="conteudo">
								<center>
									<div class="titulo">
										<h2><?php echo $retorno['nm_projeto'];?><label style="float:right;margin-right:2%;"><?php isset($_SESSION['usuario']) && isset($_SESSION['senha']) ? $icon = "<i onclick=parent.location='excluir.php?id=$id' style='cursor:pointer;' class='fas fa-trash-alt'></i>" : $icon = ''; echo $icon; ?></label></h2>
									</div>
									<br>
									<div class="input">
										<label for="Autores">Autores:</label> <?php echo $retorno['nm_autores'];?>
									</div>
									<div class="input">
										<label for="orientador">Orientador:</label> <?php echo $retorno['nm_orientador'];?>
									</div>
									<div class="input">
										<label for="curso">Curso:</label> <?php echo $retorno['nm_curso'];?>
									</div>
									<div class="input">
										<label>Ano:</label> <?php echo $retorno['aa_projeto'];?>
									</div>
									<div class="input">
										<label>Classificação:</label> <?php echo $retorno['nm_classificacao'];?>
									</div>
									<div class="input">
										<label>Cutter:</label> <?php echo $retorno['cd_cutter'];?>
									</div>
									<div class="input txt">
										<iframe src="<?php echo $retorno['ar_projeto'];?>" width="100%" height="580px"></iframe>
									</div>
								</center>
							</div>
						</form>
					<?php
				}
				else
				{
					echo '<br><center><h1>Algo errado aconteceu! Por favor, escolha outro projeto para visualizar!</h1><br><i class="fas fa-exclamation-triangle fa-10x"></i></center>';
				}
			?>
		</div>
	</body>
</html>