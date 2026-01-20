<?php
session_start();
require_once 'Config/db.php';

// Preluăm pagina din URL
$pagina = isset($_GET['url']) ? $_GET['url'] : 'home';

include 'Includes/header.php';

// Subfolderele tale din Views
$subfoldere = ['Actions', 'UserAdmin', 'UserPublic'];
$fisier_gasit = false;

// Căutăm fișierul în fiecare subfolder
foreach ($subfoldere as $sub) {
    $cale = "Views/" . $sub . "/" . $pagina . ".php";
    
    if (file_exists($cale)) {
        include $cale;
        $fisier_gasit = true;
        break; 
    }
}

// Eroare 404
if (!$fisier_gasit) {
    echo "<div class='container' style='text-align:center; padding:50px;'>";
    echo "<h2>Eroare 404</h2>";
    echo "<p>Pagina '<strong>" . htmlspecialchars($pagina) . "</strong>' nu există.</p>";
    echo "</div>";
}

include 'Includes/footer.php';
?>