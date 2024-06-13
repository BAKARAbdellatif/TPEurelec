<?php

include_once "helper.php";

$db_connexion = getConnexion();
$sql = "SELECT DISTINCT P.id, P.nom, P.prix, F.nom AS fournisseur_nom, F.contact FROM produits P 
JOIN fournisseurs F ON P.id_fournisseur=F.id
LEFT OUTER JOIN photos PH ON P.id=PH.id_produit;";
$stmt = $db_connexion->prepare($sql);
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($produits as $produit) {
    echo $produit['nom'];
}
