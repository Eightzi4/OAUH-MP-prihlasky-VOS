import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

const FORMAT_VALIDATORS = {
    email(value) {
        if (!value) return null;
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
            ? null
            : 'E-mail nemá správný formát.';
    },

    phone(value) {
        if (!value) return null;
        return /^(\+420)?\s?[1-9][0-9]{2}\s?[0-9]{3}\s?[0-9]{3}$/.test(value)
            ? null
            : 'Telefonní číslo nemá správný formát. Očekávaný formát: +420 777 123 456';
    },

    zip(value) {
        if (!value) return null;
        return /^\d{3}\s?\d{2}$/.test(value)
            ? null
            : 'PSČ nemá správný formát. Očekávaný formát: 686 01';
    },

    birth_number(value) {
        if (!value) return null;

        const stripped = value.replace('/', '');

        if (!/^\d{9,10}$/.test(stripped)) {
            return 'Rodné číslo nemá správný formát. Očekávaný formát: 000101/1234';
        }

        let month = parseInt(stripped.substring(2, 4), 10);
        const day = parseInt(stripped.substring(4, 6), 10);

        if (month > 70) month -= 70;
        else if (month > 50) month -= 50;
        else if (month > 20) month -= 20;

        if (month < 1 || month > 12) {
            return 'Rodné číslo obsahuje neplatný měsíc.';
        }
        if (day < 1 || day > 31) {
            return 'Rodné číslo obsahuje neplatný den.';
        }

        if (stripped.length === 10) {
            const num = parseInt(stripped, 10);
            if (num % 11 !== 0) {
                return 'Rodné číslo není platné (chybný kontrolní součet).';
            }
        }

        return null;
    },

    graduation_year(value) {
        if (!value) return null;
        if (!/^\d{4}$/.test(value)) {
            return 'Rok maturity musí být čtyřciferné číslo.';
        }
        const y = parseInt(value, 10);
        if (y < 1950 || y > new Date().getFullYear() + 1) {
            return `Rok maturity musí být v rozmezí 1950–${new Date().getFullYear() + 1}.`;
        }
        return null;
    },

    grade_average(value) {
        if (!value) return null;
        const n = parseFloat(value.replace(',', '.'));
        return (!isNaN(n) && n >= 1.0 && n <= 5.0)
            ? null
            : 'Průměr musí být číslo v rozmezí 1,00 až 5,00.';
    },
};

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
                    file,
                    id: Math.random().toString(36).substr(2, 9),
                    previewUrl: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                    name: file.name,
                    size: this.formatSize(file.size),
                    type: file.type,
                });
            });
            this.updateInput();
        },

        removeFile(id) {
            this.selectedFiles = this.selectedFiles.filter(f => f.id !== id);
            this.updateInput();
        },

        updateInput() {
            const dt = new DataTransfer();
            this.selectedFiles.forEach(item => dt.items.add(item.file));
            this.$refs.fileInput.files = dt.files;
        },

        formatSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024, sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        },

        getIcon(type) {
            if (type.startsWith('image/')) return 'image';
            if (type === 'application/pdf') return 'picture_as_pdf';
            return 'description';
        },
    }));

    Alpine.data('stepValidator', (config) => ({
        stepNumber: config.step || 1,
        fields: config.fields || [],
        errors: {},
        touched: {},

        serverErrorFields: config.serverErrorFields || [],

        serverMessages: config.serverMessages || {},

        init() {
            this.serverErrorFields.forEach(name => {
                this.errors[name] = this.serverMessages[name] || 'Toto pole je neplatné.';
            });

            this.fields.forEach(field => {
                this.$nextTick(() => {
                    const el = document.querySelector(`[name="${field.name}"]`);
                    if (!el) return;

                    const isBinary = el.tagName === 'SELECT'
                        || el.type === 'date'
                        || el.type === 'checkbox';

                    if (isBinary) {
                        el.addEventListener('change', () => {
                            this.touched[field.name] = true;
                            this.validateField(field);
                            this.dispatchCompletionEvent();
                        });
                    } else {
                        el.addEventListener('input', () => {
                            this.touched[field.name] = true;
                            this.validateField(field);
                            this.dispatchCompletionEvent();
                        });
                        el.addEventListener('blur', () => {
                            this.touched[field.name] = true;
                            this.validateField(field);
                            this.dispatchCompletionEvent();
                        });
                    }
                });
            });

            this.$nextTick(() => this.dispatchCompletionEvent());
        },

        getFieldValue(name) {
            const el = document.querySelector(`[name="${name}"]`);
            if (!el) return '';
            if (el.type === 'checkbox') return el.checked ? 'on' : '';
            return el.value ?? '';
        },

        validateField(field) {
            const value = this.getFieldValue(field.name);
            const trimmed = value ? value.trim() : '';

            if (!trimmed) {
                this.errors[field.name] = field.message || 'Toto pole je povinné.';
                return false;
            }

            const formatFn = FORMAT_VALIDATORS[field.name];
            if (formatFn) {
                const err = formatFn(trimmed);
                if (err) {
                    this.errors[field.name] = err;
                    return false;
                }
            }

            delete this.errors[field.name];
            return true;
        },

        validateAll() {
            this.fields.forEach(f => { this.touched[f.name] = true; });
            let valid = true;
            this.fields.forEach(field => {
                if (!this.validateField(field)) valid = false;
            });
            return valid;
        },

        isComplete() {
            return this.fields.every(field => {
                const value = this.getFieldValue(field.name);
                if (!value || !value.trim()) return false;
                const formatFn = FORMAT_VALIDATORS[field.name];
                if (formatFn && formatFn(value.trim())) return false;
                return true;
            });
        },

        dispatchCompletionEvent() {
            window.dispatchEvent(new CustomEvent('step-complete', {
                detail: { step: this.stepNumber, complete: this.isComplete() },
            }));
        },

        fieldHasError(name) {
            return !!this.errors[name];
        },

        hasError(name) {
            return !!(this.touched[name] && this.errors[name]);
        },

        showServerError(name) {
            return this.serverErrorFields.includes(name) && !this.touched[name];
        },

        trySubmit() {
            if (this.validateAll()) {
                this.dispatchCompletionEvent();
                document.getElementById('main-form').submit();
            } else {
                this.$nextTick(() => {
                    const first = document.querySelector('[data-field-error]');
                    first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            }
        },

        goBack(url) {
            window.location.href = url;
        },
    }));
});

window.submitFormWithAction = (destination) => {
    const form = document.getElementById('main-form');
    if (form) {
        let input = form.querySelector('input[name="switch_to"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'switch_to';
            form.appendChild(input);
        }
        input.value = destination;
        form.submit();
    } else {
        window.location.href = destination === 'dashboard' ? '/dashboard' : destination;
    }
};

window.saveAndExit = () => window.submitFormWithAction('dashboard');

window.switchStep = (url) => window.submitFormWithAction(url);

window.goToStep = (url) => { window.location.href = url; };

Alpine.start();
