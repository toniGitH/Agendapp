// * * * SweetAlert2 confirmation before deleting user * * * //

document.querySelectorAll('.delete-acount-button').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        var form = this.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#008000',
            cancelButtonColor: '#ff0000',
            confirmButtonText: 'Yes, delete user!',
            customClass: {
                popup: 'delete-swal-modal-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

// * * * SweetAlert2 confirmation before deleting all user's contacts * * * //

document.querySelectorAll('.delete-all-contacts-button').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        var form = this.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete all the user's contacts permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#008000',
            cancelButtonColor: '#ff0000',
            confirmButtonText: 'Yes, delete all contacts!',
            customClass: {
                popup: 'delete-swal-modal-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

// * * * SweetAlert2 confirmation before transferring all user contacts * * * //

document.querySelectorAll('.transfer-all-contacts-button').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        var form = this.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will transfer all the user's contacts to another user.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#008000',
            cancelButtonColor: '#ff0000',
            confirmButtonText: 'Yes, transfer contacts!',
            customClass: {
                popup: 'delete-swal-modal-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
