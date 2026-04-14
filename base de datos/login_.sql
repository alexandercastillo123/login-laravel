DROP database IF EXISTS login_;

CREATE DATABASE IF NOT EXISTS login_;
USE login_;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres CHAR(50) NOT NULL,
    apellidos CHAR(50) NOT NULL,
    dni INT UNIQUE NOT NULL,
    email CHAR(50) UNIQUE NOT NULL,
    pass CHAR(25) NOT NULL,
    codigo_recuperacion CHAR(10) NULL,
    fecha_expiracion DATETIME NULL
);

INSERT INTO usuarios (nombres, apellidos, dni, email, pass)
VALUES ('alexander gabriel', 'peralta', 75218119, 'alekecastillo1@gmail.com', '123456');

SELECT * FROM usuarios;

DELIMITER //

CREATE PROCEDURE sp_RegistrarUsuario(
    IN _nombres CHAR(50),
    IN _apellidos CHAR(50),
    IN _dni INT,
    IN _email CHAR(50),
    IN _pass CHAR(25)
)
BEGIN
    INSERT INTO usuarios (nombres, apellidos, dni, email, pass)
    VALUES (_nombres, _apellidos, _dni, _email, _pass);
END //

CREATE PROCEDURE sp_ActualizarUsuario(
    IN _id INT,
    IN _nombres CHAR(50),
    IN _apellidos CHAR(50),
    IN _dni INT,
    IN _email CHAR(50),
    IN _pass CHAR(25)
)
BEGIN
    UPDATE usuarios 
    SET nombres = _nombres,
        apellidos = _apellidos,
        dni = _dni,
        email = _email,
        pass = _pass
    WHERE id = _id;
END //

CREATE PROCEDURE sp_Logeandote(
    IN _email CHAR(50),
    IN _pass CHAR(50)
)
BEGIN
    SELECT id, nombres, apellidos, email FROM usuarios
    WHERE email = _email AND pass = _pass;
END //

CREATE PROCEDURE sp_ObtenerUsuario (IN _id INT)
BEGIN
    SELECT nombres, apellidos, dni, email, pass FROM usuarios WHERE id = _id;
END //

CREATE PROCEDURE sp_ListarUsuarios()
BEGIN
    SELECT id, nombres, apellidos, dni, email, pass FROM usuarios;
END //

CREATE PROCEDURE sp_GenerarCodigoRecuperacion(
    IN _email CHAR(50),
    IN _codigo CHAR(10)
)
BEGIN
    IF EXISTS (SELECT 1 FROM usuarios WHERE email = _email) THEN
        UPDATE usuarios 
        SET codigo_recuperacion = _codigo,
            fecha_expiracion = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
        WHERE email = _email;
        SELECT 1 AS resultado;
    ELSE
        SELECT 0 AS resultado;
    END IF;
END //

CREATE PROCEDURE sp_RestablecerPass(
    IN _email CHAR(50),
    IN _codigo CHAR(10),
    IN _nuevapass CHAR(25)
)
BEGIN
    IF EXISTS (SELECT 1 FROM usuarios 
               WHERE email = _email 
               AND codigo_recuperacion = _codigo 
               AND fecha_expiracion > NOW()) THEN
        UPDATE usuarios 
        SET pass = _nuevapass,
            codigo_recuperacion = NULL,
            fecha_expiracion = NULL
        WHERE email = _email;
        SELECT 1 AS resultado;
    ELSE
        SELECT 0 AS resultado;
    END IF;
END //

DELIMITER ;