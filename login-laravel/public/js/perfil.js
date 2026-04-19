document.addEventListener('DOMContentLoaded', () => {
    cargarPerfil();

    const btnEditMode = document.getElementById('btn-edit-mode');
    const btnCancelEdit = document.getElementById('btn-cancel-edit');
    const formPerfil = document.getElementById('form-perfil');
    const viewPerfil = document.getElementById('perfil-view');

    if (btnEditMode) {
        btnEditMode.addEventListener('click', () => {
            viewPerfil.classList.add('hidden');
            formPerfil.classList.remove('hidden');
        });
    }

    if (btnCancelEdit) {
        btnCancelEdit.addEventListener('click', () => {
            formPerfil.classList.add('hidden');
            viewPerfil.classList.remove('hidden');
        });
    }

    if (formPerfil) {
        formPerfil.addEventListener('submit', actualizarPerfil);
    }
});

async function cargarPerfil() {
    try {
        const response = await fetch('/api/perfil');
        const data = await response.json();

        if (response.status === 401) {
            window.location.href = '/';
            return;
        }

        if (data) {
            // Llenar vista
            document.getElementById('view-nombres').innerText = data.nombres;
            document.getElementById('view-apellidos').innerText = data.apellidos;
            document.getElementById('view-dni').innerText = data.dni;
            document.getElementById('view-email').innerText = data.email;

            // Llenar formulario
            document.getElementById('user-id').value = data.id || data.idUsuario;
            document.getElementById('perfil-nombres').value = data.nombres;
            document.getElementById('perfil-apellidos').value = data.apellidos;
            document.getElementById('perfil-dni').value = data.dni;
            document.getElementById('perfil-email').value = data.email;
        }
    } catch (error) {
        console.error("Error al cargar perfil:", error);
    }
}

async function actualizarPerfil(e) {
    e.preventDefault();

    const id = document.getElementById('user-id').value;
    const nombres = document.getElementById('perfil-nombres').value;
    const apellidos = document.getElementById('perfil-apellidos').value;
    // DNI y Email son readonly, pero los enviamos por si el SP los requiere o para validación
    const dni = document.getElementById('perfil-dni').value;
    const email = document.getElementById('perfil-email').value;
    const pass = document.getElementById('perfil-pass').value;

    try {
        const response = await fetch(`/api/actualizar/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombres,
                apellidos,
                dni,
                email,
                pass: pass || ''
            })
        });

        const data = await response.json();

        if (data.res) {
            alert('Perfil actualizado correctamente');
            
            // Actualizar localStorage para el dashboard
            const user = JSON.parse(localStorage.getItem('usuario')) || {};
            user.nombres = nombres;
            localStorage.setItem('usuario', JSON.stringify(user));
            
            // Recargar para volver a modo vista con datos nuevos
            location.reload();
        } else {
            alert('Error al actualizar perfil: ' + (data.msg || ''));
        }
    } catch (error) {
        console.error("Error al actualizar perfil:", error);
        alert('Ocurrió un error inesperado');
    }
}
