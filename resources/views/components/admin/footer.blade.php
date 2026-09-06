@if (session('login_success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            background: 'linear-gradient(85deg, #392c70, #6a005b)',
            color: '#fff',

            iconColor: '#fff',
        });

        Toast.fire({
            icon: 'success',
            title: "{{ session('login_success') }}"
        });

        @php session()->forget('login_success'); @endphp
    </script>
@endif
</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer -->
<footer class="footer">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
        <span class="text-center text-md-left mb-2 mb-md-0">
            © {{ date('Y') }} <strong>CrediFlow</strong>. All rights reserved.
        </span>

        <span class="text-center text-md-right">
            Secure Credit & Lending Management System
        </span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="/vendors/js/vendor.bundle.base.js"></script>
<script src="/vendors/js/vendor.bundle.addons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/js/off-canvas.js"></script>
<script src="/js/hoverable-collapse.js"></script>
<script src="/js/misc.js"></script>
<script src="/js/settings.js"></script>
<script src="/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/js/dashboard.js"></script>
<!-- End custom js for this page-->
</body>


</html>
