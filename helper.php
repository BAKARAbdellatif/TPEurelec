<?php


function getConnexion()
{
    // Paramètres de connexion
    $host = '127.0.0.1'; // Adresse de l'hôte (localhost ou adresse IP)
    $db = 'ajax'; // Nom de la base de données
    $user = 'root'; // Nom d'utilisateur
    $pass = ''; // Mot de passe
    $charset = 'utf8mb4'; // Jeu de caractères

    // DSN (Data Source Name) de la connexion
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    // Options PDO
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Gérer les erreurs en mode exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mode de récupération des résultats par défaut
        PDO::ATTR_EMULATE_PREPARES => false, // Désactiver l'émulation des requêtes préparées pour des raisons de sécurité
    ];

    try {
        // Créer une nouvelle instance PDO
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Capturer et afficher les erreurs de connexion
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}


function getPaginate($current_page, $total_pages)
{
    $pagination_html = '<nav aria-label="Page navigation"><ul class="pagination">';

    // First page link
    $pagination_html .= '<li class="page-item text-primary' . ($current_page <= 1 ? ' disabled' : '') . '"><a class="page-link text-primary" href="?page=1">First</a></li>';

    // Previous page link
    $pagination_html .= '<li class="page-item text-primary' . ($current_page <= 1 ? ' disabled' : '') . '"><a class="page-link text-primary" href="?page=' . ($current_page - 1) . '">Previous</a></li>';

    // Page links with ellipsis
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 3);
    if ($start_page > 1) $pagination_html .= '<li class="page-item disabled"><a class="page-link">...</a></li>';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $active = ($current_page == $i) ? ' bg-primary' : '';
        $text_color = ($current_page == $i) ? "text-white " : "text-primary ";
        $pagination_html .= '<li class="page-item text-' . $text_color . '"><a class="page-link ' . $text_color . $active . '" href="?page=' . $i . '">' . $i . '</a></li>';
    }
    if ($end_page < $total_pages) $pagination_html .= '<li class="page-item disabled"><a class="page-link">...</a></li>';

    // Next page link
    $pagination_html .= '<li class="page-item text-primary' . ($current_page >= $total_pages ? ' disabled' : '') . '"><a class="page-link text-primary" href="?page=' . ($current_page + 1) . '">Next</a></li>';

    // Last page link
    $pagination_html .= '<li class="page-item text-primary' . ($current_page >= $total_pages ? ' disabled' : '') . '"><a class="page-link text-primary" href="?page=' . $total_pages . '">Last</a></li>';

    $pagination_html .= '</ul></nav>';

    return $pagination_html;
}
