<?php
	$maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
	$req = "SELECT * FROM article INNER JOIN genre ON article.idG = genre.idG INNER JOIN 
	compositeur on article.idCompo = compositeur.idCompo";
	$res = mysqli_query($maConnexion,$req);    
	echo "function StockMax()
{
	"; 
	while($tbLigne = mysqli_fetch_array($res))
	{    
		if ($tbLigne["stockA"]!=0)
		{
		echo "document.getElementById('idk".$tbLigne["idA"]."').max = '".$tbLigne["stockA"]."';
	";
		}
	}
echo "}";
	mysqli_close($maConnexion);
?>