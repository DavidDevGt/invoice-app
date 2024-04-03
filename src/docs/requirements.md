# InvoiceApp

1. **Autenticación de Usuarios**:
   - Los usuarios deben poder iniciar sesión utilizando su usuario y contraseña.
   - Deben existir roles de usuario (por ejemplo, administrador, contador, vendedor) con diferentes niveles de acceso a las funciones de la aplicación.

2. **Gestión de Roles y Permisos**:
   - Los administradores deben poder crear, actualizar y eliminar roles de usuario.
   - Los roles deben tener permisos asociados para acceder a diferentes partes de la aplicación (por ejemplo, crear facturas, gestionar clientes, ver informes fiscales).

3. **Gestión de Clientes**:
   - Debe ser posible agregar, ver, actualizar y eliminar clientes.
   - Los clientes deben tener información como nombre, dirección, NIT, correo electrónico, etc.

4. **Gestión de Pedidos y Facturas**:
   - Debe ser posible crear nuevos pedidos para clientes.
   - Los pedidos deben contener información detallada sobre los artículos comprados, cantidades, precios unitarios, etc.
   - Los pedidos deben poder convertirse en facturas una vez que se completen.
   - Debe ser posible generar facturas basadas en los pedidos y enviarlas a los clientes.
   - Las facturas deben contener información sobre los artículos vendidos, cantidades, precios, campos obligatorios de la SAT (Superintendencia de Administración Tributaria), como el NIT del cliente, el número de factura, serie, fecha de emisión, etc.

5. **Gestión de Inventario**:
   - Debe ser posible agregar, ver, actualizar y eliminar artículos del inventario.
   - Los artículos deben tener información como nombre, descripción, precio de venta, precio de compra, existencias en inventario, etc.

6. **Registro de Movimientos de Inventario**:
   - Debe haber un registro de todos los movimientos de inventario, como ingresos de mercadería, ventas, devoluciones, ajustes de inventario, etc.
   - Cada movimiento de inventario debe estar asociado con el usuario que lo realizó y la fecha en que ocurrió.

## Pantallas o Vistas de la App

1. **Pantalla de inicio / Inicio de Sesión:**
   - Una pantalla simple donde el usuario puede ingresar sus credenciales (usuario y contraseña) para acceder a la aplicación.

2. **Dashboard o Panel de Control:**
   - Una pantalla central desde donde el usuario puede acceder a las principales funcionalidades de la aplicación de manera rápida y fácil. Aquí, el usuario puede ver:
     - Lista de clientes.
     - Pedidos recientes.
     - Vista de calendario con fechas de pedidos programados.
     - Acceso a otras funciones importantes de la aplicación, como la gestión de clientes, pedidos, facturas, etc.
     - La posibilidad de iniciar un nuevo pedido de manera intuitiva.

3. **Vista de Pedido y POS (Punto de Venta):**
   - En esta vista, el usuario tendrá la capacidad de realizar todas las acciones necesarias para gestionar un pedido de manera fluida y eficiente. Aquí se incluyen:
     - **Barra de búsqueda de productos:** Permite al usuario buscar productos por nombre o código de barras.
     - **Lista de productos disponibles:** Muestra los productos disponibles para agregar al pedido, con detalles como nombre, precio unitario y cantidad en stock.
     - **Formulario de cliente:** Permite al usuario agregar o seleccionar un cliente para el pedido, con campos como nombre, dirección y contacto.
     - **Tabla de líneas de pedido:** Muestra los productos agregados al pedido, con detalles como nombre del producto, cantidad, precio unitario y total por línea.
     - **Opciones de edición:** Botones o campos de entrada que permiten al usuario editar la cantidad de productos, eliminar líneas de pedido o ajustar el precio de los productos (sin reducir el precio por debajo del establecido en la base de datos).
     - **Botones de acción:** Permiten al usuario guardar el pedido, cancelarlo o realizar otras acciones relevantes, como imprimir la factura o procesar el pago.
     - **Resumen del pedido:** Muestra un resumen del pedido actual, incluyendo el total de productos, el total a pagar y cualquier otra información relevante.

- Ultima Actualizacion: 31-03-2024 12:00 PM

### Base de Datos

```sql
CREATE DATABASE IF NOT EXISTS sistema_facturacion;
USE sistema_facturacion;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT,
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    module_id INT,
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
    status INT DEFAULT 1,
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    status INT DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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

CREATE TABLE articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    active BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipos_precio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL, -- Ejemplo: 'Publico', 'Mayorista', 'Super Mayorista'
    descripcion TEXT,
    active BOOLEAN DEFAULT TRUE
);

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
    link VARCHAR(100),
    orden INT DEFAULT 0,
    padre INT NOT NULL,
    tipo INT NOT NULL,
    active INT DEFAULT 1
);

CREATE TABLE ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT NOT NULL,
    observaciones TEXT,
    active INT DEFAULT 1
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
    active INT DEFAULT 1
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
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE movimientos_d (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    documento_id INT NOT NULL, -- Aqui tiene que ir egreso_id o ingreso_id
    articulo_id INT NOT NULL,
    cantidad INT NOT NULL,
    tipo VARCHAR(45) NOT NULL, -- Ejemplos: 'EGRESO', 'INGRESO', 'AJUSTE INVENTARIO'
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

DELIMITER $$

CREATE PROCEDURE LoginUsuario(IN _email VARCHAR(255), IN _password VARCHAR(255))
BEGIN
    SELECT id, nombre, email, rol_id
    FROM usuarios
    WHERE email = _email AND password = _password AND active = TRUE;
END$$

DELIMITER ;


DELIMITER $$
CREATE PROCEDURE CrearRol(IN _nombre VARCHAR(255), IN _descripcion VARCHAR(255))
BEGIN
    INSERT INTO roles(nombre, descripcion) VALUES (_nombre, _descripcion);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ActualizarRol(IN _id INT, IN _nombre VARCHAR(255), IN _descripcion VARCHAR(255), IN _active BOOLEAN)
BEGIN
    UPDATE roles SET nombre = _nombre, descripcion = _descripcion, active = _active WHERE id = _id;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE EliminarRol(IN _id INT)
BEGIN
    UPDATE roles SET active = FALSE WHERE id = _id;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE AsignarPermisoRol(IN _rol_id INT, IN _module_id INT, IN _escritura BOOLEAN, IN _lectura BOOLEAN)
BEGIN
    INSERT INTO permisos(rol_id, module_id, escritura, lectura) VALUES (_rol_id, _module_id, _escritura, _lectura);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ActualizarPermisoRol(IN _id INT, IN _rol_id INT, IN _module_id INT, IN _escritura BOOLEAN, IN _lectura BOOLEAN, IN _active BOOLEAN)
BEGIN
    UPDATE permisos SET rol_id = _rol_id, module_id = _module_id, escritura = _escritura, lectura = _lectura, active = _active WHERE id = _id;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE EliminarPermisoRol(IN _id INT)
BEGIN
    UPDATE permisos SET active = FALSE WHERE id = _id;
END$$
DELIMITER ; 
```
