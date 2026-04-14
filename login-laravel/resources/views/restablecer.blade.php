<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
</head>
<body>
    <div class="wrapper active-popup">
        <div class="form-box">
            <form id="form-restablecer">
                <h1>Nueva Contraseña</h1>

                <div class="input-box">
                    <input type="text" id="rest-codigo" placeholder="Ingresa el código de 6 dígitos" required>
                </div>

                <div class="input-box">
                    <input type="password" id="rest-pass" placeholder="Nueva contraseña" required>
                </div>

                <div class="input-box">
                    <input type="password" id="rest-pass-confirm" placeholder="Repite la contraseña" required>
                </div>

                <button type="submit" class="btn">Actualizar Contraseña</button>
            </form>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const emailUser = urlParams.get('email');

        document.getElementById('form-restablecer').addEventListener('submit', async (e) => {
            e.preventDefault();

            const nuevaPass = document.getElementById('rest-pass').value;
            const confirmPass = document.getElementById('rest-pass-confirm').value;

            if(nuevaPass !== confirmPass) {
                alert('Las contraseñas no coinciden');
                return;
            }

            const res = await fetch('/api/restablecer-pass', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email: emailUser,
                    codigo: document.getElementById('rest-codigo').value,
                    nuevaPass: nuevaPass
                })
            });

            const data = await res.json();

            if(data.resultado == 1) {
                alert('Contraseña actualizada correctamente.');
                window.location.href = "{{ url('/') }}";
            } else {
                alert('Código incorrecto o expirado.');
            }
        });
    </script>
</body>
</html>
