// Preview selected image

document.getElementById('image').addEventListener('change', function(event) {
    let file = event.target.files[0];
    let preview = document.getElementById('previewImage');

    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Custom file input

document.addEventListener("DOMContentLoaded", function() {
    var fileInput = document.getElementById('image');
    var fileName = document.getElementById('file-name');

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileName.value = this.files[0].name;
        } else {
            fileName.value = "No file selected";
        }
    });
});

