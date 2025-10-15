<?php
session_start();
include 'php/navbar_index.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tienda Musical</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/Practica-Gabriel/css/styles.css" />
  <link rel="shortcut icon" href="/img/guitarra.ico" />
  <style>
   body {
  background: url('/Practica-Gabriel-Unidad3/img/fondo-negro.jpg') no-repeat center center fixed;
  background-size: cover;
  color: white;
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}

nav {
  position: sticky;
  top: 0;
  z-index: 1030; /* Bootstrap navbar z-index para que esté arriba */
  background-color: rgba(0, 0, 0, 0.85); /* Fondo semitransparente para navbar */
  backdrop-filter: saturate(180%) blur(20px); /* efecto blur para que se vea nice */
}

.seccion {
  background-color: rgba(0, 0, 0, 0.7);
  padding: 2rem;
  border-radius: 10px;
  margin-bottom: 2rem;
}

/* Animación de entrada */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.card, .seccion {
  opacity: 0;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  will-change: transform;
}

.animated-card, .animated-seccion {
  opacity: 1;
  animation: fadeInUp 0.8s ease forwards;
}

/* Escala al pasar el mouse directamente en cards */
.card:hover {
  transform: scale(1.03);
  box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
}
  </style>
</head>
<body>

<!-- Carrusel -->
<div id="carouselFotos" class="carousel slide mt-4 carrusel-ajustado" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/Practica-Gabriel-Unidad3/img/carrusel1.jpg" class="d-block w-100" alt="Instrumento 1">
    </div>
    <div class="carousel-item">
      <img src="/Practica-Gabriel-Unidad3/img/carrusel2.jpg" class="d-block w-100" alt="Instrumento 2">
    </div>
    <div class="carousel-item">
      <img src="/Practica-Gabriel-Unidad3/img/carrusel3.jpg" class="d-block w-100" alt="Instrumento 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotos" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselFotos" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<div class="container mt-5" id="productos">
  <h2>Catálogo de productos</h2>
  <div class="row" id="lista-productos">
    <!-- Los productos se cargarán dinámicamente aquí -->
  </div>
</div>


<div id="mensaje-no-encontrado" class="text-center text-warning mt-3" style="display: none;">
  No se encontraron productos con ese nombre.
</div>

<!-- Sección Información -->
<div class="container mt-5">
  <div class="row g-4">
    <!-- Sobre la tienda -->
    <div class="col-md-6">
      <div class="card bg-dark text-white h-100">
        <div class="card-body">
          <h5 class="card-title">Sobre nuestra tienda</h5>
          <p class="card-text">
            En Tienda Musical llevamos más de 10 años ofreciendo los mejores instrumentos musicales a músicos de todos los niveles. Desde guitarras eléctricas hasta violines clásicos, trabajamos con las marcas más reconocidas y garantizamos calidad en cada producto. Nuestro compromiso es ayudarte a encontrar el instrumento perfecto que se adapte a tu estilo y nivel.
          </p>
        </div>
      </div>
    </div>

    <!-- Contáctanos -->
    <div class="col-md-6" id="contacto">
      <div class="card bg-dark text-white h-100">
        <div class="card-body">
          <h5 class="card-title">Contáctanos</h5>
          <p>📧 Correo: contacto@tiendamusical.com</p>
          <p>📞 Teléfono: +52 55 1234 5678</p>
          <p>📍 Dirección: Av. Música #123, Ciudad de México</p>
          <div class="redes-sociales mt-3">
            <a href="https://facebook.com/tuPagina" target="_blank" class="text-white me-3" title="Facebook"><i class="bi bi-facebook fs-4"></i></a>
            <a href="https://instagram.com/tuPerfil" target="_blank" class="text-white me-3" title="Instagram"><i class="bi bi-instagram fs-4"></i></a>
            <a href="https://tiktok.com/@tuUsuario" target="_blank" class="text-white me-3" title="TikTok"><i class="bi bi-tiktok fs-4"></i></a>
            <a href="https://youtu.be/dQw4w9WgXcQ?si=b8iaCX3A0TRoXg5c" target="_blank" class="text-white me-3" title="YouTube"><i class="bi bi-youtube fs-4"></i></a>
            <a href="https://twitter.com/tuUsuario" target="_blank" class="text-white" title="Twitter"><i class="bi bi-twitter fs-4"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- Centro de ayuda -->
    <div class="col-md-6" id="ayuda">
      <div class="card bg-dark text-white h-100">
        <div class="card-body">
          <h5 class="card-title">Centro de ayuda</h5>
          <div class="accordion accordion-flush" id="faqAccordion">
            <div class="accordion-item bg-dark text-white border-0">
              <h2 class="accordion-header" id="faq1">
                <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                  ¿Cómo creo una cuenta?
                </button>
              </h2>
              <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Ve a la sección de <strong>Registro</strong>, llena el formulario y haz clic en "Registrarse".</div>
              </div>
            </div>
            <div class="accordion-item bg-dark text-white border-0">
              <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                  Olvidé mi contraseña, ¿qué hago?
                </button>
              </h2>
              <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Ingresa a la página de <strong>recuperación</strong> e introduce tu correo electrónico para restablecer tu contraseña.</div>
              </div>
            </div>
            <div class="accordion-item bg-dark text-white border-0">
              <h2 class="accordion-header" id="faq3">
                <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                  ¿Cómo contacto al soporte?
                </button>
              </h2>
              <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Puedes enviar tu mensaje desde la página de <strong>Contáctanos</strong> o usar el <strong>chat</strong> si está disponible.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mapa del sitio -->
    <div class="col-md-6" id="mapa">
      <div class="card bg-dark text-white h-100">
        <div class="card-body">
          <h5 class="card-title">Mapa del sitio</h5>
          <ul class="list-unstyled">
            <li><a href="/Practica-Gabriel-Unidad3/index.php" class="text-white text-decoration-none">🏠 Inicio</a></li>
            <li><a href="#contacto" class="text-white text-decoration-none">📞 Contáctanos</a></li>
            <li><a href="#ayuda" class="text-white text-decoration-none">❓ Ayuda</a></li>
            <li><a href="#mapa" class="text-white text-decoration-none">🗺️ Mapa del sitio</a></li>
            <li><a href="/Practica-Gabriel-Unidad3/pages/login.php" class="text-white text-decoration-none">🔐 Iniciar sesión</a></li>
            <li><a href="/Practica-Gabriel-Unidad3/pages/register.php" class="text-white text-decoration-none">📝 Registrarse</a></li>
            <li class="text-secondary">💬 Chat (Solo disponible al iniciar sesión)</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  &copy; 2025 Tienda Musical | Todos los derechos reservados
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<script src="/Practica-Gabriel/js/main.js"></script>
<script>
  // Cargar productos dinámicamente desde el backend
  async function cargarProductos() {
    try {
      const res = await fetch('/Practica-Gabriel-Unidad3/api/productos.php');
      const productos = await res.json();
      const contenedor = document.getElementById('lista-productos');
      contenedor.innerHTML = ''; // limpiar

      productos.forEach(prod => {
        const card = document.createElement('div');
        card.className = 'col-md-4 mb-4 producto';
        card.innerHTML = `
          <div class="card h-100">
            <img src="${prod.img}" class="card-img-top" alt="${prod.nombre}">
            <div class="card-body">
              <h5 class="card-title">${prod.nombre}</h5>
              <p class="card-text">${prod.descripcion}</p>
            </div>
          </div>
        `;
        contenedor.appendChild(card);
      });

      // Reaplicar animaciones una vez que se cargan dinámicamente
      aplicarAnimaciones();
    } catch (error) {
      console.error('Error cargando productos:', error);
    }
  }

  // Buscar productos al escribir (dinámicamente)
  document.addEventListener('input', e => {
    if (e.target.id === 'busqueda') buscarProducto();
  });

  /**
   * Busca productos en la lista según el texto ingresado en el campo de búsqueda.
   *
   * Este método obtiene el valor del campo de búsqueda, filtra los elementos con la clase 'producto'
   * dentro del contenedor 'lista-productos' y muestra u oculta cada producto según si coincide con la búsqueda.
   * Si no se encuentra ningún producto, muestra un mensaje indicando que no se encontraron resultados.
   * Si solo se encuentra un producto, realiza un scroll suave hasta centrarlo en la vista.
   *
   * @returns {boolean} Siempre retorna false para evitar el envío del formulario.
   */
  function buscarProducto() {
    const input = document.getElementById('busqueda')?.value.toLowerCase().trim();
    const productos = document.querySelectorAll('#lista-productos .producto');
    const mensaje = document.getElementById('mensaje-no-encontrado');
    let encontrados = [];

    productos.forEach(producto => {
      const texto = producto.textContent.toLowerCase();
      const visible = texto.includes(input);
      producto.style.display = visible ? 'block' : 'none';
      if (visible) encontrados.push(producto);
    });

    if (encontrados.length === 0) {
      mensaje.style.display = 'block';
    } else {
      mensaje.style.display = 'none';
      if (encontrados.length === 1) {
        encontrados[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }

    return false;
  }

  // Animaciones con IntersectionObserver
  /**
   * Aplica animaciones a los elementos con las clases 'card' y 'seccion' 
   * cuando entran en el viewport utilizando IntersectionObserver.
   * 
   * - Selecciona todos los elementos con la clase 'card' y 'seccion'.
   * - Observa cada elemento y, cuando es visible en el viewport:
   *   - Si es una 'card', agrega la clase 'animated-card' y deja de observarlo.
   *   - Si es una 'seccion', agrega la clase 'animated-seccion' y deja de observarlo.
   */
  function aplicarAnimaciones() {
    const cards = document.querySelectorAll('.card');
    const secciones = document.querySelectorAll('.seccion');

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          if (entry.target.classList.contains('card')) {
            entry.target.classList.add('animated-card');
            observer.unobserve(entry.target);
          }
          if (entry.target.classList.contains('seccion')) {
            entry.target.classList.add('animated-seccion');
            observer.unobserve(entry.target);
          }
        }
      });
    }, { threshold: 0.2 });

    cards.forEach(card => {
      observer.observe(card);

      // Efecto hover cerca
      card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        card.style.transform = `scale(1.03) translate(${x * 0.02}px, ${y * 0.02}px)`;
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'scale(1)';
      });
    });

    secciones.forEach(sec => {
      observer.observe(sec);
    });
  }

  // Ejecutar al cargar
  document.addEventListener("DOMContentLoaded", () => {
    cargarProductos();
  });
  // Mostrar alertas según la URL
  const params = new URLSearchParams(window.location.search);
  if (params.get('error') === 'acceso_denegado') {
    Swal.fire({
      icon: 'error',
      title: 'Acceso denegado',
      text: 'No tienes permisos para acceder a esa página.',
    });
  }
</script>
</body>
</html>
