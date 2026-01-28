<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
                    <div>
                        <span class="text-muted"><i class="far fa-calendar"></i> <?php echo date('d F Y'); ?></span>
                        <span class="ms-3"><i class="far fa-clock"></i> <span id="jam"></span></span>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Statistics Cards -->
                <div class="row">
                    <!-- Total Nasabah -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card primary">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-primary fw-bold text-xxs mb-1" style="font-size: 0.7rem;">
                                            Total Nasabah
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800" style="font-size: 1.1rem;">
                                            <?php echo number_format($total_nasabah); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users stat-icon text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Saldo -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card success">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-success fw-bold text-xxs mb-1" style="font-size: 0.7rem;">
                                            Total Saldo
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800" style="font-size: 1rem;">
                                            Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-wallet stat-icon text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Hari Ini -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card info">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-info fw-bold text-xxs mb-1" style="font-size: 0.7rem;">
                                            Transaksi Hari Ini
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800" style="font-size: 1.1rem;">
                                            <?php echo number_format($transaksi_hari_ini); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-exchange-alt stat-icon text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card warning">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-warning fw-bold text-xxs mb-1" style="font-size: 0.7rem;">
                                            Total Transaksi
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800" style="font-size: 1.1rem;">
                                            <?php echo number_format($total_transaksi); ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line stat-icon text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Transaksi Terbaru -->
                    <div class="col-12 mb-4">
                        <div class="card h-100">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 fw-bold"><i class="fas fa-list"></i> Transaksi Terbaru</h6>
                                <a href="<?php echo base_url('transaksi'); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-external-link-alt me-1"></i> Lihat Semua
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>No. Rekening</th>
                                                <th>Nama Nasabah</th>
                                                <th>Jenis</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($transaksi_terbaru)): ?>
                                                <?php foreach ($transaksi_terbaru as $transaksi): ?>
                                                    <tr>
                                                        <td><?php echo date('d/m/Y H:i', strtotime($transaksi->tanggal)); ?></td>
                                                        <td><?php echo $transaksi->no_rekening; ?></td>
                                                        <td><?php echo $transaksi->nama_nasabah; ?></td>
                                                        <td>
                                                            <?php if ($transaksi->jenis_transaksi == 'setoran'): ?>
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-arrow-down"></i> Setoran
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">
                                                                    <i class="fas fa-arrow-up"></i> Penarikan
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="fw-bold">
                                                            Rp <?php echo number_format($transaksi->jumlah, 0, ',', '.'); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">
                                                        Belum ada transaksi
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 fw-bold"><i class="fas fa-bolt"></i> Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 text-center">
                                    <div class="col-xl-3 col-md-6">
                                        <a href="<?php echo base_url('nasabah/tambah'); ?>" class="btn btn-primary btn-lg w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                                            <span>Tambah Nasabah</span>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <a href="<?php echo base_url('index.php/transaksi/setoran'); ?>" class="btn btn-success btn-lg w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-arrow-down fa-2x mb-2"></i>
                                            <span>Setoran</span>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <a href="<?php echo base_url('index.php/transaksi/penarikan'); ?>" class="btn btn-danger btn-lg w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-arrow-up fa-2x mb-2"></i>
                                            <span>Penarikan</span>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <a href="<?php echo base_url('laporan'); ?>" class="btn btn-info btn-lg w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-file-pdf fa-2x mb-2"></i>
                                            <span>Cetak Laporan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>