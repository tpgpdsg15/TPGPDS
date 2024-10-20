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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    
</head>
<body>

<nav class="navbar">
    <div class="container navbar-content">
        <a class="navbar-brand" href="index.php"><i class="fas fa-home mr-2"></i>Tablero</a>
        <ul class="navbar-nav">
            <?php if (Session::get('id') == TRUE) { ?>
                <?php if (Session::get('roleid') == '1') { ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php"><i class="fas fa-users mr-2"></i>Lista de usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'addUser.php') ? 'active' : ''; ?>" href="addUser.php"><i class="fas fa-user-plus mr-2"></i>Agregar usuario</a>
                    </li>
                <?php  } ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>" href="profile.php?id=<?php echo Session::get("id"); ?>"><i class="fab fa-500px mr-2"></i>Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?action=logout"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'register.php') ? 'active' : ''; ?>" href="register.php"><i class="fas fa-user-plus mr-2"></i>Registro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'active' : ''; ?>" href="login.php"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<div class="container">
