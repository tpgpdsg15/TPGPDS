<?php
include 'inc/header.php';
Session::CheckSession();

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);
}

if (isset($updateUser)) {
  echo $updateUser;
}

$getUinfo = $users->getUserInfoById($userid);
if (!$getUinfo) {
  header('Location:index.php');
  exit;
}
?>

<style>
    .profile-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    .profile-header {
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
    .form-group input, .form-group select {
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

<div class="profile-container">
    <div class="profile-header">
        <h3>Perfil de usuario</h3>
        <a href="index.php" class="btn btn-primary">Atrás</a>
    </div>

    <?php
    if (isset($updateUser)) {
        echo '<div class="flash-message">' . $updateUser . '</div>';
    }
    ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Su nombre</label>
            <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" name="username" value="<?php echo $getUinfo->username; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Casilla de correo</label>
            <input type="email" id="email" name="email" value="<?php echo $getUinfo->email; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="mobile">Número móvil</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo $getUinfo->mobile; ?>" class="form-control">
        </div>

        <?php if (Session::get("roleid") == '1' && Session::get("id") != $getUinfo->id) { ?>
            <div class="form-group">
                <label for="roleid">Seleccione rol de usuario</label>
                <select class="form-control" name="roleid" id="roleid">
                    <option value="1" <?php echo ($getUinfo->roleid == '1') ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?php echo ($getUinfo->roleid == '2') ? 'selected' : ''; ?>>Editor</option>
                    <option value="3" <?php echo ($getUinfo->roleid == '3') ? 'selected' : ''; ?>>Solo usuario</option>
                </select>
            </div>
        <?php } else { ?>
            <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
        <?php } ?>

        <div class="form-group">
            <?php if (Session::get("id") == $getUinfo->id || Session::get("roleid") == '1') { ?>
                <button type="submit" name="update" class="btn btn-success">Actualizar</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Cambiar contraseña</a>
            <?php } elseif(Session::get("roleid") == '2') { ?>
                <button type="submit" name="update" class="btn btn-success">Actualizar</button>
            <?php } else { ?>
                <a class="btn btn-primary" href="index.php">Ok</a>
            <?php } ?>
        </div>
    </form>
</div>

<?php include 'inc/footer.php'; ?>
