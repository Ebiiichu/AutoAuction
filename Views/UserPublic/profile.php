<?php
//  Protecție: trebuie să fii logat
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$id_user = $_SESSION['user_id'];

// Extragem datele proaspete din baza de date (pentru Email și Username)
$sql_me = "SELECT username, email, rol FROM utilizatori WHERE id = $id_user";
$res_me = mysqli_query($conn, $sql_me);
$me = mysqli_fetch_assoc($res_me);
?>

<div class="container">
    <h2>Activitatea ta, <?php echo htmlspecialchars($me['username']); ?></h2>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 25px; border-left: 5px solid #2c3e50;">
        <h3 style="margin-top: 0;">Informații Cont</h3>
        <p>👤 <strong>Username:</strong> <?php echo htmlspecialchars($me['username']); ?></p>
        <p>📧 <strong>Email:</strong> <?php echo !empty($me['email']) ? htmlspecialchars($me['email']) : "<em>Nesetat</em>"; ?></p>
        <p>🛡️ <strong>Rol actual:</strong> <span style="text-transform: capitalize;"><?php echo htmlspecialchars($me['rol']); ?></span></p>
    </div>

    <hr style="margin-bottom: 25px; opacity: 0.2;">

    <?php if ($me['rol'] === 'admin'): ?>
        <div style="background: #fff3cd; padding: 20px; border-radius: 10px; border: 1px solid #ffeeba; margin-bottom: 30px;">
            <h3>🛡️ Panou Admin: Gestionare Utilizatori</h3>
            <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse; background: white;">
                <tr style="background: #2c3e50; color: white;">
                    <th>Utilizator</th> 
                    <th>Rol Actual</th>
                    <th>Acțiuni</th>
                </tr>
                <?php
                $sql_users = "SELECT id, username, rol FROM utilizatori WHERE id != $id_user";
                $res_users = mysqli_query($conn, $sql_users);

                if (mysqli_num_rows($res_users) > 0) {
                    while ($u = mysqli_fetch_assoc($res_users)) {
                        echo "<tr>";
                            echo "<td>" . htmlspecialchars($u['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($u['rol']) . "</td>";
                            echo "<td>";
                                if ($u['rol'] !== 'admin') {
                                    echo "<a href='user_action?act=make_admin&id=" . $u['id'] . "' style='color: green; text-decoration: none; font-weight: bold;'>⬆️ Fă Admin</a> | ";
                                } else {
                                    echo "<a href='user_action?act=make_user&id=" . $u['id'] . "' style='color: orange; text-decoration: none; font-weight: bold;'>⬇️ Revocă Admin</a> | ";
                                }
                                echo "<a href='user_action?act=delete&id=" . $u['id'] . "' style='color: red; text-decoration: none; font-weight: bold;' onclick='return confirm(\"Sigur vrei să ștergi acest cont?\")'>❌ Șterge</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nu există alți utilizatori în sistem.</td></tr>";
                }
                ?>
            </table>
        </div>
    <?php else: ?>
        <h3>Licitațiile tale recente:</h3>

        <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse; background: white;">
            <tr style="background: #2c3e50; color: white;">
                <th>Mașină</th>
                <th>Suma oferită</th>
                <th>Dată licitație</th>
            </tr>

            <?php
            // Folosim 'firma' și numele exacte ale coloanelor din tabelul licitatii
            $sql = "SELECT masini.firma, licitatii.suma_oferita, licitatii.data_licitatie 
                    FROM licitatii 
                    JOIN masini ON licitatii.id_masina = masini.id 
                    WHERE licitatii.id_utilizator = $id_user 
                    ORDER BY licitatii.data_licitatie DESC";

            $rezultat = mysqli_query($conn, $sql);

            if ($rezultat && mysqli_num_rows($rezultat) > 0) {
                while($rand = mysqli_fetch_assoc($rezultat)) {
                    echo "<tr>";
                        
                        echo "<td style='font-weight:bold;'>" . htmlspecialchars($rand['firma']) . "</td>";
                        echo "<td style='color:green; font-weight:bold;'>" . number_format($rand['suma_oferita'], 0, ',', '.') . " €</td>";
                        echo "<td>" . date('d.m.Y H:i', strtotime($rand['data_licitatie'])) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align:center; padding: 20px;'>Nu ai participat la nicio licitație încă.</td></tr>";
            }
            ?>
        </table>
    <?php endif; ?>
</div>