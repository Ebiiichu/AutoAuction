<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acces interzis!");
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firma = mysqli_real_escape_string($conn, $_POST['firma']);
    $submodel = mysqli_real_escape_string($conn, $_POST['submodel']);
    $an = (int)$_POST['an'];
    $pret = (float)$_POST['pret_pornire'];
    $descriere = mysqli_real_escape_string($conn, $_POST['descriere']);
    $motorizare = mysqli_real_escape_string($conn, $_POST['motorizare']);
    $kilometri = (int)$_POST['kilometri'];

    // Logica pentru Imagine
    if (!empty($_FILES['imagine']['name'])) {
        $nume_imagine = $_FILES['imagine']['name'];
        $target = "Uploads/" . basename($nume_imagine);
        
        if (move_uploaded_file($_FILES['imagine']['tmp_name'], $target)) {
            // Actualizăm tot, inclusiv imaginea
            $sql_update = "UPDATE masini SET 
                            firma = '$firma', submodel = '$submodel', an = '$an', 
                            pret_pornire = '$pret', descriere = '$descriere',
                            motorizare = '$motorizare', kilometri = '$kilometri',
                            imagine = '$nume_imagine' 
                           WHERE id = '$id'";
        }
    } else {
        // Dacă nu am încărcat poză nouă, imaginea rămâne neschimbată
        $sql_update = "UPDATE masini SET 
                        firma = '$firma', submodel = '$submodel', an = '$an', 
                        pret_pornire = '$pret', descriere = '$descriere',
                        motorizare = '$motorizare', kilometri = '$kilometri'
                       WHERE id = '$id'";
    }

    if (mysqli_query($conn, $sql_update)) {
        echo "<div style='background: #eaffea; color: #27ae60; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #27ae60; font-weight: bold;'>✔️ Mașina a fost actualizată cu succes!</div>";
    }
}

$rezultat = mysqli_query($conn, "SELECT * FROM masini WHERE id = '$id'");
$m = mysqli_fetch_assoc($rezultat);
?>

<h2 style="border-bottom: 2px solid var(--primary); padding-bottom: 10px;">Editează Mașina: <?php echo htmlspecialchars($m['firma']); ?></h2>

<form action="edit_car?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" style="display: grid; gap: 15px; max-width: 800px; margin-top: 20px;">
    
    <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Marca și Model (Firma):</label>
            <input type="text" name="firma" value="<?php echo htmlspecialchars($m['firma']); ?>" required style="width: 100%; padding: 8px;">
        </div>
        <div style="flex: 1;">
            <label>Submodel / Variantă:</label>
            <input type="text" name="submodel" value="<?php echo htmlspecialchars($m['submodel']); ?>" required style="width: 100%; padding: 8px;">
        </div>
    </div>

    <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>An:</label>
            <input type="number" name="an" value="<?php echo $m['an']; ?>" required style="width: 100%; padding: 8px;">
        </div>
        <div style="flex: 1;">
            <label>KM:</label>
            <input type="number" name="kilometri" value="<?php echo $m['kilometri']; ?>" required style="width: 100%; padding: 8px;">
        </div>
        <div style="flex: 1;">
            <label>Motor:</label>
            <select name="motorizare" required style="width: 100%; padding: 8px;">
                <option value="Benzina" <?php if($m['motorizare'] == 'Benzina') echo 'selected'; ?>>Benzină</option>
                <option value="Diesel" <?php if($m['motorizare'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
                <option value="Electrica" <?php if($m['motorizare'] == 'Electrica') echo 'selected'; ?>>Electrică</option>
            </select>
        </div>
    </div>

    <div>
        <label>Preț actual (€):</label>
        <input type="number" name="pret_pornire" value="<?php echo $m['pret_pornire']; ?>" step="0.01" required style="width: 100%; padding: 8px;">
    </div>

    <div>
        <label>Imagine curentă:</label><br>
        <img src="Uploads/<?php echo $m['imagine']; ?>" style="width: 150px; border-radius: 5px; margin-bottom: 10px;"><br>
        <label>Schimbă imaginea (lasă gol dacă nu vrei să o schimbi):</label>
        <input type="file" name="imagine" accept="image/*">
    </div>

    <div>
        <label>Descriere:</label>
        <textarea name="descriere" rows="5" required style="width: 100%; padding: 8px;"><?php echo htmlspecialchars($m['descriere']); ?></textarea>
    </div>

    <div style="display: flex; gap: 15px;">
        <input type="submit" value="Actualizează Datele" style="background: var(--primary); color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; flex: 1;">
        <a href="licitatii" style="background: #7f8c8d; color: white; padding: 12px; text-decoration: none; border-radius: 5px; text-align: center; flex: 1;">Anulează</a>
    </div>
</form>