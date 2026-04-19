<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
</head>
<body>
    <div class="wrapper active-popup">
        <div class="form-box">
            <form id="form-recuperar">
                <h1>Recuperar Contraseña</h1>
                <p style="color: white; margin-bottom: 20px; text-align: center;">
                    Ingresa tu correo para generar tu código de validación.
                </p>

                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" id="rec-email" placeholder=" " required>
                    <label>Tu correo electrónico</label>
                </div>

                <button type="submit" class="btn">Generar Código</button>

                <div class="login-register">
                    <p><a href="{{ url('/') }}" class="login-link">Volver al Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        document.getElementById('form-recuperar').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('rec-email').value;
            const codigoAleatorio = Math.floor(100000 + Math.random() * 900000);

            try {
                const res = await fetch('/api/recuperar-codigo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        codigo: codigoAleatorio
                    })
                });

                const data = await res.json();

                if(data.resultado == 1) {
                    alert('Código enviado. Por favor, revisa tu correo electrónico (incluyendo la carpeta de spam).');
                    window.location.href = "{{ url('/restablecer') }}?email=" + encodeURIComponent(email);
                } else {
                    alert('Error: El correo ingresado no existe.');
                }
            } catch (error) {
                console.error('Error en la petición:', error);
                alert('No se pudo conectar con el servidor. Revisa tu consola.');
            }
        });
    </script>
</body>
</html>
