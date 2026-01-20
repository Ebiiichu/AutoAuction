<?php
// Preluăm datele trimise prin POST
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];

// Validare: Verificăm dacă sunt goale
if (empty($user) || empty($email) || empty($pass)) {
    die("Eroare: Toate câmpurile sunt obligatorii!");
}

// Validare cerinte

// Verificare format Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Eroare: Adresa de email nu are un format valid (ex: nume@yahoo.com)!");
}

// Verificare lungime Username (minim 6 caractere)
if (strlen($user) < 6) {
    die("Eroare: Numele de utilizator trebuie să aibă cel puțin 6 caractere!");
}

// Verificare complexitate Parolă
// Această verificare se face pe variabila $pass (parola brută) înainte de hashing.
if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass)) {
    die("Eroare: Parola trebuie să conțină minim 8 caractere, cel puțin o cifră și un semn special!");
}


// Sanitizare pentru baza de date
$user = mysqli_real_escape_string($conn, $user);
$email = mysqli_real_escape_string($conn, $email);

// Aici parola devine invizibilă în phpMyAdmin
// Folosim password_hash pentru a transforma "parola123." într-un cod lung securizat.
$pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

// Verificare duplicate
$verificare = mysqli_query($conn, "SELECT id FROM utilizatori WHERE username = '$user' OR email = '$email'");

if (mysqli_num_rows($verificare) > 0) {
    die("Eroare: Numele de utilizator sau adresa de email sunt deja utilizate!");
}

// Introducem variabila $pass_hashed în coloana 'password'
$sql = "INSERT INTO utilizatori (username, email, password, rol) VALUES ('$user', '$email', '$pass_hashed', 'user')";

if (mysqli_query($conn, $sql)) {
    echo "<h2>Succes!</h2>";
    echo "<p>Contul pentru <strong>$user</strong> a fost creat. Parola este criptată și securizată.</p>";
    echo "<p><a href='login'>Te poți autentifica aici</a>.</p>";
} else {
    echo "A apărut o eroare la salvarea datelor: " . mysqli_error($conn);
}
?>