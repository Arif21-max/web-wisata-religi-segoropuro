import Alpine from 'alpinejs';
import '@fortawesome/fontawesome-free/css/all.min.css';

window.Alpine = Alpine;
Alpine.start();

// ============================================================
// Scroll reveal — animasi halus saat elemen masuk layar
// - Hanya aktif bila browser mendukung IntersectionObserver
// - Otomatis nonaktif jika user memilih prefers-reduced-motion
// - Kelas `js` ditambahkan ke <html> agar CSS hanya menyembunyikan
//   elemen saat JS benar-benar berjalan (konten tetap terlihat
//   jika JS gagal dimuat).
// ============================================================
(() => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        return;
    }

    document.documentElement.classList.add('js');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -48px 0px' },
    );

    document.querySelectorAll('[data-reveal]').forEach((el) => observer.observe(el));
})();
