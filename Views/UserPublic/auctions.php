<h2 style="border-left: 5px solid #2c3e50; padding-left: 15px; margin-bottom: 25px;">🔥 Licitații Auto Active</h2>

<?php
$rezultat = mysqli_query($conn, "SELECT * FROM masini");

if (mysqli_num_rows($rezultat) > 0) {
    while($masina = mysqli_fetch_assoc($rezultat)) {
        echo "<div style='border:1px solid #ddd; padding:20px; margin-bottom:20px; overflow:hidden; border-radius:12px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05);'>";
            echo "<img src='Uploads/" . htmlspecialchars($masina['imagine']) . "' style='width:250px; height:180px; object-fit:cover; float:left; margin-right:25px; border-radius:8px;'>";
            echo "<h3 style='margin-top:0; color:#2c3e50; font-size:1.5rem;'>" . htmlspecialchars($masina['model']) . "</h3>";
            echo "<p style='font-size:1.1rem;'>Preț actual: <strong style='color:#27ae60;'>" . number_format($masina['pret_pornire'], 0, ',', '.') . " €</strong></p>";
            echo "<p style='color:#7f8c8d; line-height:1.5;'>" . htmlspecialchars($masina['descriere']) . "</p>";

            // Formular licitare (doar useri)
            if (isset($_SESSION['user_id']) && $_SESSION['rol'] == 'user') {
                echo "<div style='background:#f4f7f6; padding:15px; border-radius:8px; margin-top:15px; clear:both;'>";
                    echo "<form action='bid_action' method='post' style='display:flex; align-items:center; gap:10px;'>";
                        echo "<input type='hidden' name='id_masina' value='" . $masina['id'] . "'>";
                        echo "<input type='number' name='suma' min='" . ($masina['pret_pornire'] + 1) . "' placeholder='Suma ta' required style='padding:8px;'> ";
                        echo "<input type='submit' value='Licitează' style='background:#27ae60; color:white; border:none; padding:8px 20px; border-radius:4px; cursor:pointer;'>";
                    echo "</form>";
                echo "</div>";
            }
        echo "</div>";
    }
} else {
    echo "<p>Momentan nu există licitații active.</p>";
}
?>