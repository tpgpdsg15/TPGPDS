<?php
include 'inc/header.php';
Session::CheckLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
  $register = $users->userRegistration($_POST);
}
?>

<style>
    .register-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    .register-header {
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
    .btn-register {
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
    .btn-register:hover {
        background-color: #2980b9;
    }
    .flash-message {
        background-color: #e74c3c;
        color: white;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
        text-align: center;
}
 .password-requirements {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }
    .error-message {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
    }
		.success-message {
    background-color: #2ecc71;
    color: white;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    text-align: center;
}
</style>
<div class="register-container">
    <h3 class="register-header">Registro de usuario</h3>
	  <?php
    if (isset($register)) {
        $messageClass = (strpos($register, 'exitosamente') !== false) ? 'success-message' : 'error-message';
        echo "<div class='flash-message $messageClass'>$register</div>";
    }
    ?>
    <form action="" method="post" id="registerForm">
        <div class="form-group">
            <label for="name">Su nombre</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" name="username" id="username" required>
            <span id="username-error" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="email">Casilla de correo</label>
            <input type="email" name="email" id="email" required>
            <span id="email-error" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="mobile">Número móvil</label>
            <input type="text" name="mobile" id="mobile" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            <div class="password-requirements">
                La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, un número y un símbolo.
            </div>
            <span id="password-error" class="error-message"></span>
        </div>
        <input type="hidden" name="roleid" value="3">
        <div class="form-group">
            <button type="submit" name="register" class="btn-register">Registrar</button>
        </div>
    </form>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let hasError = false;
    const password = document.getElementById('password').value;
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

    if (!passwordRegex.test(password)) {
        document.getElementById('password-error').textContent = 'La contraseña no cumple con los requisitos.';
        hasError = true;
    } else {
        document.getElementById('password-error').textContent = '';
    }

    if (hasError) {
        e.preventDefault();
    }
});

document.getElementById('username').addEventListener('blur', function() {
    checkUnique('username', this.value);
});

document.getElementById('email').addEventListener('blur', function() {
    checkUnique('email', this.value);
});

function checkUnique(field, value) {
    fetch('check_unique.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `field=${field}&value=${value}`
    })
    .then(response => response.json())
    .then(data => {
        if (!data.isUnique) {
            document.getElementById(`${field}-error`).textContent = `Este ${field} ya está en uso.`;
        } else {
            document.getElementById(`${field}-error`).textContent = '';
        }
    });
}
</script>

<?php include 'inc/footer.php'; ?>
