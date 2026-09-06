<!-- FOOTER -->
<footer class="pt-1">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-1">
        <span style="font-size:9px;color:#93a3b3">© 2026 LMSP · Library Management SaaS Platform</span>
        <span style="font-size:9px;color:#93a3b3">
            <i class="fa-solid fa-shield-halved text-success me-1"></i>
            Secure & Cloud Managed
        </span>
    </div>
</footer>

</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    menuToggle?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.querySelectorAll('.side-link').forEach(link => {
        link.addEventListener('click', () => {
            document.querySelectorAll('.side-link').forEach(item => item.classList.remove('active'));
            link.classList.add('active');

            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });
</script>
</body>

</html>