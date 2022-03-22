/*
Procedimiento para reservar una habitacion
*/
CREATE PROCEDURE introducirDatosReservaHabitacion(
    codReserva SERIAL,
    idOferta varchar(30),
    idCliente varchar(30),
    idHabitacion varchar(30),
    precio decimal(6,2),
    pagada boolean,
    nPersonas int(3)
)
BEGIN
    INSERT INTO reservaHist values(
        codReserva,
        idOferta,
        idCliente,
        idHabitacion,
        /*llamar a procedimiento para calcular el precio de la habitacion*/,
        'activa' ,
        pagada,
        nPersonas)
END

/*
Procedimiento para dar de alta un cliente/empleado
*/
CREATE PROCEDURE introducirDatosCliente(
    isEmployee boolean,
    nif varchar(30), nombre varchar(30), apellidos varchar(30), email varchar(30),telefono varchar(30),
    fechaNac DATE, nacionalidad varchar(30), cp varchar(30), ciudad varchar(30), paisResidencia varchar(30)
)
BEGIN
    IF isEmployee = true THEN
        INSERT INTO empleado(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
        values(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
    ELSE THEN
        INSERT INTO cliente(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
        values(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
END

# Procedure auxiliar de inserción de multiplicador 
# J.PALOMAR

DROP PROCEDURE IF EXISTS insert_multiplicador;

DELIMITER $$
CREATE PROCEDURE insert_multiplicador (IN v_temporada VARCHAR(30), IN v_multiplicador DECIMAL(5, 2))

BEGIN 

DECLARE v_currentyear INT;
SELECT YEAR(NOW()) INTO v_currentyear;

INSERT INTO temporada (nombre, anyo, multiplicador) VALUES (v_temporada, v_currentyear, v_multiplicador);

END;

$$
DELIMITER ;

# Procedure auxiliar de actualización de multiplicador 
# J.PALOMAR

DROP PROCEDURE IF EXISTS update_multiplicador;

DELIMITER $$
CREATE PROCEDURE update_multiplicador (IN v_temporada VARCHAR(30), IN v_multiplicador DECIMAL(5, 2))

BEGIN 

	DECLARE v_currentyear INT;
	SELECT YEAR(NOW()) INTO v_currentyear;
	
	
	UPDATE temporada SET multiplicador = v_multiplicador WHERE nombre = v_temporada AND anyo = v_currentyear;

END;

$$
DELIMITER ;


# Procedure de establecimiento de multiplicador utilizando los procedures previos
# J.PALOMAR

DROP PROCEDURE IF EXISTS set_multiplicador;

DELIMITER $$
CREATE PROCEDURE set_multiplicador (IN v_temporada VARCHAR(30), IN v_multiplicador DECIMAL(5, 2))

BEGIN 

	DECLARE v_currentyear INT;
	DECLARE v_exists INT;
	
	
	SELECT YEAR(NOW()) INTO v_currentyear;
	SELECT -1 INTO v_exists FROM temporada WHERE NOT EXISTS (SELECT * FROM temporada temp WHERE temp.anyo = v_currentyear AND temp.nombre = v_temporada);
	
	IF v_exists = -1 THEN
		CALL insert_multiplicador(v_temporada, v_multiplicador);
	ELSE
		CALL update_multiplicador(v_temporada, v_multiplicador);
	END IF;

END;

$$
DELIMITER ;


CALL set_multiplicador('Media', 1.5);