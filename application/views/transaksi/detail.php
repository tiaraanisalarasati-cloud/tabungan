<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-receipt"></i> Detail Transaksi</h4>
                    <div>
                        <a href="<?php echo site_url('transaksi'); ?>" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="<?php echo site_url('transaksi/print_bukti/' . $transaksi->id_transaksi); ?>" 
                           class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Print Bukti
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        
                        <!-- Detail Card -->
                        <div class="card">
                            <div class="card-header <?php echo $transaksi->jenis_transaksi == 'setoran' ? 'bg-success' : 'bg-danger'; ?> text-white">
                                <h5 class="m-0 fw-bold">
                                    <i class="fas fa-<?php echo $transaksi->jenis_transaksi == 'setoran' ? 'arrow-down' : 'arrow-up'; ?>"></i>
                                    Bukti Transaksi <?php echo ucfirst($transaksi->jenis_transaksi); ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                
                                <!-- Info Transaksi -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-info-circle"></i> Informasi Transaksi
                                        </h6>
                                        
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>No. Transaksi</strong></td>
                                                <td>: #<?php echo str_pad($transaksi->id_transaksi, 8, '0', STR_PAD_LEFT); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal</strong></td>
                                                <td>: <?php echo date('d F Y', strtotime($transaksi->tanggal)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Waktu</strong></td>
                                                <td>: <?php echo date('H:i:s', strtotime($transaksi->tanggal)); ?> WIB</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Transaksi</strong></td>
                                                <td>: 
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
                                            </tr>
                                            <tr>
                                                <td><strong>Petugas</strong></td>
                                                <td>: <?php echo $transaksi->petugas; ?></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-user"></i> Informasi Nasabah
                                        </h6>
                                        
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>No. Rekening</strong></td>
                                                <td>: 
                                                    <span class="badge bg-info" style="font-size: 0.9rem;">
                                                        <?php echo $transaksi->no_rekening; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Nasabah</strong></td>
                                                <td>: <?php echo $transaksi->nama_nasabah; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat</strong></td>
                                                <td>: <?php echo $transaksi->alamat; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>No. Telepon</strong></td>
                                                <td>: <?php echo $transaksi->no_telepon; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <hr>

                                <!-- Detail Keuangan -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-calculator"></i> Detail Keuangan
                                        </h6>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <small class="text-muted">Saldo Sebelum</small>
                                                <h4 class="mb-0">
                                                    Rp <?php echo number_format($transaksi->saldo_sebelum, 0, ',', '.'); ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="card <?php echo $transaksi->jenis_transaksi == 'setoran' ? 'bg-success' : 'bg-danger'; ?> text-white">
                                            <div class="card-body text-center">
                                                <small>Jumlah <?php echo ucfirst($transaksi->jenis_transaksi); ?></small>
                                                <h4 class="mb-0 fw-bold">
                                                    <?php echo $transaksi->jenis_transaksi == 'setoran' ? '+' : '-'; ?>
                                                    Rp <?php echo number_format($transaksi->jumlah, 0, ',', '.'); ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <small>Saldo Sesudah</small>
                                                <h4 class="mb-0 fw-bold">
                                                    Rp <?php echo number_format($transaksi->saldo_sesudah, 0, ',', '.'); ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Keterangan -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-2">
                                            <i class="fas fa-file-alt"></i> Keterangan
                                        </h6>
                                        <div class="alert alert-info mb-0">
                                            <?php echo $transaksi->keterangan ? $transaksi->keterangan : 'Tidak ada keterangan'; ?>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Actions -->
                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo site_url('nasabah/detail/' . $transaksi->id_nasabah); ?>" 
                                       class="btn btn-info">
                                        <i class="fas fa-user"></i> Lihat Profil Nasabah
                                    </a>
                                    <a href="<?php echo site_url('transaksi/print_bukti/' . $transaksi->id_transaksi); ?>" 
                                       class="btn btn-primary" target="_blank">
                                        <i class="fas fa-print"></i> Print Bukti
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="card">
                            <div class="card-body">
                                <h6 class="fw-bold text-info mb-3">
                                    <i class="fas fa-lightbulb"></i> Catatan
                                </h6>
                                <p class="mb-0">
                                    Bukti transaksi ini dapat dicetak sebagai arsip atau diberikan kepada nasabah. 
                                    Transaksi yang telah diproses tidak dapat diubah. Pastikan semua informasi sudah benar.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>