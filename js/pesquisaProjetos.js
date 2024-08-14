/** * Função para criar um objeto XMLHTTPRequest */ 

function CriaRequest() 
{ 
	try
	{ 
		request = new XMLHttpRequest(); 
	}
	catch (IEAtual)
	{ 
		try
		{ 
			request = new ActiveXObject("Msxml2.XMLHTTP"); 
		}
		catch(IEAntigo)
		{ 
			try
			{ 
				request = new ActiveXObject("Microsoft.XMLHTTP"); 
			}
			catch(falha)
			{ 
				request = false; 
			} 
		} 
	} 
	if (!request)
	{
		alert("Seu Navegador não suporta Ajax!"); 
	}
	else 
	{
		return request;
	} 
} 

function pesquisaProjetos() 
{ 
	var ano = document.getElementById("cmb_ano").value;
	var curso = document.getElementById("cmb_curso").value;
	var order = document.getElementById("cmb_order").value;
	var xmlreq = CriaRequest(); 
	xmlreq.open("GET", "../tcc/php/pesquisa.php?ano=" + ano + "&curso=" + curso + "&order=" + order, true);
	xmlreq.onreadystatechange = function()
	{ 
		if (xmlreq.readyState == 4) 
		{ 
			if (xmlreq.status == 200) 
			{ 
				document.getElementById("retorno").innerHTML = xmlreq.responseText;
			}
			else
			{ 
				alert('Erro: ' + xmlreq.statusText); 
			}
		} 
	}; 
	xmlreq.send(null);
}