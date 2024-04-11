CREATE DATABASE IF NOT EXISTS invoice_app_db;
USE invoice_app_db;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO roles (nombre, descripcion) VALUES ('ADMIN', 'Rol de administrador con acceso total');
INSERT INTO roles (nombre, descripcion) VALUES ('GERENCIA', 'Rol para gerentes y directivos');
INSERT INTO roles (nombre, descripcion) VALUES ('OFICINA', 'Rol para personal administrativo de oficina');
INSERT INTO roles (nombre, descripcion) VALUES ('SALA VENTAS', 'Rol para personal de ventas en sala');
INSERT INTO roles (nombre, descripcion) VALUES ('BODEGA', 'Rol para personal encargado de bodega');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(5) NOT NULL,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT,
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuario_perfil (
    usuario_id INT PRIMARY KEY,
    correo VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(45),
    fecha_nacimiento DATE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    module_id INT,
    usuario_id INT NOT NULL,
    escritura BOOLEAN DEFAULT FALSE,
    lectura BOOLEAN DEFAULT FALSE,
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nit VARCHAR(45) NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    telefono VARCHAR(45),
    email VARCHAR(255),
    es_nit BOOLEAN DEFAULT TRUE,
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha_pedido DATE NOT NULL,
    forma_de_pago INT DEFAULT 0,
    total DECIMAL(20,2),
    status INT DEFAULT 1, -- 0 = Rechazado, 1 = Creado, 2 = Pend. Autorizar, 3 = Autorizado, 4 = En Bodega, 5 = Pedido Completado (se crea factura)
    observaciones TEXT,
    usuario_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE pedido_d (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    articulo_id INT NOT NULL,
    cantidad INT,
    precio_unitario DECIMAL(20,2),
    total DECIMAL(20,2),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dte VARCHAR(255) DEFAULT NULL,
    pedido_id INT NOT NULL,
    cliente_id INT NOT NULL,
    fecha_factura DATE NOT NULL,
    forma_de_pago INT DEFAULT 0,
    total DECIMAL(20,2),
    serie VARCHAR(45),
    numero_factura INT,
    status INT DEFAULT 1, # 0 = Anulada, 1 = Creada, 3 = En Transito, 4 = Anulada, 5 = Firmada FEL
    usuario_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE factura_d (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT NOT NULL,
    articulo_id INT NOT NULL,
    cantidad INT,
    precio_unitario DECIMAL(20,2),
    total DECIMAL(20,2),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE unidad_medida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    simbolo VARCHAR(10),
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    active INT DEFAULT 1
);

CREATE TABLE subcategorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    active INT DEFAULT 1
);

CREATE TABLE articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_articulo VARCHAR(255),
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    unidad_medida_id INT NOT NULL,
    marca_id INT NOT NULL,
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(255),
    nombre VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(45),
    correo VARCHAR(255),
    nombre_contacto VARCHAR(255),
    telefono_contacto VARCHAR(45),
    dias_credito INT NOT NULL DEFAULT 0,
    nit VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE matches_productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    articulo_id INT NOT NULL,
    nombres_alternativos TEXT NOT NULL,  --Diccionario para almacenar nombres alternativos del producto
    proveedor_id INT NOT NULL,
    veces_matcheado INT DEFAULT 1, -- Cantidad de veces que se dio si a Match
    FOREIGN KEY (articulo_id) REFERENCES articulos(id),
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id)
);

CREATE TABLE tipos_precio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL, -- Ejemplo: 'Publico', 'Mayorista', 'Super Mayorista'
    descripcion TEXT,
    active BOOLEAN DEFAULT TRUE
);

-- Insertar tipos de precios
INSERT INTO tipos_precio (nombre, descripcion) VALUES ('Publico', 'Precio para el consumidor final');
INSERT INTO tipos_precio (nombre, descripcion) VALUES ('Mayorista', 'Precio para compras al por mayor');
INSERT INTO tipos_precio (nombre, descripcion) VALUES ('Super Mayorista', 'Precio para compras en grandes cantidades');

CREATE TABLE precios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    articulo_id INT NOT NULL,
    tipo_precio_id INT NOT NULL,
    precio DECIMAL(20,2) NOT NULL,
    costo DECIMAL(20,2),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (articulo_id) REFERENCES articulos(id),
    FOREIGN KEY (tipo_precio_id) REFERENCES tipos_precio(id)
);

CREATE TABLE modulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45) NOT NULL,
    orden INT DEFAULT 0,
    padre_id INT,
    ruta VARCHAR(200) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    active INT DEFAULT 1
);

CREATE TABLE ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT NOT NULL,
    proveedor_id INT NOT NULL,
    observaciones TEXT,
    active INT DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE ingresos_d (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingreso_id INT NOT NULL,
    articulo_id INT NOT NULL,
    cantidad DECIMAL(10,2),
    costo DECIMAL(20,2)
);

CREATE TABLE egresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT NOT NULL,
    observaciones TEXT,
    active INT DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE egresos_d (
    id INT AUTO_INCREMENT PRIMARY KEY,
    egreso_id INT NOT NULL,
    articulo_id INT NOT NULL,
    cantidad DECIMAL(10,2),
    costo DECIMAL(20,2)
);

CREATE TABLE movimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    articulo_id INT NOT NULL,
    stock INT NOT NULL,
    usuario_last_update INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_last_update) REFERENCES usuarios(id)
);

CREATE TABLE movimientos_d (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    documento_id INT NOT NULL, -- Aqui tiene que ir egreso_id o ingreso_id
    articulo_id INT NOT NULL,
    cantidad INT NOT NULL,
    tipo VARCHAR(45) NOT NULL, -- Ejemplos: 'EGRESO', 'INGRESO', 'AJUSTE INVENTARIO'
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Bitacoras

CREATE TABLE bitacora_movimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movimiento_id INT NOT NULL,
    usuario_id INT NOT NULL,
    tipo VARCHAR(50) NOT NULL, -- Ejemplo: 'CREACION', 'ACTUALIZACION'
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movimiento_id) REFERENCES movimientos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE bitacora_facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT NOT NULL,
    usuario_id INT NOT NULL,
    tipo VARCHAR(50) NOT NULL, -- Ejemplo: 'CREACION', 'ANULACION'
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (factura_id) REFERENCES facturas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);



CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    estado INT NOT NULL DEFAULT 0, -- 0 = Creada, 1 = Enviada, 2 = No leida, 3 = Leida
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

DELIMITER $$

CREATE PROCEDURE LoginUsuario(IN _usuario VARCHAR(255))
BEGIN
    SELECT id, usuario, password, rol_id, active
    FROM usuarios
    WHERE usuario = _usuario AND active = TRUE;
END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE RegisterUsuario(
    IN _codigo VARCHAR(5), 
    IN _usuario VARCHAR(255), 
    IN _password VARCHAR(255), 
    IN _rol_id INT
)
BEGIN
    DECLARE _usuarioExists INT;
    
    SELECT COUNT(*)
    INTO _usuarioExists
    FROM usuarios
    WHERE usuario = _usuario;
    
    IF _usuarioExists = 0 THEN
        INSERT INTO usuarios(codigo, usuario, password, rol_id)
        VALUES (_codigo, _usuario, _password, _rol_id);
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El nombre de usuario ya existe.';
    END IF;
END$$

DELIMITER ;


# Triggers

-- Movimientos Crear
DELIMITER //
CREATE TRIGGER after_movimiento_insert
AFTER INSERT ON movimientos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_movimientos(movimiento_id, usuario_id, tipo, descripcion)
    VALUES (NEW.id, NEW.usuario_last_update, 'CREACION', CONCAT('Creación de movimiento de stock con ID ', NEW.id));
END; //
DELIMITER ;

-- Movimientos Actualizar
DELIMITER //
CREATE TRIGGER after_movimiento_update
AFTER UPDATE ON movimientos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_movimientos(movimiento_id, usuario_id, tipo, descripcion)
    VALUES (NEW.id, NEW.usuario_last_update, 'ACTUALIZACION', CONCAT('Actualización de movimiento de stock con ID ', NEW.id));
END; //
DELIMITER ;

-- Facturas Crear
DELIMITER //
CREATE TRIGGER after_factura_insert
AFTER INSERT ON facturas
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_facturas(factura_id, usuario_id, tipo, descripcion)
    VALUES (NEW.id, NEW.usuario_id, 'CREACION', CONCAT('Creación de factura con ID ', NEW.id));
END; //
DELIMITER ;

-- Facturas Anular
DELIMITER //
CREATE TRIGGER after_factura_anulacion
AFTER UPDATE ON facturas
FOR EACH ROW
BEGIN
    IF NEW.status = 0 AND OLD.status != 0 THEN
        INSERT INTO bitacora_facturas(factura_id, usuario_id, tipo, descripcion)
        VALUES (NEW.id, NEW.usuario_id, 'ANULACION', CONCAT('Anulación de factura con ID ', NEW.id, '. Razón: Cambio de estado a 0.'));
    END IF;
END; //
DELIMITER ;

