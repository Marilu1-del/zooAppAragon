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

// Obtener animales con coordenadas
$sql_animales = "SELECT 
                    'animal' AS tipo, 
                    AnimalID AS id, 
                    nombre, 
                    especie, 
                    descripcion, 
                    imagen, 
                    latitud, 
                    longitud 
                 FROM animales 
                 WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$result_animales = $conn->query($sql_animales);

// Obtener zonas con coordenadas
$sql_zonas = "SELECT 
                'zona' AS tipo, 
                ZonaID AS id, 
                Nombre AS nombre, 
                'Zona' AS especie, 
                Descripcion AS descripcion, 
                Imagen AS imagen, 
                latitud, 
                longitud 
              FROM zonas 
              WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$result_zonas = $conn->query($sql_zonas);

// Combinar resultados manualmente
$elementos_mapa = array();

if ($result_animales->num_rows > 0) {
    while($row = $result_animales->fetch_assoc()) {
        // Corregir ruta de imagen si es necesario
        if (!empty($row['imagen']) && !str_contains($row['imagen'], 'imagenes/')) {
            $row['imagen'] = 'imagenes/' . $row['imagen'];
        }
        $elementos_mapa[] = $row;
    }
}

if ($result_zonas->num_rows > 0) {
    while($row = $result_zonas->fetch_assoc()) {
        // Corregir ruta de imagen si es necesario
        if (!empty($row['imagen']) && !str_contains($row['imagen'], 'imagenes/')) {
            $row['imagen'] = 'imagenes/' . $row['imagen'];
        }
        $elementos_mapa[] = $row;
    }
}

$elementos_json = json_encode($elementos_mapa);

// Consulta para elementos destacados
$sql_destacados_animales = "SELECT 
                            'animal' AS tipo, 
                            AnimalID AS id, 
                            nombre, 
                            especie, 
                            imagen 
                           FROM animales 
                           WHERE latitud IS NOT NULL AND longitud IS NOT NULL
                           ORDER BY RAND() LIMIT 3";
$result_destacados_animales = $conn->query($sql_destacados_animales);

$sql_destacados_zonas = "SELECT 
                        'zona' AS tipo, 
                        ZonaID AS id, 
                        Nombre AS nombre, 
                        'Zona' AS especie, 
                        Imagen AS imagen 
                       FROM zonas 
                       WHERE latitud IS NOT NULL AND longitud IS NOT NULL
                       ORDER BY RAND() LIMIT 2";
$result_destacados_zonas = $conn->query($sql_destacados_zonas);

// Contar animales y zonas
$sql_animales_count = "SELECT COUNT(*) as total FROM animales WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$result_animales_count = $conn->query($sql_animales_count);
$animales_count = $result_animales_count->fetch_assoc()['total'];

$sql_zonas_count = "SELECT COUNT(*) as total FROM zonas WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$result_zonas_count = $conn->query($sql_zonas_count);
$zonas_count = $result_zonas_count->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa del Zoológico | ZooAragon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/ca7c7e6854.js" crossorigin="anonymous"></script>
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
        
        .map-container {
            height: 600px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        
        .legend {
            padding: 10px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            line-height: 1.5;
        }
        
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
        
        .info-panel {
            position: absolute;
            top: 80px;
            right: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            max-width: 300px;
        }
        
        .animal-card {
            margin-bottom: 15px;
            border-left: 4px solid var(--color-primario);
        }
        
        .zona-card {
            margin-bottom: 15px;
            border-left: 4px solid #4CAF50;
        }
        
        .animal-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
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
                height: 400px;
            }
            
            .info-panel {
                position: relative;
                top: auto;
                right: auto;
                margin-bottom: 15px;
                max-width: 100%;
            }
            
            .nav-menu {
                top: 70px;
                right: 10px;
            }
        }
        /* Navigation Bar */
        nav {
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            font-family: 'Poppins', sans-serif;
        }

        nav h1 {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        nav h1 img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #ffeb3b;
        }

    </style>
</head>
<body>
<nav>
        <h1>
            <img src="imagenes/evento1.jpg" alt="Zoo Logo">
            Zoológico San Juan de Aragón
        </h1>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="mapaZooAragon.php">Mapa</a></li>
            <li><a href="animales.php">Animales</a></li>
            <li><a href="zonas.php">Zonas</a></li>
            <li><a href="actividades.php">Actividades</a></li>
            <li><a href="precios.php">Precios</a></li>
            <li><a href="nosotros.php">Sobre Nosotros</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
    
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <div id="map-container" class="map-container"></div>
            </div>
            <div class="col-lg-4">
                <div class="info-panel">
                    <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Información del Zoológico</h4>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-paw me-2"></i>Animales</h5>
                        <p>Total en el mapa: <strong><?= $animales_count ?></strong></p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-map-marker-alt me-2"></i>Zonas</h5>
                        <p>Total en el mapa: <strong><?= $zonas_count ?></strong></p>
                    </div>
                    
                    <div class="mb-3">
                        <h5><i class="fas fa-search me-2"></i>Leyenda</h5>
                        <div><i class="fas fa-paw me-2" style="color: var(--color-primario);"></i> Animales</div>
                        <div><i class="fas fa-map-marker-alt me-2" style="color: #4CAF50;"></i> Zonas</div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-list me-2"></i>Elementos destacados
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        <?php
                        // Mostrar animales destacados
                        if ($result_destacados_animales->num_rows > 0) {
                            while($row = $result_destacados_animales->fetch_assoc()) {
                                echo '<div class="animal-card p-3">';
                                echo '<h6><i class="fas fa-paw me-2"></i>' . htmlspecialchars($row['nombre']) . '</h6>';
                                echo '<small class="text-muted">' . htmlspecialchars($row['especie']) . '</small>';
                                if (!empty($row['imagen'])) {
                                    $imagenPath = !str_contains($row['imagen'], 'imagenes/') ? 'imagenes/' . $row['imagen'] : $row['imagen'];
                                    echo '<img src="' . $imagenPath . '" class="animal-image" alt="' . htmlspecialchars($row['nombre']) . '" onerror="this.style.display=\'none\'">';
                                }
                                echo '</div>';
                            }
                        }
                        
                        // Mostrar zonas destacadas
                        if ($result_destacados_zonas->num_rows > 0) {
                            while($row = $result_destacados_zonas->fetch_assoc()) {
                                echo '<div class="zona-card p-3">';
                                echo '<h6><i class="fas fa-map-marker-alt me-2"></i>' . htmlspecialchars($row['nombre']) . '</h6>';
                                if (!empty($row['imagen'])) {
                                    $imagenPath = !str_contains($row['imagen'], 'imagenes/') ? 'imagenes/' . $row['imagen'] : $row['imagen'];
                                    echo '<img src="' . $imagenPath . '" class="animal-image" alt="' . htmlspecialchars($row['nombre']) . '" onerror="this.style.display=\'none\'">';
                                }
                                echo '</div>';
                            }
                        }
                        
                        if ($result_destacados_animales->num_rows === 0 && $result_destacados_zonas->num_rows === 0) {
                            echo '<p>No hay elementos destacados para mostrar.</p>';
                        }
                        ?>
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
            let iconColor = '#00796b'; // Color primario para animales
            
            if (tipo === 'zona') {
                return L.divIcon({
                    className: 'custom-icon',
                    html: '<i class="fas fa-map-marker-alt"></i>',
                    iconSize: [30, 30],
                    iconColor: '#4CAF50' // Verde para zonas
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
                iconSize: [30, 30],
                iconColor: iconColor
            });
        };

        // Añadir marcadores para cada elemento
        elementos.forEach(elemento => {
            const marker = L.marker([elemento.latitud, elemento.longitud], {
                icon: getElementIcon(elemento.tipo, elemento.especie)
            }).addTo(map);
            
            let popupContent = `<div style="max-width: 250px;">
                              <h5 style="color: ${elemento.tipo === 'animal' ? 'var(--color-primario)' : '#4CAF50'}; margin-bottom: 10px;">
                                <i class="fas ${elemento.tipo === 'animal' ? 'fa-paw' : 'fa-map-marker-alt'} me-2"></i>
                                ${elemento.nombre}
                              </h5>`;
            
            if (elemento.tipo === 'animal') {
                popupContent += `<p><strong>Especie:</strong> ${elemento.especie}</p>`;
            }
            
            // Mostrar imagen si existe
            if (elemento.imagen && elemento.imagen.trim() !== '') {
                // Construir ruta correcta de la imagen
                let rutaImagen = elemento.imagen;
                if (!rutaImagen.startsWith('imagenes/') && !rutaImagen.startsWith('http')) {
                    rutaImagen = 'imagenes/' + rutaImagen;
                }
                popupContent += `<img src="${rutaImagen}" class="animal-image" alt="${elemento.nombre}" onerror="this.style.display='none'">`;
            }
            
            if (elemento.descripcion) {
                popupContent += `<p style="margin-top: 10px;">${elemento.descripcion.substring(0, 100)}${elemento.descripcion.length > 100 ? '...' : ''}</p>`;
            }
            
            popupContent += `</div>`;
            
            marker.bindPopup(popupContent);
        });

        // Añadir leyenda al mapa
        const legend = L.control({position: 'bottomright'});

        legend.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'legend');
            div.innerHTML = `
                <h6 style="margin-bottom: 10px;"><i class="fas fa-map me-2"></i>Leyenda</h6>
                <div><i class="fas fa-paw me-2" style="color: #00796b;"></i> Animales</div>
                <div><i class="fas fa-map-marker-alt me-2" style="color: #4CAF50;"></i> Zonas</div>
            `;
            return div;
        };

        legend.addTo(map);

        // Añadir escala al mapa
        L.control.scale().addTo(map);
    </script>
</body>
</html>

<?php $conn->close(); ?>