<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-users"></i> Laporan Saldo Per Nasabah</h4>
                    <div>
                        <a href="<?php echo base_url('laporan'); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card primary">
                            <div class="card-body">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                    Total Nasabah
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    <?php echo number_format($total_nasabah); ?> Orang
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card success">
                            <div class="card-body">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                    Total Saldo
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card warning">
                            <div class="card-body">
                                <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                    Rata-rata Saldo
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($rata_rata_saldo, 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card info">
                            <div class="card-body">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                    Saldo Tertinggi
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($saldo_tertinggi, 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Tabel -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold"><i class="fas fa-filter"></i> Filter & Daftar Saldo Nasabah</h6>
                        <div>
                            <button class="btn btn-success btn-sm" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <a href="<?php echo base_url('laporan/export_saldo_excel'); ?>" 
                               class="btn btn-info btn-sm">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Filter Form -->
                        <form action="<?php echo base_url('laporan/saldo_nasabah'); ?>" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Status Nasabah</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="aktif" <?php echo ($this->input->get('status') == 'aktif') ? 'selected' : ''; ?>>
                                            Aktif
                                        </option>
                                        <option value="nonaktif" <?php echo ($this->input->get('status') == 'nonaktif') ? 'selected' : ''; ?>>
                                            Non-Aktif
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Urutan</label>
                                    <select name="urutan" class="form-select">
                                        <option value="saldo_desc" <?php echo ($this->input->get('urutan') == 'saldo_desc') ? 'selected' : ''; ?>>
                                            Saldo Tertinggi
                                        </option>
                                        <option value="saldo_asc" <?php echo ($this->input->get('urutan') == 'saldo_asc') ? 'selected' : ''; ?>>
                                            Saldo Terendah
                                        </option>
                                        <option value="nama_asc" <?php echo ($this->input->get('urutan') == 'nama_asc') ? 'selected' : ''; ?>>
                                            Nama A-Z
                                        </option>
                                        <option value="nama_desc" <?php echo ($this->input->get('urutan') == 'nama_desc') ? 'selected' : ''; ?>>
                                            Nama Z-A
                                        </option>
                                        <option value="terbaru" <?php echo ($this->input->get('urutan') == 'terbaru') ? 'selected' : ''; ?>>
                                            Terbaru Daftar
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="<?php echo base_url('laporan/saldo_nasabah'); ?>" 
                                           class="btn btn-secondary">
                                            <i class="fas fa-sync"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="12%">No. Rekening</th>
                                        <th width="20%">Nama Nasabah</th>
                                        <th width="25%">Alamat</th>
                                        <th width="13%">No. Telepon</th>
                                        <th width="15%">Saldo</th>
                                        <th width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($nasabah)): ?>
                                        <?php $no = 1; foreach ($nasabah as $n): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?php echo $n->no_rekening; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url('nasabah/detail/' . $n->id_nasabah); ?>">
                                                        <strong><?php echo $n->nama_nasabah; ?></strong>
                                                    </a>
                                                </td>
                                                <td>
                                                    <small><?php echo substr($n->alamat, 0, 40); ?><?php echo strlen($n->alamat) > 40 ? '...' : ''; ?></small>
                                                </td>
                                                <td><?php echo $n->no_telepon; ?></td>
                                                <td>
                                                    <strong class="text-success">
                                                        Rp <?php echo number_format($n->saldo, 0, ',', '.'); ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <?php if ($n->status == 'aktif'): ?>
                                                        <span class="badge bg-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Non-Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Tidak ada data</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info fw-bold">
                                        <td colspan="5" class="text-end">TOTAL:</td>
                                        <td>Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?></td>
                                        <td><?php echo number_format($total_nasabah); ?> Nasabah</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- Info Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-chart-line"></i> Analisis Saldo
                                </h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Saldo Tertinggi</td>
                                        <td>:</td>
                                        <td class="text-end fw-bold text-success">
                                            Rp <?php echo number_format($saldo_tertinggi, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Saldo Terendah</td>
                                        <td>:</td>
                                        <td class="text-end fw-bold text-danger">
                                            Rp <?php echo number_format($saldo_terendah, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rata-rata Saldo</td>
                                        <td>:</td>
                                        <td class="text-end fw-bold text-primary">
                                            Rp <?php echo number_format($rata_rata_saldo, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Saldo</td>
                                        <td>:</td>
                                        <td class="text-end fw-bold text-info">
                                            Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-info mb-3">
                                    <i class="fas fa-info-circle"></i> Informasi
                                </h6>
                                <ul class="mb-0">
                                    <li>Laporan menampilkan saldo semua nasabah saat ini</li>
                                    <li>Gunakan filter untuk menyaring berdasarkan status</li>
                                    <li>Klik Print untuk mencetak laporan</li>
                                    <li>Export Excel untuk mendapatkan file Excel</li>
                                    <li>Data diurutkan sesuai pilihan filter urutan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>