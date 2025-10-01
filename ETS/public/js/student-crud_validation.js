function initializeCourseFormValidation(formId) {
    const form = document.getElementById(formId);

    // Hentikan eksekusi jika form tidak ditemukan di halaman ini
    if (!form) {
        return;
    }

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
            clearSingleError(this);
        });
    });

    function validateForm() {
        let isValid = true;
        clearAllErrors();

        // Validasi Nama Mata Kuliah
        const courseName = form.querySelector('#course_name');
        if (courseName.value.trim() === '') {
            showError('course_name', 'Nama Mata Kuliah wajib diisi.');
            isValid = false;
        } else if (courseName.value.length > 255) {
            showError('course_name', 'Nama Mata Kuliah tidak boleh lebih dari 255 karakter.');
            isValid = false;
        }

        // Validasi Kode Mata Kuliah
        const courseCode = form.querySelector('#course_code');
        if (courseCode.value.trim() === '') {
            showError('course_code', 'Kode Mata Kuliah wajib diisi.');
            isValid = false;
        } else if (courseCode.value.length > 10) {
            showError('course_code', 'Kode Mata Kuliah tidak boleh lebih dari 10 karakter.');
            isValid = false;
        }

        // Validasi SKS
        const credits = form.querySelector('#credits');
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
        const field = form.querySelector('#' + fieldId);
        // Div untuk error JS, yang memiliki ID
        const errorElement = form.querySelector('#' + fieldId + '_error');

        if (field && errorElement) {
            field.classList.add('is-invalid');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function clearSingleError(inputElement) {
        inputElement.classList.remove('is-invalid');

        // Sembunyikan pesan error dari JS
        const jsErrorElement = form.querySelector('#' + inputElement.id + '_error');
        if (jsErrorElement) {
            jsErrorElement.style.display = 'none';
        }

        // Sembunyikan pesan error dari Laravel (yang tidak punya ID)
        let nextElement = inputElement.nextElementSibling;
        while (nextElement) {
            if (nextElement.classList.contains('invalid-feedback')) {
                nextElement.style.display = 'none';
                break;
            }
            nextElement = nextElement.nextElementSibling;
        }
    }

    function clearAllErrors() {
        const errorFields = form.querySelectorAll('.is-invalid');
        errorFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = form.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(msg => {
            if (msg.id) { // Hanya target pesan error dari JS
                msg.textContent = '';
                msg.style.display = 'none';
            }
        });
    }
}

// Inisialisasi listener saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    initializeCourseFormValidation('create-course-form');
    initializeCourseFormValidation('edit-course-form');
});
