<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT ID, Nombre, Rol, NumeroControl, Foto FROM integrantes";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Integrantes del Equipo</title>
   <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f4f8;
        margin: 20px;
    }
    table {
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    caption {
        caption-side: top;
        font-size: 2em;
        font-weight: 600;
        background-color: #dbeafe;
        color: #1e3a8a;
        padding: 15px;
        border-radius: 8px 8px 0 0;
    }
    th {
        background-color: #2563eb;
        color: #ffffff;
        padding: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    td {
        padding: 12px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #334155;
    }
    tr:nth-child(even) {
        background-color: #f1f5f9;
    }
    tr:nth-child(odd) {
        background-color: #e2e8f0;
    }
    tr:hover {
        background-color: #c7d2fe !important;
    }
    img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #3b82f6;
    }
    a {
        color: #1d4ed8;
        text-decoration: underline;
        font-weight: 500;
    }
    button {
        margin-left: 15px;
        padding: 10px 16px;
        font-size: 0.8em;
        border: none;
        border-radius: 6px;
        background-color: #1d4ed8;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #2563eb;
    }
    .error {
        color: #dc2626;
        font-weight: bold;
    }
</style>
</head>
<body>

<table>
    <caption>kendrii y rafita
        <a href="operaciones.php"><button>Acciones</button></a>
    </caption>
    <tr>
        <th>Nombres</th>
        <th>Roles</th>
        <th>Numero de control</th>
        <th>Fotos</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombre_raw = $row['Nombre'];
            $nombre = htmlspecialchars($nombre_raw);
            $rol = htmlspecialchars($row['Rol']);
            $control = htmlspecialchars($row['NumeroControl']);

            $foto_file = $row['Foto'];
            $foto_path = "images/{$foto_file}";
            $foto_path_attr = htmlspecialchars($foto_path);
            $alt = htmlspecialchars("Foto de {$nombre}");

            $google = "https://www.google.com/search?q=" . urlencode($nombre_raw);

            echo "<tr>";
            echo "<td><a href=\"{$google}\" target=\"_blank\">{$nombre}</a></td>";
            echo "<td>{$rol}</td>";
            echo "<td>{$control}</td>";

            if (file_exists($foto_path)) {
                echo "<td><img src=\"{$foto_path_attr}\" alt=\"{$alt}\"></td>";
            } else {
                echo "<td class='error'>Imagen no encontrada</td>";
            }

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='error'>No hay datos disponibles.</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>