<?php

echo("hola");
// Seguridad de la sesión
ini_set('session.cookie_httponly', 1);
session_start();
session_regenerate_id(true);

$duracion_sesion = 300;
if (!isset($_SESSION['ultimo_acceso'])) {
    $_SESSION['ultimo_acceso'] = time();
} else {
    if (time() - $_SESSION['ultimo_acceso'] > $duracion_sesion) {
        session_unset();
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['ultimo_acceso'] = time();
    }
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "agencia_pudu");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$titulo = 'Agencia Pudú';
$notificacion = "";
$vista = $_POST['vista'] ?? "";

// Confirmar reserva y reiniciar sesión
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirmar_reserva'])) {
    if (isset($_POST['cliente_id'], $_POST['fecha_reserva'], $_POST['vuelo_id'], $_POST['hotel_id'])) {
        $cliente_id = $_POST['cliente_id'];
        $fecha = $_POST['fecha_reserva'];
        $vuelo_id = $_POST['vuelo_id'];
        $hotel_id = $_POST['hotel_id'];

        // Verificar disponibilidad de vuelo
        $sql_vuelo = "SELECT plazas_disponibles FROM vuelo WHERE vuelo_id = $vuelo_id";
        $result_vuelo = $conn->query($sql_vuelo);
        $vuelo = $result_vuelo->fetch_assoc();

        if ($vuelo['plazas_disponibles'] <= 0) {
        $notificacion = "❌ No hay plazas disponibles en este vuelo. Por favor selecciona otro.";
            } else {
        // Verificar disponibilidad de hotel
        $sql_hotel = "SELECT habitaciones_disponibles FROM hotel WHERE hotel_id = $hotel_id";
        $result_hotel = $conn->query($sql_hotel);
        $hotel = $result_hotel->fetch_assoc();

        if ($hotel['habitaciones_disponibles'] <= 0) {
        $notificacion = "❌ No hay habitaciones disponibles en este hotel. Por favor elige otro.";
            } else {
        // Hacer reserva
        $sql_reserva = "INSERT INTO reserva (cliente_id, fecha_reserva, vuelo_id, hotel_id)
                        VALUES ($cliente_id, '$fecha', $vuelo_id, $hotel_id)";
        if ($conn->query($sql_reserva) === TRUE) {
            // Actualizar disponibilidad
            $conn->query("UPDATE vuelo SET plazas_disponibles = plazas_disponibles - 1 WHERE vuelo_id = $vuelo_id");
            $conn->query("UPDATE hotel SET habitaciones_disponibles = habitaciones_disponibles - 1 WHERE hotel_id = $hotel_id");

            $notificacion = "✅ ¡Reserva confirmada con éxito!";
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(true);
        } else {
            $notificacion = "❌ Error al guardar la reserva: " . $conn->error;
                }
            }
        }


        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
    } else {
        $notificacion = "⚠️ Faltan datos para realizar la reserva.";
    }
}

// Guardar vuelos
if ($vista === "vuelo" && isset($_POST['origen'])) {
    $conn->query("INSERT INTO vuelo (origen, destino, fecha, plazas_disponibles, precio)
                  VALUES ('{$_POST['origen']}', '{$_POST['destino']}', '{$_POST['fecha']}', {$_POST['plazas']}, {$_POST['precio']})");
    $notificacion = "✈️ Vuelo guardado correctamente.";
}

// Guardar hoteles
if ($vista === "hotel" && isset($_POST['nombre'])) {
    $conn->query("INSERT INTO hotel (nombre, ubicacion, habitaciones_disponibles, tarifa_noche)
                  VALUES ('{$_POST['nombre']}', '{$_POST['ubicacion']}', {$_POST['habitaciones']}, {$_POST['tarifa']})");
    $notificacion = "🏨 Hotel guardado correctamente.";
}

// Función para mostrar formularios
function mostrarFormulario($tipo) {
    global $conn;

    if ($tipo === "vuelo") {
        echo '<h2>✈️ Agregar vuelo</h2>
        <form method="POST">
            <input type="hidden" name="vista" value="vuelo">
            <input type="text" name="origen" placeholder="Origen" required>
            <input type="text" name="destino" placeholder="Destino" required>
            <input type="date" name="fecha" required>
            <input type="number" name="plazas" placeholder="Plazas disponibles" required>
            <input type="number" name="precio" placeholder="Precio" step="0.01" required>
            <button type="submit">Guardar vuelo</button>
        </form>';
    }

    if ($tipo === "hotel") {
        echo '<h2>🏨 Agregar hotel</h2>
        <form method="POST">
            <input type="hidden" name="vista" value="hotel">
            <input type="text" name="nombre" placeholder="Nombre del hotel" required>
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <input type="number" name="habitaciones" placeholder="Habitaciones disponibles" required>
            <input type="number" name="tarifa" placeholder="Tarifa por noche" step="0.01" required>
            <button type="submit">Guardar hotel</button>
        </form>';
    }

    if ($tipo === "reserva") {
        $vuelos = $conn->query("SELECT vuelo_id, origen, destino FROM vuelo");
        $hoteles = $conn->query("SELECT hotel_id, nombre FROM hotel");

        echo '<h2>📝 Realizar reserva</h2>
        <form method="POST">
            <input type="hidden" name="vista" value="reserva">
            <label>ID Cliente:</label>
            <input type="number" name="cliente_id" required>
            <label>Fecha de reserva:</label>
            <input type="date" name="fecha_reserva" required>
            <label>Vuelo:</label>
            <select name="vuelo_id">';
        while ($v = $vuelos->fetch_assoc()) {
            echo "<option value='{$v['vuelo_id']}'>{$v['origen']} → {$v['destino']}</option>";
        }
        echo '</select>
            <label>Hotel:</label>
            <select name="hotel_id">';
        while ($h = $hoteles->fetch_assoc()) {
            echo "<option value='{$h['hotel_id']}'>{$h['nombre']}</option>";
        }
        echo '</select>
            <button type="submit" name="confirmar_reserva">Confirmar reserva</button>
        </form>';
    }
}

// Función para mostrar tablas
function mostrarTabla($tipo) {
    global $conn;

    if ($tipo === "mostrar_vuelos") {
        $res = $conn->query("SELECT * FROM vuelo");
        echo "<h2>✈️ Vuelos disponibles</h2><ul>";
        while ($v = $res->fetch_assoc()) {
            echo "<li>{$v['origen']} → {$v['destino']} | Fecha: {$v['fecha']} | \$ {$v['precio']}</li>";
        }
        echo "</ul>";
    }

    if ($tipo === "mostrar_hoteles") {
        $res = $conn->query("SELECT * FROM hotel");
        echo "<h2>🏨 Hoteles disponibles</h2><ul>";
        while ($h = $res->fetch_assoc()) {
            echo "<li>{$h['nombre']} - {$h['ubicacion']} - \$ {$h['tarifa_noche']}</li>";
        }
        echo "</ul>";
    }

    if ($tipo === "mostrar_reservas") {
        $res = $conn->query("SELECT h.nombre AS hotel, v.origen, v.destino, COUNT(*) AS total
                             FROM reserva r
                             JOIN hotel h ON r.hotel_id = h.hotel_id
                             JOIN vuelo v ON r.vuelo_id = v.vuelo_id
                             GROUP BY r.hotel_id, r.vuelo_id
                             HAVING total > 2
                             ORDER BY total DESC");
        echo "<h2>📊 Reservas destacadas (más de 2)</h2><ul>";
        while ($r = $res->fetch_assoc()) {
            echo "<li>{$r['hotel']} + Vuelo {$r['origen']} → {$r['destino']} = {$r['total']} reservas</li>";
        }
        echo "</ul>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <style>
        body { 
            font-family: Arial; 
            margin: 0; 
            background: #f9f9f9;
            background-image: url(pudu.jpg); 
        }
        .titulo { 
            background: rgb(0, 173, 69); 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; 
            padding: 10px;
            color: #004d40;
            font-size: 30px;
            padding: 0;  
        }
        img{
            width: 80px;
        }
        .contenedor { 
            display: flex; 
            justify-content: center; 
            margin-top: 20px; 
            gap: 20px; 
        }
        .panel, .panel-dinamico {
            width: 45%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        form button, input, select {
            margin: 8px 0;
            width: 100%;
            padding: 10px;
            font-size: 15px;
        }
        .notificacion {
            background-color: #e0f7fa;
            color: #00796b;
            margin: 20px auto;
            padding: 10px;
            width: 60%;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="titulo">
    <h1><?php echo $titulo; ?></h1>
    <img src="logo.png" alt="logo">
</div>

<?php if ($notificacion): ?>
    <div class="notificacion"><?php echo $notificacion; ?></div>
<?php endif; ?>

<div class="contenedor">
    <div class="panel">
        <form method="POST">
            <button name="vista" value="vuelo">✈️ Agregar Vuelo</button>
            <button name="vista" value="hotel">🏨 Agregar Hotel</button>
            <button name="vista" value="mostrar_vuelos">📃 Mostrar Vuelos</button>
            <button name="vista" value="mostrar_hoteles">📃 Mostrar Hoteles</button>
            <button name="vista" value="reserva">📝 Realizar Reserva</button>
            <button name="vista" value="mostrar_reservas">📊 Mostrar Reservas</button>
        </form>
    </div>

    <div class="panel-dinamico">
        <?php
        if (in_array($vista, ["vuelo", "hotel", "reserva"])) {
            mostrarFormulario($vista);
        } elseif (in_array($vista, ["mostrar_vuelos", "mostrar_hoteles", "mostrar_reservas"])) {
            mostrarTabla($vista);
        } else {
            echo "<p>Selecciona una acción desde el panel izquierdo.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
