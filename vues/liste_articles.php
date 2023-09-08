<?php
$recherche = "";

if(isset($_REQUEST["texte_recherche"]))
    $recherche = $_REQUEST["texte_recherche"];
    
if(isset($_SESSION["username"]))
    echo "Bienvenue : " . $_SESSION["username"] . "<br>";

if(isset($_SESSION["username"]))
{
?>
    <a href="index.php?commande=Logout">Log out</a>
<?php
}
else
{
?>
    <a href="index.php?commande=FormLogin">Log in</a>
<?php
}
?>

<h1>Liste d'Articles</h1>
<form method="GET" action="index.php">
    <input type="text" name="texte_recherche" value="<?= $recherche ?>"/>
    <input type="submit" value="Rechercher"/>
    <input type="hidden" name="commande" value="Recherche"/>
<form>
<br><br>

<?php 
if(isset($_REQUEST["message"])) 
{
?>    
<p><?= $_REQUEST["message"]; ?></p>
<?php
}

if(mysqli_num_rows($article) > 0)
{
    while($rangee = mysqli_fetch_assoc($article))
    {
?> 
        <h2>Titre : <?= $rangee["titre"] ?></h2>
        <p><?= $rangee["texte"] ?></p>
        <p>Auteur : <?= $rangee["auteur"] ?></p>    
<?php
        if(isset($_SESSION["username"]))
        {
            if($_SESSION["username"] == $rangee["auteur"])
            {
?>
                <a href='index.php?commande=FormModifieArticle&id=<?= $rangee["id"] ?>'>
                    Modifier cet article / 
                </a>

                <a href='index.php?commande=SupprimeArticle&id=<?= $rangee["id"] ?>'>
                    Supprimer cet article
                </a>
<?php 
            }
        }
    }
}
else 
{
?>
    <p>Il n'y a pas d'article à afficher</p>
<?php 
}
?>

<br>
<a href='index.php?commande=FormCreeArtciel'>Ecrire un article</a>
<br>
<a href='index.php'>Retourner à l'accueil</a><br>
