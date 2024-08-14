<?php
	include ("banco.php");
	session_start('repoweb');
	
	if (!(isset($_SESSION['usuario']) && isset($_SESSION['senha'])))
	{
		header('Location: index.php');
	}

	$usuario = $_SESSION['usuario'];
	$senha = $_SESSION['senha'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>RepoWEB | Cadastro de Projetos</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/validacaoCadastroObra.js"></script>
		<script src="js/validarCampos.js"></script>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Didact+Gothic" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<script src="js/ajax.js"></script>
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
			<input type="text" placeholder="Usuário" maxlength="45"/>
			<input type="password" placeholder="Senha" maxlength="16"/>
			<input type="submit" value="OK"/>
		<?php
				}
		?>
		</div>
		</header>
		<br>
        <form name="frm_cadastro" method="POST" action="php/cadastroFinal.php" enctype="multipart/form-data">
			<center>
				<div class="titulo">
					<h2>Cadastro de Projetos</h2>
				</div>
			</center>
			<br>
            <div class="input txt">
                <label for="Autores">Autores</label>
                <input type="text" id = "txt_autores" name="txt_autores" onkeypress="return apenasLetras(event);" required maxlength="150" >
            </div>
            <div class="input">
                <label for="orientador">Orientador</label>
                <input type="text" maxlength="45" id ="txt_orientador" onkeypress="return apenasLetras(event);" name="txt_orientador" required >
            </div>
            <div class="input">
                <label for="curso">Curso</label>
                <input type="text" maxlength="45" id ="txt_curso" onkeypress="return apenasLetras(event);" name="txt_curso" required >
            </div>
            <div class="input">
                <label for="ano">Ano</label>
                <input type="text" maxlength="4" id ="txt_ano" name="txt_ano" onkeypress="return apenasNumeros(event);" required >
            </div>
            <div class="input">
                <label for="título">Título</label>
                <input type="text" maxlength="45" id ="txt_titulo" onkeypress="return letrasNumeros(event);" name="txt_titulo" required >
            </div>
            <div class="input">
                <label for="Classificação">Classificação</label>
                <input type="text" maxlength="45" id ="txt_classificacao" onkeypress="return apenasLetras(event);" name="txt_classificacao" required >
            </div>
            <div class="input">
                <label for="Cutter">Cutter</label>
                <input type="text" maxlength="45" id ="txt_cutter" onkeypress="return letrasNumeros(event);" name="txt_cutter" required >
            </div>
            <div class="input txt">
                <label for="arquivo">Enviar arquivo</label>
                <i class="fas fa-file-upload fa-2x"></i> <i id="check" class="fas fa-check fa-2x" style="display: none;"></i><i id="error" class="fas fa-times fa-2x" style="display:none;"></i><input type="file" accept=".pdf" id ="arquivo" name="arquivo" required>
            </div>
            <div class="buttons">
                <button type="button" class="cancel" onclick="parent.location='index.php'">Cancelar</button>
                <button type="button" name="btn_cadastrar" id="submit" class="ok">Cadastrar</button>
            </div>
        </form>
    </body>
</html>