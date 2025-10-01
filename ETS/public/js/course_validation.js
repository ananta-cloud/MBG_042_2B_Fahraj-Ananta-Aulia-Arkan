document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('create-course-form');
    const inputs = form.querySelectorAll('input[type="text"], input[type="number"]');

    // Listener untuk validasi saat form di-submit
    form.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    // Menghapus error saat pengguna mulai mengetik
    inputs.forEach(input => {
        input.addEventListener('input', function () {
            // Hapus style error dari input field
            this.classList.remove('is-invalid');

            // Sembunyikan pesan error dari JavaScript
            const jsErrorElement = document.getElementById(this.id + '_error');
            if (jsErrorElement) {
                jsErrorElement.style.display = 'none';
            }

            // Sembunyikan pesan error dari Laravel (server-side)
            // Error dari server tidak punya ID, jadi kita cari elemen sibling-nya
            let nextElement = this.nextElementSibling;
            while (nextElement) {
                if (nextElement.classList.contains('invalid-feedback')) {
                    nextElement.style.display = 'none';
                    break;
                }
                nextElement = nextElement.nextElementSibling;
            }
        });
    });

    function validateForm() {
        let isValid = true;
        clearErrors();

        // Validasi Nama Mata Kuliah
        const courseName = document.getElementById('course_name');
        if (courseName.value.trim() === '') {
            showError('course_name', 'Nama Mata Kuliah wajib diisi.');
            isValid = false;
        } else if (courseName.value.length > 255) {
            showError('course_name', 'Nama Mata Kuliah tidak boleh lebih dari 255 karakter.');
            isValid = false;
        }

        // Validasi Kode Mata Kuliah
        const courseCode = document.getElementById('course_code');
        if (courseCode.value.trim() === '') {
            showError('course_code', 'Kode Mata Kuliah wajib diisi.');
            isValid = false;
        } else if (courseCode.value.length > 10) {
            showError('course_code', 'Kode Mata Kuliah tidak boleh lebih dari 10 karakter.');
            isValid = false;
        }

        // Validasi SKS
        const credits = document.getElementById('credits');
        const creditsValue = credits.value;
        if (creditsValue.trim() === '') {
            showError('credits', 'SKS wajib diisi.');
            isValid = false;
        } else {
            const creditsNum = parseInt(creditsValue, 10);
            if (isNaN(creditsNum)) {
                 showError('credits', 'SKS harus berupa angka.');
                 isValid = false;
            } else if (creditsNum < 1 || creditsNum > 6) {
                showError('credits', 'SKS harus antara 1 dan 6.');
                isValid = false;
            }
        }

        return isValid;
    }

    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById(fieldId + '_error');

        field.classList.add('is-invalid');
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function clearErrors() {
        const errorFields = form.querySelectorAll('.is-invalid');
        errorFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = form.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(msg => {
            if (msg.id) {
                msg.textContent = '';
                msg.style.display = 'none';
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('edit-course-form');
    const inputs = form.querySelectorAll('input[type="text"], input[type="number"]');

    form.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    inputs.forEach(input => {
        input.addEventListener('input', function () {
            this.classList.remove('is-invalid');
            const jsErrorElement = document.getElementById(this.id + '_error');
            if (jsErrorElement) {
                jsErrorElement.style.display = 'none';
            }
            let nextElement = this.nextElementSibling;
            while (nextElement) {
                if (nextElement.classList.contains('invalid-feedback')) {
                    nextElement.style.display = 'none';
                    break;
                }
                nextElement = nextElement.nextElementSibling;
            }
        });
    });

    function validateForm() {
        let isValid = true;
        clearErrors();

        const courseName = document.getElementById('course_name');
        if (courseName.value.trim() === '') {
            showError('course_name', 'Nama Mata Kuliah wajib diisi.');
            isValid = false;
        } else if (courseName.value.length > 255) {
            showError('course_name', 'Nama Mata Kuliah tidak boleh lebih dari 255 karakter.');
            isValid = false;
        }

        const courseCode = document.getElementById('course_code');
        if (courseCode.value.trim() === '') {
            showError('course_code', 'Kode Mata Kuliah wajib diisi.');
            isValid = false;
        } else if (courseCode.value.length > 10) {
            showError('course_code', 'Kode Mata Kuliah tidak boleh lebih dari 10 karakter.');
            isValid = false;
        }

        const credits = document.getElementById('credits');
        const creditsValue = credits.value;
        if (creditsValue.trim() === '') {
            showError('credits', 'SKS wajib diisi.');
            isValid = false;
        } else {
            const creditsNum = parseInt(creditsValue, 10);
            if (isNaN(creditsNum)) {
                 showError('credits', 'SKS harus berupa angka.');
                 isValid = false;
            } else if (creditsNum < 1 || creditsNum > 6) {
                showError('credits', 'SKS harus antara 1 dan 6.');
                isValid = false;
            }
        }

        return isValid;
    }


    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById(fieldId + '_error');

        field.classList.add('is-invalid');
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function clearErrors() {
        const errorFields = form.querySelectorAll('.is-invalid');
        errorFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = form.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(msg => {
            if (msg.id) {
                msg.textContent = '';
                msg.style.display = 'none';
            }
        });
    }


});
