<?php
// Verificăm dacă utilizatorul este logat și are rolul de 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'user') {
    die("Doar utilizatorii înregistrați pot licita!");
}

// Preluăm și curățăm datele (Sanitizare)
$id_masina = mysqli_real_escape_string($conn, $_POST['id_masina']);
$suma_noua = mysqli_real_escape_string($conn, $_POST['suma']);
$id_user = $_SESSION['user_id'];

// Verificăm prețul actual din baza de date
$interogare = mysqli_query($conn, "SELECT pret_pornire FROM masini WHERE id = $id_masina");
$date_masina = mysqli_fetch_assoc($interogare);

if ($suma_noua > $date_masina['pret_pornire']) {
    
    // Actualizăm prețul mașinii
    $sql_update_masina = "UPDATE masini SET pret_pornire = $suma_noua WHERE id = $id_masina";
    
    // Salvăm istoricul licitației
    $sql_insert_licitatie = "INSERT INTO licitatii (id_masina, id_utilizator, suma_oferita) 
                             VALUES ($id_masina, $id_user, $suma_noua)";

    // Executăm ambele comenzi SQL
    if (mysqli_query($conn, $sql_update_masina) && mysqli_query($conn, $sql_insert_licitatie)) {
        // Redirecționare imediată înapoi la pagina de licitații cu un mesaj de succes
        header("Location: licitatii?status=success");
        exit();
    } else {
        die("Eroare la procesarea licitației: " . mysqli_error($conn));
    }

} else {
    // Redirecționare înapoi în caz de eroare (sumă prea mică)
    header("Location: licitatii?status=error_sum");
    exit();
}
?>