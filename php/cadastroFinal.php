<?php
	include ("../banco.php");
	session_start('repoweb');
	
	$autores = filter_var($_POST['txt_autores']);
	$orientador = filter_var($_POST['txt_orientador']);
	$curso = filter_var($_POST['txt_curso']);
	$ano = filter_var($_POST['txt_ano']);
	$titulo = filter_var($_POST['txt_titulo']);
	$classificacao = filter_var($_POST['txt_classificacao']);
	$cutter = filter_var($_POST['txt_cutter']);
	
	
	if ($_FILES['arquivo']['error'] != 4)//verifica se existe o arquivo
	{										
		$caminho = 'Arquivos';
		$auxcaminho = '../Arquivos/';
		$auxArq = 0;
		
		$auxpasta = '../Arquivos/';
				
		$_UP['pasta'] = '../Arquivos/'; // selecionando a pasta onde os arquivos serão salvos
		
		if(!file_exists($auxpasta)) //se a pasta Arquivos não existir, cria ela.
		{
			$pasta = mkdir($auxpasta); // criando a pasta
		}
		
		if (isset($_FILES['arquivo']))
		{
			$_UP['tamanho'] = 1024 * 1024 * 3; // 3MB. O padrão do PHP é 2, porém, aumentei para 3 no php.ini, para conseguir colocar arquivos maiores
			$_UP['extensoes'] = array('pdf');
			$_UP['renomeia'] = false;
			
			$_UP['erros'][0] = 'Não houve erro';
			$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
			$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
			$_UP['erros'][3] = 'O upload foi feito parcialmente';
			$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
			
			if ($_FILES['arquivo']['error'] != 0)
			{
				echo "Não foi possivel fazer o upload, erro: <br/>" . $_UP['erros'][$_FILES['arquivo']['error']];
			}
			
			$tmp = explode('.', $_FILES['arquivo']['name']);
			$extensao = strtolower(end($tmp));
			
			if (array_search($extensao, $_UP['extensoes']) === false)
			{
				if ($_FILES['arquivo']['error'] != 0)
				{
					echo 'Por favor, envie arquivos com a extensão PDF.';
					exit;
				}
				else
				{
					echo 'Por favor, envie arquivos com a extensão PDF.';
					exit;
				}
				
			}
			else if ($_UP['tamanho'] < $_FILES['arquivo']['size'])
			{
				echo 'O arquivo enviado é muito grande, envie arquivos de até 20MB.';
				exit;
			}
			else
			{
				if ($_UP['renomeia'] == true)
				{
					$nome_final = time() . '.'.$extensao;
				}
				else
				{
					$nome_final = $_FILES['arquivo']['name'];
				}
				
				$nome_final = preg_replace( '/[´¨`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $nome_final ) );
				
				
				if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . '/' . $nome_final))
				{
					$auxArq = 1;
					
					$auxcaminho = $auxcaminho . '/' . $nome_final;
				}
				else
				{
					$auxArq = 0;
					
					if ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4)
					{
						echo 'Não foi possivel enviar o arquivo, tente novamente';
						exit;
					}							
				}
			}
		
			if ($_FILES['arquivo']['name'] != "" && $auxArq == 1)
			{
				$arquivo = $caminho . '/' . $nome_final;
				$arq = $arquivo;
			}
		}
	}
	else
	{
		$arq = null;
	}
	
	try
	{
		$query = $conexao->prepare("insert into tb_projeto (nm_autores, nm_orientador, nm_curso, aa_projeto, nm_projeto, nm_classificacao, cd_cutter, ar_projeto) values (:autores, :orientador, :curso, :ano, :titulo, :classificacao, :cutter, :arquivo);");
		$query->bindParam(':autores', $autores);
		$query->bindParam(':orientador', $orientador);
		$query->bindParam(':curso', $curso);
		$query->bindParam(':ano', $ano);
		$query->bindParam(':titulo',$titulo);
		$query->bindParam(':classificacao',$classificacao);
		$query->bindParam(':cutter',$cutter);
		$query->bindParam(':arquivo',$arq);
		$query->execute();
		echo ("Obra cadastrada com sucesso!");
	}
	catch (PDOException $e)
	{
		echo "Erro: ".$e->getMessage();
	}
?>