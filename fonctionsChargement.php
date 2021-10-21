<?php

function connexion() {
    //Tentative de connexion :
        try{
            $host = 'mysql:host=localhost;dbname=magazines';
            $username = 'root';
            $password = '';
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", /*Charset utf8 pour qu'on ait le même jeu de caractère entre le HTML et PDO */
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC , /*Mode par défaut des données qu'on reçoit : tableaux associatif*/
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING /*Si une erreur se produit, on aimerait bien que le pdo nous la signale */
            );
            $db = new PDO($host, $username, $password, $options); //Connexion
            return $db;
        }
        
        catch (PDOException $e)
        {
            die('<p>Une erreur est détectée : ' .$e->getMessage() . '</p>'); //On récupère le signalement de l'erreur.
        }
}

function deconnexion(){
    global $db, $requete;
    $db = null;
    $requete = null;
    return '<p>Deconnexion effectuée </p>';
}


/* pour l'initialisation de la base de données */
function initBaseMagazine(){
    // conection à la base de données Magazines
    $db = connexion();
    // supprimer les données des tables
    //"DELETE FROM magazines;"
    //"DELETE FROM editeur;"
    $req = $db->query("DELETE FROM magazines;");
    var_dump("del ", $req);
    $req = $db->query("DELETE FROM editeur;");
    var_dump("del ", $req);
    // supprimer les tables
    //"DROP TABLE magazines;"
    //"DROP TABLE editeur;"
    $req = $db->query("DROP TABLE magazines;");
    var_dump("drop ", $req);
    $req = $db->query("DROP TABLE editeur;");
    var_dump("drop ", $req);

    //******************** */
    // Création des tables
    //******************** */

    //-- Structure de la table editeur
    $sql = "CREATE TABLE editeur (
        idediteur int(11) NOT NULL,
        nomediteur varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $req = $db->query($sql);
    var_dump("create ", $req);

    //-- Index pour la table editeur //
    $sql = "ALTER TABLE editeur ADD PRIMARY KEY (idediteur);";
    $req = $db->query($sql);
    var_dump("index ", $req);

    //-- AUTO_INCREMENT pour la table editeur
    $sql = "ALTER TABLE editeur
    MODIFY idediteur int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    $req = $db->query($sql);
    var_dump("auto-increment ", $req);

    //-- Structure de la table magazines//
    $sql = "CREATE TABLE magazines (
        idmagazines int(11) NOT NULL,
        nom varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        description varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        prix varchar(20) COLLATE utf8_unicode_ci NOT NULL,
        image varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        idediteur_fk int(11) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
     $req = $db->query($sql);
     var_dump("create ", $req);

    //-- Index pour la table magazines //
    $sql = "ALTER TABLE magazines ADD PRIMARY KEY (idmagazines);";
    $req = $db->query($sql);
    var_dump("index ", $req);

    //-- AUTO_INCREMENT pour la table magazines
    $sql = "ALTER TABLE magazines
    MODIFY idmagazines int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    $req = $db->query($sql);
    var_dump("auto-increment ", $req);

}

?>