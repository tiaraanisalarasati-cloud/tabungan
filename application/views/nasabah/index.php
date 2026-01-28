<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-users"></i> Data Nasabah</h4>
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

                <!-- Card Data Nasabah -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold"><i class="fas fa-list"></i> Daftar Nasabah</h6>
                        <div>
                            <a href="<?php echo base_url('nasabah/export_excel'); ?>" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                            <a href="<?php echo base_url('nasabah/tambah'); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Nasabah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="<?php echo base_url('nasabah'); ?>" method="GET" class="d-flex">
                                    <input type="text" name="search" class="form-control me-2" 
                                           placeholder="Cari berdasarkan nama, no. rekening, alamat..." 
                                           value="<?php echo $this->input->get('search'); ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="badge bg-primary" style="font-size: 1rem; padding: 10px 15px;">
                                    Total: <?php echo count($nasabah); ?> Nasabah
                                </span>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tableNasabah">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="12%">No. Rekening</th>
                                        <th width="18%">Nama Nasabah</th>
                                        <th width="20%">Alamat</th>
                                        <th width="12%">No. Telepon</th>
                                        <th width="13%">Saldo</th>
                                        <th width="10%">Status</th>
                                        <th width="10%" class="text-center">Aksi</th>
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
                                                    <strong><?php echo $n->nama_nasabah; ?></strong><br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-<?php echo $n->jenis_kelamin == 'L' ? 'male' : 'female'; ?>"></i>
                                                        <?php echo $n->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <small><?php echo substr($n->alamat, 0, 50); ?><?php echo strlen($n->alamat) > 50 ? '...' : ''; ?></small>
                                                </td>
                                                <td>
                                                    <?php echo $n->no_telepon; ?>
                                                </td>
                                                <td>
                                                    <strong class="text-success">
                                                        Rp <?php echo number_format($n->saldo, 0, ',', '.'); ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <?php if ($n->status == 'aktif'): ?>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Aktif
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times"></i> Non-Aktif
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo site_url('nasabah/detail/' . $n->id_nasabah); ?>" 
                                                           class="btn btn-info btn-sm" 
                                                           data-bs-toggle="tooltip" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo site_url('nasabah/edit/' . $n->id_nasabah); ?>" 
                                                           class="btn btn-warning btn-sm" 
                                                           data-bs-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" 
                                                           onclick="confirmDelete('<?php echo site_url('nasabah/hapus/' . $n->id_nasabah); ?>', '<?php echo addslashes($n->nama_nasabah); ?>')"
                                                           class="btn btn-danger btn-sm" 
                                                           data-bs-toggle="tooltip" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="py-5">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada data nasabah</p>
                                                    <a href="<?php echo base_url('nasabah/tambah'); ?>" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Tambah Nasabah Pertama
                                                    </a>
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

        <script>
        function confirmDelete(url, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus nasabah: ' + nama + '?')) {
                window.location.href = url;
            }
        }
        
        // Inisialisasi tooltip
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        </script>