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
	
	$query = $conexao->query('select cd_projeto, nm_projeto, nm_autores, aa_projeto from tb_projeto order by cd_projeto desc limit 5');
	$queryAcessadas = $conexao->query('select cd_projeto, nm_projeto from tb_projeto order by qt_acesso desc limit 5');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>RepoWEB | Início</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Didact+Gothic" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>
	<body>
		<header>
			<img class="mob" src="img/logo-white-ver.png" onclick="parent.location='index.php'" style="cursor:pointer;"/>
			<img class="desk" src="img/logo.png" onclick="parent.location='index.php'" style="cursor:pointer;"/>
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
        <center><h1>Bem vindo ao RepoWEB, o seu site de pesquisa aos melhores trabalhos acadêmicos. Entre em contato com a nossa equipe, e faça parte você também dessa comunidade!</h1></center>
        <div class="recentes">
			<div class="titulo">
				<center><h2>Obras Recentes</h2></center>
			</div>
			<div class="projetos">
			<?php
				while($retorno = $query->fetch(PDO::FETCH_ASSOC))
				{
					?>
						<div class="infos">
							<i class="fas fa-file-pdf fa-4x"></i>
							<center>
								<label for="Titulo">Título: </label><label onclick="parent.location='visualizarObra.php?id=<?php echo $retorno['cd_projeto'];?>'" style="cursor:pointer;"><?php echo $retorno['nm_projeto']; ?></label>
								<br>
								<label for="Autores">Autores: </label><label><?php strlen($retorno['nm_autores']) > 60 ? $autores = substr($retorno['nm_autores'],0,60) . "..." : $autores = $retorno['nm_autores']; echo $autores ?></label>
								<br>
								<label for="Ano">Ano: </label><label><?php echo $retorno['aa_projeto']; ?></label>
							</center>
						</div>
					<?php
				}
			?>
			</div>
        </div>
        <div class="acessadas">
			<div class="titulo">
				<center><h2>Obras mais acessadas</h2></center>
			</div>
			<div class="projetos">
			<?php
				while($retornoAcessadas = $queryAcessadas->fetch(PDO::FETCH_ASSOC))
				{
					?>
						<div class="infos" style="cursor:pointer" onclick="parent.location='visualizarObra.php?id=<?php echo $retornoAcessadas['cd_projeto'];?>'">
						<center>
							<label for="projeto" style="cursor:pointer"><?php echo $retornoAcessadas['nm_projeto'];?></label>
						</center>
				</div>
					<?php
				}
			?>
			</div>
		</div>
		<p style="clear:both;font-size:8px">   </p>
		<?php
			if (isset($_SESSION['usuario']) && isset($_SESSION['senha']))
			{
				?>
					<a href="cadastrarProjeto.php"><label for="cadastrar" style="cursor: pointer;margin:0 0 0 2%;">Cadastrar nova obra</label></a>
				<?php
			}
		?>
		<a href="projetos.php"><label for="todas" style="float:right;cursor:pointer;margin: 0 2% 0 0;">Ver todas as obras</label></a>
		<br><br>
		<footer>
			<img src="img/logo-white-ver.png" onclick="parent.location='index.php'" style="cursor:pointer;"/>
			<ul>
				<li onclick="alert('Página ainda não desenvolvida!')"><i class="fas fa-star"></i> Quem somos </li>
				<li onclick="alert('Página ainda não desenvolvida!')"><i class="fas fa-star"></i> Como enviar um projeto </li>
				<li onclick="alert('Página ainda não desenvolvida!')"><i class="fas fa-star"></i> Encontrou erros no site? Reporte-nos!</li>
				<li onclick="alert('Página ainda não desenvolvida!')"><i class="fas fa-star"></i> Contato </li>
			</ul>
			<address>
				<center>COPYRIGHT © 2018 | Desenvolvido por: <a href="mailto:diany.06@gmail.com">Diany Souza</a></center>
			</address>
		</footer>
	</body>
</html>