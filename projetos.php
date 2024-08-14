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
	
	$queryAno = $conexao->query('select distinct aa_projeto from tb_projeto');
	$queryCurso = $conexao->query('select distinct nm_curso from tb_projeto');
	$queryProjetos = $conexao->query('select cd_projeto, nm_projeto, nm_autores, aa_projeto, nm_curso from tb_projeto');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>RepoWEB | Projetos</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Didact+Gothic" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/pesquisaProjetos.js"></script>
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
			</center>
			<?php
				}
			?>
		</div>
		</header>
		<center><h1>Pesquisa de Projetos</h1></center>
		<div class="pesquisaProjetos" onchange="pesquisaProjetos();">
			<center>
				<p>
					<label>Pesquisa Avançada</label>
				</p>
				<label>Ano:</label>
				<p>
					<select name="ano" id="cmb_ano" >
					<option value="">Selecione...
					<?php
						while($retornoAno = $queryAno->fetch(PDO::FETCH_ASSOC))
						{
							?>
								<option value="<?php echo $retornoAno['aa_projeto'];?>"><?php echo $retornoAno['aa_projeto'];?>
							<?php
						}
					?>
					</select>
				</p>
				<label>Curso:</label>
				<p>
					<select name="curso" id="cmb_curso" >
						<option value="">Selecione...
						<?php
							while($retornoCurso = $queryCurso->fetch(PDO::FETCH_ASSOC))
							{
								?>
									<option value="<?php echo $retornoCurso['nm_curso'];?>"><?php echo $retornoCurso['nm_curso'];?>
								<?php
							}
						?>
					</select>
				</p>
				<label> Ordenar Por:</label>
				<p>
				<select name="ordenarPor" id="cmb_order">
					<option value="">Selecione...
					<option value="nm_projeto">Projeto
					<option value="nm_autores">Autor
				</select>
				</p>
			</center>
		</div>
		<div id="retorno" class="todosProjetos">
			<center>
				<?php
					if ($queryProjetos->rowCount() > 0)
					{
						while($retornoProjetos = $queryProjetos->fetch(PDO::FETCH_ASSOC))
						{
							?>
								<div class="projeto" onclick="parent.location='visualizarObra.php?id=<?php echo $retornoProjetos['cd_projeto'];?>'">
									<div class="titulo">
										<?php echo $retornoProjetos['nm_projeto'];?><br>
										<label><?php echo $retornoProjetos['aa_projeto'];?></label><br>
										<label><?php strlen($retornoProjetos['nm_autores']) > 60 ? $autores = substr($retornoProjetos['nm_autores'],0,60) . "..." : $autores = $retornoProjetos['nm_autores']; echo $autores ?></label><br>
										<label><?php echo $retornoProjetos['nm_curso'];?></label>
										<div class="icon">
											<i class="fas fa-file-pdf fa-4x"></i>
										</div>
									</div>
								</div>
							<?php
						}
					}
					else
					{
						echo '<br><h1>Não há nada para exibir. Por favor, refaça a sua pesquisa!</h1><br><i class="fas fa-exclamation-triangle fa-10x"></i><br><br>';
					}
				?>
			</center>
		</div>
		<br>   </br>
	</body>
</html>