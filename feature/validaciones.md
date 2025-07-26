🔍 ¿Qué valida este script?
El sistema detecta automáticamente el tipo de formulario mediante el campo oculto vista (por ejemplo: vuelo, hotel, reserva) y ejecuta validaciones específicas según el caso:

✈️ Validación de Vuelos
Origen y destino no pueden estar vacíos.

Fecha debe estar seleccionada.

Plazas y precio deben ser numéricos y mayores a cero.

🏨 Validación de Hoteles
Nombre y ubicación son campos obligatorios.

Habitaciones y tarifa deben ser números positivos.

📅 Validación de Reservas
ID del cliente debe ser un número válido.

Fecha, vuelo y hotel no pueden estar vacíos.

💡 ¿Cómo funciona?
Al enviar cualquier formulario, el script evalúa los datos ingresados.

Si los datos no son válidos:

Se muestra un bloque <div> al inicio del formulario con una notificación roja usando Bulma.

No se envía el formulario.

Si todo está correcto, el formulario se envía normalmente.

## Issue relacionado
- Resuelve el [Issue #4](https://github.com/Kriger037/agencia_pudu/issues/4)