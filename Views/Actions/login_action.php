<?php
// Preluăm datele (input-ul poate fi acum username sau email)
$identificator = mysqli_real_escape_string($conn, $_POST['username']);
$parola_introdusa = $_POST['password']; // Nu o sanitizăm cu mysqli_real_escape_string pentru că o verificăm separat

// Căutăm userul doar după nume sau email (fără să punem parola în SQL)
$sql = "SELECT * FROM utilizatori WHERE username = '$identificator' OR email = '$identificator' LIMIT 1";
$rezultat = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($rezultat);

// Verificăm dacă userul există si dacă parola se potrivește cu hash-ul din DB
if ($user && password_verify($parola_introdusa, $user['password'])) {
    
    // Salvăm datele esențiale în sesiune
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nume'] = $user['username']; // Folosit pentru mesajul de bun venit
    $_SESSION['username'] = $user['username']; // Evită eroarea "Undefined key" din profile.php
    $_SESSION['rol'] = $user['rol'];

    // Redirecționare automată 
    header("Location: home");
    exit();
} else {
    // Mesaj de eroare dacă datele nu se potrivesc
    echo "<div class='container' style='padding: 20px; text-align: center;'>";
    echo "<p style='color:red;'>Date de autentificare incorecte! Utilizatorul sau parola nu se potrivesc.</p>";
    echo "<a href='login' style='text-decoration: none; font-weight: bold;'>Înapoi la login</a>";
    echo "</div>";
}
?>