// Ganti status


// Upload photo
const input = document.getElementById('photoInput');
const previewBox = document.getElementById('previewBox');
let selectedFiles = [];

if (input && previewBox) {
    input.addEventListener('change', (e) => {
        selectedFiles = Array.from(e.target.files).slice(0, 1);
        renderPreview();
        syncFilesToInput();
    });
}

function renderPreview() {
    previewBox.innerHTML = '';

    if (selectedFiles.length === 0) {
        previewBox.className = 'photo-preview-empty';
        previewBox.innerHTML = '<i class="bi bi-image text-body-secondary"></i><span>Belum ada foto dipilih</span>';
        return;
    }

    previewBox.className = '';
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (event) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'photo-preview-card';

            const image = document.createElement('img');
            image.className = 'photo-preview-image';
            image.src = event.target.result;
            image.alt = `Preview ${file.name}`;

            const details = document.createElement('div');
            details.className = 'photo-preview-details';

            const fileName = document.createElement('div');
            fileName.className = 'photo-preview-name';
            fileName.textContent = file.name;

            const uploadStatus = document.createElement('span');
            uploadStatus.className = 'badge text-bg-success';
            uploadStatus.textContent = 'Siap diunggah';
            details.append(fileName, uploadStatus);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'photo-remove-button';
            removeButton.title = 'Hapus foto';
            removeButton.setAttribute('aria-label', 'Hapus foto');
            removeButton.innerHTML = '<i class="bi bi-trash3"></i>';
            removeButton.addEventListener('click', () => removePhoto(index));

            wrapper.append(image, details, removeButton);
            previewBox.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

function removePhoto(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
    syncFilesToInput();
}

function syncFilesToInput() {
    if (!input) {
        return;
    }

    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}