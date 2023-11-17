var etiquetasPredefinidas = [
  'Playa', 
  'Montaña', 
  'Ciudad', 
  'Casa', 
  'Departamento', 
  'Habitación privada', 
  'Habitación compartida', 
  'Aire acondicionado', 
  'Piscina', 
  'WiFi', 
  'Mascotas permitidas', 
  'Estacionamiento gratuito', 
  'Desayuno incluido', 
  'Admite fumadores', 
  'Cocina completa', 
  'Vistas panorámicas', 
  'Acceso a la playa', 
  'Jardín', 
  'Terraza', 
  'Se aceptan niños', 
  'Acceso para personas con discapacidad', 
  'Spa', 
  'Cerca del transporte público', 
  'Zona tranquila', 
  // Agrega más etiquetas aquí
];

// Ejemplo de cómo mostrar estas etiquetas en un formulario HTML
var selectEtiquetas = document.getElementById("etiquetas");
etiquetasPredefinidas.forEach(function(etiqueta) {
  var option = document.createElement("option");
  option.value = etiqueta;
  option.text = etiqueta;
  selectEtiquetas.appendChild(option);
});
