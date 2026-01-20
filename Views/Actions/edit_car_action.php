<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: no_access");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $pret = mysqli_real_escape_string($conn, $_POST['pret']);

    // Verificăm dacă a fost încărcată o poză nouă
    if (!empty($_FILES['poza_noua']['name'])) {
        $nume_poza = $_FILES['poza_noua']['name'];
        $temp_poza = $_FILES['poza_noua']['tmp_name'];
        $destinatie = "Uploads/" . $nume_poza;

        if (move_uploaded_file($temp_poza, $destinatie)) {
            // Actualizăm modelul, prețul si imaginea
            $sql = "UPDATE masini SET model='$model', pret_pornire='$pret', imagine='$nume_poza' WHERE id=$id";
        }
    } else {
        // Dacă nu a pus poză nouă, actualizăm doar textul
        $sql = "UPDATE masini SET model='$model', pret_pornire='$pret' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: home");
        exit();
    } else {
        echo "Eroare: " . mysqli_error($conn);
    }
}
?>