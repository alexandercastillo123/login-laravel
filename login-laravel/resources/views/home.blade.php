<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <input type="hidden" id="url-base" value="{{ url('/') }}">

    <header>
        <h2 class="logo">Logo</h2>
        <nav class="navigation">
            <a href="#">Home</a>
            <a href="#">Usuarios</a>
            <a href="perfil" onclick="window.location.href = '/perfil'">Perfil</a>
            <button class="btn-logout" id="btn-logout">Cerrar Sesión</button>
        </nav>
    </header>

    <div class="main-content">
        <div style="text-align: center; color: white; margin-bottom: 20px;">
            <h2 id="bienvenida-user">Bienvenido</h2>
            <p>Has ingresado al panel de control.</p>
        </div>

        <div class="table-container">
            <h3>Listado de Usuarios</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody id="lista-usuarios">
                    <tr>
                        <td colspan="6" style="text-align: center;">Cargando...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
