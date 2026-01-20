<?php
// Doar adminul poate accesa această pagină
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acces interzis! Doar administratorii pot adăuga mașini.");
}

// Procesare formular (Când se apasă butonul "Salvează")
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preluăm câmpurile actualizate (fără model)
    $firma = mysqli_real_escape_string($conn, $_POST['firma']); // Aici vei scrie ex: "BMW Seria 3"
    $submodel = mysqli_real_escape_string($conn, $_POST['submodel']);
    
    $an = (int)$_POST['an'];
    $pret = (float)$_POST['pret_pornire'];
    $descriere = mysqli_real_escape_string($conn, $_POST['descriere']);
    $motorizare = mysqli_real_escape_string($conn, $_POST['motorizare']);
    $kilometri = (int)$_POST['kilometri'];

    // Gestionare Imagine
    $nume_imagine = $_FILES['imagine']['name'];
    $target = "Uploads/" . basename($nume_imagine);

    if (move_uploaded_file($_FILES['imagine']['tmp_name'], $target)) {
        $sql = "INSERT INTO masini (firma, submodel, an, pret_pornire, descriere, imagine, motorizare, kilometri) 
                VALUES ('$firma', '$submodel', '$an', '$pret', '$descriere', '$nume_imagine', '$motorizare', '$kilometri')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green; font-weight:bold;'>✔️ Mașina $firma a fost adăugată cu succes!</p>";
        } else {
            echo "<p style='color:red;'>Eroare SQL: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Eroare la încărcarea imaginii!</p>";
    }
}
?>

<h2 style="border-bottom: 2px solid var(--primary); padding-bottom: 10px;">Adaugă Mașină Nouă</h2>

<form action="add_car" method="POST" enctype="multipart/form-data" style="display: grid; gap: 15px; max-width: 800px; margin-top: 20px;">
    
    <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Marca și Model (Firma):</label>
            <input type="text" name="firma" placeholder="Ex: BMW Seria 3" required style="width: 100%; padding: 8px;">
        </div>
        <div style="flex: 1;">
            <label>Submodel / Variantă:</label>
            <input type="text" name="submodel" placeholder="Ex: M-Sport / 320d" required style="width: 100%; padding: 8px;">
        </div>
    </div>

    <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>An Fabricație:</label>
            <input type="number" name="an" min="1900" max="2026" required style="width: 100%; padding: 8px;">
        </div>
        <div style="flex: 1;">
            <label>Kilometraj (km):</label>
            <input type="number" name="kilometri" min="0" required style="width: 100%; padding: 8px;">
        </div>
        <div style="flex: 1;">
            <label>Motorizare:</label>
            <select name="motorizare" required style="width: 100%; padding: 8px;">
                <option value="Benzina">Benzină</option>
                <option value="Diesel">Diesel</option>
                <option value="Electrica">Electrică</option>
            </select>
        </div>
    </div>

    <div>
        <label>Preț Pornire (€):</label>
        <input type="number" name="pret_pornire" step="0.01" required style="width: 100%; padding: 8px;">
    </div>

    <div>
        <label>Descriere Detaliată:</label>
        <textarea name="descriere" rows="5" required style="width: 100%; padding: 8px;"></textarea>
    </div>

    <div>
        <label>Imagine Mașină:</label>
        <input type="file" name="imagine" accept="image/*" required>
    </div>

    <input type="submit" value="Salvează Mașina în Licitație" style="background: var(--primary); color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 10px;">
</form>