$(document).ready(function() {
  // Obtenemos el select
  var select = $("#provincia");

  // Agregamos el evento onchange al select
  select.on("change", function() {
    // Obtenemos la opción seleccionada
    var provinciaSeleccionada = $(this).val();
    // Actualizamos el select2
    actualizarSelectDepartamentos(provinciaSeleccionada);
  });
});

//departamentos por provincia
var departamentosPorProvincia = {
  'Buenos Aires': ['Almirante Brown', 'Avellaneda', 'Banfield', 'La Matanza', 'Quilmes', 'San Isidro'],
  'Córdoba': ['Capital', 'Río Primero', 'Río Segundo', 'Colón', 'San Justo', 'Río Cuarto'],
  'Santa Fe': ['Capital', 'La Capital', 'San Jerónimo', 'Rosario', 'San Lorenzo', 'General Obligado'],
  'Mendoza': ['Capital', 'Godoy Cruz', 'Guaymallén', 'Las Heras', 'Maipú', 'San Rafael'],
  'San Juan': ['Capital', 'Rawson', 'Pocito', 'Rivadavia', 'Chimbas', 'Caucete'],
  'Salta': ['Capital', 'Orán', 'Cafayate', 'Metán', 'Güemes', 'Tartagal'],
  'Entre Ríos': ['Paraná', 'Gualeguaychú', 'Concordia', 'Diamante', 'Uruguay', 'Villaguay'],
  'Misiones': ['Posadas', 'Oberá', 'Eldorado', 'Apóstoles', 'San Vicente', 'Montecarlo'],
  'Jujuy': ['San Salvador de Jujuy', 'Palpalá', 'San Pedro', 'Libertador General San Martín', 'Perico', 'El Carmen'],
  'La Rioja': ['Capital', 'Chilecito', 'Arauco', 'Chamical', 'Famatina', 'Sanagasta'],
  'San Luis': ['San Luis (Capital)', 'Villa Mercedes', 'La Toma', 'Merlo', 'Justo Daract', 'Naschel'],
  'Catamarca': ['San Fernando del Valle de Catamarca', 'Andalgalá', 'Belén', 'Santa María', 'Tinogasta', 'Fiambalá'],
  'La Pampa': ['Santa Rosa', 'General Pico', 'Toay', 'Realicó', 'Macachín', 'Eduardo Castex'],
  'Formosa': ['Formosa (Capital)', 'Clorinda', 'Pirané', 'Las Lomitas', 'El Colorado', 'Ibarreta'],
  'Corrientes': ['Corrientes (Capital)', 'Goya', 'Mercedes', 'Curuzú Cuatiá', 'Esquina', 'Bella Vista'],
  'Tucumán': ['San Miguel de Tucumán', 'Tafí Viejo', 'Yerba Buena', 'Concepción', 'Río Grande', 'Aguilares'],
  'Chaco': ['Resistencia', 'Barranqueras', 'Sáenz Peña', 'Villa Ángela', 'Quitilipi', 'Charata'],
  'Santa Cruz': ['Río Gallegos', 'Caleta Olivia', 'Puerto Deseado', 'Pico Truncado', 'Las Heras', 'El Calafate'],
  'Neuquén': ['Neuquén (Capital)', 'Cutral Có', 'Plottier', 'Centenario', 'Zapala', 'San Martín de los Andes'],
  'Chubut': ['Comodoro Rivadavia', 'Rawson', 'Trelew', 'Esquel', 'Puerto Madryn', 'Sarmiento'],
  'Santiago del Estero': ['Capital', 'Banda', 'La Banda', 'Santiago del Estero Sur', 'Santiago del Estero Norte', 'Fernández'],
  'Tierra del Fuego': ['Antártida Argentina', 'Tierra del Fuego, Antártida e Islas del Atlántico Sur', 'Ushuaia', 'Río Grande', 'Tolhuin', 'San Sebastián'],
  'Río Negro': ['General Roca', 'Lamarque', 'Valcheta', 'Bariloche', 'Viedma', 'Cipolletti'],
};


// Función para actualizar el select de departamentos
function actualizarSelectDepartamentos(provincia) {
  var select2 = $("#dept");

  // Limpiamos el select2
  select2.empty();

  // Verificamos si la provincia está en el objeto departamentosPorProvincia
  if (departamentosPorProvincia.hasOwnProperty(provincia)) {
    // Obtenemos los departamentos para la provincia seleccionada
    var departamentos = departamentosPorProvincia[provincia];

    // Agregamos los departamentos al select2
    departamentos.forEach(function(depto) {
      select2.append("<option value='" + depto + "'>" + depto + "</option>");
    });
  }
}
