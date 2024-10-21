<?php

include 'lib/Database.php';
include_once 'lib/Session.php';


class Users
{


  // Db Property
  private $db;

  // Db __construct Method
  public function __construct()
  {
    $this->db = new Database();
  }

  // Date formate Method
  public function formatDate($date)
  {
    // date_default_timezone_set('Asia/Dhaka');
    $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
  }

// Check Unique Username Method
public function checkUnique($field, $value) {
    $sql = "SELECT COUNT(*) as count FROM tbl_users WHERE $field = :value";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':value', $value);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] == 0;
}

  // Check Exist Email Address Method
  public function checkExistEmail($email)
  {
    $sql = "SELECT email from  tbl_users WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

public function userRegistration($data){
    $name = $data['name'] ?? '';
    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $mobile = $data['mobile'] ?? '';
    $roleid = $data['roleid'] ?? '';
    $password = $data['password'] ?? '';

    if(empty($name) || empty($username) || empty($email) || empty($mobile) || empty($password)) {
        return "Todos los campos son obligatorios.";
    }

    $passwordRegex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/';
    if (!preg_match($passwordRegex, $password)) {
        return "La contraseña no cumple con los requisitos de complejidad.";
    }

    if (!$this->checkUnique('username', $username)) {
        return "El nombre de usuario ya está en uso.";
    }

    if (!$this->checkUnique('email', $email)) {
        return "El correo electrónico ya está en uso.";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO tbl_users(name, username, email, password, mobile, roleid) VALUES(:name, :username, :email, :password, :mobile, :roleid)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password_hash);
    $stmt->bindValue(':mobile', $mobile);
    $stmt->bindValue(':roleid', $roleid);
    $result = $stmt->execute();

    if ($result) {
        return "Usuario registrado exitosamente.";
    } else {
        return "Hubo un problema al registrar el usuario. Por favor, intente nuevamente.";
    }
}

  // Add New User By Admin
  public function addNewUserByAdmin($data)
  {
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Ningún campo puede quedar vacío !</div>';
      return $msg;
    } elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Nombre de usuario es muy corto, tiene menos de 3 caracteres !</div>';
      return $msg;
    } elseif (filter_var($mobile, FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Ingrese solo números en el campo Móvil !</div>';
      return $msg;
    } elseif (strlen($password) < 8) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> La contraseña deberá tener 8 caracteres !</div>';
      return $msg;
    } elseif (!preg_match("#[0-9]+#", $password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Su contraseña debe tener al menos 1 número !</div>';
      return $msg;
    } elseif (!preg_match("#[a-z]+#", $password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Su contraseña debe tener al menos 1 letra !</div>';
      return $msg;
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Correo electrónico inválido !</div>';
      return $msg;
    } elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Esa casilla de correo ya existe, intente con otra... !</div>';
      return $msg;
    } else {

      $sql = "INSERT INTO tbl_users(name, username, email, password, mobile, roleid) VALUES(:name, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
     /* $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));*/
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Realizado !</strong> Bien, se ha registrado correctamente !</div>';
        return $msg;
      } else {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Algo salió mal !</div>';
        return $msg;
      }
    }
  }



  // Select All User Method
  public function selectAllUserData()
  {
    $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // User login Autho Method
  public function userLoginAutho($email, $password)
  {
    $password = SHA1($password);
  /*  $password = password_hash($password, PASSWORD_DEFAULT);*/
    $sql = "SELECT * FROM tbl_users WHERE email = :email and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  // Check User Account Satatus
  public function CheckActiveUser($email)
  {
    $sql = "SELECT * FROM tbl_users WHERE email = :email and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

public function userLoginAuthotication($data){
    $usernameOrEmail = $data['username'];
    $password = $data['password'];

    $sql = "SELECT * FROM tbl_users WHERE username = :usernameOrEmail OR email = :usernameOrEmail LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':usernameOrEmail', $usernameOrEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        Session::init();
        Session::set('login', true);
        Session::set('id', $user['id']);
        Session::set('roleid', $user['roleid']);
        Session::set('name', $user['name']);
        Session::set('username', $user['username']);
        Session::set('logMsg', "Acceso exitoso!!");
        return true;
    } else {
        return false;
    }
}


  // Get Single User Information By Id Method
  public function getUserInfoById($userid)
  {
    $sql = "SELECT * FROM tbl_users WHERE id = :id LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $userid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result;
    } else {
      return false;
    }
  }



  //
  //   Update Single User Information By Id Method
  public function updateUserByIdInfo($userid, $data)
  {
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];



    if ($name == "" || $username == "" || $email == "" || $mobile == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Los campos no pueden estar vacíos !</div>';
      return $msg;
    } elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Nombre de usuario es muy corto, tiene menos de 3 caracteres !</div>';
      return $msg;
    } elseif (filter_var($mobile, FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Ingrese solo números en el campo Móvil !</div>';
      return $msg;
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Casilla de correo inválida !</div>';
      return $msg;
    } else {

      $sql = "UPDATE tbl_users SET
          name = :name,
          username = :username,
          email = :email,
          mobile = :mobile,
          roleid = :roleid
          WHERE id = :id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $stmt->bindValue(':id', $userid);
      $result =   $stmt->execute();

      if ($result) {
        echo "<script>location.href='index.php';</script>";
        Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Realizado !</strong> Bien, su información fue actualizada correctamente !</div>');
      } else {
        echo "<script>location.href='index.php';</script>";
        Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Dato no ingresado !</div>');
      }
    }
  }




  // Delete User by Id Method
  public function deleteUserById($remove)
  {
    $sql = "DELETE FROM tbl_users WHERE id = :id ";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $remove);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Realizado !</strong> La cuenta de usuario fue borrada correctamente !</div>';
      return $msg;
    } else {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Dato no borrado !</div>';
      return $msg;
    }
  }

  // User Deactivated By Admin
  public function userDeactiveByAdmin($deactive)
  {
    $sql = "UPDATE tbl_users SET

       isActive=:isActive
       WHERE id = :id";

    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':isActive', 1);
    $stmt->bindValue(':id', $deactive);
    $result =   $stmt->execute();
    if ($result) {
      echo "<script>location.href='index.php';</script>";
      Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Realizado !</strong> Usuario desactivado correctamente !</div>');
    } else {
      echo "<script>location.href='index.php';</script>";
      Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Dato no desactivado !</div>');

      return $msg;
    }
  }


  // User Activated By Admin
  public function userActiveByAdmin($active)
  {
    $sql = "UPDATE tbl_users SET
       isActive=:isActive
       WHERE id = :id";

    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':isActive', 0);
    $stmt->bindValue(':id', $active);
    $result =   $stmt->execute();
    if ($result) {
      echo "<script>location.href='index.php';</script>";
      Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Realizado !</strong> Cuenta de usuario activada correctamente !</div>');
    } else {
      echo "<script>location.href='index.php';</script>";
      Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Usuario no activado !</div>');
    }
  }




  // Check Old password method
  public function CheckOldPassword($userid, $old_pass)
  {
    $old_pass = SHA1($old_pass);
  /*  $old_pass = password_hash($old_pass, PASSWORD_DEFAULT);*/
    $sql = "SELECT password FROM tbl_users WHERE password = :password AND id =:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':password', $old_pass);
    $stmt->bindValue(':id', $userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }



  // Change User pass By Id
public function changePasswordBysingelUserId($userid, $data, $isAdmin) {
    error_log("Password change attempt for user ID: $userid");
    error_log("Is admin: " . ($isAdmin ? "Yes" : "No"));

    $new_password = $data['new_password'];
    $confirm_password = $data['confirm_password'];

    error_log("New password: $new_password");
    error_log("Confirm password: $confirm_password");

    if ($new_password != $confirm_password) {
        error_log("Passwords do not match");
        return "Las nuevas contraseñas no coinciden.";
    }

    $passwordRegex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/';
    if (!preg_match($passwordRegex, $new_password)) {
        error_log("Password does not meet complexity requirements");
        return "La nueva contraseña no cumple con los requisitos de complejidad.";
    }

    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    error_log("New password hash: $new_password_hash");

    $sql = "UPDATE tbl_users SET password = :password WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':password', $new_password_hash);
    $stmt->bindValue(':id', $userid);
    $result = $stmt->execute();

    if ($result) {
        error_log("Password updated successfully");
        return "La contraseña ha sido cambiada exitosamente.";
    } else {
        error_log("Error updating password");
        return "Ha ocurrido un error al cambiar la contraseña.";
    }
}
}
