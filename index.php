<?php
include 'inc/header.php';
Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}
if (isset($removeUser)) {
  echo $removeUser;
}
if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}
if (isset($deactiveId)) {
  echo $deactiveId;
}
if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}
if (isset($activeId)) {
  echo $activeId;
}
?>

<style>
    body {
        background-color: #ecf0f1;
        font-family: 'Roboto', Arial, sans-serif;
        color: #333;
        padding: 20px;
    }
    .dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }
    .welcome-banner {
        background-color: #3498db;
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .user-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .user-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s ease;
    }
    .user-card:hover {
        transform: translateY(-5px);
    }
    .user-name {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
        color: #3498db;
    }
    .user-info {
        margin-bottom: 15px;
    }
    .user-actions {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
    }
    .btn {
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 0.9em;
        margin-right: 10px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }
    .btn-view { background-color: #3498db; }
    .btn-edit { background-color: #2ecc71; }
    .btn-delete { background-color: #e74c3c; }
    .btn-deactivate { background-color: #f39c12; }
    .btn-activate { background-color: #95a5a6; }
    .btn:hover { opacity: 0.8; }
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8em;
        margin-bottom: 5px;
    }
    .badge-role { background-color: #34495e; color: white; }
    .badge-active { background-color: #2ecc71; color: white; }
    .badge-inactive { background-color: #e74c3c; color: white; }
</style>

<div class="dashboard">
    <div class="welcome-banner">
        <h1><i class="fas fa-users mr-2"></i>Listado de usuarios</h1>
        <div>
            Bienvenido! <strong>
                <span class="badge badge-light">
                    <?php
                    $username = Session::get('username');
                    if (isset($username)) {
                        echo $username;
                    }
                    ?>
                </span>
            </strong>
        </div>
    </div>

    <div class="user-grid">
        <?php
        $allUser = $users->selectAllUserData();
        if ($allUser) {
            foreach ($allUser as $value) {
        ?>
            <div class="user-card">
                <div class="user-name"><?php echo $value->name; ?></div>
                <div class="user-info">
                    <p><strong>Usuario:</strong> <?php echo $value->username; ?></p>
                    <p><strong>Email:</strong> <?php echo $value->email; ?></p>
                    <p><strong>Móvil:</strong> <?php echo $value->mobile; ?></p>
                    <p><strong>Creado:</strong> <?php echo $users->formatDate($value->created_at); ?></p>
                    <span class="badge badge-role">
                        <?php
                        if ($value->roleid == '1') {
                            echo "Admin";
                        } elseif ($value->roleid == '2') {
                            echo "Editor";
                        } elseif ($value->roleid == '3') {
                            echo "Solo usuario";
                        }
                        ?>
                    </span>
                    <span class="badge <?php echo $value->isActive == '0' ? 'badge-active' : 'badge-inactive'; ?>">
                        <?php echo $value->isActive == '0' ? 'Activo' : 'Inactivo'; ?>
                    </span>
                </div>
                <div class="user-actions">
                    <?php if (Session::get("roleid") == '1') { ?>
                        <a class="btn btn-view" href="profile.php?id=<?php echo $value->id; ?>">Vista</a>
                        <a class="btn btn-edit" href="profile.php?id=<?php echo $value->id; ?>">Editar</a>
                        <a onclick="return confirm('Seguro quiere borrarlo ?')" class="btn btn-delete <?php if (Session::get("id") == $value->id) echo "disabled"; ?>" href="?remove=<?php echo $value->id; ?>">Remover</a>
                        <?php if ($value->isActive == '0') { ?>
                            <a onclick="return confirm('Seguro quiere desactivarlo ?')" class="btn btn-deactivate <?php if (Session::get("id") == $value->id) echo "disabled"; ?>" href="?deactive=<?php echo $value->id; ?>">Deshabilitar</a>
                        <?php } elseif ($value->isActive == '1') { ?>
                            <a onclick="return confirm('Seguro quiere activarlo ?')" class="btn btn-activate <?php if (Session::get("id") == $value->id) echo "disabled"; ?>" href="?active=<?php echo $value->id; ?>">Activar</a>
                        <?php } ?>
                    <?php } elseif (Session::get("id") == $value->id && Session::get("roleid") == '2') { ?>
                        <a class="btn btn-view" href="profile.php?id=<?php echo $value->id; ?>">Vista</a>
                        <a class="btn btn-edit" href="profile.php?id=<?php echo $value->id; ?>">Editar</a>
                    <?php } elseif (Session::get("roleid") == '2') { ?>
                        <a class="btn btn-view <?php if ($value->roleid == '1') echo "disabled"; ?>" href="profile.php?id=<?php echo $value->id; ?>">Vista</a>
                        <a class="btn btn-edit <?php if ($value->roleid == '1') echo "disabled"; ?>" href="profile.php?id=<?php echo $value->id; ?>">Editar</a>
                    <?php } elseif (Session::get("id") == $value->id && Session::get("roleid") == '3') { ?>
                        <a class="btn btn-view" href="profile.php?id=<?php echo $value->id; ?>">Vista</a>
                        <a class="btn btn-edit" href="profile.php?id=<?php echo $value->id; ?>">Edit</a>
                    <?php } else { ?>
                        <a class="btn btn-view <?php if ($value->roleid == '1') echo "disabled"; ?>" href="profile.php?id=<?php echo $value->id; ?>">Vista</a>
                    <?php } ?>
                </div>
            </div>
        <?php }
        } else { ?>
            <div class="user-card">
                <p>No hay usuario disponible ahora !</p>
            </div>
        <?php } ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
