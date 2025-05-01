// * * * Custom script to manage title attribute on action buttons into index.blade.php view * * * //

function toggleTitlesBasedOnScreenSize() {
    // Find all elements whith this classes: 'linkView', 'linkDelete'
    var viewLinks = document.querySelectorAll('.linkView');
    var deleteLinks = document.querySelectorAll('.linkDelete');

    // Assign or remove title attribute based on screen size
    if (window.innerWidth < 768) { // bootstrap screen
        viewLinks.forEach(function (link) {
            link.setAttribute('title', 'View');
        });
        deleteLinks.forEach(function (link) {
            link.setAttribute('title', 'Delete');
        });
    } else {
        viewLinks.forEach(function (link) {
            link.removeAttribute('title');
        });
        deleteLinks.forEach(function (link) {
            link.removeAttribute('title');
        });
    }
}

// Execute on load
toggleTitlesBasedOnScreenSize();

// Excetute on resize
window.addEventListener('resize', toggleTitlesBasedOnScreenSize);


// * * * SweetAlert2 script for contact delete confirmation * * * //

document.querySelectorAll('.delete-button').forEach(function (button) {
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
            confirmButtonText: 'Yes, delete contact!',
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
