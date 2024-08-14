$(document).ready(function()
{
	
	txt_autores.onblur = function() { verificaAutores(); }
	txt_orientador.onblur = function() { verificaOrientador(); }
    txt_curso.onblur = function() {verificaCurso(); }
    txt_ano.onblur = function() {verificaAno(); }
    txt_titulo.onblur = function() {verificaTitulo();}
    txt_classificacao.onblur = function() {verificaClassificacao();}
    txt_cutter.onblur = function(){verificaCutter();}
	arquivo.onchange = function() { verificaArquivo();}
	
	var camposCorretos = new Array(7);
	
	for (i = 0; i < 8; i++)
	{
		camposCorretos[i] = 0;
	}
    
	
	function verificaAutores()
	{
		if (document.getElementById('txt_autores').value.trim() == "" || document.getElementById('txt_autores').value.trim().indexOf(" ") == -1 )
		{
			txt_autores.style.border = "1px solid red";
			txt_autores.style.boxShadow = " 0 0 1px red";
			camposCorretos[0] = 0;
		}
		else
		{
			txt_autores.style.border = "1px solid green";
			txt_autores.style.boxShadow = " 0 0 1px green";
			camposCorretos[0] = 1;
		}
	}
	
	function verificaOrientador()
	{
		if (document.getElementById('txt_orientador').value.trim() == "" || document.getElementById('txt_orientador').value.trim().indexOf(" ") == -1)
        {
            txt_orientador.style.border = "1px solid red";
			txt_orientador.style.boxShadow = " 0 0 1px red";
            camposCorretos[1] = 0;
        }
        else
        {
            txt_orientador.style.border = "1px solid green";
			txt_orientador.style.boxShadow = " 0 0 1px green";
            camposCorretos[1] = 1;
        }
	}
    
    function verificaCurso()
    {
        if (document.getElementById('txt_curso').value.trim() == "")
        {
            txt_curso.style.border = "1px solid red";
			txt_curso.style.boxShadow = " 0 0 1px red";
            camposCorretos[2] = 0;
        }
        else
        {
            txt_curso.style.border = "1px solid green";
			txt_curso.style.boxShadow = " 0 0 1px green";
            camposCorretos[2] = 1;
        }
    }
    
    function verificaAno()
    {
        if (document.getElementById('txt_ano').value.trim() == "" || document.getElementById('txt_ano').value.trim().length < 4)
        {
            txt_ano.style.border = "1px solid red";
			txt_ano.style.boxShadow = " 0 0 1px red";
            camposCorretos[3] = 0;
        }
        else
        {
            txt_ano.style.border = "1px solid green";
			txt_ano.style.boxShadow = " 0 0 1px green";
            camposCorretos[3] = 1;
        }
    }
    
    function verificaTitulo()
    {
        
        if (document.getElementById('txt_titulo').value.trim() == "")
        {
            txt_titulo.style.border = "1px solid red";
			txt_titulo.style.boxShadow = " 0 0 1px red";
            camposCorretos[4] = 0;
        }
        else
        {
            txt_titulo.style.border = "1px solid green";
			txt_titulo.style.boxShadow = " 0 0 1px green";
            camposCorretos[4] = 1;
        }
    }
	
	function verificaClassificacao()
	{
		if (document.getElementById('txt_classificacao').value.trim() == "")
        {
            txt_classificacao.style.border = "1px solid red";
			txt_classificacao.style.boxShadow = " 0 0 1px red";
            camposCorretos[5] = 0;
        }
        else
        {
            txt_classificacao.style.border = "1px solid green";
			txt_classificacao.style.boxShadow = " 0 0 1px green";
            camposCorretos[5] = 1;
        }
	}
	
	function verificaCutter()
	{
		if (document.getElementById('txt_cutter').value.trim() == "")
		{
            txt_cutter.style.border = "1px solid red";
			txt_cutter.style.boxShadow = " 0 0 1px red";
            camposCorretos[6] = 0;
        }
        else
        {
            txt_cutter.style.border = "1px solid green";
			txt_cutter.style.boxShadow = " 0 0 1px green";
            camposCorretos[6] = 1;
        }
	}
	
	function verificaArquivo()
	{
		if (document.getElementById('arquivo').value == "")
		{
			check.style.display = "none";
			error.style.display = "block";
			camposCorretos[7] = 0;
		}
		else
		{
			check.style.display = "block";
			error.style.display = "none";
			camposCorretos[7] = 1;
		}
	}
	
	$("#submit").click(function() 
	{
		aux = 0;
		for (cont = 0; cont <= camposCorretos.length - 1; cont = cont + 1)
		{
			aux = aux + parseInt(camposCorretos[cont]);
		}
		if (aux != camposCorretos.length) 
		{
			alert ("Por favor, preencha todos os campos corretamente!");
			return false;
		} 
		else 
		{
			AjaxForm(frm_cadastro, "", "aux = this.responseText; alert(aux); if (aux.indexOf('Erro!') == -1) {window.location.href = 'index.php';}");
		}
	});
});