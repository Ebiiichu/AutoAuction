<?php
// Adăugăm ob_start() la începutul fișierului pentru a preveni eroarea "headers already sent"
ob_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoAction | Licitații Premium</title>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --success: #27ae60;
        }

        /* Setări Flexbox pentru Sticky Footer */
        html, body {
            height: 100%;
            margin: 0;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            display: flex;
            flex-direction: column; /* Aliniere verticală */
            background-color: #f4f7f6; 
            color: #333;
        }

        nav { 
            background: var(--primary); 
            padding: 1rem 2rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        nav a { 
            color: white; 
            text-decoration: none; 
            margin-left: 20px; 
            font-weight: 500;
            transition: color 0.3s;
        }
        nav a:hover { color: var(--accent); }
        .logo { font-size: 1.5rem; font-weight: bold; color: white !important; margin-left: 0; }

        /* Containerul principal */
        .container { 
            max-width: 1000px; 
            margin: 30px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-height: 400px; 
            flex: 1 0 auto; 
            overflow: visible !important; 
        }

        /* Stil carduri si preview */
        .car-card {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 30px;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .car-card:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
        }

        .car-image-container {
            flex-shrink: 0;
            width: 250px;
            height: 180px;
        }

        .car-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            display: block;
        }

        .car-details {
            flex-grow: 1;
        }

        .hover-preview {
            display: none;
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translate(-50%, -100%);
            background: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            width: 320px;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            font-size: 0.85rem;
            line-height: 1.4;
            pointer-events: none;
        }

        .hover-preview::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -8px;
            border-width: 8px;
            border-style: solid;
            border-color: #2c3e50 transparent transparent transparent;
        }

        .car-card:hover .hover-preview {
            display: block;
        }
    </style>
</head>
<body>

<nav>
    <a href="home" class="logo">🏎️ AutoAction</a>
    <div>
        <a href="home" style="<?php echo ($pagina == 'home') ? 'color: var(--accent); font-weight: bold;' : ''; ?>">Acasă</a>
        <a href="licitatii" style="<?php echo ($pagina == 'licitatii' || $pagina == 'detalii') ? 'color: var(--accent); font-weight: bold;' : ''; ?>">Licitații</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="add_car" style="<?php echo ($pagina == 'add_car') ? 'color: #f1c40f; font-weight: bold;' : 'color: #f1c40f;'; ?>">+ Panou Admin</a>
            <?php endif; ?>
            <a href="profile" style="<?php echo ($pagina == 'profile') ? 'color: var(--accent); font-weight: bold;' : ''; ?>">Profilul meu</a>
            <a href="logout" style="color: var(--accent);" onclick="return confirm('Sigur vrei să te deconectezi?')">Logout</a>
        <?php else: ?>
            <a href="register" style="<?php echo ($pagina == 'register') ? 'color: var(--accent); font-weight: bold;' : ''; ?>">Înregistrare</a>
            <a href="login" style="<?php echo ($pagina == 'login') ? 'color: var(--accent); font-weight: bold;' : ''; ?>">Autentificare</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">