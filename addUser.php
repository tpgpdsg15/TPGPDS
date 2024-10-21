<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId != '1') {
    header('Location:index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {
    $userAdd = $users->addNewUserByAdmin($_POST);
}
?>

<style>
    body {
        background-color: #ecf0f1;
        font-family: 'Roboto', sans-serif;
    }
    .adduser-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    .adduser-header {
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
    .form-group input, .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #ecf0f1;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: #3498db;
        outline: none;
    }
    .btn-adduser {
        background-color: #2ecc71;
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
    .btn-adduser:hover {
        background-color: #27ae60;
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

<div class="adduser-container">
    <h3 class="adduser-header">Agregar nuevo usuario</h3>
    
    <?php
    if (isset($userAdd)) {
        $messageClass = (strpos($userAdd, 'exitosamente') !== false) ? 'success-message' : '';
        echo '<div class="flash-message ' . $messageClass . '">' . $userAdd . '</div>';
    }
    ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="mobile">Número de celular</label>
            <input type="text" name="mobile" id="mobile" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="roleid">Seleccionar rol de usuario</label>
            <select name="roleid" id="roleid" required>
                <option value="1">Admin</option>
                <option value="2">Editor</option>
                <option value="3">Solo usuario</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="addUser" class="btn-adduser">Agregar Usuario</button>
        </div>
    </form>
</div>

<?php // include 'inc/footer.php'; ?>
