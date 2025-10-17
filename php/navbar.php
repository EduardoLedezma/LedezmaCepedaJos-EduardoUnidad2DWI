<!-- Navbar -->
 <link rel="stylesheet" href="/css/styles.css" />
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Tienda Musical</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="../index.php">Inicio</a></li>
      </ul>

      <!-- Menú de usuario -->
      <div class="dropdown">
        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          👤 Usuario
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a class="dropdown-item" href="/pages/register.php">Registrarse</a></li>
            <li><a class="dropdown-item" href="/pages/login.php">Iniciar sesión</a></li>
            <li><a class="dropdown-item" href="/pages/recover.php">Recuperar contraseña</a></li>
            <li><a class="dropdown-item" href="/pages/buzon.php">Buzón de Sugerencias</a></li>
          <?php else: ?>
            <li><span class="dropdown-item-text">Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span></li>
            <li><a class="dropdown-item" href="/pages/change_password.php">Cambiar contraseña</a></li>
            <li><a class="dropdown-item" href="/pages/chat.php">Chat</a></li>
            <li><a class="dropdown-item" href="/pages/buzon.php">Buzón de Sugerencias</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="/php/logout.php" method="POST" style="margin: 0;">
                <button type="submit" class="dropdown-item">Cerrar sesión</button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<script src="/js/main.js"></script>