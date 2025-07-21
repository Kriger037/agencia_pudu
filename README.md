# Agencia Pudú

Este es un sistema web desarrollado en PHP y MySQL que permite registrar vuelos, hoteles y realizar reservas que vinculan a ambos. El proyecto incluye control de sesión, formularios dinámicos y visualización de datos.

## Descripción general

El sistema está orientado a simular el funcionamiento básico de una agencia de viajes que permite:

- Registrar vuelos con información de origen, destino, fecha, plazas y precio.
- Registrar hoteles con nombre, ubicación, habitaciones disponibles y tarifa por noche.
- Realizar reservas, asignando un vuelo y un hotel a un cliente.
- Mostrar combinaciones de reservas destacadas.
- Controlar la sesión del usuario con tiempo de expiración.
- Presentar los datos de manera ordenada y sencilla en una interfaz HTML.

## Estructura del proyecto

agencia_pudu/
├── index.php # Página principal con formularios y lógica del sistema
├── agencia_pudu.sql # Archivo SQL con la estructura y datos de la base de datos
├── logo.png # Imagen del logotipo de la agencia
├── pudu.jpg # Imagen decorativa de fondo
├── README.md # Archivo con información del proyecto


## Base de datos

El archivo `agencia_pudu.sql` contiene la estructura y datos de ejemplo del sistema. Incluye tres tablas relacionadas:

- `vuelo`: contiene los vuelos disponibles.
- `hotel`: contiene los hoteles registrados.
- `reserva`: tabla intermedia que vincula vuelos y hoteles con el cliente.

### Cómo importar la base de datos

1. Crear una base de datos llamada `agencia_pudu`.
2. Abrir phpMyAdmin o MySQL Workbench.
3. Usar la opción "Importar" para cargar el archivo `agencia_pudu.sql`.

## Requisitos para ejecutar

- Servidor local (XAMPP, WAMP, Laragon u otro)
- PHP 7.4 o superior
- MySQL
- Navegador web moderno

## Instrucciones de uso

1. Clonar o descargar este repositorio.
2. Colocar los archivos en la carpeta `htdocs` o equivalente según tu entorno local.
3. Importar la base de datos.
4. Ejecutar `index.php` desde el navegador con la URL correspondiente (por ejemplo: `http://localhost/agencia_pudu/index.php`).

## Autor

Felipe Hernández Cid  
Estudiante del Instituto Profesional IACC  
Técnico en Análisis y Programación Computacional
