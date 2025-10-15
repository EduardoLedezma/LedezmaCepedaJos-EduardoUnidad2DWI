<?php
session_start();
include '../php/navbar.php';
require_once '../php/auth_check.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8">
  <title>ChatBot</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/Practica-Gabriel/css/styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: url('/Practica-Gabriel/img/fondo-negro.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    #chat-box {
      background-color: rgba(255, 255, 255, 0.15);
      padding: 15px;
      border-radius: 10px;
      height: 300px;
      overflow-y: auto;
      font-family: 'Poppins', sans-serif;
    }

    #chat-box p {
      opacity: 0;
      transform: translateY(10px);
      animation: fadeIn 0.4s ease forwards;
      background: rgba(255, 255, 255, 0.1);
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .input-group input {
      background-color: rgba(255, 255, 255, 0.8);
    }

    #sugerencias button {
      transition: all 0.2s ease-in-out;
    }

    #sugerencias button:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body class="bg-dark text-white">
  <div class="container mt-5">
    <h2 class="mb-4">ChatBot</h2>

    <div class="border p-3 rounded text-white" id="chat-box"></div>

    <form id="chat-form" class="mt-3">
      <div class="input-group">
        <input type="text" class="form-control" id="mensaje" placeholder="Escribe tu mensaje..." required>
        <button class="btn btn-primary" type="submit">Enviar</button>
      </div>
    </form>

    <div class="mt-3" id="sugerencias">
      <button class="btn btn-outline-info btn-sm me-2">¿Cómo me registro?</button>
      <button class="btn btn-outline-info btn-sm me-2">Olvidé mi contraseña</button>
      <button class="btn btn-outline-info btn-sm me-2">Quiero dejar una sugerencia</button>
    </div>
  </div>

  <script>
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('mensaje');

    function agregarMensaje(usuario, texto) {
      const p = document.createElement('p');
      p.innerHTML = `<strong>${usuario}:</strong> ${texto}`;
      chatBox.appendChild(p);
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    form.addEventListener('submit', async e => {
      e.preventDefault();
      const mensaje = input.value;
      agregarMensaje("Tú", mensaje);

      const res = await fetch('../php/chat.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mensaje })
      });

      const data = await res.json();
      agregarMensaje("ChatBot", data.respuesta);
      input.value = "";
    });

    document.querySelectorAll('#sugerencias button').forEach(btn => {
      btn.addEventListener('click', () => {
        input.value = btn.textContent;
        form.dispatchEvent(new Event('submit'));
      });
    });
  </script>
</body>
</html>
