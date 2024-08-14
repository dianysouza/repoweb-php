<?php
	include ("../banco.php");
	session_start('repoweb');
	
	$ano = ($_GET['ano']);
	$curso = ($_GET['curso']);
	$order = ($_GET['order']);
	
	if ($ano != '')
	{
		$ano = " and aa_projeto = ".$ano."";
	}
	if ($curso != '')
	{
		$curso = " and nm_curso = '".$curso."'";
	}
	if ($order != '')
	{
		$order = " order by ".$order;
	}
	
	$query = $conexao->prepare("select cd_projeto, nm_projeto, nm_autores, aa_projeto, nm_curso from tb_projeto where cd_projeto > 0 $ano $curso $order");

	$query->execute();
	
	if (!$query->execute()) 
	{
		echo "\nPDO::errorInfo():\n";
		print_r($query->errorInfo());
	}

	?>
		<center>
			<?php
				if ($query->rowCount() > 0)
					{
						while($retornoProjetos = $query->fetch(PDO::FETCH_ASSOC))
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
	<?php
?>