// home.blade sweetalert2 script

    document.addEventListener('DOMContentLoaded', function() {
        // Show the register succes message if exists
        if (typeof successMessage !== 'undefined' && successMessage) {
            Swal.fire({
                title: '¡Success!',
                html: successMessage,
                icon: 'success',
                confirmButtonText: 'Ok',
                customClass: {
                    popup: 'home-swal-modal-custom'
                }
            });
        }

        // Check if there are error messages in the errorMessages variable and if that variable contains at least one error message.
        if (typeof errorMessages !== 'undefined' && errorMessages.length > 0) {
            errorMessages.forEach(function(error) {
                // Show only error messages related to login authentication (not form validation)
                if (error.includes('incorrect') || error.includes('registered')) {
                    Swal.fire({
                        title: 'Error',
                        html: error,
                        icon: 'error',
                        confirmButtonText: 'Ok',
                        customClass: {
                            popup: 'home-swal-modal-custom'
                        }
                    });
                }
            });
        }
    });

// Toggle button to show/hide password

    document.addEventListener("DOMContentLoaded", function () {
        // Select all toggle buttons
        const toggleButtons = document.querySelectorAll("[id^='togglePassword']");

        toggleButtons.forEach(button => {
            button.addEventListener("click", function () {
                const passwordField = document.getElementById(this.dataset.target);
                const icon = this.querySelector("i");

                if (passwordField) {
                    // Alternate input type
                    const type = passwordField.type === "password" ? "text" : "password";
                    passwordField.type = type;

                    // Alternate icon classes
                    icon.classList.toggle("fa-eye");
                    icon.classList.toggle("fa-eye-slash");
                }
            });
        });
    });

