<?php 
    if(!isset($_SESSION["username"]))
    {
?>
        <form method="POST" action="index.php">
            Username : <input type="text" name="nom"/><br>
            Password : <input type="password" name="mot_passe"/><br>
            <input type="hidden" name="commande" value="Login"/>
            <input type="submit" value="Log in"/>
        </form>
<?php if(isset($_REQUEST["message"])) echo $_REQUEST["message"]; ?>
<?php
    }
    else 
    {
?>
        Bienvenue <?= $_SESSION["username"] ?>
        <a href="index.php?commande=Logout">Log out</a><br>
        <h1><a href='index.php?commande=ListeArticles'>Articles</a></h1>
<?php 
    }
?>