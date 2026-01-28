<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-file-alt"></i> Laporan</h4>
                    <div>
                        <span class="text-muted"><i class="far fa-calendar"></i> <?php echo date('d F Y'); ?></span>
                        <span class="ms-3"><i class="far fa-clock"></i> <span id="jam"></span></span>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

                <!-- Statistics Cards -->
                <div class="row g-3">
                    <!-- Total Nasabah -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm primary">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-primary fw-bold text-xxs mb-1">
                                            Total Nasabah
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            <?php echo number_format($total_nasabah); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users stat-icon-sm text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Saldo -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm success">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-success fw-bold text-xxs mb-1">
                                            Total Saldo
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-wallet stat-icon-sm text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Bulan Ini -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm info">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-info fw-bold text-xxs mb-1">
                                            Transaksi Bulan Ini
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            <?php echo number_format($total_transaksi_bulan_ini); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-exchange-alt stat-icon-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Setoran Bulan Ini -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm warning">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-warning fw-bold text-xxs mb-1">
                                            Setoran Bulan Ini
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            Rp <?php echo number_format($total_setoran_bulan_ini, 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-down stat-icon-sm text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    /* Stat Card Small khusus halaman laporan */
                    .stat-card-sm {
                        height: 100%;
                        border-left: 4px solid;
                        transition: all 0.2s ease;
                        margin-bottom: 0;
                        border-radius: 0.5rem;
                    }

                    .stat-card-sm:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                    }

                    .stat-card-sm.primary {
                        border-left-color: #3B82F6;
                    }

                    .stat-card-sm.success {
                        border-left-color: #10B981;
                    }

                    .stat-card-sm.info {
                        border-left-color: #06B6D4;
                    }

                    .stat-card-sm.warning {
                        border-left-color: #F59E0B;
                    }

                    .stat-icon-sm {
                        font-size: 1.5rem;
                        opacity: 0.8;
                    }

                    .text-xxs {
                        font-size: 0.65rem !important;
                        letter-spacing: 0.5px;
                    }
                </style>

                <!-- Menu Laporan -->
                <div class="row mt-4">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 fw-bold"><i class="fas fa-chart-bar"></i> Menu Laporan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <!-- Laporan Saldo Per Nasabah -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-users fa-4x text-primary"></i>
                                                </div>
                                                <h5 class="card-title">Laporan Saldo Per Nasabah</h5>
                                                <p class="card-text text-muted">
                                                    Lihat daftar saldo semua nasabah dengan berbagai filter dan urutan
                                                </p>
                                                <a href="<?php echo base_url('index.php/laporan/saldo_nasabah'); ?>" 
                                                   class="btn btn-primary">
                                                    <i class="fas fa-eye"></i> Lihat 
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Laporan Transaksi Bulanan -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-success">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-calendar-alt fa-4x text-success"></i>
                                                </div>
                                                <h5 class="card-title">Laporan Transaksi Per Bulan</h5>
                                                <p class="card-text text-muted">
                                                    Lihat semua transaksi dalam bulan tertentu dengan statistik lengkap
                                                </p>
                                                <a href="<?php echo base_url('index.php/laporan/transaksi_bulanan'); ?>" 
                                                   class="btn btn-success">
                                                    <i class="fas fa-eye"></i> Lihat Laporan
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Laporan Transaksi Per Nasabah -->
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-info">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-user-chart fa-4x text-info"></i>
                                                </div>
                                                <h5 class="card-title">Laporan Transaksi Per Nasabah</h5>
                                                <p class="card-text text-muted">
                                                    Lihat riwayat transaksi lengkap dari nasabah tertentu
                                                </p>
                                                <a href="<?php echo base_url('index.php/laporan/transaksi_nasabah'); ?>" 
                                                   class="btn btn-info">
                                                    <i class="fas fa-eye"></i> Lihat Laporan
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>