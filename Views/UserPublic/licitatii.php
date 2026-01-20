<h2 style="border-left: 5px solid #2c3e50; padding-left: 15px; margin-bottom: 25px;">🔥 Licitații Auto Active</h2>

<div style="margin-bottom: 30px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <form action="index.php" method="GET" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <input type="hidden" name="url" value="licitatii"> 
        
        <div>
            <label style="display:block; font-weight:bold; margin-bottom:8px; font-size:0.9rem;">Căutare liberă (Marcă/Model):</label>
            <input type="text" name="search" placeholder="Scrie litere din nume..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display:block; font-weight:bold; margin-bottom:8px; font-size:0.9rem;">Motorizare:</label>
            <select name="motorizare" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; background-color: white;">
                <option value="">Oricare</option>
                <option value="Benzina" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Benzina') echo 'selected'; ?>>Benzină</option>
                <option value="Diesel" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
                <option value="Electrica" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Electrica') echo 'selected'; ?>>Electrică</option>
            </select>
        </div>

        <div>
            <label style="display:block; font-weight:bold; margin-bottom:8px; font-size:0.9rem;">An minim:</label>
            <input type="number" name="an_min" placeholder="Ex: 2010" 
                   value="<?php echo isset($_GET['an_min']) ? htmlspecialchars($_GET['an_min']) : ''; ?>" 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display:block; font-weight:bold; margin-bottom:8px; font-size:0.9rem;">Preț maxim (€):</label>
            <input type="number" name="pret_max" placeholder="Suma maximă" 
                   value="<?php echo isset($_GET['pret_max']) ? htmlspecialchars($_GET['pret_max']) : ''; ?>" 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display:block; font-weight:bold; margin-bottom:8px; font-size:0.9rem;">KM maximi:</label>
            <input type="number" name="km_max" placeholder="Max km" 
                   value="<?php echo isset($_GET['km_max']) ? htmlspecialchars($_GET['km_max']) : ''; ?>" 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
        </div>

        <div style="display: flex; gap: 10px; align-items: flex-end;">
            <button type="submit" style="background: #2c3e50; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; flex: 2; height: 45px;">🔍 Aplică</button>
            <a href="licitatii" style="background: #e74c3c; color: white; text-decoration: none; padding: 12px; border-radius: 8px; font-weight: bold; flex: 1; text-align: center; font-size: 0.8rem; height: 45px; display: flex; align-items: center; justify-content: center; box-sizing: border-box;">Reset</a>
        </div>
    </form>
</div>

<?php
// Logica de cautare independenta 
$conditii = ["1=1"]; 

if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $conditii[] = "(firma LIKE '%$search%' OR submodel LIKE '%$search%')";
}

if (!empty($_GET['motorizare'])) {
    $motor = mysqli_real_escape_string($conn, $_GET['motorizare']);
    $conditii[] = "motorizare = '$motor'";
}

if (!empty($_GET['an_min'])) {
    $an = (int)$_GET['an_min'];
    $conditii[] = "an >= $an";
}

if (!empty($_GET['pret_max'])) {
    $pret = (float)$_GET['pret_max'];
    $conditii[] = "pret_pornire <= $pret";
}

if (!empty($_GET['km_max'])) {
    $km = (int)$_GET['km_max'];
    $conditii[] = "kilometri <= $km";
}

$sql = "SELECT * FROM masini WHERE " . implode(" AND ", $conditii) . " ORDER BY id DESC";
$rezultat = mysqli_query($conn, $sql);

// Afisare rezultate
if (mysqli_num_rows($rezultat) > 0) {
    while($masina = mysqli_fetch_assoc($rezultat)) {
        // Folosim clasa 'car-card' definită în header care utilizează Flexbox pentru aliniere
        echo "<div class='car-card'>";
            
            // Adaugare preview descriere
            echo "<div class='hover-preview'>";
                echo "<strong>Specificații & Descriere:</strong><br>";
                $short_desc = mb_strimwidth($masina['descriere'], 0, 200, "...");
                echo htmlspecialchars($short_desc);
            echo "</div>";

            // Container imagine (Aliniat simetric prin Flexbox) 
            echo "<div class='car-image-container'>";
                echo "<a href='detalii?id=" . $masina['id'] . "'>";
                    echo "<img src='Uploads/" . htmlspecialchars($masina['imagine']) . "' alt='Foto Mașină'>";
                echo "</a>";
            echo "</div>";

            // Container detalii (Text centrat vertical față de imagine)
            echo "<div class='car-details'>";
                echo "<a href='detalii?id=" . $masina['id'] . "' style='text-decoration:none;'>";
                    echo "<h3 style='margin-top:0; color:#2c3e50; font-size:1.5rem;'>" . htmlspecialchars($masina['firma']) . "</h3>";
                echo "</a>";

                echo "<p style='margin: 10px 0;'><strong>Motor:</strong> " . $masina['motorizare'] . " | <strong>An:</strong> " . $masina['an'] . " | <strong>KM:</strong> " . number_format($masina['kilometri'], 0, ',', '.') . "</p>";
                echo "<p style='font-size:1.1rem; margin-bottom: 15px;'>Preț actual: <strong style='color:#27ae60;'>" . number_format($masina['pret_pornire'], 0, ',', '.') . " €</strong></p>";
                
                echo "<a href='detalii?id=" . $masina['id'] . "' style='color: #3498db; text-decoration: none; font-weight: bold;'>Vezi detalii complete ➔</a>";

                // Butoane Admin
                if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') {
                    echo "<div style='margin-top:15px; border-top:1px dotted #ccc; padding-top:10px;'>";
                        echo "<a href='edit_car?id=" . $masina['id'] . "' style='color:#3498db; text-decoration:none;'>⚙️ Editează</a> | ";
                        echo "<a href='delete_car?id=" . $masina['id'] . "' style='color:#e74c3c; text-decoration:none;'>❌ Șterge</a>";
                    echo "</div>";
                }
            echo "</div>"; // Închidere car-details
            
        echo "</div>"; // Închidere car-card
    }
} else {
    echo "<div style='text-align:center; padding:40px; background:#f9f9f9; border-radius:12px;'>";
    echo "<p style='color:#7f8c8d;'>Nu am găsit nicio mașină pentru filtrele selectate.</p>";
    echo "<a href='licitatii' style='color:#2c3e50; font-weight:bold;'>Vezi toate mașinile</a>";
    echo "</div>";
}
?>