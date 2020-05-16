<!doctype html>
<html id="Pages" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
	<title>MusiqueWorld</title>
	<script type="text/javascript" src="JavaScript/script.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="JavaScript/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/Index.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <?php session_start();
            if(isset($_SESSION["Conecter"]) and $_SESSION["Conecter"]==true) 
                echo "<span class='navbar-brand'>Bonjour ".$_SESSION["login"]."</span>";
            else
            {
                if (!isset($_SESSION['Panier'])){
                    $_SESSION['Panier']=array();
                    $_SESSION['Panier']['qteProduit'] = array();
                    $_SESSION['Panier']['idProduit'] = array();
                }
                if(!isset($_SESSION["rank"]))
                {
                    $_SESSION["rank"]=2;
                }
                echo "<span class='navbar-brand'>Bonjour Visiteur</span>";
            }
    ?>
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="Panier.php">Panier</a>
            </li>
          </ul>
          <ul class="navbar-nav">
        <?php if($_SESSION["rank"]==2) echo "<li class='nav-item'><a class='nav-link' href='connection.php'><span class='glyphicon glyphicon-log-in'aria-hidden='true'></span> Se Connecter</a></li><br/><li class='nav-item'><a class='nav-link'href='enregistrer.php'><span class='glyphicon glyphicon-user'></span> S'enregistrer</a></li>"; else {echo "<li class='nav-item'><a class='nav-link' onclick='deconecter()'><span class=' glyphicon glyphicon-log-out'></span> Se Deconnecter</a></li><br/>";}?>
        <?php if($_SESSION["rank"]==1) echo "<li class='nav-item'><a class='nav-link' href='PanelAdm.php'><span class='glyphicon glyphicon-shopping-cart'></span> Gestion Du Site</a></li>";?>
    	</ul>
        </div>
      </div>
    </nav>
<div class="Panier">
    <h1>Votre Panier</h1>
	<?php 
	if(isset($_GET["Achat"]))
	{
		if($_GET["Achat"] == "True")
		{
			echo "<script> alert('Achat effectuer')</script>";
		}
	}
	else
	{
		if(isset($_POST["ValAchat"]))
		{
			if(isset($_SESSION["idPanier"]))
			{
				$maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
				$pan = "SELECT *,article.stockA as stockArt FROM `contenir` INNER JOIN article ON article.idA = contenir.idA WHERE id='".$_SESSION["idPanier"]."'";
				$respan = mysqli_query($maConnexion,$pan);
				if(mysqli_num_rows($respan)!=0)
				{
					while($PanART = mysqli_fetch_array($respan))
					{
						$req = "UPDATE `article` SET `stockA` = '".($PanART["stockA"] - $PanART["Quandtiter"])."' WHERE `article`.`idA` =".$PanART["idA"];
						$res = mysqli_query($maConnexion,$req);
						$req = "DELETE FROM `contenir` WHERE `contenir`.`idA` = ".$PanART["idA"]." AND `contenir`.`id` = '".$_SESSION["idPanier"]."';";
						$res = mysqli_query($maConnexion,$req);
					}
					header('Location: Panier.php?Achat=True');
				}
				else
					echo "PROB IF $res";
			}
		}
	}
		
	?>
<?php
	$maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
	if(isset($_SESSION["rank"]) and $_SESSION["rank"]==2)
	{
        if(isset($_SESSION["Panier"]["idProduit"][0]))
        {
		$req = "SELECT * FROM article";
		$res = mysqli_query($maConnexion,$req);
		$CoutTotal = 0;
		while($tbLigne = mysqli_fetch_array($res))
		{
			$i=0;
			foreach ($_SESSION["Panier"]["idProduit"] as $value)
			{
				if($value == $tbLigne["idA"])
				{
					echo "<img src='images/".$tbLigne["nomImg"]."' alt='".$tbLigne["nomA"]."'/><div class='article'> <span>".$tbLigne["nomA"]." Quantiter ".$_SESSION["Panier"]["qteProduit"][$i]." au prix unitaire de ".$tbLigne["prixA"]."€"."</span></div></article><br/>";
					$CoutTotal += $_SESSION["Panier"]["qteProduit"][$i] * $tbLigne["prixA"];
				}
				$i++;
			}
		}
        echo "Coût total de votre Panier est de ".$CoutTotal."€";
        }else echo "<a class='home2'>Panier Vide</a>";
	}
	else
	{
		if(isset($_SESSION["idPanier"])){
			$req = "SELECT * FROM `contenir` INNER JOIN article ON article.idA = contenir.idA WHERE id='".$_SESSION["idPanier"]."'";
			$res = mysqli_query($maConnexion,$req);
			if(mysqli_num_rows($res)!=0)
			{
				$CoutTotal = 0;
				while($tbLigne = mysqli_fetch_array($res))
				{
					echo "<img src='images/".$tbLigne["nomImg"]."' alt='".$tbLigne["nomA"]."'/><div class='article'> <span>".$tbLigne["nomA"]." Quantiter ".$tbLigne["Quandtiter"]." au prix unitaire de ".$tbLigne["prixA"]."€"."</span></div></article><br/>";
					$CoutTotal += $tbLigne["Quandtiter"] * $tbLigne["prixA"];
				}
				echo "Coût total de votre Panier est de ".$CoutTotal."€";
				echo "<form method='POST'><input type='submit' name='ValAchat'/></form>";
			}else 
				echo "Panier Vide ";		
		}else 
			echo "Panier Vide ";
	}
    mysqli_close($maConnexion);
?>
    
</div>
</body>
</html>