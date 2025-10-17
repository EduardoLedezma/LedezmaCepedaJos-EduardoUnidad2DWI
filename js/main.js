function buscarProducto() {
  const termino = document.getElementById("busqueda").value.trim();
  if (termino === "") {
    alert("Por favor, escribe algo para buscar.");
    return false;
  }
  // Aquí puedes hacer redirección o mostrar resultados
  alert("Buscando: " + termino);
  return false; // Evita el envío real del formulario
}
