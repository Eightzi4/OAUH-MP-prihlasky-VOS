import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('fileUploader', (config) => ({
        maxAttachments: config.maxAttachments || 1,
        acceptedTypes: config.acceptedTypes || [],
        selectedFiles: [],
        isDragging: false,

        handleFiles(files) {
            const newFiles = Array.from(files);

            if (this.selectedFiles.length + newFiles.length > this.maxAttachments) {
                alert(`Můžete nahrát maximálně ${this.maxAttachments} soubor(ů).`);
                return;
            }

            newFiles.forEach(file => {
                this.selectedFiles.push({
                    file: file,
                    id: Math.random().toString(36).substr(2, 9),
                    previewUrl: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                    name: file.name,
                    size: this.formatSize(file.size),
                    type: file.type
                });
            });

            this.updateInput();
        },

        removeFile(id) {
            this.selectedFiles = this.selectedFiles.filter(f => f.id !== id);
            this.updateInput();
        },

        updateInput() {
            const dataTransfer = new DataTransfer();
            this.selectedFiles.forEach(item => dataTransfer.items.add(item.file));
            this.$refs.fileInput.files = dataTransfer.files;
        },

        formatSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        },

        getIcon(type) {
            if (type.startsWith('image/')) return 'image';
            if (type === 'application/pdf') return 'picture_as_pdf';
            return 'description';
        }
    }));
});

Alpine.start();
