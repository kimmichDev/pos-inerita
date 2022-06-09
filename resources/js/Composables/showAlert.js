import Swal from "sweetalert2"

let showAlert = (icon, title, text) =>
    Swal.fire({
        icon, title, text
    });

export { showAlert };

