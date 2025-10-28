<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['borrar'])) {
    $numero_control = $_GET['borrar'];
    $conn->query("DELETE FROM integrantes WHERE NumeroControl='$numero_control'");
    header("Location: operaciones.php");
    exit;
}

if (isset($_POST['editar'])) {
    $original_control = $_POST['original_control'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $nuevo_control = $_POST['numero_control'];
    $foto = $_POST['foto'];

    $conn->query("UPDATE integrantes SET 
        Nombre='$nombre', 
        Rol='$rol', 
        NumeroControl='$nuevo_control', 
        Foto='$foto' 
        WHERE NumeroControl='$original_control'");
    header("Location: operaciones.php");
    exit;
}

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $control = $_POST['numero_control'];
    $foto = $_POST['foto'];

    $conn->query("INSERT INTO integrantes (Nombre, Rol, NumeroControl, Foto) VALUES ('$nombre', '$rol', '$control', '$foto')");
    header("Location: operaciones.php");
    exit;
}

$result = $conn->query("SELECT Nombre, Rol, NumeroControl, Foto FROM integrantes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Operaciones de Integrantes</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 20px;
        }
        .top-buttons {
            margin: 20px;
            text-align: center;
        }
        .top-buttons a {
            background-color: #1d4ed8;
            color: white;
            padding: 10px 15px;
            margin: 0 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }
        .main-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;
            margin: 30px auto;
            width: 95%;
        }
        .table-box {
            flex: 2;
        }
        table {
            width: 100%;
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
            border-radius: 10%;
            border: 2px solid #3b82f6;
        }
        .edit-btn, .delete-btn {
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            text-decoration: none;
        }
        .edit-btn {
            background-color: #2563eb;
        }
        .delete-btn {
            background-color: #f97316;
        }
        .form-box {
            flex: 1;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-box h2 {
            color: #1e3a8a;
        }
        .form-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #cbd5e1;
        }
        .form-box button {
            background-color: #1d4ed8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="top-buttons">
    <a href="index.php">Regresar</a>
    <a href="#formulario">Agregar</a>
</div>

<div class="main-content">
    <div class="table-box">
        <table>
            <caption>acciones en integrantes</caption>
            <tr>
                <th>Nombres</th>
                <th>Rol</th>
                <th>Número de Control</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) {
                $nombre = htmlspecialchars($row['Nombre']);
                $rol = htmlspecialchars($row['Rol']);
                $control = htmlspecialchars($row['NumeroControl']);
                $foto = htmlspecialchars("images/" . $row['Foto']);
                echo "<tr>
                    <td>$nombre</td>
                    <td>$rol</td>
                    <td>$control</td>
                    <td><img src='$foto' alt='Foto de $nombre'></td>
                    <td>
                        <a class='edit-btn' href='?editar=$control'>Editar</a>
                        <a class='delete-btn' href='?borrar=$control' onclick=\"return confirm('¿Seguro que deseas borrar este integrante?')\">Borrar</a>
                    </td>
                </tr>";
            } ?>
        </table>
    </div>

    <div class="form-box" id="formulario">
        <?php
        if (isset($_GET['editar'])) {
            $numero_control = $conn->real_escape_string($_GET['editar']);
            $res = $conn->query("SELECT * FROM integrantes WHERE NumeroControl='$numero_control'");
            if ($res && $res->num_rows == 1) {
                $row = $res->fetch_assoc();
                $nombre_edit = htmlspecialchars($row['Nombre']);
                $rol_edit = htmlspecialchars($row['Rol']);
                $control_edit = htmlspecialchars($row['NumeroControl']);
                $foto_edit = htmlspecialchars($row['Foto']);
        ?>
        <h2>Editar integrante</h2>
        <form method="post" action="operaciones.php">
            <input type="hidden" name="original_control" value="<?php echo $control_edit; ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $nombre_edit; ?>" required>
            <label>Rol:</label>
            <input type="text" name="rol" value="<?php echo $rol_edit; ?>" required>
            <label>Número de Control:</label>
            <input type="text" name="numero_control" value="<?php echo $control_edit; ?>" required>
            <label>Foto (nombre de archivo en carpeta images):</label>
            <input type="text" name="foto" value="<?php echo $foto_edit; ?>">
            <button type="submit" name="editar">Guardar cambios</button>
        </form>
        <?php
            } else {
                echo "<p>Integrante no encontrado.</p>";
            }
        } else {
        ?>
        <h2>Agregar nuevo integrante</h2>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <label>Rol:</label>
            <input type="text" name="rol" placeholder="Rol" required>
            <label>Número de Control:</label>
            <input type="text" name="numero_control" placeholder="Número de Control" required>
            <label>Foto (nombre de archivo en carpeta images):</label>
            <input type="text" name="foto" placeholder="foto1.jpg" required>
            <button type="submit" name="agregar">Agregar</button>
        </form>
        <?php } ?>
    </div>
</div>

</body>
</html>
