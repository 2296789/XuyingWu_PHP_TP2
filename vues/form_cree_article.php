<?php 
    $titre = "";
    $texte = "";

    if(isset($_REQUEST["titre"]))
        $titre = $_REQUEST["titre"];

    if(isset($_REQUEST["texte"]))
        $texte = $_REQUEST["texte"];
    
    if(isset($_SESSION["username"]))
        echo "Bienvenue : " . $_SESSION["username"];
?>
<h1>Creer un article</h1>
<form method="POST" action="index.php">
    Titre : <input type="text" name="titre" value="<?= htmlspecialchars($titre) ?>"/><br>
    Texte : <br>
    <textarea name="texte" cols="30" rows="10">
      <?= htmlspecialchars($texte) ?>
    </textarea>
    <br>
    <input type="hidden" name="commande" value="CreeArticle"/>
    <input type="hidden" name="auteur" value="<?= $_SESSION["username"] ?>"/>
    <input type="submit" value="Creer"/>
</form>
