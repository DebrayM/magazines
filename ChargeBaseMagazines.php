<?php
require_once 'vendor\autoload.php';
require_once 'fonctionsChargement.php';

$faker = Faker\Factory::create('fr_FR');

$dir = "assets/uploads";
$width = "300";
$height = "600";

// conection à la base de données Magazines
$db = connexion();

for ($i=0; $i < 25; $i++): 

    //Crée une occurence dans le fichier Editeur
    $req = $db->prepare("INSERT INTO editeur (nomediteur) VALUES (:nom)");
    $req -> bindValue(':nom', $faker->company, PDO::PARAM_STR);
    $req->execute();
    //récupère le n° de la dernière occurence créée
    $sql = "SELECT idediteur FROM editeur ORDER BY idediteur DESC LIMIT 1";
    $req = $db->query($sql);
    $result = $req->fetch();
    $idocc = intval($result["idediteur"]);
    /*var_dump($idocc);*/

    for ($y=0; $y < 15; $y++):
    
    $req = $db->prepare("INSERT INTO magazines (nom, description, prix, image, idediteur_fk) VALUES (:nom, :desc, :prix, :pict, :editeur)");
    /* */
    $req -> bindValue(':nom', $faker->company, PDO::PARAM_STR);
    $req -> bindValue(':desc', $faker->text(), PDO::PARAM_STR);
    $req -> bindValue(':pict', $faker->imageUrl($width, $height, 'cats'), PDO::PARAM_STR);
    $req -> bindValue(':prix', $faker->numberBetween(5, 25), PDO::PARAM_STR);
    $req -> bindValue(':editeur', $idocc, PDO::PARAM_INT);
    /* */
    $req->execute();
    endfor;

endfor;

// conection de la base de données Magazines
echo deconnexion();

header('Location: index.php');
?>