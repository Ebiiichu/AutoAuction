<?php
// Protecție: Doar adminul are voie să ruleze aceste acțiuni
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: no_access");
    exit();
}

// Verificăm dacă avem parametrii necesari în URL
if (isset($_GET['act']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $actiune = $_GET['act'];
    $sql = ""; // Inițializăm variabila pentru a evita eroarea "Undefined variable"

    // Stabilim comanda SQL în funcție de acțiune
    if ($actiune === 'delete') {
        $sql = "DELETE FROM utilizatori WHERE id = $id";
    } elseif ($actiune === 'make_admin') {
        $sql = "UPDATE utilizatori SET rol = 'admin' WHERE id = $id";
    } elseif ($actiune === 'make_user') {

        $sql = "UPDATE utilizatori SET rol = 'user' WHERE id = $id";
    }

    // Executăm comanda doar dacă $sql a fost populat
    if ($sql !== "") {
        if (mysqli_query($conn, $sql)) {
            // Redirecționare succes înapoi la profil
            header("Location: profile");
            exit();
        } else {
            echo "Eroare la baza de date: " . mysqli_error($conn);
        }
    } else {
        echo "Acțiune necunoscută!";
    }
} else {
    header("Location: profile");
    exit();
}
?>