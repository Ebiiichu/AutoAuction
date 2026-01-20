<?php
// Verificăm permisiunile de acces - PHP Vanilla
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Redirecționare la nivel de protocol HTTP
    header("Location: no_access");
    exit();
}

// Procesarea ștergerii (Logica de Business)
if (isset($_GET['id'])) {
    // Curata datele primite prin URL pentru securitate
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Comanda SQL de ștergere (delete din CRUD)
    $sql = "DELETE FROM masini WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Dacă ștergerea a reușit, trimitem utilizatorul direct pe Home
        header("Location: home");
        exit();
    } else {
        // Aceasta este singura situație unde afișăm ceva (doar dacă e eroare SQL)
        echo "Eroare la ștergere: " . mysqli_error($conn);
    }
} else {
    // Dacă cineva accesează pagina fără un ID, îl trimitem înapoi
    header("Location: home");
    exit();
}
?>