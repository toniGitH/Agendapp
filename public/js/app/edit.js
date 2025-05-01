// Preview selected image

document.getElementById('image').addEventListener('change', function(e) {
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    imagePreviewContainer.innerHTML = '';

    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.alt = 'Preview';
            img.className = 'img-thumbnail';
            img.style.maxHeight = '100px';
            imagePreviewContainer.appendChild(img);
        }

        reader.readAsDataURL(e.target.files[0]);
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

