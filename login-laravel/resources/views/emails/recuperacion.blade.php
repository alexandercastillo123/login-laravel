<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperación de Contraseña</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #162938; text-align: center;">Código de Recuperación - Senatino</h2>
        <p>Hola,</p>
        <p>Has solicitado restablecer tu contraseña. Tu código de validación es:</p>
        <div style="background: #f4f4f4; padding: 15px; border-radius: 5px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #162938;">
            {{ $codigo }}
        </div>
        <p style="text-align: center; margin-top: 20px;">
            <strong>Recuerda:</strong> Tienes 5 minutos antes de que este código expire.
        </p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">
            Si no has solicitado este cambio, puedes ignorar este correo de forma segura.
        </p>
    </div>
</body>
</html>
