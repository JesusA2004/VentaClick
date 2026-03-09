CREATE DATABASE IF NOT EXISTS pos_saas
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE pos_saas;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Configuracions;
DROP TABLE IF EXISTS System_logs;
DROP TABLE IF EXISTS Autorizacions;
DROP TABLE IF EXISTS Facturas;
DROP TABLE IF EXISTS Movimientos_inventarios;
DROP TABLE IF EXISTS Venta_pagos;
DROP TABLE IF EXISTS Venta_detalles;
DROP TABLE IF EXISTS Ventas;
DROP TABLE IF EXISTS Descuentos;
DROP TABLE IF EXISTS Producto_stocks;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Categorias;
DROP TABLE IF EXISTS Clientes;
DROP TABLE IF EXISTS Caja_turnos;
DROP TABLE IF EXISTS Cajas;
DROP TABLE IF EXISTS Empleados;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Sucursals;

SET FOREIGN_KEY_CHECKS = 1;

-- =============================
-- SUCURSALES
-- =============================
CREATE TABLE Sucursals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    clave VARCHAR(30) NOT NULL UNIQUE,
    telefono VARCHAR(30),
    email VARCHAR(150),
    direccion VARCHAR(255),
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- =============================
-- USERS
-- =============================
CREATE TABLE Users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nip_autorizacion VARCHAR(255),
    rol ENUM('ADMIN','GERENTE','CAJERO') DEFAULT 'CAJERO',
    sucursal_id BIGINT UNSIGNED,
    activo TINYINT(1) DEFAULT 1,
    ultimo_acceso_at DATETIME,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (sucursal_id) REFERENCES Sucursals(id)
);

-- =============================
-- EMPLEADOS
-- =============================
CREATE TABLE Empleados (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED UNIQUE,
    sucursal_id BIGINT UNSIGNED NOT NULL,
    numero_empleado VARCHAR(30) UNIQUE,
    nombre VARCHAR(120) NOT NULL,
    apellido_paterno VARCHAR(120),
    apellido_materno VARCHAR(120),
    telefono VARCHAR(30),
    puesto VARCHAR(100),
    fecha_ingreso DATE,
    estatus ENUM('ACTIVO','INACTIVO','BAJA') DEFAULT 'ACTIVO',
    meta_ventas_mensual DECIMAL(12,2),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (sucursal_id) REFERENCES Sucursals(id)
);

-- =============================
-- CAJAS
-- =============================
CREATE TABLE Cajas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sucursal_id BIGINT UNSIGNED NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    clave VARCHAR(30) NOT NULL,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (sucursal_id) REFERENCES Sucursals(id)
);

-- =============================
-- TURNOS DE CAJA
-- =============================
CREATE TABLE Caja_turnos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    caja_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    fecha_apertura DATETIME NOT NULL,
    fecha_cierre DATETIME,
    monto_inicial DECIMAL(12,2) DEFAULT 0,
    monto_ventas_brutas DECIMAL(12,2) DEFAULT 0,
    monto_descuentos DECIMAL(12,2) DEFAULT 0,
    monto_final_calculado DECIMAL(12,2) DEFAULT 0,
    monto_final_declarado DECIMAL(12,2),
    diferencia DECIMAL(12,2),
    estado ENUM('ABIERTO','CERRADO','CANCELADO') DEFAULT 'ABIERTO',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (caja_id) REFERENCES Cajas(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- =============================
-- CLIENTES
-- =============================
CREATE TABLE Clientes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    telefono VARCHAR(30),
    email VARCHAR(150),
    rfc VARCHAR(20),
    nombre_fiscal VARCHAR(255),
    regimen_fiscal VARCHAR(10),
    codigo_postal_fiscal VARCHAR(10),
    uso_cfdi_default VARCHAR(10),
    direccion VARCHAR(255),
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- =============================
-- CATEGORIAS
-- =============================
CREATE TABLE Categorias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- =============================
-- PRODUCTOS
-- =============================
CREATE TABLE Productos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categoria_id BIGINT UNSIGNED,
    codigo_barras VARCHAR(120) UNIQUE,
    codigo_qr VARCHAR(120) UNIQUE,
    sku VARCHAR(80) UNIQUE,
    nombre VARCHAR(160) NOT NULL,
    descripcion TEXT,
    precio_compra DECIMAL(12,2) DEFAULT 0,
    precio_venta DECIMAL(12,2) NOT NULL,
    impuesto_porcentaje DECIMAL(5,2) DEFAULT 0,
    permite_descuento TINYINT(1) DEFAULT 1,
    stock_minimo DECIMAL(12,2) DEFAULT 0,
    unidad_medida VARCHAR(30) DEFAULT 'PZA',
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

-- =============================
-- STOCK POR SUCURSAL
-- =============================
CREATE TABLE Producto_stocks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    producto_id BIGINT UNSIGNED NOT NULL,
    sucursal_id BIGINT UNSIGNED NOT NULL,
    stock_actual DECIMAL(12,2) DEFAULT 0,
    stock_reservado DECIMAL(12,2) DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE(producto_id,sucursal_id),
    FOREIGN KEY (producto_id) REFERENCES Productos(id),
    FOREIGN KEY (sucursal_id) REFERENCES Sucursals(id)
);

-- =============================
-- DESCUENTOS
-- =============================
CREATE TABLE Descuentos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE,
    nombre VARCHAR(120),
    tipo ENUM('PORCENTAJE','MONTO') NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    limite_usos INT,
    usos_actuales INT DEFAULT 0,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- =============================
-- VENTAS
-- =============================
CREATE TABLE Ventas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sucursal_id BIGINT UNSIGNED NOT NULL,
    caja_id BIGINT UNSIGNED NOT NULL,
    caja_turno_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    cliente_id BIGINT UNSIGNED,
    descuento_id BIGINT UNSIGNED,
    subtotal DECIMAL(12,2) NOT NULL,
    descuento_total DECIMAL(12,2) DEFAULT 0,
    impuesto_total DECIMAL(12,2) DEFAULT 0,
    total DECIMAL(12,2) NOT NULL,
    total_pagado DECIMAL(12,2),
    cambio DECIMAL(12,2),
    estado ENUM('COMPLETADA','CANCELADA','DEVUELTA') DEFAULT 'COMPLETADA',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (sucursal_id) REFERENCES Sucursals(id),
    FOREIGN KEY (caja_id) REFERENCES Cajas(id),
    FOREIGN KEY (caja_turno_id) REFERENCES Caja_turnos(id),
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (cliente_id) REFERENCES Clientes(id),
    FOREIGN KEY (descuento_id) REFERENCES Descuentos(id)
);

-- =============================
-- DETALLE VENTA
-- =============================
CREATE TABLE Venta_detalles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venta_id BIGINT UNSIGNED NOT NULL,
    producto_id BIGINT UNSIGNED NOT NULL,
    cantidad DECIMAL(12,2) NOT NULL,
    precio_unitario DECIMAL(12,2) NOT NULL,
    descuento DECIMAL(12,2) DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (venta_id) REFERENCES Ventas(id),
    FOREIGN KEY (producto_id) REFERENCES Productos(id)
);

-- =============================
-- PAGOS
-- =============================
CREATE TABLE Venta_pagos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venta_id BIGINT UNSIGNED NOT NULL,
    metodo_pago ENUM('EFECTIVO','TARJETA','TRANSFERENCIA','QR','OTRO'),
    monto DECIMAL(12,2) NOT NULL,
    referencia VARCHAR(120),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (venta_id) REFERENCES Ventas(id)
);

-- =============================
-- INVENTARIO
-- =============================
CREATE TABLE Movimientos_inventarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    producto_id BIGINT UNSIGNED NOT NULL,
    sucursal_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED,
    tipo ENUM('ENTRADA','SALIDA','AJUSTE','VENTA','DEVOLUCION'),
    cantidad DECIMAL(12,2) NOT NULL,
    referencia_tipo VARCHAR(50),
    referencia_id BIGINT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (producto_id) REFERENCES Productos(id),
    FOREIGN KEY (sucursal_id) REFERENCES Sucursals(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- =============================
-- FACTURAS SAT CFDI 4.0
-- =============================
CREATE TABLE Facturas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venta_id BIGINT UNSIGNED NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    cliente_id BIGINT UNSIGNED NULL,
    serie VARCHAR(25),
    folio VARCHAR(50),
    uuid VARCHAR(50),
    estado_timbrado ENUM('BORRADOR','TIMBRADA','CANCELADA','ERROR') DEFAULT 'BORRADOR',
    rfc_receptor VARCHAR(20) NOT NULL,
    nombre_receptor VARCHAR(255) NOT NULL,
    regimen_fiscal_receptor VARCHAR(10) NOT NULL,
    codigo_postal_receptor VARCHAR(10) NOT NULL,
    uso_cfdi VARCHAR(10) NOT NULL,
    forma_pago VARCHAR(5),
    metodo_pago VARCHAR(5),
    subtotal DECIMAL(12,2),
    descuento DECIMAL(12,2),
    impuestos DECIMAL(12,2),
    total DECIMAL(12,2),
    xml_timbrado LONGTEXT,
    pdf_url VARCHAR(255),
    fecha_timbrado DATETIME,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (venta_id) REFERENCES Ventas(id),
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (cliente_id) REFERENCES Clientes(id)
);

-- =============================
-- AUTORIZACIONES
-- =============================
CREATE TABLE Autorizacions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_solicitante_id BIGINT UNSIGNED NOT NULL,
    user_autorizador_id BIGINT UNSIGNED NOT NULL,
    accion VARCHAR(80),
    referencia_tipo VARCHAR(50),
    referencia_id BIGINT,
    motivo VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_solicitante_id) REFERENCES Users(id),
    FOREIGN KEY (user_autorizador_id) REFERENCES Users(id)
);

-- =============================
-- LOGS
-- =============================
CREATE TABLE System_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    modulo VARCHAR(100),
    accion VARCHAR(100),
    descripcion TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- =============================
-- CONFIGURACIONES
-- =============================
CREATE TABLE Configuracions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(120) UNIQUE,
    valor TEXT,
    descripcion TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
