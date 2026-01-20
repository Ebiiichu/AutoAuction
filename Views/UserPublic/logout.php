<?php
// Stergem toate variabilele din sesiune 
session_unset(); 
// Distrugem sesiunea de tot
session_destroy(); 

// Redirectionam utilizatorul la pagina de start
header("Location: home");
exit();
?>