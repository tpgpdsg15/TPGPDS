<?php
include 'inc/header.php';
Session::CheckLogin();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
   $loginSuccess = $users->userLoginAuthotication($_POST);
   if ($loginSuccess) {
       header("Location: index.php");
       exit();
   } else {
       $errorMessage = "Username/Email or Password is incorrect";
   }
}
?>

<style>
    body {
        background-color: #ecf0f1;
        font-family: 'Roboto', sans-serif;
    }
    .login-container {
        max-width: 400px;
        margin: 100px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    .login-header {
        color: #3498db;
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 700;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #34495e;
        font-weight: 500;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ecf0f1;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    .form-group input:focus {
        border-color: #3498db;
        outline: none;
    }
    .btn-login {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 14px 0;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }
    .btn-login:hover {
        background-color: #2980b9;
    }
    .flash-message {
        background-color: #e74c3c;
        color: white;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 16px;
    }
    .success-message {
        background-color: #2ecc71;
    }
</style>

<div class="login-container">
    <h3 class="login-header"><i class="fas fa-sign-in-alt mr-2"></i>Iniciar sesión</h3>
    
    <?php
    if (isset($errorMessage)) {
        echo '<div class="flash-message">' . $errorMessage . '</div>';
    }
    ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="username">Usuario o Correo Electrónico</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="login" class="btn-login">Iniciar sesión</button>
        </div>
    </form>
</div>

<?php include 'inc/footer.php'; ?>
