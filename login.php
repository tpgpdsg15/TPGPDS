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
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    .login-header {
        color: #3498db;
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        font-weight: bold;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    .btn-login {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 12px 0;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    .btn-login:hover {
        background-color: #2980b9;
    }
    .debug-info {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-family: monospace;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>

<div class="login-container">
    <h3 class="login-header"><i class="fas fa-sign-in-alt mr-2"></i>Inicio de sesión</h3>
    
    <?php
    if (isset($userLog)) {
        $messageClass = ($userLog === "Login Successful") ? 'success-message' : 'error-message';
        echo '<div class="flash-message ' . $messageClass . '">' . $userLog . '</div>';
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
