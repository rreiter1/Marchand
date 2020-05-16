<!doctype html>
<html  id="Pages" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
	<title>MusiqueWorld</title>
	<script type="text/javascript" src="JavaScript/script.js"></script>
	<!-- AJAX envoyerRequete(); actualise cet ID.div.monDiv -->
    <link rel="stylesheet" type="text/css" href="CSS/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="JavaScript/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/Index.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/PanelAdm.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <?php session_start(); 
            if((isset($_SESSION["Conecter"])) AND ($_SESSION["rank"]==1)) 
                echo "<span class='navbar-brand'>Pages Reserver au ADMIN</span>";
            else
                header('Location: index.php');
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
        <li class='nav-item'><a class='nav-link' onclick='deconecter()'><span class=' glyphicon glyphicon-log-out'></span> Se Deconnecter</a></li>
        </ul>
        </div>
      </div>
    </nav>

    <div id="Trie_des_ADD">
        <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'Article')" >Article</button>
        <button class="tablinks" onclick="openCity(event, 'Genre')">Genre</button>
        <button class="tablinks" onclick="openCity(event, 'Compositeur')">Compositeur</button>
        <button class="tablinks" onclick="openCity(event, 'Stock')">Stock</button>
        <button class="tablinks" onclick="openCity(event, 'SupArticle')">Suprimer un Article</button>
        <button class="tablinks" onclick="openCity(event, 'SupGenre')">Suprimer un Genre</button>
        <button class="tablinks" onclick="openCity(event, 'SupCompo')">Suprimer un Compositeur</button>
    </div>
    <?php
    if(isset($_POST["ValArt"]))
    {
        $uploaddir = 'images/';
        $uploadfile = $uploaddir.basename($_FILES['nomImgA']['name']);
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        $req = "SELECT * FROM article;";
        $res = mysqli_query($maConnexion,$req);
        $resuNomDoublon =true;
        while($tbLigne = mysqli_fetch_array($res))
        {
            if($tbLigne["nomImg"]==$_FILES['nomImgA']['name'])
            {
                $resuNomDoublon = false;
            }
        }
        $resultat = move_uploaded_file($_FILES['nomImgA']['tmp_name'],$uploadfile);
        if ((($resultat)AND($resuNomDoublon))==true)
        {
            echo "<p class='alert alert-success'>Transfert réussi</p>"; 
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "INSERT INTO `article` (`idA`, `nomA`, `prixA`, `stockA`, `nomImg`, `idG`, `idCompo`) VALUES (NULL, '".$_POST["nomA"]."', '".$_POST["prixA"]."', '".$_POST["stockA"]."', '".$_FILES['nomImgA']['name']."', '".$_POST["idG"]."', '".$_POST["idCompo"]."');";
            mysqli_query($maConnexion,$req);
			mysqli_close($maConnexion);
        }
        else{
            echo "<p class='alert alert-danger'>Transfert Perturber</p>";
            if($resuNomDoublon)
            {
                echo "<p class='alert alert-info'>Si le probleme persite Cree une nouvelle image et copier l'ancien dessus </p>";
            }
            else
                echo"<p class='alert alert-info'> Nom de l'image en doublon </p>";
        }
    }
    ?>
<?php
    $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
    $req = "SELECT * FROM Article INNER JOIN Genre ON Article.idG = Genre.idG INNER JOIN Compositeur on Article.idCompo = Compositeur.idCompo;";
    $res = mysqli_query($maConnexion,$req);
    mysqli_close($maConnexion);
?>
    <br/>
    <?php
    if(isset($_POST["ValGenre"]) and ($_POST["ValGenre"]!=""))
    {
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        $req = "INSERT INTO `genre` (`idG`, `nomG`) VALUES (NULL, '".$_POST["genre"]."');";
        mysqli_query($maConnexion,$req);
        mysqli_close($maConnexion);
        echo "<p class='alert alert-success'>Votre Genre a etais cree</p>";
    }
    if(isset($_POST["ValCompo"]) and ($_POST["ValCompo"]!=""))
    {
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        $req = "INSERT INTO `compositeur` (`idCompo`, `nom`) VALUES (NULL, '".$_POST["compo"]."');";
        mysqli_query($maConnexion,$req);
        mysqli_close($maConnexion);
        echo "<p class='alert alert-success'>Votre Compositeur a etais cree</p>";
    }
    if(isset($_POST["ValStock"]))
    {
        if($_POST["nbstock"] < 0)
              echo '<script>alert("Valeur saisis trop bas minimum 0 ");</script>';
        else
        {
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $IDa = preg_split('/[\s,]+/', $_POST["idArticle"], -1, PREG_SPLIT_NO_EMPTY);
            $req = "UPDATE `article` SET `stockA` = '".$_POST["nbstock"]."' WHERE `article`.`idA` = ".$IDa[0].";";
            mysqli_query($maConnexion,$req);
            mysqli_close($maConnexion);
            echo "<p class='alert alert-success'>Votre Stock a etais mis a jour</p>";
        }
    }
    if(isset($_POST["ValSupArticle"]))
    {
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        $req = "SELECT * FROM article where idA =".$_POST["idArticleS"]." ;";
        $res = mysqli_query($maConnexion,$req);
        $tbLigne = mysqli_fetch_array($res);
        unlink("images/".$tbLigne["nomImg"]);
        $req = "DELETE FROM `article` WHERE `article`.`idA` = ".$_POST["idArticleS"]." ;";
        mysqli_query($maConnexion,$req);
        mysqli_close($maConnexion);
        echo "<p class='alert alert-success'>Votre article a etais suprimer</p>";
        
    }
    if(isset($_POST["ValSupGenre"]))
    {
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        $req = "DELETE FROM `genre` WHERE `genre`.`idG` = ".$_POST["idArticleSg"]." ;";
        if((mysqli_query($maConnexion,$req))==false)
           {
               echo "<p class='alert alert-warning'>Attention , Suprimer Avant Les article avec ce Genre</p> ";
           }
           else
            echo "<p class='alert alert-success'>Votre Genre a etais suprimer</p>";
        mysqli_close($maConnexion);
    }
    if(isset($_POST["ValSupCompo"]))
    {
        $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
        $req = "DELETE FROM `compositeur` WHERE `compositeur`.`idCompo` = ".$_POST["idArticleSc"]." ;";
        //mysqli_query($maConnexion,$req);
        if((mysqli_query($maConnexion,$req))==false)
           {
               echo "<p class='alert alert-warning'>Attention , Suprimer Avant Les article avec ce Compositeur</p> ";
           }
        else
           echo "<p class='alert alert-success'>Votre Compositeur a etais suprimer</p>";
        mysqli_close($maConnexion);
    }
    ?>
    <div id='Article' class="tabcontent">
        <h1>Ajouter un article</h1>
    <form method="post" enctype="multipart/form-data">
        <p>Saisir le nom de l'album : <input type="text" name="nomA"/></p><br/>
        <p>Saisir le prix : <input type="text" name="prixA"/></p><br/>
        <p>Saisir le nb de stock : <input type="text" name="stockA"/></p><br/>
        <p>Sasir l'image de votre album : <input type="file" name="nomImgA"/></p><br/>
        <p>Saisir le genre de l'album : <select name="idG">
        <?php
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "SELECT * FROM genre;";
            $res = mysqli_query($maConnexion,$req);
            while($tbLigne = mysqli_fetch_array($res))
                echo   "<option value='".$tbLigne["idG"]."'>".$tbLigne["nomG"]."</option>";
            mysqli_close($maConnexion);
        ?>        
        </select></p><br/>
        <p>Saisir le Compositeur : <select name="idCompo">
        <?php
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "SELECT * FROM compositeur;";
            $res = mysqli_query($maConnexion,$req);
            while($tbLigne = mysqli_fetch_array($res))
                echo   "<option value='".$tbLigne["idCompo"]."'>".$tbLigne["nom"]."</option>";
            mysqli_close($maConnexion);
        ?>
        </select></p><br/>
        <input class='btn btn-outline-success' type="submit" name="ValArt" value="Valider"/>
    </form>
    </div>
    <div id='Genre' class="tabcontent">
        <h1>Ajouter un genre</h1>
        <form method="post">
            <p>Saisir le nom du genre :</p> <input type="text" name="genre"/>
            <input class='btn btn-outline-success' type="submit" name="ValGenre" value="Valider"/>
        </form>        
    </div>
        <div id='Compositeur' class="tabcontent">
            <h1>Ajouter un Compositeur</h1>
            <form method="post">
            <p>Saisir le nom du/des compositeur(e)(s) :</p> <input type="text" name="compo"/>
            <input class='btn btn-outline-success' type="submit" name="ValCompo" value="Valider"/>
        </form>
        </div> 
        <div id='Stock' class="tabcontent">
            <h1>Gestion des stock</h1>
            <form method="post">
                <p>Saisir le nom de l'article que vous voulez geree les stock : <select id='selection' name="idArticle" onclick="affnombre()"> <option value='default' name='Vide' id="Vide"> </option>
            <?php
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "SELECT * FROM article;";
            $res = mysqli_query($maConnexion,$req);
            while($tbLigne = mysqli_fetch_array($res))
            {
                echo   "<option value='".$tbLigne["idA"].",".$tbLigne["stockA"]."' name='".$tbLigne["stockA"]."' id='stock".$tbLigne["idA"]."'>".$tbLigne["nomA"]."</option>";
            }
            mysqli_close($maConnexion);
            ?>
            </select>
                <p id="stockAadd">Voici la quantiter de l'article : <input type="number" id='nombre' name="nbstock" value='0' min=0></p> 
            <input class='btn btn-outline-success' type="submit" name="ValStock" value="Valider"/>
        </form>
        </div>
        <div id='SupArticle' class="tabcontent">
            <h1>Suprimer un Article</h1>
            <form method="post">
                <p>Saisir le nom de l'article que vous voulez Suprimer : <select id='selectionS' name="idArticleS"> <option value='default' name='Vide' id="Vide2"> </option>
            <?php
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "SELECT * FROM article;";
            $res = mysqli_query($maConnexion,$req);
            while($tbLigne = mysqli_fetch_array($res))
            {
                echo   "<option value='".$tbLigne["idA"]."'>".$tbLigne["nomA"]."</option>";
            }
            mysqli_close($maConnexion);
            ?>
            </select>
            <br/><input class='btn btn-outline-success' type="submit" name="ValSupArticle" value="Valider"/>
        </form>
        </div>
        <div id='SupGenre' class="tabcontent">
            <h1>Suprimer un Genre</h1>
            <form method="post">
                <p>Saisir le nom de l'article que vous voulez Suprimer : <select id='selectionSg' name="idArticleSg"> <option value='default' name='Vide' id="Vide2"> </option>
            <?php
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "SELECT * FROM genre;";
            $res = mysqli_query($maConnexion,$req);
            while($tbLigne = mysqli_fetch_array($res))
            {
                echo   "<option value='".$tbLigne["idG"]."'>".$tbLigne["nomG"]."</option>";
            }
            mysqli_close($maConnexion);
            ?>
            </select>
            <br/><input class='btn btn-outline-success' type="submit" name="ValSupGenre" value="Valider"/>
        </form>
        </div>
        <div id='SupCompo' class="tabcontent">
            <h1>Suprimer un Article</h1>
            <form method="post">
                <p>Saisir le nom de l'article que vous voulez Suprimer : <select id='selectionSc' name="idArticleSc"> <option value='default' name='Vide' id="Vide2"> </option>
            <?php
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "SELECT * FROM compositeur;";
            $res = mysqli_query($maConnexion,$req);
            while($tbLigne = mysqli_fetch_array($res))
            {
                echo   "<option value='".$tbLigne["idCompo"]."'>".$tbLigne["nom"]."</option>";
            }
            mysqli_close($maConnexion);
            ?>
            </select>
            <br/><input class='btn btn-outline-success' type="submit" name="ValSupCompo" value="Valider"/>
        </form>
        </div>
    <script>document.getElementById("defaultOpen").click();</script>
</body>
</html>