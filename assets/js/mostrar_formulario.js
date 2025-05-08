document.addEventListener("DOMContentLoaded", function () {

    /* Obtenemis el elemento select */
    let tipoEgreso = document.getElementById("tipo_egreso");

    /* Obtenemos los formularios del DOM */
    let formProducto = document.getElementById("form_producto");
    let formServicio = document.getElementById("form_servicio");

    /* El formulario de producto será visible por defecto */
    formProducto.style.display = "block";
    formServicio.style.display = "none";

    /* Seleccionamos la opción producto por defecto */
    tipoEgreso.value = "producto";

    tipoEgreso.addEventListener("change", function () {

        /* Condicional que si seleccion producto */
        if (tipoEgreso.value === "producto") {
            formProducto.style.display = "block";
            formServicio.style.display = "none";
        }

        else if (tipoEgreso.value === "servicio") {
            formProducto.style.display = "none";
            formServicio.style.display = "block";
        }

        else {
            formProducto.style.display = "none";
            formServicio.style.display = "none";
        }
    });
});