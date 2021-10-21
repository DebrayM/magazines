<?php
    require_once 'fonctions.php'; 
    
    // Vérifie que les données proviennent bien d'un formulaire
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Vérifie que l'ID projet est bien passé en paramètre
        $id = $_GET["id"];
        /*var_dump($id);*/ 
        /* */
        $db = connexion();
        /* etape 1 : rechercher le nom de l'image */
        $query = "SELECT image FROM magazines WHERE idmagazines =". $id;
        $req = $db->query($query);
        while($data = $req->fetch()){
            $file = $data['image'];
        }
        /* etape 2 : construire la variable fichier à supprimer */
        $filesuppr = 'assets/uploads/'. $file;
        /* etape 3 : supprimer la référence dans la table */
        $query = "DELETE FROM magazines WHERE idmagazines =". $id;
        $req = $db->prepare($query);
        $req->execute();

        $count = $req->rowCount();
        /* print('Effacement de ' .$count. ' entrée(s).'); */
        /* etape 4 : supprimer le fichier image */
        if ($count>0){
            /* supprimer le fichier*/
            unlink($filesuppr);
            echo "Image supprimée de la base et du répertoire upload";
        }
    }
    header('Location: index.php');
?>