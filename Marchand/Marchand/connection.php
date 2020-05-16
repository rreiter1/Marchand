<?php session_start(); ?>
<!doctype html>
<html id="Pages" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
	<title>MusiqueWorld</title>
	<script type="text/javascript" src="JavaScript/script.js"></script>
	<!-- AJAX envoyerRequete(); actualise cet ID.div.monDiv -->
    <link rel="stylesheet" type="text/css" href="CSS/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/Index.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/connection.css" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="JavaScript/bootstrap.min.js"></script>
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
            <li class='nav-item'><a class='nav-link' href='enregistrer.php'><span class='glyphicon glyphicon-user'></span> S'enregistrer</a></li>"
          </ul>
        </div>
    </div>
</nav>
<?php 
$_SESSION["Conecter"]=false;
$_SESSION["rank"]=2;
if(isset($_POST["Valider"]))
{
    $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
    $req = "SELECT * FROM compte WHERE identifiantC='".$_POST["login"]."';"; // AND mdpC='".$_POST["password"]."'
    $res = mysqli_query($maConnexion,$req);
    $TbRes=mysqli_fetch_array($res);
    if(password_verify ( $_POST["password"] , $TbRes["mdpC"])) //if(mysqli_num_rows($res)==1)
    {
        $_SESSION["idCompte"] = $TbRes["idC"];
        $_SESSION["Conecter"]=true;
        $_SESSION["login"]=$TbRes["identifiantC"];
        $_SESSION["rank"]=$TbRes["idP"];
        $req = "SELECT * FROM panier WHERE idC='".$TbRes["idC"]."';";
        $res = mysqli_query($maConnexion,$req);
        $TbRes=mysqli_fetch_array($res);
        if(mysqli_num_rows($res)==1)
        {
            $_SESSION["idPanier"]= $TbRes["id"];
        }
        else
        {
            $req = "INSERT INTO `panier` (`id`, `idC`) VALUES (NULL, '".$_SESSION["idCompte"]."');";
            echo $req;
            mysqli_query($maConnexion,$req);
            $req = "SELECT * FROM panier WHERE idC='".$_SESSION["idCompte"]."';";
            echo $req;
            $res = mysqli_query($maConnexion,$req);
            $TbRes=mysqli_fetch_array($res);
            $_SESSION["idPanier"]= $TbRes["id"];
        }
        $req = "SELECT * FROM contenir where id='".$_SESSION["idPanier"]."'";
        echo $req;
        $res = mysqli_query($maConnexion,$req);
/*      while($tbLigne = mysqli_fetch_array($res))
        {
            $i=0;
            foreach ($_SESSION["Panier"]["idProduit"] as $value)
            {
                if($value != $tbLigne["idA"])
                {
                    $req2 = "INSERT INTO `contenir` (`idA`, `id`, `Quandtiter`) VALUES ('".$value."', '".$_SESSION["idPanier"]."', '".$_SESSION["Panier"]["qteProduit"][$i]."');";
                    mysqli_query($maConnexion,$req2);
                }
                $i++;
            }
        }*/
        $i=0;
        foreach ($_SESSION["Panier"]["idProduit"] as $value)
        {
            $req = "SELECT * FROM `contenir` Where id = ".$_SESSION["idPanier"]." AND idA = ".$value;
            echo $req;
            echo $req;
            $res = mysqli_query($maConnexion,$req);
            if(mysqli_num_rows($res)==0)
            {
                $req2 = "INSERT INTO `contenir` (`idA`, `id`, `Quandtiter`) VALUES ('".$value."', '".$_SESSION["idPanier"]."', '".$_SESSION["Panier"]["qteProduit"][$i]."');";
                echo $req2;
                mysqli_query($maConnexion,$req2);
            }
            $i++;
        }
        unset($_SESSION["Panier"]);
        echo "Conecter";
    }
    else
    {
        echo "<br/><a>Identifiant Ou/Et Mots Passe Incorecte</a>";
    }
    mysqli_close($maConnexion);
    if($_SESSION["Conecter"])
    {
        header('Location: index.php');
        echo "connecter" ;
    }
}
?>
<div class="login">
<h2>Conection</h2>
    <form method="POST">
        <p>ID :</p>
        <input type="text" name="login" placeholder="Entrer votre Identifiant" />
        <p>MDP :</p>
        <input type="password" name="password" placeholder="Entrer votre Mots de passe"  />
        <button type="submit" class="btn btn-danger" name="Valider"> Valider </button>
        <a href="enregistrer.php">Cree un compte</a>
    </form>
</div>
</body>
</html>