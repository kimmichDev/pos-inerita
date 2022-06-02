import Swal from "sweetalert2";
let showConfirm = (task, text = "You won't be able to revert this!",) => {
    Swal.fire({
        title: 'Are you sure?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            task();
        }
    })
};
export { showConfirm };