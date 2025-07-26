document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            const vista = form.querySelector("input[name='vista']")?.value;

            if (vista === "vuelo" && !validarVuelo(form)) e.preventDefault();
            if (vista === "hotel" && !validarHotel(form)) e.preventDefault();
            if (vista === "reserva" && !validarReserva(form)) e.preventDefault();
        });
    });

    function validarVuelo(form) {
        const origen = form.origen.value.trim();
        const destino = form.destino.value.trim();
        const fecha = form.fecha.value;
        const plazas = parseInt(form.plazas.value);
        const precio = parseFloat(form.precio.value);

        if (!origen || !destino || !fecha || isNaN(plazas) || isNaN(precio)) {
            alert("⚠️ Todos los campos del vuelo son obligatorios y deben ser válidos.");
            return false;
        }

        if (plazas <= 0 || precio <= 0) {
            alert("⚠️ Las plazas y el precio deben ser mayores a cero.");
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
            alert("⚠️ Todos los campos del hotel son obligatorios y deben ser válidos.");
            return false;
        }

        if (habitaciones <= 0 || tarifa <= 0) {
            alert("⚠️ Las habitaciones y la tarifa deben ser mayores a cero.");
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
            alert("⚠️ Todos los campos de la reserva son obligatorios.");
            return false;
        }

        return true;
    }
});
