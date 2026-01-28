</div> <!-- End Wrapper -->

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Menampilkan jam realtime dengan format Indonesia
        function updateClock() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            
            var clockElement = document.getElementById('jam');
            if (clockElement) {
                clockElement.innerHTML = hours + ':' + minutes + ':' + seconds;
            }
        }
        
        // Update jam setiap detik
        setInterval(updateClock, 1000);
        updateClock();

        // Set active menu berdasarkan URL
        $(document).ready(function() {
            var url = window.location.href;
            
            $('#sidebar ul li a').each(function() {
                // Hapus class active dari semua menu
                $(this).removeClass('active');
                
                // Tambahkan class active ke menu yang sesuai dengan URL
                if (this.href === url) {
                    $(this).addClass('active');
                }
            });
            
            // Jika tidak ada yang cocok, set dashboard sebagai active
            if ($('#sidebar ul li a.active').length === 0) {
                $('#sidebar ul li a[href*="dashboard"]').addClass('active');
            }
        });

        // Animasi smooth scroll
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if(target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });

        // Tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Format angka dengan pemisah ribuan
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            if(ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }

        // Sweet Alert untuk konfirmasi
        function confirmDelete(url, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus data ' + nama + '?')) {
                window.location.href = url;
            }
        }

        // Loading overlay
        function showLoading() {
            $('body').append('<div class="loading-overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(14,165,233,0.1);z-index:9999;display:flex;align-items:center;justify-content:center;"><div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        }

        function hideLoading() {
            $('.loading-overlay').remove();
        }

        // Print function
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }

        // Auto hide alert after 5 seconds
        setTimeout(function() {
            $('.alert:not(.alert-permanent)').fadeOut('slow');
        }, 5000);

        // Number only input
        $('.number-only').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Rupiah format on input
        $('.rupiah-format').on('keyup', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(formatRupiah(value));
        });
    </script>
    
    <!-- Additional page-specific scripts can be added here -->
    <?php if(isset($additional_js)): ?>
        <?php echo $additional_js; ?>
    <?php endif; ?>
</body>
</html>