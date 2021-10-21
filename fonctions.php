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
    return 'Déconnexion effectuée';
}

// Afficher les magazines
function AfficherMagazines(){
    $db = connexion();
    // sélection des magazines avec les noms des éditeurs
    $sql = "SELECT * FROM editeur INNER JOIN magazines ON editeur.idediteur = magazines.idediteur_fk;";

    $req = $db->query($sql);
    $results = $req->fetchAll();
    /* */
    /*$tabMag = selectMagazinesEditeur("");*/    
    /* création de l'entête du tableau*/
    $tabEntete = "<tr><th>ID</th>
    <th>Nom</th>
    <th>Description</th>
    <th>Prix</th>
    <th>image</th>
    <th>Editeur</th></tr>";
    /* création du tableau */
    $tabMagazine = '<table class="tabM">'. $tabEntete;

    /* var_dump($results); */
    foreach($results as $row){
        $lgn = "<tr><td>". $row['idmagazines']. "</td>";
        $lgn = $lgn. "<td>". $row['nom']. "</td>";
        $lgn = $lgn. "<td>". $row['description']. "</td>";
        $lgn = $lgn. "<td>". $row['prix']. "</td>";

        $url = substr($row['image'], 0, 4);
        $test = "http";
        /* var_dump($test, $url); */
       
        if ($url == $test){
            $lgn = $lgn. '<td><img class="card" src="'. $row['image']. '"/></td>';
        }else {
            $lgn = $lgn. '<td><img c src="'. 'assets/uploads/'. $row['image']. '"/></td>';
        }
        $lgn = $lgn. '<td><a href="formEditeur.php?id='. $row['idediteur']. '">'. $row['nomediteur']. '</a></td></tr>';
        $action = "<tr><td></td><td></td>";
        $action = $action. '<td><ul>';
        $action = $action. '<li><a href="detail.php?id='. $row['idmagazines']. '">Voir le détail</a></li>';
        $action = $action. '<li><a href="editer.php?id='. $row['idmagazines']. '">Editer</a></li>';
        $action = $action. '<li><a href="supprimer.php?id='. $row['idmagazines']. '" onclick="return confirm(\'êtes-vous sûr?\');">Supprimer</a></li>';
        $action = $action. '</ul><class="card"/td>';
        $action = $action. "<td></td><td></td><td></td></tr>";
 
        /* ajout de la ligne "magazine" dans le tableau */
        $tabMagazine = $tabMagazine. $lgn;
        /* ajout de la ligne "actions sur le magazine" dans le tableau */
        $tabMagazine = $tabMagazine. $action;
    }  
    /* finalisation du tableau */
    $tabMagazine = $tabMagazine. '</table>';
    return $tabMagazine;
}

function editeurs($eId){
    $db = connexion();
    if ((!isset($eId)) or (empty($eId))) {
        $listOptions = '<option value="1" selected>Editeur inconnu</option>';
    }else{
        $listOptions = "";
    }
    $req = $db->query("SELECT * FROM editeur");
    $results = $req->fetchAll();
    foreach($results as $row){
        if (($row['idediteur'] == $eId) and (!empty($eId))) {
            $listOptions = $listOptions. '<option value="'. $row['idediteur']. '" selected>'. $row['nomediteur']. '</option>';
        } else{
            $listOptions = $listOptions. '<option value="'. $row['idediteur']. '">'. $row['nomediteur']. '</option>';
        }
    }
    return $listOptions;
}

function uploadForm($m){
    $db = connexion();
    //* sélection des magazines avec les noms des éditeurs */
    $sql = 'SELECT * FROM editeur INNER JOIN magazines ON editeur.idediteur = magazines.idediteur_fk';
    $sql = $sql. ' WHERE idmagazines="'. $m. '";';
    $data = $db->query($sql);
    $form = "";
    // chargement du formulaire //
    foreach($data as $row) {
    $form = $form.'<label for="id">ID</label>';
    $form = $form.'<input type="text" name="id" id="idmagazines" required size="11"';
    $form = $form.' value = "'. $row['idmagazines']. '">';
    $form = $form.'<label for="nom">Nom</label>';
    $form = $form.'<input type="text" name="nom" id="nom" required size="255"';
    $form = $form.' value = "'. $row['nom']. '">';
    $form = $form.'<label for="desc">Description</label>';
    $form = $form.'<input type="text" name="desc" id="desc" required size="255"';
    $form = $form.' value = "'. $row['description']. '">';
    $form = $form.'<label for="prix">Prix</label>';
    $form = $form.'<input type="text" name="prix" id="prix" required size="15"';
    $form = $form.' value = "'. $row['prix']. '">';
    $form = $form.'<label for="file">Image</label>';
    $form = $form.'<input type="text" name="file" id="image" required size="255"';
    $form = $form.' value = "'. $row['image']. '">';
    // chargement du selecteur pour l'éditeur
    $select = '<label for="editeur">Editeur</label>'; 
    $select = $select. '<select name="editeur" id="editeur" size="1">';
    // traitement des options de la sélection Editeurs -->
    $select = $select. editeurs($row['idediteur_fk']);
    $select = $select.'</select>';
    // finalisation du formulaire avec ajout de la liste de sélection Editeur
    $form = $form. $select;
    } 
    return $form;
}

function voirEditeur($eId){
    $db = connexion();
    if ((!isset($eId)) or (empty($eId))) {
        return "";
    }else{
        $sql = "SELECT * FROM editeur where idediteur = " . $eId;
        $req = $db->query($sql);
        $results = $req->fetch();
        /*
        echo '<pre>';
        print_r($results);
        print_r($results['nomediteur']);
        echo '</pre>';
        */
        return $results['nomediteur'];
    }
}
function voirForm($m){
    $db = connexion();
    //* sélection des magazines avec les noms des éditeurs */
    $sql = 'SELECT * FROM editeur INNER JOIN magazines ON editeur.idediteur = magazines.idediteur_fk';
    $sql = $sql. ' WHERE idmagazines="'. $m. '";';
    $data = $db->query($sql);
    $form = "";
    // chargement du formulaire //
    foreach($data as $row) {
    $form = $form.'<label for="id">ID</label>';
    $form = $form.'<input type="text" name="id" id="idmagazines" disabled size="11"';
    $form = $form.' value = "'. $row['idmagazines']. '">';
    $form = $form.'<label for="nom">Nom</label>';
    $form = $form.'<input type="text" name="nom" id="nom" disabled size="255"';
    $form = $form.' value = "'. $row['nom']. '">';
    $form = $form.'<label for="desc">Description</label>';
    $form = $form.'<input type="text" name="desc" id="desc" disabled size="255"';
    $form = $form.' value = "'. $row['description']. '">';
    $form = $form.'<label for="prix">Prix</label>';
    $form = $form.'<input type="text" name="prix" id="prix" disabled size="15"';
    $form = $form.' value = "'. $row['prix']. '">';
    $form = $form.'<label for="file">Image</label>';
    $form = $form.'<input type="text" name="file" id="image" disabled size="255"';
    $form = $form.' value = "'. $row['image']. '">';
    $form = $form. '<label for="editeur">Editeur</label>'; 
    $form = $form. '<input type="text" name="editeur" id="editeur" disabled size="255"';
    $form = $form.' value ="'. voirEditeur($row['idediteur_fk']). '">';
    } 
    return $form;
}

function uploadImage($m){
    $db = connexion();
    //* sélection des magazines avec les noms des éditeurs */
    $sql = 'SELECT image FROM magazines WHERE idmagazines="'. $m. '"';
    $data = $db->query($sql);
    $results = $data->fetch();
    $url = substr($results['image'], 0, 4);
    $test = "http";
    /* var_dump($test, $url); */
   
    if ($url == $test){
        $form = '<img id="frame" src="'. $results['image']. '"/>';
    }else {
        $form = '<img id="frame" src="'. 'assets/uploads/'. $results['image']. '"/>';
    }
    
    return $form;
}

function chargeTableauEditeur($nEdit){

    $editeur = voirEditeur($nEdit);
    //var_dump($editeur);
    $tableau = '<table class="tabM">';
    /* légende du tableau */
    $tableau = $tableau. '<caption>'. $editeur. '</caption>';
    /* entete du tableau */
    $tableau = $tableau. '<tr><th>ID</th><th>Nom</th><th>Description</th><th>Prix</th><th>Image</th></tr>';
    /* contenu du tableau */
    $db = connexion();
    //* sélection des magazines pour un éditeur */
    $sql = "SELECT * FROM magazines WHERE idediteur_fk =". $nEdit. ";";
    $req = $db->query($sql);
    $results = $req->fetchAll();
    //var_dump($results);
    foreach($results as $row){
        $lgn = "<tr><td>". $row['idmagazines']. "</td>";
        $lgn = $lgn. "<td>". $row['nom']. "</td>";
        $lgn = $lgn. "<td>". $row['description']. "</td>";
        $lgn = $lgn. "<td>". $row['prix']. "</td>";

        $url = substr($row['image'], 0, 4);
        $test = "http";
        /* var_dump($test, $url); */
       
        if ($url == $test){
            $lgn = $lgn. '<td><img class="card" src="'. $row['image']. '"/></td>';
        }else {
            $lgn = $lgn. '<td><img class="card" src="'. 'assets/uploads/'. $row['image']. '"/></td>';
        }
        $lgn = $lgn. '</tr>';

        $tableau = $tableau. $lgn;
    }

    $tableau = $tableau. "</table>";
    return $tableau;
}

// pagination de la page index.php

function NbMag(){
    // On se connecte à là base de données
    $db = connexion();
    // On détermine le nombre total de magazines
    $sql = 'SELECT COUNT(*) AS nb_mag FROM magazines;';
    // On prépare la requête
    $query = $db->prepare($sql);
    // On exécute
    $query->execute();
    // On récupère le nombre d'articles
    $result = $query->fetch();
    $nb_mag = (int) $result['nb_mag'];
    // On se déconnecte de la base de données
    $mess = deconnexion();
    //on retourne le nombre de magazines
    return $nb_mag;
}

function ChargeMag($premier, $parPage){
    // On se connecte à là base de données
    $db = connexion();
    // sélection des magazines avec les noms des éditeurs
    $sql = 'SELECT * FROM editeur INNER JOIN magazines ON editeur.idediteur = magazines.idediteur_fk';
    $sql = $sql. ' LIMIT :premier, :parpage;';
    // On prépare la requête
    $query = $db->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    // On exécute
    $query->execute();
    // On récupère les valeurs dans un tableau associatif
    $mag = $query->fetchAll(PDO::FETCH_ASSOC);
    // On se déconnecte de la base de données
    $mess = deconnexion();

    return $mag;
}

function ChargeTableauMag($results){
    $tabMagazine ="";
    foreach($results as $row){
        $lgn = "<tr><td>". $row['idmagazines']. "</td>";
        $lgn = $lgn. "<td>". $row['nom']. "</td>";
        $lgn = $lgn. "<td>". $row['description']. "</td>";
        $lgn = $lgn. "<td>". $row['prix']. "</td>";

        $url = substr($row['image'], 0, 4);
        $test = "http";
        /* var_dump($test, $url); */
       
        if ($url == $test){
            $lgn = $lgn. '<td><img class="card" src="'. $row['image']. '"/></td>';
        }else {
            $lgn = $lgn. '<td><img c src="'. 'assets/uploads/'. $row['image']. '"/></td>';
        }
        $lgn = $lgn. '<td><a href="formEditeur.php?id='. $row['idediteur']. '">'. $row['nomediteur']. '</a></td></tr>';
        $action = "<tr><td></td><td></td>";
        $action = $action. '<td><ul>';
        $action = $action. '<li><a href="detail.php?id='. $row['idmagazines']. '">Voir le détail</a></li>';
        $action = $action. '<li><a href="editer.php?id='. $row['idmagazines']. '">Editer</a></li>';
        $action = $action. '<li><a href="supprimer.php?id='. $row['idmagazines']. '" onclick="return confirm(\'êtes-vous sûr?\');">Supprimer</a></li>';
        $action = $action. '</ul><class="card"/td>';
        $action = $action. "<td></td><td></td><td></td></tr>";
 
        /* ajout de la ligne "magazine" dans le tableau */
        $tabMagazine = $tabMagazine. $lgn;
        /* ajout de la ligne "actions sur le magazine" dans le tableau */
        $tabMagazine = $tabMagazine. $action;
    } 
    return $tabMagazine;
}

?>