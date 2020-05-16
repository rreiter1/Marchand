<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
	<title>MusiqueWorld</title>
	<script type="text/javascript" src="JavaScript/script.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/enregistrer.css" />
    <link rel="stylesheet" type="text/css" href="CSS/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="JavaScript/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/Index.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <?php
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
            <li class="nav-item">
              <a class="nav-link" href="Panier.php">Panier</a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class='nav-item'><a class='nav-link' href='connection.php'><span class='glyphicon glyphicon-log-in'aria-hidden='true'></span> Se Connecter</a></li>
        </ul>
        </div>
      </div>
    </nav>
<div class="inscription">
<h2>Cree un Compte</h2>
    <form method="POST">
        <p>nom : <input type="text" name="nom" placeholder="Entrer votre nom" /></p>
        <p>prenom :</p>
        <input type="text" name="prenom" placeholder="Entrer votre prenom" />
        <p>identifiant :</p>
        <input type="text" name="identifiant" placeholder="Entrer un identifiant" />
        <p>mots de passe :</p>
        <input type="password" name="mdp" placeholder="Entrer un Mots de passe"  />
        <p>ville :</p>
        <input type="text" name="ville" placeholder="Entrer votre ville" />
        <p>adresse :</p>
        <input type="text" name="adresse" placeholder="Entrer votre adresse" />
        <p>pays :</p>
        <input type="text" name="pays" placeholder="Entrer votre pays" />
        <p>code postal :</p>
        <input type="number" name="cp" placeholder="Entrer votre Code Postal" />
        <p>numero de telephone :</p>
        <input type="number" name="num" placeholder="Entrer votre telephone" />
        <input type="submit" name="Valider" value="Valider" />
        <a href="index.php">Déja un compte</a>
    </form>
</div>
<?php
if(isset($_POST["Valider"]))
{
    $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
	$req = "SELECT * FROM compte";
	$res = mysqli_query($maConnexion,$req);
    $doublon = true;
    while($TbRes=mysqli_fetch_array($res))
    {
        if($TbRes["identifiantC"]==$_POST["identifiant"])
            $doublon = false;
    }  
    if($doublon)
    {
        $pass = password_hash($_POST["mdp"],PASSWORD_DEFAULT);
        $req = "INSERT INTO `compte` (`idC`, `nomC`, `prenomC`, `identifiantC`, `mdpC`, `villeC`, `adresseC`, `payC`, `cpC`, `numtelC`, `idP`) VALUES 
        (NULL, '".$_POST["nom"]."', '".$_POST["prenom"]."', '".$_POST["identifiant"]."', '".$pass."', '".$_POST["ville"]."', '".$_POST["adresse"]."',
         '".$_POST["pays"]."', '".$_POST["cp"]."', '".$_POST["num"]."', '3');";
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        mysqli_query($maConnexion,$req);
    }
}
?>
</body>
</html>