<?php
// 1. Verificare Admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: no_access");
    exit();
}

// 2. Verificăm dacă datele vin prin POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $pret = mysqli_real_escape_string($conn, $_POST['pret']);
    $descriere = mysqli_real_escape_string($conn, $_POST['descriere']);

    // Logica pentru fișier 
    $nume_poza = $_FILES['poza']['name'];
    $temp_poza = $_FILES['poza']['tmp_name'];
    $folder_destinatie = "Uploads/" . $nume_poza;

    if (move_uploaded_file($temp_poza, $folder_destinatie)) {
        // SQL Insert
        $sql = "INSERT INTO masini (model, pret_pornire, descriere, imagine) 
                VALUES ('$model', '$pret', '$descriere', '$nume_poza')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: home"); 
            exit();
        } else {
            echo "Eroare SQL: " . mysqli_error($conn);
        }
    } else {
        echo "Eroare: Nu s-a putut încărca imaginea în folderul Uploads.";
    }
}
?>