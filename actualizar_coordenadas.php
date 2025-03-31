<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "zoologico";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar acciones (agregar/actualizar/eliminar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        // Verificar si es animal o zona
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'animal'; // Por defecto animal si no se especifica
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        
        if ($id === null) {
            $mensaje = "Error: No se especificó el ID del elemento";
            $tipoMensaje = "error";
        } else {
            if ($_POST['accion'] === 'agregar' || $_POST['accion'] === 'actualizar') {
                $latitud = isset($_POST['latitud']) ? (float)$_POST['latitud'] : null;
                $longitud = isset($_POST['longitud']) ? (float)$_POST['longitud'] : null;
                
                // Validar coordenadas
                if ($latitud !== null && $longitud !== null && 
                    $latitud >= -90 && $latitud <= 90 && 
                    $longitud >= -180 && $longitud <= 180) {
                    
                    if ($tipo === 'animal') {
                        $stmt = $conn->prepare("UPDATE animales SET latitud = ?, longitud = ? WHERE AnimalID = ?");
                    } else {
                        $stmt = $conn->prepare("UPDATE zonas SET latitud = ?, longitud = ? WHERE ZonaID = ?");
                    }
                    
                    if ($stmt) {
                        $stmt->bind_param("ddi", $latitud, $longitud, $id);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Coordenadas ".($_POST['accion'] === 'agregar' ? 'agregadas' : 'actualizadas')." correctamente para ".($tipo === 'animal' ? 'el animal' : 'la zona')." ID $id";
                            $tipoMensaje = "success";
                        } else {
                            $mensaje = "Error al ".($_POST['accion'] === 'agregar' ? 'agregar' : 'actualizar').": " . $conn->error;
                            $tipoMensaje = "error";
                        }
                        $stmt->close();
                    } else {
                        $mensaje = "Error en la preparación de la consulta: " . $conn->error;
                        $tipoMensaje = "error";
                    }
                } else {
                    $mensaje = "Coordenadas inválidas. Latitud (-90 a 90), Longitud (-180 a 180)";
                    $tipoMensaje = "error";
                }
            } elseif ($_POST['accion'] === 'eliminar') {
                if ($tipo === 'animal') {
                    $stmt = $conn->prepare("UPDATE animales SET latitud = NULL, longitud = NULL WHERE AnimalID = ?");
                } else {
                    $stmt = $conn->prepare("UPDATE zonas SET latitud = NULL, longitud = NULL WHERE ZonaID = ?");
                }
                
                if ($stmt) {
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Coordenadas eliminadas correctamente para ".($tipo === 'animal' ? 'el animal' : 'la zona')." ID $id";
                        $tipoMensaje = "success";
                    } else {
                        $mensaje = "Error al eliminar: " . $conn->error;
                        $tipoMensaje = "error";
                    }
                    $stmt->close();
                } else {
                    $mensaje = "Error en la preparación de la consulta: " . $conn->error;
                    $tipoMensaje = "error";
                }
            }
        }
    }
}

// Obtener lista de animales para el formulario
$sql_animales = "SELECT AnimalID, nombre, especie FROM animales ORDER BY nombre";
$result_animales = $conn->query($sql_animales);

// Obtener lista de zonas para el formulario
$sql_zonas = "SELECT ZonaID, Nombre, Descripcion FROM zonas ORDER BY Nombre";
$result_zonas = $conn->query($sql_zonas);

// Obtener animales con coordenadas para mostrar en la tabla
$sql_mapa_animales = "SELECT AnimalID, nombre, especie, latitud, longitud FROM animales WHERE latitud IS NOT NULL AND longitud IS NOT NULL ORDER BY nombre";
$result_mapa_animales = $conn->query($sql_mapa_animales);

// Obtener zonas con coordenadas para mostrar en la tabla
$sql_mapa_zonas = "SELECT ZonaID, Nombre, Descripcion, latitud, longitud FROM zonas WHERE latitud IS NOT NULL AND longitud IS NOT NULL ORDER BY Nombre";
$result_mapa_zonas = $conn->query($sql_mapa_zonas);

// Obtener todos los elementos con coordenadas para el mapa
$sql_elementos_mapa = "SELECT 
                        'animal' AS tipo, AnimalID AS id, nombre, especie, descripcion, imagen, latitud, longitud 
                       FROM animales 
                       WHERE latitud IS NOT NULL AND longitud IS NOT NULL
                       UNION
                       SELECT 
                        'zona' AS tipo, ZonaID AS id, Nombre AS nombre, 'Zona' AS especie, Descripcion AS descripcion, Imagen AS imagen, latitud, longitud 
                       FROM zonas 
                       WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$result_elementos_mapa = $conn->query($sql_elementos_mapa);
$elementos_mapa = array();
if ($result_elementos_mapa->num_rows > 0) {
    while($row = $result_elementos_mapa->fetch_assoc()) {
        $elementos_mapa[] = $row;
    }
}
$elementos_json = json_encode($elementos_mapa);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Coordenadas | ZooAragon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
        <script src="https://kit.fontawesome.com/ca7c7e6854.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function toggleMenu() {
            document.getElementById("nav-menu").classList.toggle("active");
        }
    </script>
    <style>
        :root {
            --color-primario: #00796b;
            --color-secundario: #004d40;
            --color-fondo: #e0f2f1;
            --color-texto: #333;
        }
        
        body {
            background-color: var(--color-fondo);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            background: linear-gradient(90deg, var(--color-secundario), var(--color-primario));
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: var(--color-primario);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--color-primario);
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-success {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .coordinates-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid var(--color-primario);
        }
        
        .map-container {
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        table th {
            background-color: var(--color-primario);
            color: white;
        }
        
        .custom-icon {
            background: var(--color-primario);
            border: 2px solid #fff;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            width: 30px;
            height: 30px;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--color-primario);
        }
        .nav-pills .nav-link {
            color: var(--color-primario);
        }
        
        .nav-menu {
            display: none;
            position: absolute;
            right: 20px;
            top: 80px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
        }
        
        .nav-menu a {
            display: block;
            padding: 10px 20px;
            color: var(--color-texto);
            text-decoration: none;
        }
        
        .nav-menu a:hover {
            background-color: #f0f0f0;
        }
        
        @media (max-width: 768px) {
            .map-container {
                height: 350px;
            }
        }
    </style>
</head>
<body>
    <header class="header py-4 mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="imagenes/logobien.jpg" alt="ZooAragon" class="rounded-circle me-3" width="80">
                    <div>
                        <h1 class="mb-0">ZooAragon App</h1>
                        <h2 class="h5 mb-0">Gestión de Coordenadas</h2>
                    </div>
                </div>
                <button class="btn btn-light d-lg-none" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="nav-menu" id="nav-menu">
                    <a href="admin.php"><i class="fas fa-home me-2"></i>Inicio</a>
                    <a href="lista_usuarios.php"><i class="fas fa-users me-2"></i>Usuarios</a>
                    <a href="MantenerPersonal.php"><i class="fas fa-user-tie me-2"></i>Personal</a>
                    <a href="MantenerPaquetes.php"><i class="fas fa-box-open me-2"></i>Paquetes</a>
                    <a href="MantenerZonas.php"><i class="fas fa-map-marked-alt me-2"></i>Zonas</a>
                    <a href="tratamientos.php"><i class="fas fa-medkit me-2"></i>Tratamientos</a>
                    <a href="Gest_especies.php"><i class="fas fa-paw me-2"></i>Animales</a>
                    <a href="actualizar_coordenadas.php"><i class="fas fa-map me-2"></i>Mapa</a>
                    <a href="admin.php"><i class="fas fa-user-cog me-2"></i>Administrador</a>
                    <a href="inicio.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mb-5">
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                <?= $mensaje ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-map-marker-alt me-2"></i>Gestión de Coordenadas
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-animales-tab" data-bs-toggle="pill" data-bs-target="#pills-animales" type="button" role="tab" aria-controls="pills-animales" aria-selected="true">
                                    Animales
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-zonas-tab" data-bs-toggle="pill" data-bs-target="#pills-zonas" type="button" role="tab" aria-controls="pills-zonas" aria-selected="false">
                                    Zonas
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="pills-tabContent">
                            <!-- Pestaña de Animales -->
                            <div class="tab-pane fade show active" id="pills-animales" role="tabpanel" aria-labelledby="pills-animales-tab">
                                <form method="post">
                                    <input type="hidden" name="tipo" value="animal">
                                    <input type="hidden" name="accion" id="accion-animal" value="agregar">
                                    
                                    <div class="mb-3">
                                        <label for="animalID" class="form-label">Selecciona un animal:</label>
                                        <select class="form-select" name="id" id="animalID" required>
                                            <option value="">-- Selecciona un animal --</option>
                                            <?php 
                                            $result_animales->data_seek(0);
                                            while($row = $result_animales->fetch_assoc()): ?>
                                                <option value="<?= $row['AnimalID'] ?>">
                                                    <?= htmlspecialchars($row['nombre']) ?> (<?= htmlspecialchars($row['especie']) ?>)
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="latitud-animal" class="form-label">Latitud:</label>
                                        <input type="number" step="0.000001" class="form-control" name="latitud" id="latitud-animal" required>
                                        <small class="text-muted">Valor entre -90 y 90 (ej. 19.461994)</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="longitud-animal" class="form-label">Longitud:</label>
                                        <input type="number" step="0.000001" class="form-control" name="longitud" id="longitud-animal" required>
                                        <small class="text-muted">Valor entre -180 y 180 (ej. -99.082451)</small>
                                    </div>
                                    
                                    <div class="coordinates-info text-center" id="coordinates-display-animal">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Haz clic en el mapa para obtener coordenadas
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success flex-grow-1 py-2">
                                            <i class="fas fa-plus-circle me-2"></i>Agregar
                                        </button>
                                        <button type="button" class="btn btn-primary flex-grow-1 py-2" onclick="actualizarCoordenadas('animal')">
                                            <i class="fas fa-save me-2"></i>Actualizar
                                        </button>
                                        <button type="button" class="btn btn-danger flex-grow-1 py-2" onclick="eliminarCoordenadas('animal')">
                                            <i class="fas fa-trash-alt me-2"></i>Eliminar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Pestaña de Zonas -->
                            <div class="tab-pane fade" id="pills-zonas" role="tabpanel" aria-labelledby="pills-zonas-tab">
                                <form method="post">
                                    <input type="hidden" name="tipo" value="zona">
                                    <input type="hidden" name="accion" id="accion-zona" value="agregar">
                                    
                                    <div class="mb-3">
                                        <label for="zonaID" class="form-label">Selecciona una zona:</label>
                                        <select class="form-select" name="id" id="zonaID" required>
                                            <option value="">-- Selecciona una zona --</option>
                                            <?php 
                                            $result_zonas->data_seek(0);
                                            while($row = $result_zonas->fetch_assoc()): ?>
                                                <option value="<?= $row['ZonaID'] ?>">
                                                    <?= htmlspecialchars($row['Nombre']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="latitud-zona" class="form-label">Latitud:</label>
                                        <input type="number" step="0.000001" class="form-control" name="latitud" id="latitud-zona" required>
                                        <small class="text-muted">Valor entre -90 y 90 (ej. 19.461994)</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="longitud-zona" class="form-label">Longitud:</label>
                                        <input type="number" step="0.000001" class="form-control" name="longitud" id="longitud-zona" required>
                                        <small class="text-muted">Valor entre -180 y 180 (ej. -99.082451)</small>
                                    </div>
                                    
                                    <div class="coordinates-info text-center" id="coordinates-display-zona">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Haz clic en el mapa para obtener coordenadas
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success flex-grow-1 py-2">
                                            <i class="fas fa-plus-circle me-2"></i>Agregar
                                        </button>
                                        <button type="button" class="btn btn-primary flex-grow-1 py-2" onclick="actualizarCoordenadas('zona')">
                                            <i class="fas fa-save me-2"></i>Actualizar
                                        </button>
                                        <button type="button" class="btn btn-danger flex-grow-1 py-2" onclick="eliminarCoordenadas('zona')">
                                            <i class="fas fa-trash-alt me-2"></i>Eliminar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-map me-2"></i>Mapa Interactivo
                    </div>
                    <div class="card-body p-0">
                        <div id="map-container" class="map-container"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Elementos con Coordenadas Asignadas
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="animales-tab" data-bs-toggle="tab" data-bs-target="#animales-tab-pane" type="button" role="tab" aria-controls="animales-tab-pane" aria-selected="true">
                            Animales
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="zonas-tab" data-bs-toggle="tab" data-bs-target="#zonas-tab-pane" type="button" role="tab" aria-controls="zonas-tab-pane" aria-selected="false">
                            Zonas
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="animales-tab-pane" role="tabpanel" aria-labelledby="animales-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Especie</th>
                                        <th>Latitud</th>
                                        <th>Longitud</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result_mapa_animales->num_rows > 0): ?>
                                        <?php while($row = $result_mapa_animales->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['AnimalID'] ?></td>
                                                <td><?= htmlspecialchars($row['nombre']) ?></td>
                                                <td><?= htmlspecialchars($row['especie']) ?></td>
                                                <td><?= number_format($row['latitud'], 6) ?></td>
                                                <td><?= number_format($row['longitud'], 6) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay animales con coordenadas asignadas</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="zonas-tab-pane" role="tabpanel" aria-labelledby="zonas-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Latitud</th>
                                        <th>Longitud</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result_mapa_zonas->num_rows > 0): ?>
                                        <?php while($row = $result_mapa_zonas->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['ZonaID'] ?></td>
                                                <td><?= htmlspecialchars($row['Nombre']) ?></td>
                                                <td><?= htmlspecialchars(substr($row['Descripcion'], 0, 50)) ?>...</td>
                                                <td><?= number_format($row['latitud'], 6) ?></td>
                                                <td><?= number_format($row['longitud'], 6) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay zonas con coordenadas asignadas</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4 bg-dark text-white">
        <div class="container text-center">
            <p class="mb-1">©CrossGen Coders | ZooAragon App</p>
            <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>Av. José Loreto Fabela S/N, Zoológico de San Juan de Aragón, CDMX</p>
            <p class="mb-0"><i class="fas fa-phone me-2"></i>Contacto: 5557312412</p>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Función para el menú responsive
        function toggleMenu() {
            const menu = document.getElementById("nav-menu");
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        // Datos de elementos desde PHP
        const elementos = <?php echo $elementos_json; ?>;
        
        // Inicializar el mapa
        const map = L.map('map-container').setView([19.46199407137986, -99.08245160231877], 16);

        // Añadir capa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Función para obtener icono según el tipo y especie
        const getElementIcon = (tipo, especie) => {
            let iconClass = 'fa-paw'; // Icono por defecto para animales
            
            if (tipo === 'zona') {
                return L.divIcon({
                    className: 'custom-icon',
                    html: '<i class="fas fa-map-marker-alt"></i>',
                    iconSize: [30, 30],
                    iconColor: '#00796b'
                });
            }
            
            // Iconos para animales
            especie = especie.toLowerCase();
            if (especie.includes('ave') || especie.includes('pájaro')) iconClass = 'fa-dove';
            if (especie.includes('felino') || especie.includes('león') || especie.includes('tigre')) iconClass = 'fa-cat';
            if (especie.includes('reptil') || especie.includes('serpiente') || especie.includes('cocodrilo')) iconClass = 'fa-staff-snake';
            if (especie.includes('acuático') || especie.includes('pez') || especie.includes('nutria')) iconClass = 'fa-fish';
            if (especie.includes('mono') || especie.includes('chimpancé')) iconClass = 'fa-monkey';
            if (especie.includes('elefante')) iconClass = 'fa-elephant';
            if (especie.includes('jirafa')) iconClass = 'fa-giraffe';
            
            return L.divIcon({
                className: 'custom-icon',
                html: `<i class="fas ${iconClass}"></i>`,
                iconSize: [30, 30]
            });
        };

        // Añadir marcadores para cada elemento
        elementos.forEach(elemento => {
            const marker = L.marker([elemento.latitud, elemento.longitud], {
                icon: getElementIcon(elemento.tipo, elemento.especie)
            }).addTo(map);
            
            let popupContent = `<h5>${elemento.nombre}</h5>
                              <p><strong>Tipo:</strong> ${elemento.tipo === 'animal' ? 'Animal' : 'Zona'}</p>`;
            
            if (elemento.tipo === 'animal') {
                popupContent += `<p><strong>Especie:</strong> ${elemento.especie}</p>`;
            }
            
            if (elemento.imagen) {
                popupContent += `<img src="${elemento.imagen}" style="width:100%; border-radius:5px; margin:5px 0;">`;
            }
            
            if (elemento.descripcion) {
                popupContent += `<p>${elemento.descripcion}</p>`;
            }
            
            marker.bindPopup(popupContent);
        });

        // Variables para almacenar marcadores de clic
        let clickMarker = null;
        let activeTab = 'animal'; // 'animal' o 'zona'

        // Actualizar activeTab cuando cambia la pestaña
        document.getElementById('pills-animales-tab').addEventListener('click', () => {
            activeTab = 'animal';
        });
        
        document.getElementById('pills-zonas-tab').addEventListener('click', () => {
            activeTab = 'zona';
        });

        // Manejar clics en el mapa
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            
            // Actualizar campos del formulario según la pestaña activa
            if (activeTab === 'animal') {
                document.getElementById('latitud-animal').value = lat;
                document.getElementById('longitud-animal').value = lng;
                document.getElementById('coordinates-display-animal').innerHTML = 
                    `<i class="fas fa-check-circle me-2"></i><strong>Coordenadas seleccionadas:</strong><br>
                    Latitud: ${lat.toFixed(6)}<br>
                    Longitud: ${lng.toFixed(6)}`;
            } else {
                document.getElementById('latitud-zona').value = lat;
                document.getElementById('longitud-zona').value = lng;
                document.getElementById('coordinates-display-zona').innerHTML = 
                    `<i class="fas fa-check-circle me-2"></i><strong>Coordenadas seleccionadas:</strong><br>
                    Latitud: ${lat.toFixed(6)}<br>
                    Longitud: ${lng.toFixed(6)}`;
            }
            
            // Eliminar marcador anterior si existe
            if (clickMarker) {
                map.removeLayer(clickMarker);
            }
            
            // Añadir nuevo marcador
            clickMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: 'custom-icon',
                    html: '<i class="fas fa-map-pin"></i>',
                    iconSize: [30, 30],
                    iconColor: '#ff0000'
                })
            }).addTo(map)
              .bindPopup('Ubicación seleccionada')
              .openPopup();
        });

        // Función para cambiar a modo actualización
        function actualizarCoordenadas(tipo) {
            const form = tipo === 'animal' ? document.querySelector('#pills-animales form') : document.querySelector('#pills-zonas form');
            const id = tipo === 'animal' ? document.getElementById('animalID').value : document.getElementById('zonaID').value;
            const latitud = tipo === 'animal' ? document.getElementById('latitud-animal').value : document.getElementById('latitud-zona').value;
            const longitud = tipo === 'animal' ? document.getElementById('longitud-animal').value : document.getElementById('longitud-zona').value;
            
            if (!id) {
                alert(`Por favor selecciona un ${tipo === 'animal' ? 'animal' : 'zona'}`);
                return;
            }
            
            if (!latitud || !longitud) {
                alert('Por favor ingresa las coordenadas');
                return;
            }
            
            if (confirm(`¿Estás seguro de que deseas actualizar las coordenadas de este ${tipo === 'animal' ? 'animal' : 'zona'}?`)) {
                form.querySelector('[name="accion"]').value = 'actualizar';
                form.submit();
            }
        }

        // Función para eliminar coordenadas
        function eliminarCoordenadas(tipo) {
            const form = tipo === 'animal' ? document.querySelector('#pills-animales form') : document.querySelector('#pills-zonas form');
            const id = tipo === 'animal' ? document.getElementById('animalID').value : document.getElementById('zonaID').value;
            
            if (!id) {
                alert(`Por favor selecciona un ${tipo === 'animal' ? 'animal' : 'zona'}`);
                return;
            }
            
            if (confirm(`¿Estás seguro de que deseas eliminar las coordenadas de este ${tipo === 'animal' ? 'animal' : 'zona'}?`)) {
                form.querySelector('[name="accion"]').value = 'eliminar';
                form.submit();
            }
        }

        // Añadir escala al mapa
        L.control.scale().addTo(map);
    </script>
</body>
</html>

<?php $conn->close(); ?>