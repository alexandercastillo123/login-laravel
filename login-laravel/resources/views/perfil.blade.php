<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>

    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .profile-container {
            width: 90%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 30px;
            color: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }
        .profile-container h3 {
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 15px;
        }
        .info-row {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 10px;
        }
        .info-row label {
            font-weight: 600;
            color: #ddd;
        }
        .info-row span {
            color: #fff;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            color: white;
            padding: 0 15px;
            font-size: 1em;
            outline: none;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: #fff;
        }
        .form-control[readonly] {
            background: rgba(0, 0, 0, 0.2);
            cursor: not-allowed;
            border-color: rgba(255,255,255,0.1);
            color: #ccc;
        }
        .btn-toggle, .btn-primary, .btn-secondary {
            width: 100%;
            height: 45px;
            border: 2px solid #fff;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            margin-top: 10px;
        }
        .btn-toggle, .btn-primary {
            background: #162938;
            color: #fff;
        }
        .btn-toggle:hover, .btn-primary:hover {
            background: #fff;
            color: #162938;
        }
        .btn-secondary {
            background: transparent;
            color: #fff;
            margin-top: 5px;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.1);
        }
        .hidden {
            display: none !important;
        }
    </style>
</head>
<body>
    <input type="hidden" id="url-base" value="{{ url('/') }}">

    <header>
        <h2 class="logo">Logo</h2>
        <nav class="navigation">
            <a href="/home">Home</a>
            <a href="/perfil">Perfil</a>
            <button class="btn-logout" id="btn-logout">Cerrar Sesión</button>
        </nav>
    </header>

    <div class="main-content">
        <div class="profile-container">
            <h3>Mi Perfil</h3>
            
            <!-- Vista de Información -->
            <div id="perfil-view">
                <div class="info-row">
                    <label>Nombres:</label>
                    <span id="view-nombres">-</span>
                </div>
                <div class="info-row">
                    <label>Apellidos:</label>
                    <span id="view-apellidos">-</span>
                </div>
                <div class="info-row">
                    <label>DNI:</label>
                    <span id="view-dni">-</span>
                </div>
                <div class="info-row">
                    <label>Email:</label>
                    <span id="view-email">-</span>
                </div>
                <button type="button" class="btn-toggle" id="btn-edit-mode">Editar Perfil</button>
            </div>

            <!-- Formulario de Edición -->
            <form id="form-perfil" class="hidden">
                <input type="hidden" id="user-id">
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" id="perfil-nombres" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" id="perfil-apellidos" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>DNI</label>
                    <input type="text" id="perfil-dni" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="perfil-email" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Nueva Contraseña (opcional)</label>
                    <input type="password" id="perfil-pass" class="form-control">
                </div>
                <button type="submit" class="btn-primary">Guardar Cambios</button>
                <button type="button" class="btn-secondary" id="btn-cancel-edit">Cancelar</button>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="{{ asset('js/perfil.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
