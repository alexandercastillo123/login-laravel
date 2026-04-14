document.addEventListener('DOMContentLoaded', () => {
    // 1. Mostrar nombre de usuario
    const user = JSON.parse(localStorage.getItem('usuario'));
    const bienvenida = document.getElementById('bienvenida-user');
    if (user && bienvenida) {
        bienvenida.innerText = `Hola, ${user.nombres}`;
    }

    cargarUsuarios();

    const btnLogout = document.getElementById('btn-logout');
    if (btnLogout) {
        btnLogout.addEventListener('click', cerrarSesion);
    }
});

async function cargarUsuarios() {
    const tbody = document.getElementById('lista-usuarios');
    if (!tbody) return;

    try {
        const response = await fetch('/api/usuarios');
        const data = await response.json();

        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No hay usuarios registrados</td></tr>';
            return;
        }

        data.forEach(u => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${u.id || u.idUsuario || '-'}</td>
                <td>${u.nombres}</td>
                <td>${u.apellidos}</td>
                <td>${u.dni}</td>
                <td>${u.email}</td>
            `;
            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error("Error al obtener usuarios:", error);
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #ff4747;">Error al cargar datos</td></tr>';
    }
}

async function cerrarSesion() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const redirectUrl = document.getElementById('url-base').value;

    try {
        await fetch('/api/cerrar_sesion', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        });
    } catch (e) {
        console.error("Error al cerrar sesión en servidor");
    }

    localStorage.clear();
    window.location.href = redirectUrl;
}
