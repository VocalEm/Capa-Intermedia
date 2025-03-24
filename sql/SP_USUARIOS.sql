DELIMITER //
CREATE PROCEDURE ManageUser(
    IN p_option VARCHAR(10),
    IN p_id INT,
    IN p_nombre VARCHAR(50),
    IN p_apellido_p VARCHAR(50),
    IN p_apellido_m VARCHAR(50),
    IN p_sexo BOOLEAN,
    IN p_correo VARCHAR(80),
    IN p_username VARCHAR(50),
    IN p_password VARCHAR(255),
    IN p_tipo_usuario TINYINT,
    IN p_imagen VARCHAR(255),
    IN p_fecha_nacimiento DATE,
    IN p_privacidad BOOLEAN
)
BEGIN
    IF p_option = 'REGISTRAR' THEN
        INSERT INTO USUARIO (NOMBRE, APELLIDO_P, APELLIDO_M, SEXO, CORREO, USERNAME, PASSWORD, TIPO_USUARIO, IMAGEN, FECHA_NACIMIENTO, FECHA_REGISTRO, PRIVACIDAD)
        VALUES (p_nombre, p_apellido_p, p_apellido_m, p_sexo, p_correo, p_username, p_password, p_tipo_usuario, p_imagen, p_fecha_nacimiento, NOW(), p_privacidad);
    
    ELSEIF p_option = 'MODIFICAR' THEN
        UPDATE USUARIO 
        SET NOMBRE = p_nombre, APELLIDO_P = p_apellido_p, APELLIDO_M = p_apellido_m,
            SEXO = p_sexo, CORREO = p_correo, USERNAME = p_username, PASSWORD = p_password, 
            TIPO_USUARIO = p_tipo_usuario, IMAGEN = p_imagen, FECHA_NACIMIENTO = p_fecha_nacimiento,
            PRIVACIDAD = p_privacidad
        WHERE ID = p_id;
    
    ELSEIF p_option = 'ELIMINAR' THEN
        DELETE FROM USUARIO WHERE ID = p_id;
    
    ELSEIF p_option = 'LOGIN' THEN
        SELECT ID, NOMBRE, USERNAME, CORREO, TIPO_USUARIO 
        FROM USUARIO 
        WHERE (USERNAME = p_username OR CORREO = p_correo) AND PASSWORD = p_password;
    END IF;
END //
DELIMITER ;
