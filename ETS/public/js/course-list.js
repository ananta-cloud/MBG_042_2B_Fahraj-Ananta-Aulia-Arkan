document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk checkbox "Pilih Semua"
    const selectAllCheckbox = document.getElementById('select-all');
    const courseCheckboxes = document.querySelectorAll('.course-checkbox');

    if(selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            courseCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Fungsi untuk konfirmasi sebelum submit
    const enrollForm = document.getElementById('enroll-form');
    if(enrollForm) {
        enrollForm.addEventListener('submit', function (event) {
            const selectedCourses = document.querySelectorAll('.course-checkbox:checked');

            // Hentikan submit jika tidak ada yang dipilih
            if (selectedCourses.length === 0) {
                event.preventDefault(); // Mencegah form dikirim
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda harus memilih setidaknya satu mata kuliah.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            // Konfirmasi jika ada yang dipilih
            event.preventDefault(); // Selalu hentikan submit awal untuk menampilkan konfirmasi
            let courseListHtml = '<ul>';
            selectedCourses.forEach(cb => {
                // Mengambil nama mata kuliah dari sel tabel di baris yang sama
                const row = cb.closest('tr');
                const courseName = row.cells[2].textContent;
                courseListHtml += `<li>${courseName}</li>`;
            });
            courseListHtml += '</ul>';

            Swal.fire({
                title: 'Konfirmasi Pengambilan',
                html: `Anda akan mengambil <strong>${selectedCourses.length}</strong> mata kuliah berikut:${courseListHtml}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    enrollForm.submit(); // Lanjutkan submit jika dikonfirmasi
                }
            });
        });
    }
});
