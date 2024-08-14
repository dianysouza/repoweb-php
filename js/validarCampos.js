function apenasLetras(e,args)
{
	if (document.all) // caso seja IE
	{
		var evt=event.keyCode;
	}			
	else // do contrário deve ser Mozilla ou Google
	{
		var evt = e.charCode;
	}
	
	var caracteres = 'abcdefghijklmnopqrstuvwxyzçáàâãéèêíìîóòôõúùûABCDEFGHIJKLMNOPQRSTUVWXYZÇÁÀÂÃÉÈÊÍÌÎÓÒÔÕÚÙÛ ';      // criando a lista de teclas permitidas
	var chr= String.fromCharCode(evt);      // pegando a tecla digitada
	
	// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
    // códigos de tecla menores que 09 por exemplo 
	
	if (caracteres.indexOf(chr)>-1 || evt < 9)
	{
		return true;
	}
	
	return false;   // do contrário nega
}

function letrasNumeros(e,args)
{
	if (document.all)
	{
		var evt=event.keyCode;
	}			
	else
	{
		var evt = e.charCode;
	}
	
	var caracteres = 'abcdefghijklmnopqrstuvwxyzçáàâãéèêíìîóòôõúùûABCDEFGHIJKLMNOPQRSTUVWXYZÇÁÀÂÃÉÈÊÍÌÎÓÒÔÕÚÙÛ1234567890 ';
	var chr= String.fromCharCode(evt);
		
	if (caracteres.indexOf(chr)>-1 || evt < 9)
	{
		return true;
	}
	
	return false;
}


function apenasNumeros(e,args)
{
	if (document.all)
	{
		var evt=event.keyCode;
	}			
	else
	{
		var evt = e.charCode;
	}
	
	var caracteres = '0123456789';
	var chr= String.fromCharCode(evt);
	
	if (caracteres.indexOf(chr)>-1 || evt < 9)
	{
		return true;
	}
	
	return false;
}