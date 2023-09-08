<?php 
/*        
    define("SERVER", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "root");
    define("DBNAME", "blog");
*/
    define("SERVER", "localhost");
    define("USERNAME", "e2296789");
    define("PASSWORD", "JLl2AH6eOoD6Ru7pOjhO");
    define("DBNAME", "e2296789");

    function connectDB()
    {
        $c = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);

        if(!$c)
            die("Erreur de connexion : " . mysqli_connect_error());

        mysqli_query($c, "SET NAMES 'utf8'");   
        return $c;
    }

    $connexion = connectDB();

    function obtenir_articles()
    {
        global $connexion;

        $requete = "SELECT id, titre, texte, auteur FROM article ORDER BY id DESC";
        $resultats = mysqli_query($connexion, $requete);

        return $resultats;
    }

    function obtenir_article_par_id($id)
    {
        global $connexion;

        $requete = "SELECT id, titre, texte, auteur FROM article WHERE id = " . $id;
        $resultats = mysqli_query($connexion, $requete);
        $rangee = mysqli_fetch_assoc($resultats);

        return $rangee;
    }
    
    function authentifier_usager($nom, $mot_passe)
    {
        global $connexion;

        $requete = "SELECT nom, mot_passe, titre, texte 
                    FROM usager 
                    JOIN article ON usager.nom = article.auteur
                    WHERE nom = ? AND mot_passe = ?";
        $reqPrep = mysqli_prepare($connexion, $requete);
        $test = mysqli_query($connexion, $requete);

        if($reqPrep)
        {
            mysqli_stmt_bind_param($reqPrep, "ss", $nom, $mot_passe);
            $test = mysqli_stmt_execute($reqPrep);      
            return $test;
        }
        else 
            return false;
    }
    function cree_article($titre, $texte, $auteur)
    {
        global $connexion;

        $requete = "INSERT INTO article (titre, texte, auteur) VALUES(?,?,?)";
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            mysqli_stmt_bind_param($reqPrep, "sss", $titre, $texte, $auteur);
            $test = mysqli_stmt_execute($reqPrep);

        if($test)
        {
            $id = mysqli_insert_id($connexion);
            return $id;
        }
        else 
            return false;
        }
        else 
            die("Erreur mysqli.");
    }

    function modifie_article($titre, $texte, $id)
    {
        global $connexion;

        $requete = "UPDATE article SET titre = ?, texte = ? WHERE id = $id";
        $reqPrep = mysqli_prepare($connexion, $requete);
        $test = mysqli_query($connexion, $requete);
        if($reqPrep)
        {
            mysqli_stmt_bind_param($reqPrep, "ss", $titre, $texte);
            $test = mysqli_stmt_execute($reqPrep);      
            return $test;
        }
        else 
            return false;
    }

    function supprime_article($id)
    {
        global $connexion;

        $requete = "DELETE FROM article WHERE id = " . $id;
        $resultats = mysqli_query($connexion, $requete);

        return $resultats;
    }

    function obtenir_article_par_recherche($contenu)
    {
        global $connexion;

        $requete = "SELECT titre, texte, auteur FROM article WHERE titre LIKE ? OR texte LIKE ? ";
        $contenu = "%" . $contenu . "%";
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            mysqli_stmt_bind_param($reqPrep, "ss", $contenu, $contenu);
            mysqli_stmt_execute($reqPrep);
            $resultats = mysqli_stmt_get_result($reqPrep);
            return $resultats;
        }
        else 
            return false;
    }

    function login($nom, $mot_passe)
    {
        global $connexion;

        $requete = "SELECT nom, mot_passe FROM usager WHERE nom = ?";
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            mysqli_stmt_bind_param($reqPrep, "s", $nom);
            mysqli_stmt_execute($reqPrep);
            $resultats = mysqli_stmt_get_result($reqPrep);

            if(mysqli_num_rows($resultats) > 0)
            {
                $rangee = mysqli_fetch_assoc($resultats);
                $test = password_verify($mot_passe, $rangee["mot_passe"]);
                
                if($test)
                {
                    return $rangee["nom"];
                }
                else 
                    return false;
            }
            else 
                return false;
        }
        else 
            die("Erreur mysqli.");
    }

    function recherche_article($texte)
    {
        global $connexion;

        $recherche = "%$texte%";
        $requete = "SELECT id, titre, texte, auteur
                    FROM article 
                    WHERE titre LIKE ? OR texte LIKE ?";
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            mysqli_stmt_bind_param($reqPrep, "ss", $recherche, $recherche);

            mysqli_stmt_execute($reqPrep);

            $resultats = mysqli_stmt_get_result($reqPrep);
            return $resultats;
        }
        else 
            die("Erreur mysqli.");
    }
    