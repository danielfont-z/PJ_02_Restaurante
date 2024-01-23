// divs del index para cada rol de usuario
const divgerente = document.getElementById("gerente");
const divcamarero = document.getElementById("camarero");
const divmantenimiento = document.getElementById("mantenimiento");
const divadministrador = document.getElementById("administrador");
// botones del index para gerente
const buttonGestionGerente = document.getElementById("gestion-gerente");
const buttonHistorico = document.getElementById("historico-gerente");
// botones del index para camarero
const buttonGestionCamarero = document.getElementById("gestion-camarero");
// botones del index para mantenimiento
const buttonMantenimiento = document.getElementById("mantenimiento-mantenimiento");
// botones del index para administrador
const buttonAdministrar = document.getElementById("administrar-administrador");
const buttonAlta = document.getElementById("alta-administrador");
// boton salir (igual para todos los roles)
const buttonSalir = document.getElementsByClassName("salir");
// div donde está el H1 de Selecciona la Sala/Mesa
const divSeleccionala = document.getElementById("selecciona-la");
// div del historico para gerente
const divListadoHistorico = document.getElementById("listado-historico-gerente");
// div de gestion para gerente
const divListadoGestionGerente = document.getElementById("listado-gestion-gerente");

// al dirigirse a index.php hará esta función, la cual mostrará un div u otro dependiendo del rol del usuario
window.addEventListener('load', function(){
    var ajax = new XMLHttpRequest();
    
    ajax.open('POST', 'rol.php');

    ajax.onload = function(){
        if(ajax.status == 200){
            try {
                var respuestarol = JSON.parse(ajax.responseText);

                var userRol = respuestarol.rol;

                switch (userRol){
                    case 'Gerente':
                        divgerente.style.display = "block";
                        divcamarero.style.display = "none";
                        divmantenimiento.style.display = "none";
                        divadministrador.style.display = "none";
                        buttonGestionGerente.style.backgroundColor = "green";
                        buttonHistorico.style.backgroundColor = "red";
                        break;
                    case 'Camarero':
                        divgerente.style.display = "none";
                        divcamarero.style.display = "block";
                        divmantenimiento.style.display = "none";
                        divadministrador.style.display = "none";
                        buttonGestionCamarero.style.backgroundColor = "green";
                        break;
                    case 'Mantenimiento':
                        divgerente.style.display = "none";
                        divcamarero.style.display = "none";
                        divmantenimiento.style.display = "block";
                        divadministrador.style.display = "none";
                        buttonMantenimiento.style.backgroundColor = "green";
                        break;
                    case 'Administrador':
                        divgerente.style.display = "none";
                        divcamarero.style.display = "none";
                        divmantenimiento.style.display = "none";
                        divadministrador.style.display = "block";
                        buttonAdministrar.style.backgroundColor = "green";
                        break;
                    default:
                        divgerente.style.display = "none";
                        divcamarero.style.display = "none";
                        divmantenimiento.style.display = "none";
                        divadministrador.style.display = "none";
                        break; 
                }
                console.log("Llamando a gestionSalas con rol = ", userRol);
                gestionSalas(userRol);
            } catch (e){
                console.error("Error al parsear la respuesta JSON:", e);
            }
        } else {
            console.log("Error en la petición AJAX");
        }
    }

    ajax.send();

});

// Evento para cerrar sesion al clicar en Salir
// El bucle se hace debido a que todos los botones salir comparten la misma clase.
// Debido a ello, si se hace el evento como si se tratase de un elemento ID, no sabe cual elemento seleccionar
for (let i = 0; i < buttonSalir.length; i++) {
    buttonSalir[i].addEventListener("click", function() {
        var ajaxLogOut = new XMLHttpRequest();

        ajaxLogOut.open('POST', 'logout.php');

        ajaxLogOut.onload = function(){
            if(ajaxLogOut.status == 200){
                window.location.href = 'login.php';
            } else {
                console.log("Error en la petición AJAX para cerrar sesión");
            }
        }
        ajaxLogOut.send();
    });
}

// Evento cuando se clique el boton Gestion de Gerente o Camarero
function gestionSalas(rol) {
    var ajaxMostrarSalas = new XMLHttpRequest();

    ajaxMostrarSalas.open('POST', 'mostrar-salas.php');

    ajaxMostrarSalas.onload = function () {
        if (ajaxMostrarSalas.status == 200) {
            try {
                var salas = JSON.parse(ajaxMostrarSalas.responseText);

                // Obtén el ID del div correspondiente al rol del usuario
                var listadoDivId = "listado-gestion-" + rol.toLowerCase();

                var listadoDiv = document.getElementById(listadoDivId);

                // Limpia el contenido actual del div
                listadoDiv.innerHTML = "";
                divSeleccionala.innerHTML = "";
                divListadoHistorico.innerHTML = '';
                divListadoGestionGerente.innerHTML = '';
                // Itera sobre las salas y actualiza el contenido del div
                salas.forEach(function (sala) {
                    var contentItem = document.createElement("div");
                    contentItem.classList.add("column-5", "content-gestion-content-item");
                    contentItem.onclick = function () {
                        window.location.href = 'index.php?room=' + sala.room_id;
                    };

                    contentItem.innerHTML = `
                        <div class ="column-5 content-gestion-content-item">
                            <div class="content-gestion-content-item-image">
                                <img src="./img/room_${sala.room_name}.png" alt="">
                            </div>
                            <div class="content-gestion-content-item-bottom">
                                <span><span class="hideAtSmall">Mesas disponibles:</span> ${sala.table_available}/${sala.table_count}</span>
                            </div>
                            <div>
                                <span><span class="hideAtSmall">Sala = </span> ${sala.room_name}</span>
                            </div>
                        </div>`;

                    listadoDiv.appendChild(contentItem);
                });

                divSeleccionala.innerHTML = `
                    <h1>Selecciona la Sala</h1>
                `;

            } catch (e) {
                console.error("Error al parsear la respuesta JSON:", e);
            }
        } else {
            console.log("Error en la petición AJAX");
        }
    };

    ajaxMostrarSalas.send();
}

buttonGestionGerente.addEventListener("click", function () {
    buttonGestionGerente.style.backgroundColor = "green";
    buttonHistorico.style.backgroundColor = "red";
    gestionSalas('gerente');
});

buttonGestionCamarero.addEventListener("click", function () {
    gestionSalas('camarero');
});
// Evento cuando se clique el boton Historico de Gerente
function historico() {
    var ajaxHistorico = new XMLHttpRequest();

    ajaxHistorico.open('GET', 'mostrar-historico.php?tableId=...&roomName=...&fullName=...&page=1', true);

    ajaxHistorico.onload = function () {
        console.log(this.responseText);
        if (ajaxHistorico.status == 200) {
            try {
                var response = JSON.parse(ajaxHistorico.responseText);

                // Verifica si hay datos en el historial
                if (response.length > 0) {
                    // Limpia el contenido actual del div
                    divListadoHistorico.innerHTML = '';

                    // Construir la tabla y agregarla al div de historial
                    var table = '<table>';
                    // Agregar encabezados de tabla
                    table += '<thead><tr><th>ID</th><th>Nombre de sala</th><th>ID de mesa</th><th>Encargado</th><th>Libre</th><th>Fecha</th></tr></thead><tbody>';
                    // Agregar filas con datos
                    response.forEach(function (data) {
                        table += '<tr>';
                        table += '<td>' + data.id + '</td>';
                        table += '<td>' + data.name + '</td>';
                        table += '<td>' + data.table_name + '</td>';
                        table += '<td>' + data.fullName + '</td>';
                        table += data.set_available ? '<td style="color: green;">Sí</td>' : '<td style="color: red;">No</td>';
                        table += '<td>' + data.date + '</td>';
                        table += '</tr>';
                    });
                    table += '</tbody></table>';

                    // Agregar la tabla al div de historial
                    divListadoHistorico.innerHTML = table;

                    // Actualizar paginación si está presente
                    if (response.paginacion) {
                        var paginacion = response.paginacion;
                        console.log("Página actual: " + paginacion.page);
                        console.log("Total de páginas: " + paginacion.total_pages);
                        console.log("Registros por página: " + paginacion.records_per_page);
                    }
                } else {
                    console.log("No hay datos en el historial.");
                }
            } catch (e) {
                console.error("Error al parsear la respuesta JSON:", e);
            }
        } else {
            console.log("Error en la petición ajax para mostrar el historial");
        }
    };

    ajaxHistorico.send();
}

buttonHistorico.addEventListener("click", function () {
    buttonGestionGerente.style.backgroundColor = "red";
    buttonHistorico.style.backgroundColor = "green";
    historico();
});
// Evento cuando se clique el boton Mantenimiento

// Evento cuando se clique el boton Administrar de Administrador

// Evento cuando se clique el boton Alta de Administrador