<div class="container">
    <h2>Creează un cont nou</h2>
    <form action="register_action" method="post">
        <label>Nume utilizator (minim 6 caractere):</label><br>
        <input type="text" name="username" minlength="6" required><br><br>
        
        <label>Adresă Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Parolă (minim 8 caractere, cifre și un semn special):</label><br>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="Înregistrare">
    </form>
</div>