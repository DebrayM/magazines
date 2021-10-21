<?php 
    require_once 'fonctions.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazines - Editer les magazines</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="../assets/js/code.js" async></script>
</head>
<body>
<div class="container-fluid">
    <div class="row min-vh-100">
        <div class="col-md-1 col-lg-2 divLeft d-flex align-items-center justify-content-end position-relative p-0"></div>
            <div class="col-xs-12 col-md-10 col-lg-8 bgRow">
                <div class="row bgGrey">
                    <div>
                        <h1>Magazines</h1>
                        <h2>Modifier un magazine</h2>
                    </div>
                 </div>
                <!-- colonne centrale -->
                <div class="row bgRow">
                    <!-- container central -->
                    <div class="col-xs-12 col-md-8 col-lg-8 d-flex flex-column justify-content-center">
                        <form  action="update.php" method="post" enctype= "multipart/form-data" id="formInsert">
                            <div class="d-flex flex-column">
                                <!-- réception de l'ID du magazine a éditer -->
                                <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                        // Vérifie que les données ne sont pas vides
                                        $flag = true;
                                        if ((!isset($_GET["id"])) or (empty($_GET["id"]))) {
                                            $flag = false;
                                        }
                                        if($flag){
                                            // chargement des données du magazine dans le formulaire //
                                            echo uploadForm($_GET["id"]);

                                        }
                                    }
                                ?>
                            </div>
                            <div class="d-flex align-items-center justify-content-end p-3">
                                <label for="file">Photo du magazine</label>
                                <input type="file" name="file" id="file" required  onchange="preview()">
                            </div>
                            <div class="d-flex align-items-center justify-content-center p-3">
                                <input type="submit" class="styled" value="Mettre à jour"/>
                            </div>                
                        </form>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 d-flex align-items-center justify-content-center p-0">
                    <?php
                            echo uploadImage($_GET["id"]);
                        ?>
                    </div>
                </div>
            </div>
        <div class="col-md-1 col-lg-2 divRight d-flex align-items-center justify-content-center position-relative p-0">
            <a href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                    <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"/>
                    <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/>
                </svg>
            </a>
        </div>
    </div>
</div>
</body>
</html>