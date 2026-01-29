<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-exchange-alt"></i> Data Transaksi</h4>
                    <div>
                        <span class="text-muted"><i class="far fa-calendar"></i> <?php echo date('d F Y'); ?></span>
                        <span class="ms-3"><i class="far fa-clock"></i> <span id="jam"></span></span>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                
                <!-- Flash Messages -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Statistics Cards -->
                <div class="row g-3">
                    <!-- Total Setoran -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm success">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-success fw-bold text-xxs mb-1">
                                            Total Setoran
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            Rp <?php echo number_format($total_setoran, 0, ',', '.'); ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem;"><?php echo $jumlah_setoran; ?> transaksi</small>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-down stat-icon-sm text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Penarikan -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm danger">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-danger fw-bold text-xxs mb-1">
                                            Total Penarikan
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            Rp <?php echo number_format($total_penarikan, 0, ',', '.'); ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem;"><?php echo $jumlah_penarikan; ?> transaksi</small>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-up stat-icon-sm text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm primary">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-primary fw-bold text-xxs mb-1">
                                            Total Transaksi
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            <?php echo $total_transaksi; ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem;">semua transaksi</small>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-list stat-icon-sm text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selisih -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card-sm info">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-info fw-bold text-xxs mb-1">
                                            Selisih
                                        </div>
                                        <div class="h6 mb-0 fw-bold text-gray-800">
                                            Rp <?php echo number_format($total_setoran - $total_penarikan, 0, ',', '.'); ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem;">setoran - penarikan</small>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calculator stat-icon-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <style>
                    /* Stat Card Small */
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
                    
                    .stat-card-sm.success {
                        border-left-color: #10B981;
                    }
                    
                    .stat-card-sm.danger {
                        border-left-color: #EF4444;
                    }
                    
                    .stat-card-sm.primary {
                        border-left-color: #3B82F6;
                    }
                    
                    .stat-card-sm.info {
                        border-left-color: #06B6D4;
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

                <!-- Spacer -->
                <div class="mb-4"></div>
                
                <!-- Card Transaksi -->
                <div class="card mt-4 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold"><i class="fas fa-filter"></i> Filter & Daftar Transaksi</h6>
                        <div>
                            <a href="<?php echo site_url('transaksi/setoran'); ?>" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-arrow-down"></i> Setoran
                            </a>
                            <a href="<?php echo site_url('transaksi/penarikan'); ?>" class="btn btn-danger btn-sm">
                                <i class="fas fa-arrow-up"></i> Penarikan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Filter Form -->
                        <form action="<?php echo site_url('transaksi'); ?>" method="GET" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Transaksi</label>
                                    <select name="jenis" class="form-select">
                                        <option value="">Semua Jenis</option>
                                        <option value="setoran" <?php echo ($this->input->get('jenis') == 'setoran') ? 'selected' : ''; ?>>
                                            Setoran
                                        </option>
                                        <option value="penarikan" <?php echo ($this->input->get('jenis') == 'penarikan') ? 'selected' : ''; ?>>
                                            Penarikan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Dari</label>
                                    <input type="date" name="tgl_dari" class="form-control" 
                                           value="<?php echo $this->input->get('tgl_dari'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Sampai</label>
                                    <input type="date" name="tgl_sampai" class="form-control" 
                                           value="<?php echo $this->input->get('tgl_sampai'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Pencarian</label>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Nama/No. Rekening"
                                           value="<?php echo $this->input->get('search'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    <a href="<?php echo site_url('transaksi'); ?>" class="btn btn-secondary">
                                        <i class="fas fa-sync"></i> Reset Filter
                                    </a>
                                    <button type="button" class="btn btn-info" onclick="window.print()">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                        </form>

                        <hr class="my-4">

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tableTransaksi">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="13%">Tanggal & Waktu</th>
                                        <th width="12%">No. Rekening</th>
                                        <th width="15%">Nama Nasabah</th>
                                        <th width="10%">Jenis</th>
                                        <th width="12%">Jumlah</th>
                                        <th width="12%">Saldo Akhir</th>
                                        <th width="13%">Keterangan</th>
                                        <th width="8%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transaksi)): ?>
                                        <?php $no = 1; foreach ($transaksi as $t): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <strong><?php echo date('d/m/Y', strtotime($t->tanggal)); ?></strong><br>
                                                    <small class="text-muted"><?php echo date('H:i', strtotime($t->tanggal)); ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?php echo $t->no_rekening; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $t->nama_nasabah; ?></td>
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
                                                <td>
                                                    <strong class="text-primary">
                                                        Rp <?php echo number_format($t->saldo_sesudah, 0, ',', '.'); ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <small><?php echo $t->keterangan ? substr($t->keterangan, 0, 30) : '-'; ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo site_url('transaksi/detail/' . $t->id_transaksi); ?>" 
                                                           class="btn btn-info btn-sm" 
                                                           data-bs-toggle="tooltip" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo site_url('transaksi/print_bukti/' . $t->id_transaksi); ?>" 
                                                           class="btn btn-primary btn-sm" 
                                                           data-bs-toggle="tooltip" title="Print"
                                                           target="_blank">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="py-5">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada data transaksi</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>