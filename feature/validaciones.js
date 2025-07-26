document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        const errorContainer = document.createElement("div");
        errorContainer.className = "notification is-danger is-light";
        errorContainer.style.display = "none";
        form.prepend(errorContainer); // Inserta el contenedor al inicio del formulario

        form.addEventListener("submit", (e) => {
            const vista = form.querySelector("input[name='vista']")?.value;
            let valido = true;

            clearErrors();

            if (vista === "vuelo") valido = validarVuelo(form);
            if (vista === "hotel") valido = validarHotel(form);
            if (vista === "reserva") valido = validarReserva(form);

            if (!valido) e.preventDefault();
        });

        function showError(mensaje) {
            errorContainer.innerText = mensaje;
            errorContainer.style.display = "block";
        }

        function clearErrors() {
            errorContainer.innerText = "";
            errorContainer.style.display = "none";
        }

        function validarVuelo(form) {
            const origen = form.origen.value.trim();
            const destino = form.destino.value.trim();
            const fecha = form.fecha.value;
            const plazas = parseInt(form.plazas.value);
            const precio = parseFloat(form.precio.value);

            if (!origen || !destino || !fecha || isNaN(plazas) || isNaN(precio)) {
                showError("⚠️ Todos los campos del vuelo son obligatorios y deben ser válidos.");
                return false;
            }

            if (plazas <= 0 || precio <= 0) {
                showError("⚠️ Las plazas y el precio deben ser mayores a cero.");
                return false;
            }

            return true;
        }

        function validarHotel(form) {
            const nombre = form.nombre.value.trim();
            const ubicacion = form.ubicacion.value.trim();
            const habitaciones = parseInt(form.habitaciones.value);
            const tarifa = parseFloat(form.tarifa.value);

            if (!nombre || !ubicacion || isNaN(habitaciones) || isNaN(tarifa)) {
                showError("⚠️ Todos los campos del hotel son obligatorios y deben ser válidos.");
                return false;
            }

            if (habitaciones <= 0 || tarifa <= 0) {
                showError("⚠️ Las habitaciones y la tarifa deben ser mayores a cero.");
                return false;
            }

            return true;
        }

        function validarReserva(form) {
            const clienteId = parseInt(form.cliente_id.value);
            const fecha = form.fecha_reserva.value;
            const vuelo = form.vuelo_id.value;
            const hotel = form.hotel_id.value;

            if (isNaN(clienteId) || !fecha || !vuelo || !hotel) {
                showError("⚠️ Todos los campos de la reserva son obligatorios.");
                return false;
            }

            return true;
        }
    });
});
