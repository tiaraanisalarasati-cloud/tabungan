<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user"></i> Detail Nasabah</h4>
                    <div>
                        <a href="<?php echo base_url('nasabah'); ?>" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="<?php echo base_url('nasabah/edit/' . $nasabah->id_nasabah); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

                <div class="row">
                    <!-- Profile Card -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <?php if ($nasabah->jenis_kelamin == 'L'): ?>
                                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                                    <?php else: ?>
                                        <i class="fas fa-user-circle fa-5x" style="color: #ec4899;"></i>
                                    <?php endif; ?>
                                </div>
                                <h4 class="fw-bold mb-1"><?php echo $nasabah->nama_nasabah; ?></h4>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-<?php echo $nasabah->jenis_kelamin == 'L' ? 'male' : 'female'; ?>"></i>
                                    <?php echo $nasabah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                </p>
                                
                                <div class="mb-3">
                                    <span class="badge bg-primary" style="font-size: 1rem; padding: 10px 20px;">
                                        <?php echo $nasabah->no_rekening; ?>
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <?php if ($nasabah->status == 'aktif'): ?>
                                        <span class="badge bg-success" style="font-size: 0.9rem; padding: 8px 15px;">
                                            <i class="fas fa-check-circle"></i> Status Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger" style="font-size: 0.9rem; padding: 8px 15px;">
                                            <i class="fas fa-times-circle"></i> Status Non-Aktif
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <hr>

                                <div class="text-start">
                                    <h6 class="fw-bold text-primary mb-3">Informasi Kontak</h6>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted"><i class="fas fa-phone"></i> Telepon</small><br>
                                        <strong><?php echo $nasabah->no_telepon; ?></strong>
                                    </div>

                                    <?php if ($nasabah->email): ?>
                                        <div class="mb-2">
                                            <small class="text-muted"><i class="fas fa-envelope"></i> Email</small><br>
                                            <strong><?php echo $nasabah->email; ?></strong>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mb-2">
                                        <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Alamat</small><br>
                                        <strong><?php echo $nasabah->alamat; ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 fw-bold"><i class="fas fa-bolt"></i> Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <a href="<?php echo base_url('transaksi/setoran?id=' . $nasabah->id_nasabah); ?>" 
                                   class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-arrow-down"></i> Setoran
                                </a>
                                <a href="<?php echo base_url('transaksi/penarikan?id=' . $nasabah->id_nasabah); ?>" 
                                   class="btn btn-danger w-100 mb-2">
                                    <i class="fas fa-arrow-up"></i> Penarikan
                                </a>
                                <a href="<?php echo base_url('nasabah/edit/' . $nasabah->id_nasabah); ?>" 
                                   class="btn btn-warning w-100">
                                    <i class="fas fa-edit"></i> Edit Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Detail & Transaction -->
                    <div class="col-lg-8">
                        
                        <!-- Info Cards -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card stat-card success">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-success text-uppercase mb-1">Saldo Saat Ini</h6>
                                                <h3 class="mb-0 fw-bold text-success">
                                                    Rp <?php echo number_format($nasabah->saldo, 0, ',', '.'); ?>
                                                </h3>
                                            </div>
                                            <div>
                                                <i class="fas fa-wallet fa-3x text-success" style="opacity: 0.2;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card stat-card primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-primary text-uppercase mb-1">Total Transaksi</h6>
                                                <h3 class="mb-0 fw-bold text-primary">
                                                    <?php echo count($transaksi); ?>
                                                </h3>
                                            </div>
                                            <div>
                                                <i class="fas fa-exchange-alt fa-3x text-primary" style="opacity: 0.2;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 fw-bold"><i class="fas fa-info-circle"></i> Informasi Personal</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted mb-1">Tanggal Lahir</label>
                                        <p class="fw-bold mb-0">
                                            <?php echo date('d F Y', strtotime($nasabah->tanggal_lahir)); ?>
                                            <small class="text-muted">
                                                (<?php 
                                                    $tgl_lahir = new DateTime($nasabah->tanggal_lahir);
                                                    $today = new DateTime();
                                                    $umur = $today->diff($tgl_lahir)->y;
                                                    echo $umur . ' tahun';
                                                ?>)
                                            </small>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted mb-1">Pekerjaan</label>
                                        <p class="fw-bold mb-0">
                                            <?php echo $nasabah->pekerjaan ? $nasabah->pekerjaan : '-'; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted mb-1">Tanggal Daftar</label>
                                        <p class="fw-bold mb-0">
                                            <?php echo date('d F Y, H:i', strtotime($nasabah->tanggal_daftar)); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted mb-1">ID Nasabah</label>
                                        <p class="fw-bold mb-0">#<?php echo str_pad($nasabah->id_nasabah, 6, '0', STR_PAD_LEFT); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction History -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="m-0 fw-bold"><i class="fas fa-history"></i> Riwayat Transaksi</h6>
                                <a href="<?php echo base_url('transaksi?nasabah=' . $nasabah->id_nasabah); ?>" 
                                   class="btn btn-sm btn-primary">
                                    Lihat Semua
                                </a>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($transaksi)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Jenis</th>
                                                    <th>Jumlah</th>
                                                    <th>Saldo</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($transaksi as $t): ?>
                                                    <tr>
                                                        <td>
                                                            <small><?php echo date('d/m/Y H:i', strtotime($t->tanggal)); ?></small>
                                                        </td>
                                                        <td>
                                                            <?php if ($t->jenis_transaksi == 'setoran'): ?>
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
                                                            Rp <?php echo number_format($t->jumlah, 0, ',', '.'); ?>
                                                        </td>
                                                        <td class="text-success">
                                                            Rp <?php echo number_format($t->saldo_sesudah, 0, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                            <small><?php echo $t->keterangan ? $t->keterangan : '-'; ?></small>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada riwayat transaksi</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>