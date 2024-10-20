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
    .dashboard {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .dashboard-title {
        color: #3498db;
        font-size: 24px;
        font-weight: 700;
    }
    .user-welcome {
        font-size: 16px;
        color: #34495e;
    }
    .user-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .user-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        transition: box-shadow 0.3s ease;
    }
    .user-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .user-name {
        font-size: 18px;
        font-weight: 700;
        color: #3498db;
        margin-bottom: 10px;
    }
    .user-info {
        font-size: 14px;
        color: #34495e;
        margin-bottom: 15px;
    }
    .user-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .btn {
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
}
.btn:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}
.btn-view { 
    background-color: #3498db; 
    color: white; 
}
.btn-edit { 
    background-color: #2980b9; 
    color: white; 
}
.btn-delete { 
    background-color: #e74c3c; 
    color: white; 
}
.btn-deactivate, .btn-activate { 
    background-color: #f39c12; 
    color: white; 
}
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 5px;
    }
    .badge-role { background-color: #34495e; color: white; }
    .badge-active { background-color: #2ecc71; color: white; }
    .badge-inactive { background-color: #e74c3c; color: white; }
</style>

<div class="dashboard">
    <div class="dashboard-header">
        <h2 class="dashboard-title">Listado de usuarios</h2>
        <div class="user-welcome">
            Bienvenido, <strong><?php echo Session::get('username'); ?></strong>
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
                            echo "Usuario";
                        }
                        ?>
                    </span>
                    <span class="badge <?php echo $value->isActive == '0' ? 'badge-active' : 'badge-inactive'; ?>">
                        <?php echo $value->isActive == '0' ? 'Activo' : 'Inactivo'; ?>
                    </span>
                </div>
            <div class="user-actions">
    <?php if (Session::get("roleid") == '1') { ?>
        <a class="btn btn-view" href="profile.php?id=<?php echo $value->id; ?>">Ver</a>
        <a class="btn btn-edit" href="profile.php?id=<?php echo $value->id; ?>">Editar</a>
        <a onclick="return confirm('¿Está seguro de que desea eliminar?')" class="btn btn-delete <?php if (Session::get("id") == $value->id) echo "disabled"; ?>" href="?remove=<?php echo $value->id; ?>">Eliminar</a>
        <?php if ($value->isActive == '0') { ?>
            <a onclick="return confirm('¿Está seguro de que desea desactivar?')" class="btn btn-deactivate <?php if (Session::get("id") == $value->id) echo "disabled"; ?>" href="?deactive=<?php echo $value->id; ?>">Desactivar</a>
        <?php } elseif ($value->isActive == '1') { ?>
            <a onclick="return confirm('¿Está seguro de que desea activar?')" class="btn btn-activate <?php if (Session::get("id") == $value->id) echo "disabled"; ?>" href="?active=<?php echo $value->id; ?>">Activar</a>
        <?php } ?>
    <?php } elseif (Session::get("id") == $value->id && Session::get("roleid") == '2') { ?>
        <a class="btn btn-view" href="profile.php?id=<?php echo $value->id; ?>">Ver</a>
        <a class="btn btn-edit" href="profile.php?id=<?php echo $value->id; ?>">Editar</a>
    <?php } elseif (Session::get("roleid") == '2') { ?>
        <a class="btn btn-view <?php if ($value->roleid == '1') echo "disabled"; ?>" href="profile.php?id=<?php echo $value->id; ?>">Ver</a>
    <?php } elseif (Session::get("id") == $value->id && Session::get("roleid") == '3') { ?>
        <a class="btn btn-view" href="profile.php?id=<?php echo $value->id; ?>">Ver</a>
        <a class="btn btn-edit" href="profile.php?id=<?php echo $value->id; ?>">Editar</a>
    <?php } else { ?>
        <a class="btn btn-view <?php if ($value->roleid == '1') echo "disabled"; ?>" href="profile.php?id=<?php echo $value->id; ?>">Ver</a>
    <?php } ?>
</div>
                
            </div>
        <?php }
        } else { ?>
            <p>No hay usuarios disponibles en este momento.</p>
        <?php } ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
