<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-chart"></i> Laporan Transaksi Per Nasabah</h4>
                    <div>
                        <a href="<?php echo base_url('laporan'); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

                <!-- Pilih Nasabah -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 fw-bold"><i class="fas fa-user"></i> Pilih Nasabah</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('laporan/transaksi_nasabah'); ?>" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Nasabah <span class="text-danger">*</span></label>
                                    <select name="id_nasabah" class="form-select" required onchange="this.form.submit()">
                                        <option value="">-- Pilih Nasabah --</option>
                                        <?php foreach ($nasabah_list as $n): ?>
                                            <option value="<?php echo $n->id_nasabah; ?>"
                                                    <?php echo ($nasabah && $nasabah->id_nasabah == $n->id_nasabah) ? 'selected' : ''; ?>>
                                                <?php echo $n->no_rekening . ' - ' . $n->nama_nasabah; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if ($nasabah): ?>

                <!-- Info Nasabah -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 fw-bold"><i class="fas fa-user-circle"></i> Informasi Nasabah</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>No. Rekening:</strong><br>
                                <span class="badge bg-info" style="font-size: 1rem;">
                                    <?php echo $nasabah->no_rekening; ?>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <strong>Nama Nasabah:</strong><br>
                                <?php echo $nasabah->nama_nasabah; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Saldo Saat Ini:</strong><br>
                                <span class="text-success fw-bold">
                                    Rp <?php echo number_format($nasabah->saldo, 0, ',', '.'); ?>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong><br>
                                <?php if ($nasabah->status == 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Non-Aktif</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tanggal -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 fw-bold"><i class="fas fa-filter"></i> Filter Periode</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('laporan/transaksi_nasabah/' . $nasabah->id_nasabah); ?>" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Dari</label>
                                    <input type="date" name="tgl_dari" class="form-control" 
                                           value="<?php echo $tgl_dari; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Sampai</label>
                                    <input type="date" name="tgl_sampai" class="form-control" 
                                           value="<?php echo $tgl_sampai; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="<?php echo base_url('laporan/transaksi_nasabah/' . $nasabah->id_nasabah); ?>" 
                                           class="btn btn-secondary">
                                            <i class="fas fa-sync"></i> Reset
                                        </a>
                                        <button type="button" class="btn btn-success" onclick="window.print()">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card primary">
                            <div class="card-body">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                    Total Transaksi
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    <?php echo count($transaksi); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-card success">
                            <div class="card-body">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                    Total Setoran
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($total_setoran, 0, ',', '.'); ?>
                                </div>
                                <small class="text-muted"><?php echo $jumlah_setoran; ?> transaksi</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-card danger" style="border-left-color: #ef4444;">
                            <div class="card-body">
                                <div class="text-uppercase fw-bold text-xs mb-1" style="color: #ef4444;">
                                    Total Penarikan
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($total_penarikan, 0, ',', '.'); ?>
                                </div>
                                <small class="text-muted"><?php echo $jumlah_penarikan; ?> transaksi</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-card info">
                            <div class="card-body">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                    Selisih
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($total_setoran - $total_penarikan, 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Transaksi -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 fw-bold"><i class="fas fa-list"></i> Riwayat Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Tanggal & Waktu</th>
                                        <th width="12%">Jenis Transaksi</th>
                                        <th width="15%">Jumlah</th>
                                        <th width="15%">Saldo Sebelum</th>
                                        <th width="15%">Saldo Sesudah</th>
                                        <th width="23%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transaksi)): ?>
                                        <?php $no = 1; foreach ($transaksi as $t): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <strong><?php echo date('d/m/Y', strtotime($t->tanggal)); ?></strong><br>
                                                    <small class="text-muted"><?php echo date('H:i:s', strtotime($t->tanggal)); ?></small>
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
                                                <td>
                                                    <strong class="<?php echo $t->jenis_transaksi == 'setoran' ? 'text-success' : 'text-danger'; ?>">
                                                        <?php echo $t->jenis_transaksi == 'setoran' ? '+' : '-'; ?>
                                                        Rp <?php echo number_format($t->jumlah, 0, ',', '.'); ?>
                                                    </strong>
                                                </td>
                                                <td>Rp <?php echo number_format($t->saldo_sebelum, 0, ',', '.'); ?></td>
                                                <td>
                                                    <strong class="text-primary">
                                                        Rp <?php echo number_format($t->saldo_sesudah, 0, ',', '.'); ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <small><?php echo $t->keterangan ? $t->keterangan : '-'; ?></small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">
                                                        <?php if ($tgl_dari || $tgl_sampai): ?>
                                                            Tidak ada transaksi pada periode yang dipilih
                                                        <?php else: ?>
                                                            Belum ada transaksi untuk nasabah ini
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <?php if (!empty($transaksi)): ?>
                                <tfoot>
                                    <tr class="table-info fw-bold">
                                        <td colspan="3" class="text-end">TOTAL:</td>
                                        <td>
                                            <div class="text-success">+ Rp <?php echo number_format($total_setoran, 0, ',', '.'); ?></div>
                                            <div class="text-danger">- Rp <?php echo number_format($total_penarikan, 0, ',', '.'); ?></div>
                                        </td>
                                        <td colspan="3">
                                            <div class="text-info">Selisih: Rp <?php echo number_format($total_setoran - $total_penarikan, 0, ',', '.'); ?></div>
                                        </td>
                                    </tr>
                                </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <?php else: ?>

                <!-- No Nasabah Selected -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-user-circle fa-5x text-muted mb-3"></i>
                        <h5 class="text-muted">Silakan pilih nasabah terlebih dahulu</h5>
                        <p class="text-muted">Pilih nasabah dari dropdown di atas untuk melihat laporan transaksi</p>
                    </div>
                </div>

                <?php endif; ?>

            </div>
        </div>