document.addEventListener("DOMContentLoaded", function () {
    const tipoEgreso = document.getElementById("tipo_egreso");

    const formProducto = document.getElementById("form_producto");
    const formServicio = document.getElementById("form_servicio");
    const formConsumo = document.getElementById("form_consumo");

    const hideAllForms = () => {
        [formProducto, formServicio, formConsumo].forEach(form => {
            form.style.display = "none";
            form.classList.remove("active");
        });
    };

    const showForm = (form) => {
        form.style.display = "block";
        void form.offsetWidth;
        form.classList.add("active");
    };

    tipoEgreso.value = "producto";
    hideAllForms();
    showForm(formProducto);

    tipoEgreso.addEventListener("change", function () {
        hideAllForms();

        if (tipoEgreso.value === "producto") {
            showForm(formProducto);
        } else if (tipoEgreso.value === "servicio") {
            showForm(formServicio);
        } else if (tipoEgreso.value === "consumo") {
            showForm(formConsumo);
        }
    });
});
