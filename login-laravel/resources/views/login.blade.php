<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro - Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <header>
        <h2 class="logo">Logo</h2>
        <nav class="navigation">
            <a href="#">Home</a>
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Login</h2>
            <form id="form-login">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" id="signin-email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" id="signin-password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="{{ url('/recuperar') }}">Forgot Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form id="form-register">
                <div class="input-box">
                    <input type="text" id="reg-nombres" required>
                    <label>Nombres</label>
                </div>
                <div class="input-box">
                    <input type="text" id="reg-apellidos" required>
                    <label>Apellidos</label>
                </div>
                <div class="input-box">
                    <input type="text" id="reg-dni" required>
                    <label>DNI</label>
                </div>
                <div class="input-box">
                    <input type="email" id="reg-email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" id="reg-pass" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        const wrapper = document.querySelector('.wrapper');
        const loginLink = document.querySelector('.login-link');
        const registerLink = document.querySelector('.register-link');
        const btnPopup = document.querySelector('.btnLogin-popup');
        const iconClose = document.querySelector('.icon-close');

        registerLink.addEventListener('click', () => {
            wrapper.classList.add('active');
        });

        loginLink.addEventListener('click', () => {
            wrapper.classList.remove('active');
        });

        btnPopup.addEventListener('click', () => {
            wrapper.classList.add('active-popup');
        });

        iconClose.addEventListener('click', () => {
            wrapper.classList.remove('active-popup');
        });

        document.getElementById('form-login').addEventListener('submit', async (e) => {
            e.preventDefault();
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email: document.getElementById('signin-email').value,
                    pass: document.getElementById('signin-password').value
                })
            });
            const data = await res.json();
            if(data.res) {
                alert('Bienvenido: ' + data.usuario.nombres);
                window.location.href = '/home';
            } else {
                alert(data.msg);
            }
        });

        document.getElementById('form-register').addEventListener('submit', async (e) => {
            e.preventDefault();
            const res = await fetch('/api/registro', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nombres: document.getElementById('reg-nombres').value,
                    apellidos: document.getElementById('reg-apellidos').value,
                    dni: document.getElementById('reg-dni').value,
                    email: document.getElementById('reg-email').value,
                    pass: document.getElementById('reg-pass').value
                })
            });
            const data = await res.json();
            if(data.res) {
                alert(data.msg);
                wrapper.classList.remove('active'); // Te regresa al login
            } else {
                alert('Error al registrar');
            }
        });
    </script>
</body>
</html>
