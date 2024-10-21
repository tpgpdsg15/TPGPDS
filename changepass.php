<?php
include 'inc/header.php';
Session::CheckSession();

if (isset($_GET['id'])) {
   $userid = (int)$_GET['id'];
}

$isAdmin = Session::get('roleid') == '1';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass'])) {
    $changePass = $users->changePasswordBysingelUserId($userid, $_POST, $isAdmin);
}
?>

<style>
    .changepass-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    .changepass-header {
        color: #3498db;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    .btn-primary {
        background-color: #3498db;
        color: white;
    }
    .btn-success {
        background-color: #2ecc71;
        color: white;
    }
    .btn:hover {
        opacity: 0.8;
    }
    .flash-message {
        background-color: #e74c3c;
        color: white;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
        text-align: center;
    }
</style>

<div class="changepass-container">
    <div class="changepass-header">
        <h3>Cambia tu contraseña</h3>
        <a href="profile.php?id=<?php echo $userid; ?>" class="btn btn-primary">Atrás</a>
    </div>

    <?php
    if (isset($changePass)) {
        echo '<div class="flash-message">' . $changePass . '</div>';
    }
    ?>

    <form action="" method="POST">
        <?php if (!$isAdmin) { ?>
            <div class="form-group">
                <label for="old_password">Contraseña anterior</label>
                <input type="password" name="old_password" id="old_password" required>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="new_password">Nueva contraseña</label>
            <input type="password" name="new_password" id="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmar nueva contraseña</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="changepass" class="btn btn-success">Cambia tu contraseña</button>
        </div>
    </form>
</div>

<?php // include 'inc/footer.php'; ?>
