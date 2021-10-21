<?php
    require_once 'fonctions.php'; 

    // Vérifie que les données proviennent bien d'un formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifie que les données ne sont pas vides
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        /* */
        $flag = true;
        $FlagDesc = "";
        /* test de l'ID magazine */
        if ((!isset($_POST["id"])) or (empty($_POST["id"]))) {
            $flag = false;
            $FlagDesc = $FlagDesc. " ID Magazine ";
        }
        if ((!isset($_POST["nom"])) or (empty($_POST["nom"]))) {
            $flag = false;
            $FlagDesc = $FlagDesc. " nom ";
        }
        if ((!isset($_POST["desc"])) or (empty($_POST["desc"]))) {
            $flag = false;
            $FlagDesc = $FlagDesc. " description ";
        }       
        if ((!isset($_POST["prix"])) or (empty($_POST["prix"]))) {
            $flag = false;
        }
        if ((!isset($_POST["editeur"])) or (empty($_POST["editeur"]))) {
            $flag = false;
            $FlagDesc = $FlagDesc. " editeur ";
        }
        if (!$flag){
            die("Veuillez saisir ". $FlagDesc);
        } else {
            // Vérifie l'existance du fichier image
            if(isset($_FILES['file'])){
                /* traitement de l'image */ 
                $tmpName = $_FILES['file']['tmp_name'];
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $error = $_FILES['file']['error']; 
    
                $tabExtension = explode('.', $name);
                $extension = strtolower(end($tabExtension));
            
                $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                $maxSize = 4 * 1024 * 1024;
    
                if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){

                    $idmag = $_POST["id"];
                    $nom = $_POST["nom"];
                    $nom = htmlentities($nom);
                    $desc = $_POST["desc"];
                    $desc = htmlentities($desc);
                    $prix = $_POST["prix"];
                    $editeur = $_POST["editeur"];
                    /* constitution du nom d'un nom temporaire pour le fichier image*/ 
                    $file = "tmp"; // nom temporaire en attendant d'avoir l'ID du magazine

                    $db = connexion();
                    /* requete de mise à jour */
                    $sql = 'UPDATE magazines SET nom=:nom, description=:desc, prix=:prix, image=:pict, idediteur_fk=:editeur';
                    $sql = $sql. ' WHERE idmagazines='. $idmag;
                    $req = $db->prepare($sql);
                    /* constitution du nom du fichier */
                    $fileName = strtolower($nom);
                    $fileNameStr = str_replace(' ', '', $fileName);
                    $file = $fileNameStr. $idmag. ".". $extension;
                    /* */
                    move_uploaded_file($tmpName, 'assets/uploads/'.$file);
                    /* mise à jour du nom du fichier dans la table magazines */
                    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
                    $req -> bindValue(':desc', $desc, PDO::PARAM_STR);
                    $req -> bindValue(':pict', $file, PDO::PARAM_STR);
                    $req -> bindValue(':prix', $prix, PDO::PARAM_STR);
                    $req -> bindValue(':editeur', $editeur, PDO::PARAM_INT);
                    /* */
                    $req->execute();
                    /* */
                    header('Location: index.php');
                }
                else{
                    echo "Une erreur est survenue";
                }
    
            }
        }
    
      }
?>