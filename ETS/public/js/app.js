document.addEventListener('DOMContentLoaded', function () {

    // Fungsi untuk menghilangkan alert secara otomatis
    if (typeof jQuery !== 'undefined') {
        window.setTimeout(function () {
            $(".alert-dismissible").fadeTo(1000, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000); // Waktu timeout 3 detik
    }

    // Fungsi untuk menghilangkan alert secara otomatis
    if (typeof jQuery !== 'undefined') {
        window.setTimeout(function () {
            $("#hilang").fadeTo(1000, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000); // Waktu timeout 3 detik
    }

    // Data bahan baku
    const hapusButtons = document.querySelectorAll('.btn-hapus');
    const formHapus = document.getElementById('formHapus');
    const idSpan = document.getElementById('idBahanBaku');
    const namaSpan = document.getElementById('namaBahanBaku');
    const kategoriSpan = document.getElementById('kategoriBahanBaku');
    const jumlahSpan = document.getElementById('jumlahBahanBaku');
    const statusSpan = document.getElementById('statusBahanBaku');

    // Hapus button
    hapusButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const kategori = this.getAttribute('data-kategori');
            const jumlah = this.getAttribute('data-jumlah');
            const status = this.getAttribute('data-status');

            idSpan.textContent = id;
            namaSpan.textContent = nama;
            kategoriSpan.textContent = kategori;
            jumlahSpan.textContent = jumlah;
            statusSpan.textContent = status;
            formHapus.setAttribute('action', `/gudang/bahan_baku/${id}`);
        });
    });

    // Hover navigasi sidebar
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        link.style.color = '#ffffff';
        link.style.fontSize = '1.1rem';
        link.style.padding = '10px 15px';
        link.style.textDecoration = 'none';
        link.style.display = 'block';
        const originalColor = link.style.color;

        // Link active
        if (link.classList.contains('active')) {
            link.style.color = '#ffffff';
            link.style.backgroundColor = '#0070e1';
            link.style.borderRadius = '5px';
        }

        // Hover link non-active
        link.addEventListener('mouseover', function () {
            if (!link.classList.contains('active')) {
                link.style.color = '#000000';
                link.style.backgroundColor = '#FAFAD2';
                link.style.borderRadius = '5px';
            }
        });

        // Lepas hover link non-active
        link.addEventListener('mouseout', function () {
            if (!link.classList.contains('active')) {
                link.style.color = originalColor;
                link.style.backgroundColor = 'transparent';
                link.style.borderRadius = '5';
            }
        });
    })
});
