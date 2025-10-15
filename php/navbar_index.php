
<link rel="shortcut icon" href="../img/guitarra-electrica.png" />
<link rel="stylesheet" href="/Practica-Gabriel/css/styles.css" />
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid d-flex align-items-center">
    <a class="navbar-brand" href="#">Tienda Musical</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse align-items-center" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#contacto">Contáctanos</a></li>
        <li class="nav-item"><a class="nav-link" href="#ayuda">Ayuda</a></li>
        <li class="nav-item"><a class="nav-link" href="#mapa">Mapa del sitio</a></li>
      </ul>

      <!-- Formulario de búsqueda -->
      <form class="d-flex align-items-center me-3" role="search" onsubmit="return buscarProducto();">
        <input class="form-control me-2" type="search" placeholder="Buscar" id="busqueda" />
      </form>

      <!-- Menú de usuario -->
      <div class="dropdown">
        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          👤 Usuario
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/register.php">Registrarse</a></li>
            <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/login.php">Iniciar sesión</a></li>
            <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/recover.php">Recuperar contraseña</a></li>
            <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/buzon.php">Buzón de Sugerencias</a></li>
          <?php else: ?>
            <li><span class="dropdown-item-text">Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span></li>

            <?php if ($_SESSION['rol'] === 'admin'): ?>
              <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/admin_panel.php">Panel Admin</a></li>
            <?php elseif ($_SESSION['rol'] === 'usuario'): ?>
              <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/change_password.php">Mi Perfil</a></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/chat.php">Chat</a></li>
            <li><a class="dropdown-item" href="/Practica-Gabriel-Unidad3/pages/buzon.php">Buzón de Sugerencias</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="/Practica-Gabriel-Unidad3/php/logout.php" method="POST" style="margin: 0;">
                <button type="submit" class="dropdown-item">Cerrar sesión</button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>
