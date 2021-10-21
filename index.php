<?php 
    require_once 'fonctions.php'; 

    // On détermine sur quelle page on se trouve
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }
    $nbArticles = NbMag();
    // On détermine le nombre d'articles par page
    $parPage = 10;
    // On calcule le nombre de pages total
    $pages = ceil($nbArticles / $parPage);
    // Calcul du 1er article de la page
    $premier = ($currentPage * $parPage) - $parPage;

    //on récupère tous les magazines
    $magazines = ChargeMag($premier, $parPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazines</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
        <div class="col-md-1 col-lg-1 divLeft d-flex align-items-center justify-content-end position-relative p-0"></div>
        <div class="col-xs-12 col-md-10 col-lg-10 bgRow">
            <div class="row bgGrey">
                <div><h1>Magazines</h1></div>
            </div>
            <div class="row bgRow">
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between  p-2">
                    <a href="ajouter.php">Ajouter un magazine</a>
                    <a href="init.php" onclick="return confirm('êtes-vous sûr?');">Réinitialiser la base magazine</a>
                    <a href="ChargeBaseMagazines.php" onclick="return confirm('êtes-vous sûr?');">Charger la base magazine</a>
                    </div>
                    <!-- <?php echo AfficherMagazines(); ?> -->
                    <table class="tabM">      
                        <tr>      
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>image</th>
                            <th>Editeur</th>
                        </tr>
                        <?php 
                            // affichage du contenu de la table
                            echo ChargeTableauMag($magazines);
                            ?>
                    </table>
                    <nav>
                    <ul class="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                          <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                          <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>       
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-lg-1 divRight d-flex align-items-center justify-content-end position-relative p-0"></div>
        </div>
    </div>
</body>
</html>

<?php 
echo deconnexion(); 
?>

