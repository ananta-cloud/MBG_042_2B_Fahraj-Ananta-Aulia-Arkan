document.addEventListener('DOMContentLoaded', function() {

    // FUNGSI UNTUK MENGHILANGKAN ALERT SECARA OTOMATIS (MEMBUTUHKAN JQUERY)
    if (typeof jQuery !== 'undefined') {
        window.setTimeout(function() {
            // Hanya target alert-dismissible dengan class .auto-dismiss
            $(".alert-dismissible").fadeTo(1000, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000); // Waktu timeout 3 detik
    }

    // FUNGSI UNTUK MENGHILANGKAN ALERT SECARA OTOMATIS (MEMBUTUHKAN JQUERY)
    if (typeof jQuery !== 'undefined') {
        window.setTimeout(function() {
            // Hanya target hilang dengan class .auto-dismiss
            $("#hilang").fadeTo(1000, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000); // Waktu timeout 3 detik
    }

    // FUNGSI UNTUK STYLING SIDEBAR SECARA DINAMIS
    const sidebarHeader = document.querySelector('.sidebar .sidebar-header');
    if (sidebarHeader) {
        sidebarHeader.style.fontSize = '1.5rem';
        sidebarHeader.style.fontWeight = 'bold';
        sidebarHeader.style.textAlign = 'center';
        sidebarHeader.style.marginBottom = '2rem';
    }

    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        link.style.color = '#ffffff';
        link.style.fontSize = '1.1rem';
        link.style.padding = '10px 15px';
        link.style.textDecoration = 'none';
        link.style.display = 'block';
        const originalColor = link.style.color;

        if (link.classList.contains('active')) {
            link.style.color = '#ffffff';
            link.style.backgroundColor = '#0070e1';
            link.style.borderRadius = '5px';
        }

        link.addEventListener('mouseover', function() {
            if (!link.classList.contains('active')) {
                link.style.color = '#000000';
                link.style.backgroundColor = '#FAFAD2';
                link.style.borderRadius = '5px';
            }
        });

        link.addEventListener('mouseout', function() {
            if (!link.classList.contains('active')) {
                link.style.color = originalColor;
                link.style.backgroundColor = 'transparent';
                link.style.borderRadius = '0';
            }
        });
    });

});




