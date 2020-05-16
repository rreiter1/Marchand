// fonction qui récupère un objet xmlHttpRequest
function getRequeteHttp()
{
	var requeteHttp;
	if (window.XMLHttpRequest)
	{	// Mozilla
		requeteHttp=new XMLHttpRequest();
		if (requeteHttp.overrideMimeType)
		{ // problème firefox
			requeteHttp.overrideMimeType('text/xml');
		}
	}
	else
	{
		if(window.ActiveXObject)
		{	// C'est Internet explorer < IE7
			try
			{
				requeteHttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e)
			{
				try
				{
					requeteHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e)
				{
					requeteHttp=null;
				}
			}
		}
	}
	return requeteHttp;
}


//Deconecte  
function deconecter()
{
	var requeteHttp=getRequeteHttp();
	if (requeteHttp==null)
	{
		alert("Impossible d'utiliser Ajax sur ce navigateur");
	}
	else
	{
		// pour une réception en mode texte
		requeteHttp.open('GET','Ajax/deconection.php',true);
		
		requeteHttp.onreadystatechange=function(){recevoirReponse(requeteHttp);};
		requeteHttp.send(null);
	}
	return;
}

// pour les differents etats possibles : http://www.xul.fr/xml-ajax.html
function recevoirReponse(requeteHttp)
{
	if (requeteHttp.readyState==4)
	{
		if (requeteHttp.status==200)
		{
			traiterReponse(requeteHttp.responseText);
		}
		else
		{
			alert("La requête ne s'est pas correctement exécutée");
		}
	}
}
function traiterReponse(reponse)
{
	document.getElementById("Pages").innerHTML=reponse;
}

//Ajoute au panier 
function AddPanier(idpa)
{
	var requeteHttp=getRequeteHttp();
	if (requeteHttp==null)
	{
		alert("Impossible d'utiliser Ajax sur ce navigateur");
	}
	else
	{
		// pour une réception en mode texte
		requeteHttp.open('GET','Ajax/AddPanier.php?idart='+idpa+'&qtnd='+ document.getElementById("idk"+idpa).value,true);		
		requeteHttp.onreadystatechange=function(){recevoirReponsepanier(requeteHttp);};
		requeteHttp.send(null);
	}
	return;
}

// pour les differents etats possibles : http://www.xul.fr/xml-ajax.html
function recevoirReponsepanier(requeteHttp)
{
	if (requeteHttp.readyState==4)
	{
		if (requeteHttp.status==200)
		{
			traiterReponsepanier(requeteHttp.responseText);
		}
		else
		{
			alert("La requête ne s'est pas correctement exécutée");
		}
	}
}
function traiterReponsepanier(reponse)
{
	document.getElementById("resultat de l'achat").innerHTML=reponse;
}

//Panel Pour Admin
function openCity(evt, Panel) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(Panel).style.display = "block";
  evt.currentTarget.className += " active";
}

//Afficher le stock dans le Panel ADM selon le nom du disque choisis
function affnombre()
{
    var sel = document.getElementById('selection').value
    if(sel == 'default')
        document.getElementById('stockAadd').style.display = "none";
    else
    {
        document.getElementById('stockAadd').style.display = "block";
        var quant = sel.split(',')
        document.getElementById('nombre').value = quant[1]   
    }
}

//Actualiser les stocks
function ActualiserStock()
{
	var requeteHttp=getRequeteHttp();
	if (requeteHttp==null)
	{
		alert("Impossible d'utiliser Ajax sur ce navigateur");
	}
	else
	{
		// pour une réception en mode texte
		requeteHttp.open('GET','Ajax/Stock.php',true);		
		requeteHttp.onreadystatechange=function(){recevoirPageStock(requeteHttp);};
		requeteHttp.send(null);
	}
	return;
}

// pour les differents etats possibles : http://www.xul.fr/xml-ajax.html
function recevoirPageStock(requeteHttp)
{
	if (requeteHttp.readyState==4)
	{
		if (requeteHttp.status==200)
		{
			traiterPageStock(requeteHttp.responseText);
		}
		else
		{
			alert("La requête ne s'est pas correctement exécutée");
		}
	}
}
function traiterPageStock(reponse)
{
	document.getElementById("script").innerHTML=reponse;
    StockMax();
}
function rechargeToutPagePourStock(){
ActualiserStock();
setTimeout('rechargeToutPagePourStock()',10000); /* rappel après 2 secondes = 2000 millisecondes */
}