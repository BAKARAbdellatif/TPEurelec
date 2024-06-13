<?php
include_once 'helper.php';
$page = (isset($_POST['page'])) ? $_POST['page'] : 1;
$sqlcount = 'SELECT COUNT(DISTINCT P.id) as count FROM produits P JOIN fournisseurs F ON P.id_fournisseur=F.id LEFT OUTER JOIN photos PH ON P.id=PH.id_produit';
$db_connexion = getConnexion();
$stmtCount = $db_connexion->prepare($sqlcount);
$stmtCount->execute();
$count = $stmtCount->fetch(PDO::FETCH_ASSOC)['count'];
$current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$results_per_page = 2400;
$total_pages = ceil($count / $results_per_page);
$offset = ($current_page - 1) * $results_per_page;
$pagination = getPaginate($current_page, $total_pages);
$sql = "SELECT DISTINCT P.id, P.nom, P.prix, F.nom AS fournisseur_nom, F.contact, PH.url FROM produits P 
            JOIN fournisseurs F ON P.id_fournisseur=F.id
            LEFT OUTER JOIN photos PH ON P.id=PH.id_produit LIMIT $offset, $results_per_page";

$stmt = $db_connexion->prepare($sql);
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);


$items = '';
foreach ($produits as $produit) {
    $items .= "<div class='card' style='width: 18rem;'><img src='./photo.png' class='card-img-top' 
    alt='produit'><div class='card-body'><h4 class='card-title'>" . $produit['nom'] . "</h4>
    <h5>" . $produit['prix'] . " Dh</h5><a href='#' class='btn btn-primary'>Action</a></div>
</div>";
}

echo $items;
