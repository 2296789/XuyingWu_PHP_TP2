<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests unitaires des fonctions du modèle</title>
</head>

<body>

<h1>1. Test de obtenir_articles</h1>
<?php 
    require_once("modele.php");

    $articles = obtenir_articles();
    var_dump($articles);
?>    

<h1>2. Test de obtenir_article_par_id($id)</h1>
<?php 
    $article = obtenir_article_par_id(2);
    var_dump($article);
?>

<h1>3. Test de modifie_article($titre, $texte, $id)</h1>
<?php 
    $test = modifie_article("ABCD", "abcd", 5);
    var_dump($test);
?>

<h1>4. Test de authentifier_usager($nom, $mot_passe)</h1>
<?php 
    $test = authentifier_usager("AA", "aaaa");
    var_dump($test);
?> 

<h1>5. Test de cree_article($titre, $texte, $auteur)</h1>
<?php 
    $idCreeArticle = cree_article("CCCC", "cccc", "AA");
    var_dump($idCreeArticle);
?>

<h1>6. Test de supprime_article($id)</h1>
<?php 
    $test = supprime_article($idCreeArticle);
    var_dump($test);
?> 

<h1>7. Test de obtenir_article_par_recherche($contenu)</h1>
<?php 
    $test = obtenir_article_par_recherche("1");
    var_dump($test);
?> 

<h1>8. Test de login($nom, $mot_passe)</h1>
<?php 
    $test = login("AA", "aaaa");
    var_dump($test);
?> 

<h1>9. Test de recherche_article($texte)</h1>
<?php 
    $test = recherche_article("A");
    var_dump($test);
?> 

</body>
</html>

