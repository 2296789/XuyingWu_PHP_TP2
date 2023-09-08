<?php
if(isset($_SESSION["username"]))
{
    echo "Bienvenue : " . $_SESSION["username"];
}
?>
<h1>Modification d'article</h1>
<form method="POST" action="index.php">
    Titre : <input type="text" name="titre" value="<?= htmlspecialchars($article["titre"]) ?>"/><br>
    Texte : <br>
    <textarea name="texte" cols="30" rows="10">
        <?= htmlspecialchars($article["texte"]) ?>
    </textarea>
    <br>
    <input type="hidden" name="commande" value="ModifieArticle"/>
    <input type="hidden" name="id" value="<?= $article["id"]; ?>"/>
    <input type="submit" value="Modifier"/>
</form>
<p><?php if(isset($_REQUEST["message"])) echo $_REQUEST["message"]; ?></p>