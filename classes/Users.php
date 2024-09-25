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



  // User Registration Method
  public function userRegistration($data)
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
<strong>Error !</strong> Por favor, El campo Registro de Usuario no puede estar vacío !</div>';
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
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
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
<strong>Error !</strong> La contraseña deberá tener 6 caracteres !</div>';
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




  // User Login Authotication Method
  public function userLoginAuthotication($data)
  {
    $email = $data['email'];
    $password = $data['password'];


    $checkEmail = $this->checkExistEmail($email);

    if ($email == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Casilla de correo o Cantraseña no pueden estar vacíos !</div>';
      return $msg;
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Casilla de correo inválida !</div>';
      return $msg;
    } elseif ($checkEmail == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Esa casilla no está registrada, por favor utilice la casilla o contraseña correcta !</div>';
      return $msg;
    } else {


      $logResult = $this->userLoginAutho($email, $password);
      $chkActive = $this->CheckActiveUser($email);

      if ($chkActive == TRUE) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Lo sentímos, sucuenta está desactivada, contátenos !</div>';
        return $msg;
      } elseif ($logResult) {

        Session::init();
        Session::set('login', TRUE);
        Session::set('id', $logResult->id);
        Session::set('roleid', $logResult->roleid);
        Session::set('name', $logResult->name);
        Session::set('email', $logResult->email);
        Session::set('username', $logResult->username);
        Session::set('logMsg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Realizado !</strong> Ha ingresado correctamente !</div>');
        echo "<script>location.href='index.php';</script>";
      } else {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Casilla o contraseña incorrectas !</div>';
        return $msg;
      }
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
    <strong>Error !</strong> Ingrese dolo números en el campo Móvil !</div>';
      return $msg;
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
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
    <strong>Success !</strong> La cuenta de usuario fue borrada correctamente !</div>';
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
          <strong>Success !</strong> Usuario desactivado correctamente !</div>');
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
    <strong>Error !</strong> Dato no activado !</div>');
    }
  }




  // Check Old password method
  public function CheckOldPassword($userid, $old_pass)
  {
    $old_pass = SHA1($old_pass);
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
  public  function changePasswordBysingelUserId($userid, $data)
  {

    $old_pass = $data['old_password'];
    $new_pass = $data['new_password'];


    if ($old_pass == "" || $new_pass == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Contraseña no puede estar vacía !</div>';
      return $msg;
    } elseif (strlen($new_pass) < 6) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> La nueva contraseña debe contener al menos 6 caracteres !</div>';
      return $msg;
    }

    $oldPass = $this->CheckOldPassword($userid, $old_pass);
    if ($oldPass == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Error !</strong> La contraseña anterior no coincide !</div>';
      return $msg;
    } else {
      $new_pass = SHA1($new_pass);
      $sql = "UPDATE tbl_users SET

            password=:password
            WHERE id = :id";

      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $new_pass);
      $stmt->bindValue(':id', $userid);
      $result =   $stmt->execute();

      if ($result) {
        echo "<script>location.href='index.php';</script>";
        Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Realizado !</strong> Bien, la contraseña fue modificada correctamente !</div>');
      } else {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error !</strong> La contraseña no pudo ser modificada !</div>';
        return $msg;
      }
    }
  }
}
