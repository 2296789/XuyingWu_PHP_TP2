<?php 
    session_start();

    if(isset($_REQUEST["commande"]))
        $commande = $_REQUEST["commande"];
    else 
        $commande = "Accueil";

    require_once("modele.php");

    switch($commande)
    {
        case "Accueil":
            $titre = "Accueil";
            require_once("vues/header.php");
            require("vues/accueil.php");
            require_once("vues/footer.php");
            break;

        case "FormLogin":
            $titre = "Formulaire d'authentification";
            require_once("vues/header.php");
            require("vues/form_login.php");
            require_once("vues/footer.php");
            break;

        case "Login":
            if(isset($_REQUEST["nom"], $_REQUEST["mot_passe"]))
            {
                $test = login($_REQUEST["nom"], $_REQUEST["mot_passe"]);
                if($test != false)
                {
                    $_SESSION["username"] = $test;
                    header("Location: index.php?commande=PageProtegee");
                }
                else 
                {
                    header("Location: index.php?commande=FormLogin&message=La combinaison username/password est invalide.");
                }
            }
            break;

        case "Logout":
            $_SESSION = array();

            if (ini_get("session.use_cookies")) 
            {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            session_destroy();
            header("Location: index.php");
            break;

        case "PageProtegee":
            if(isset($_SESSION["username"]))
            {
                $titre = "Page protégée";
                require_once("vues/header.php");
                require("vues/page_protegee.php");
                require_once("vues/footer.php");
            }
            else 
            {
                header("Location:index.php?commande=FormLogin");
            }
            break; 

        case "ListeArticles":
            $titre = "Liste d'Articles";
            $article = obtenir_articles();
            require_once("vues/header.php");
            require("vues/liste_articles.php");
            require_once("vues/footer.php");
            break;
        
        case "FormModifieArticle":
            if(!isset($_REQUEST["id"]) || !is_numeric($_REQUEST["id"]))
            {
                header("Location: index.php");
                die();
            }
            $titre = "Modification d'article";
            $article = obtenir_article_par_id($_REQUEST["id"]);

            if($article != false)
            {
                require_once("vues/header.php");
                require("vues/form_modifie_article.php");
                require_once("vues/footer.php");
            }
            else 
            {
                header("Location: index.php");
                die();
            } 
            break;

        case "ModifieArticle":
            if(isset($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["id"]))
            {
                if(valide_article_par_id($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["id"]))
                {
                    $test = modifie_article($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["id"]);
                    
                    if($test)
                        header("Location: index.php?commande=ListeArticles&message=Modification réussie.");
                    else
                        header("Location: index.php?commande=ListeArticle&message=Échec de la modification.");
                }
                else
                {
                    header("Location: index.php?commande=FormModifieArticle&idEquipe=" . $_REQUEST["id"]);
                }
            }
            else 
            {
                header("Location: index.php");
                die();
            } 
            break;

        case "FormCreeArtciel":
            if(isset($_SESSION["username"]))
            {
                $test = obtenir_articles();
                if($test)
                {
                    $titre = "Form de creer un artciel";
                    require_once("vues/header.php");
                    require("vues/form_cree_article.php");
                    require_once("vues/footer.php");                    
                }
                else
                    header("Location: index.php?commande=FormLogin");
            }
            else
                header("Location: index.php?commande=FormLogin");
            break;

        case "CreeArticle":
            if(isset($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["auteur"]))
            {
                if(valide_article($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["auteur"]))
                {
                    $test = cree_article($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["auteur"]);
                    if($test)
                        header("Location: index.php?commande=ListeArticles&message=Modification réussie.");
                    else
                        header("Location: index.php?commande=ListeArticle&message=Échec de la modification.");
                }
                else
                {
                    header("Location: index.php?commande=FormModifieArticle&idArticle=" . $_REQUEST["auteur"]);
                }
            }
            else 
            {
                header("Location: index.php");
                die();
            } 
            break;
            
        case "SupprimeArticle":
            if(!isset($_REQUEST["id"]) || !is_numeric($_REQUEST["id"]))
            {
                header("Location: index.php");
                die();
            }
            $test = supprime_article($_REQUEST["id"]);
            if($test)
            {
                header("Location: index.php?commande=ListeArticles&message=Suppression réussie.");
                die();
            }
            else 
            {
                header("Location: index.php?commande=ListeArticles&message=Échec de la suppression.");
                die();
            }

        case "Recherche":
            if(isset($_REQUEST["texte_recherche"]))
            {
                $article = recherche_article($_REQUEST["texte_recherche"]);
                require_once("vues/header.php");
                require("vues/liste_articles.php");
                require_once("vues/footer.php");
            } 
            else
            {
                header("Location: index.php?commande=ListeArticles&message=Formulaire mal rempli.");
                die();
            }
            break;

        default: 
            $titre = "Erreur 404";
            require_once("vues/header.php");
            require("vues/404.html");
            require_once("vues/footer.php");
            break;
    }

    function valide_usager($nom, $mot_passe)
    {
        $valide = true; 

        $nom = trim($_REQUEST["nom"]);
        $mot_passe = trim($_REQUEST["mot_passe"]);

        if($nom == "" || $mot_passe == "")
            $valide = false;
            
        return $valide;
    }

    function valide_article($titre, $texte, $auteur)
    {
        $valide = true; 

        $titre = trim($_REQUEST["titre"]);
        $texte = trim($_REQUEST["texte"]);
        $auteur = trim($_REQUEST["auteur"]);

        if($titre == "" || $texte == "" || $auteur == "")
            $valide = false;

        return $valide;
    }

    function valide_article_par_id($titre, $texte, $id)
    {
        $valide = true; 

        $titre = trim($_REQUEST["titre"]);
        $texte = trim($_REQUEST["texte"]);
        $id = $_REQUEST["id"];

        if($titre == "" || $texte == "" || $id == "" || !is_numeric($id))
            $valide = false;

        return $valide;
    }
?>
