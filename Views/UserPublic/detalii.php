<?php
// Preluăm ID-ul din URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Interogăm baza de date
$sql = "SELECT * FROM masini WHERE id = '$id'";
$res = mysqli_query($conn, $sql);
$m = mysqli_fetch_assoc($res);

if (!$m) {
    echo "<h2>Mașina nu a fost găsită!</h2>";
    return;
}
?>

<div class="car-details" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px;">
    <div>
        <img src="Uploads/<?php echo htmlspecialchars($m['imagine']); ?>" style="width: 100%; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    </div>

    <div>
        <h1 style="margin-top:0; color: var(--primary);"><?php echo htmlspecialchars($m['firma']); ?></h1>
        <h3 style="color: #7f8c8d; font-weight: normal;">Versiune: <?php echo htmlspecialchars($m['submodel']); ?></h3>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
            <p>📅 <strong>An:</strong> <?php echo $m['an']; ?></p>
            <p>🚀 <strong>Motorizare:</strong> <?php echo $m['motorizare']; ?></p>
            <p>🛣️ <strong>KM:</strong> <?php echo number_format($m['kilometri'], 0, ',', '.'); ?></p>
            <p style="font-size: 1.5rem; color: var(--success);">
                💰 <strong>Preț actual: <?php echo number_format($m['pret_pornire'], 0, ',', '.'); ?> €</strong>
            </p>
        </div>

        <p style="line-height: 1.6; color: #666;"><?php echo nl2br(htmlspecialchars($m['descriere'])); ?></p>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['rol'] == 'user'): ?>
            <div style="background: var(--light); padding: 20px; border-radius: 10px; border-left: 5px solid var(--success);">
                <form action="bid_action" method="post" style="display: flex; gap: 10px;">
                    <input type="hidden" name="id_masina" value="<?php echo $m['id']; ?>">
                    <input type="number" name="suma" min="<?php echo ($m['pret_pornire'] + 1); ?>" required style="padding: 10px; flex: 1;">
                    <input type="submit" value="Licitează Acum">
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>