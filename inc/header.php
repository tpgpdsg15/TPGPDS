<?php
$filepath = realpath(dirname(__FILE__));
include_once $filepath."/../lib/Session.php";
Session::init();
spl_autoload_register(function($classes){
  include 'classes/'.$classes.".php";
});
$users = new Users();
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  Session::destroy();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Proyecto "Login"</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f1;
        }
        .navbar {
            background-color: #3498db;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand {
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
        }
        .navbar-nav {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        .nav-item {
            margin-left: 20px;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }
        .nav-link:hover {
            opacity: 0.8;
        }
        .nav-link.active {
            border-bottom: 2px solid white;
        }
        .content {
            padding: 30px 0;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="container navbar-content">
        <a class="navbar-brand" href="index.php">Proyecto Login</a>
        <ul class="navbar-nav">
            <?php if (Session::get('id') == TRUE) { ?>
                <?php if (Session::get('roleid') == '1') { ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">Lista de usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'addUser.php') ? 'active' : ''; ?>" href="addUser.php">Agregar usuario</a>
                    </li>
                <?php  } ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>" href="profile.php?id=<?php echo Session::get("id"); ?>">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?action=logout">Cerrar sesión</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'register.php') ? 'active' : ''; ?>" href="register.php">Registro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'active' : ''; ?>" href="login.php">Iniciar sesión</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
<div class="container content">
