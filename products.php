<?php
include_once "helper.php";
?>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="./jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    $sqlcount = "SELECT COUNT(DISTINCT P.id) as count FROM produits P JOIN fournisseurs F ON P.id_fournisseur=F.id LEFT OUTER JOIN photos PH ON P.id=PH.id_produit";
    $db_connexion = getConnexion();
    $stmtCount = $db_connexion->prepare($sqlcount);
    $stmtCount->execute();
    $count = $stmtCount->fetch(PDO::FETCH_ASSOC)['count'];
    $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $results_per_page = 10;
    $total_pages = ceil($count / $results_per_page);
    $offset = ($current_page - 1) * $results_per_page;
    $pagination = getPaginate($current_page, $total_pages);
    $sql = "SELECT DISTINCT P.id, P.nom, P.prix, F.nom AS fournisseur_nom, F.contact, PH.url FROM produits P 
            JOIN fournisseurs F ON P.id_fournisseur=F.id
            LEFT OUTER JOIN photos PH ON P.id=PH.id_produit LIMIT $offset, $results_per_page";

    $stmt = $db_connexion->prepare($sql);
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db_connexion = null;
    ?>

    <div class="container-fluid p-4">
        <h2>Liste des produits</h2>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Fournisseur</th>
                    <th>Contact</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $item) { ?>
                    <tr>
                        <td><?php echo $item['id'] ?></td>
                        <td><?= $item['nom'] ?></td>
                        <td><?= $item['prix'] ?></td>
                        <td><?= $item['fournisseur_nom'] ?></td>
                        <td><?= $item['contact'] ?></td>
                        <td><?= $item['url'] ?></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="pagiantion"> <?php echo $pagination; ?></div>
</body>

</html>

<script>
    $(document).ready(function() {

    })
</script>