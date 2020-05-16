<!doctype html>
<html id="Pages" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
	<title>MusiqueWorld</title>
	<script type="text/javascript" src="JavaScript/script.js"></script>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"/>    -->
    <script type="text/javascript" src="JavaScript/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/Index.css"/>
    <script type="text/javascript" src="JavaScript/bootstrap.min.js"></script>
    
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
                echo "<span class='navbar-brand'>Bonjour visiteur</span>";
            }
    ?>
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Panier.php">Panier</a>
            </li>
          </ul>
          <ul class="navbar-nav">
        <?php if($_SESSION["rank"]==2) echo "<li class='nav-item'><a class='nav-link' href='connection.php'><span class='glyphicon glyphicon-log-in'aria-hidden='true'></span> Se connecter</a></li><br/><li class='nav-item'><a class='nav-link'href='enregistrer.php'><span class='glyphicon glyphicon-user'></span> S'enregistrer</a></li>"; else {echo "<li class='nav-item'><a class='nav-link' href='' onclick='deconecter()'><span class=' glyphicon glyphicon-log-out'></span> Se déconnecter</a></li><br/>";}?>
        <?php if($_SESSION["rank"]==1) echo "<li class='nav-item'><a class='nav-link' href='PanelAdm.php'><span class='glyphicon glyphicon-shopping-cart'></span> Gestion Du Site</a></li>";?>
    	</ul>
        </div>
      </div>
    </nav>
<section>
	<header><h1>Bienvenue sur le site MusiqueWorld, votre site d'achat de Cd en Ligne</h1></header>
</section>
    <div id="resultat de l'achat"></div>
	<div class='List'>
        
		<?php        
			$maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
			$req = "SELECT * FROM article INNER JOIN genre ON article.idG = genre.idG INNER JOIN 
			compositeur on article.idCompo = compositeur.idCompo ORDER BY `article`.`idA` DESC";
			$res = mysqli_query($maConnexion,$req);
            echo "<table class='AllArti'>";$i =0 ;
			while($tbLigne = mysqli_fetch_array($res))
			{
				if ($i==0) {
                	echo "<tr>";
                }
                $i++;
                echo "<td><div classe='element'> <form method='POST'>";
				echo "<div class='Beau'><article> <img src='images/".$tbLigne["nomImg"]."'/> <div>".$tbLigne["nomA"]." realiser par ".$tbLigne["nom"]."</div> <div> prix ".$tbLigne["prixA"]."€"."</div>";
                if($tbLigne["stockA"] != 0)
                {
					echo "<div>Ils y a ".$tbLigne["stockA"]." de stock de cet article</div>
					<input type='number' name='Quantiter' id='idk".$tbLigne["idA"]."' value=1 min=1 max=".$tbLigne["stockA"].">
                    <input class='btn btn-outline-success' type='button' name='Addpa' value='Ajouter au panier' onclick='AddPanier(".$tbLigne["idA"].")'/>";
                }

                else
                    echo "<p class = 'test10'>Article en rupture de stock</p>";
              	echo "</article></div><br/></form></div></td>";
                if ($i==3) {
                	echo "</tr>"; $i=0;
                }
            }
            echo "</table>";
            mysqli_close($maConnexion);            
		?>        
    </div>
</body>
</html>