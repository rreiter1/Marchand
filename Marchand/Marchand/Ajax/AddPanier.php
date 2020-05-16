<?php session_start();

if(isset($_SESSION["idPanier"]) or $_GET["idart"])
{
    $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
    $req = "SELECT * FROM article Where idA='".$_GET["idart"]."'";
    $res = mysqli_query($maConnexion,$req);
    $Qmax = mysqli_fetch_array($res);
    if(($_GET["qtnd"]>0)AND($_GET["qtnd"]<=$Qmax["stockA"]))
    {
        if($_SESSION["rank"]==2)
        {
            array_push($_SESSION['Panier']['qteProduit'],$_GET["qtnd"]);
            array_push($_SESSION['Panier']['idProduit'],$_GET["idart"]);
            echo "Article bien ajouter a votre panier";
        }
        else
        {
            $maConnexion = mysqli_connect("localhost","phpmyadmin","0550002D","MusiqueWorld");
            $req = "INSERT INTO `contenir` (`idA`, `id`, `Quandtiter`) VALUES ('".$_GET["idart"]."', '".$_SESSION["idPanier"]."', '".$_GET["qtnd"]."');";
            echo "Article bien ajouter a votre panier";
            mysqli_query($maConnexion,$req);
            mysqli_close($maConnexion);
        }
    }
}
else
    header('Location: index.php');

?>