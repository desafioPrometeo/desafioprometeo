<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root"; // o tu usuario
$pass = "";     // tu contraseña
$dbname = "desafio_prometeo";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $programa = $_POST['programa'];
    $sede = $_POST['sede'];
    $jornada = $_POST['jornada'];
    $especialidad = $_POST['especialidad'];
    $nivel = $_POST['nivel'];

    $sql = "INSERT INTO registros (nombre, correo, programa, sede, jornada, especialidad, nivel) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $correo, $programa, $sede, $jornada, $especialidad, $nivel);
    $stmt->execute();
    echo "<p class='mensaje'>✅ Registro exitoso. ¡Gracias por sumarte al Desafío Prometeo!</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro – Desafío Prometeo</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        form, table { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        input, select { width: 100%; padding: 8px; margin: 10px 0; }
        .boton { background: #007bff; color: white; padding: 10px; border: none; cursor: pointer; }
        .boton:hover { background: #0056b3; }
        .mensaje { background: #d4edda; color: #155724; padding: 10px; margin: 20px 0; border-left: 5px solid #28a745; }
    </style>
</head>
<body>

<?php
// Acceso de profesor
if (isset($_GET['profesor']) && $_GET['profesor'] === 'clave123') {
    echo "<h2>📋 Reporte de Registros</h2>";
    $result = $conn->query("SELECT * FROM registros");
    echo "<table border='1' cellpadding='10'><tr>
            <th>Nombre</th><th>Correo</th><th>Programa</th><th>Sede</th>
            <th>Jornada</th><th>Especialidad</th><th>Nivel</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['nombre']}</td><td>{$row['correo']}</td>
              <td>{$row['programa']}</td><td>{$row['sede']}</td>
              <td>{$row['jornada']}</td><td>{$row['especialidad']}</td><td>{$row['nivel']}</td></tr>";
    }
    echo "</table>";
    echo "<br><a href='exportar.php' class='boton'>⬇️ Descargar en CSV</a>";
} else {
?>

<h2>🛸 Registro de Exploradores – Desafío Prometeo 2025-1</h2>
<form method="POST">
    <label>Nombre completo:</label>
    <input type="text" name="nombre" required>

    <label>Correo institucional:</label>
    <input type="email" name="correo" required>

    <label>Programa académico:</label>
    <select name="programa" required>
        <option value="">--Selecciona--</option>
        <option value="Comunicación Visual">Comunicación Visual</option>
        <option value="Tecnología en Comunicación Gráfica">Tecnología en Comunicación Gráfica</option>
    </select>

    <label>Sede:</label>
    <select name="sede" required>
        <option value="">--Selecciona--</option>
        <option value="Calle 80">Calle 80</option>
        <option value="Perdomo">Perdomo</option>
    </select>

    <label>Jornada:</label>
    <select name="jornada" required>
        <option value="">--Selecciona--</option>
        <option value="Diurna">Diurna</option>
        <option value="Nocturna">Nocturna</option>
    </select>

    <label>Rol creativo (especialidad):</label>
    <select name="especialidad" required>
        <option value="">--Selecciona--</option>
        <option>Diagramación y diseño editorial</option>
        <option>Fotografía y edición</option>
        <option>Ilustración y concept art</option>
        <option>Redacción y narrativa visual</option>
        <option>Audiovisual y animación</option>
        <option>Sonido y diseño narrativo auditivo</option>
        <option>Investigación y estrategia</option>
    </select>

    <label>Nivel de experiencia (1-5):</label>
    <select name="nivel" required>
        <option value="">--Selecciona--</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
    </select>

    <input type="submit" class="boton" name="submit_form" value="Registrarme">
</form>

<?php } ?>
</body>
</html>
