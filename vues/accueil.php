<h1>Bienvenue sur le site du blog</h1>
<h1><a href='index.php?commande=ListeArticles'>Articles</a></h1>
<?php
if(!isset($_SESSION["username"]))
{
?>
    <a href='index.php?commande=FormLogin'>Log in</a>
<?php
}
else
{
?>
    <a href="index.php?commande=Logout">Log out</a>
<?php
}
?>