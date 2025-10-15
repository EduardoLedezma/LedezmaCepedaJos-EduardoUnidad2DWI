<?php
session_start();
include '../php/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <title>Buzón de Sugerencias</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/Practica-Gabriel/css/styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
  body {
    background: url('/Practica-Gabriel/img/fondo-negro.jpg') no-repeat center center fixed;
    background-size: cover;
    color: white;
    font-family: 'Poppins', sans-serif;
  }

  .fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
  }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .comentario {
    background-color: rgba(255, 255, 255, 0.05);
    border: 1px solid #999;
    padding: 1rem;
    border-radius: 15px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
  }

  .comentario:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: scale(1.01);
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
  }

  .form-control, .btn {
    border-radius: 10px;
  }

  #formulario-comentario {
    animation: fadeInUp 0.6s ease forwards;
  }
</style>
</head>
<body class="bg-dark text-white">
  <div class="container mt-5">
    <h2 class="mb-4">Buzón de Sugerencias</h2>

    <div id="formulario-comentario" class="mb-4" style="display: none;">
      <form id="comentarioForm">
        <div class="mb-3">
          <label for="comentario" class="form-label">Escribe tu sugerencia:</label>
          <textarea
            class="form-control"
            id="comentario"
            name="comentario"
            rows="3"
            required
          ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>

    <div id="lista-comentarios">
      <h4>Comentarios recientes:</h4>
      <div id="comentarios"></div>
    </div>
  </div>

  <script>
  // Escapa caracteres peligrosos para evitar inyecciones
  function escapeHTML(texto) {
    const div = document.createElement("div");
    div.innerText = texto;
    return div.innerHTML;
  }

  // Carga comentarios desde el backend
  async function cargarComentarios() {
    try {
      const res = await fetch("../php/buzon.php", {
        credentials: "include"
      });
      const data = await res.json();

      const lista = document.getElementById("comentarios");
      const form = document.getElementById("formulario-comentario");

      lista.innerHTML = "";
      data.comentarios.forEach((c, index) => {
        const div = document.createElement("div");
        div.className = "comentario fade-in";
        div.style.animationDelay = `${index * 100}ms`;
        div.innerHTML = `
        <strong>${escapeHTML(c.usuario)}</strong> <span class="text-muted">[${c.fecha}]</span><br />
        ${escapeHTML(c.comentario)}
        ${c.admin ? `<button class="btn btn-sm btn-danger mt-2" onclick="eliminarComentario(${c.id})">Eliminar</button>` : ''}
        `;
        lista.appendChild(div);
      });

      if (data.logeado) {
        form.style.display = "block";
      } else {
        form.style.display = "none";
      }
    } catch (error) {
      console.error("Error al cargar comentarios:", error);
    }
  }

  function eliminarComentario(id) {
  Swal.fire({
    title: '¿Eliminar comentario?',
    text: "Esta acción no se puede deshacer.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const res = await fetch(`../php/buzon.php?id=${id}`, {
          method: 'DELETE',
          credentials: 'include'
        });
        const data = await res.json();
        if (res.ok) {
          Swal.fire({
            icon: 'success',
            title: 'Comentario eliminado',
            timer: 1500,
            showConfirmButton: false
          });
          cargarComentarios();
        } else {
          throw new Error(data.error || 'Error desconocido');
        }
      } catch (err) {
        console.error(err);
        Swal.fire('Error', 'No se pudo eliminar el comentario.', 'error');
      }
    }
  });
}


  // Envío de nuevo comentario
  document.getElementById("comentarioForm").addEventListener("submit", async e => {
    e.preventDefault();
    const textarea = document.getElementById("comentario");
    const texto = textarea.value.trim();

    if (texto.length === 0) {
      Swal.fire({
        icon: "warning",
        title: "Campo vacío",
        text: "Por favor, escribe tu sugerencia antes de enviarla."
      });
      return;
    }

    const formData = new FormData();
    formData.append("comentario", texto);

    try {
      const res = await fetch("../php/buzon.php", {
        method: "POST",
        body: formData,
        credentials: "include"
      });

      if (res.ok) {
        textarea.value = "";
        Swal.fire({
          icon: "success",
          title: "¡Gracias!",
          text: "Tu sugerencia fue enviada correctamente.",
          timer: 1800,
          showConfirmButton: false
        });
        cargarComentarios();
      } else {
        throw new Error("Error al enviar sugerencia");
      }
    } catch (error) {
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "No se pudo enviar tu sugerencia. Intenta más tarde."
      });
    }
  });

  // Cargar al iniciar
  document.addEventListener("DOMContentLoaded", cargarComentarios);
</script>

</body>
</html>
