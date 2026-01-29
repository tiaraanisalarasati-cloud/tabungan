<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Nasabah</h4>
                    <div>
                        <a href="<?php echo base_url('nasabah'); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                
                <!-- Flash Messages -->
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> 
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Card -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 fw-bold"><i class="fas fa-edit"></i> Form Edit Data Nasabah</h6>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo site_url('nasabah/edit_aksi'); ?>" method="POST" id="formEdit">
                                    
                                    <input type="hidden" name="id_nasabah" value="<?php echo $nasabah->id_nasabah; ?>">
                                    
                                    <div class="row">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            
                                            <!-- No. Rekening (Readonly) -->
                                            <div class="mb-3">
                                                <label for="no_rekening" class="form-label">No. Rekening</label>
                                                <input type="text" class="form-control" id="no_rekening" 
                                                       value="<?php echo $nasabah->no_rekening; ?>" readonly disabled>
                                                <small class="text-muted">Nomor rekening tidak dapat diubah</small>
                                            </div>

                                            <!-- Nama Nasabah -->
                                            <div class="mb-3">
                                                <label for="nama_nasabah" class="form-label">
                                                    Nama Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nama_nasabah" 
                                                       name="nama_nasabah" required
                                                       value="<?php echo set_value('nama_nasabah', $nasabah->nama_nasabah); ?>">
                                            </div>

                                            <!-- Jenis Kelamin -->
                                            <div class="mb-3">
                                                <label for="jenis_kelamin" class="form-label">
                                                    Jenis Kelamin <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="L" <?php echo ($nasabah->jenis_kelamin == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                                    <option value="P" <?php echo ($nasabah->jenis_kelamin == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                                </select>
                                            </div>

                                            <!-- Tanggal Lahir -->
                                            <div class="mb-3">
                                                <label for="tanggal_lahir" class="form-label">
                                                    Tanggal Lahir <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" class="form-control" id="tanggal_lahir" 
                                                       name="tanggal_lahir" required
                                                       value="<?php echo set_value('tanggal_lahir', $nasabah->tanggal_lahir); ?>">
                                            </div>

                                            <!-- Pekerjaan -->
                                            <div class="mb-3">
                                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                                <input type="text" class="form-control" id="pekerjaan" 
                                                       name="pekerjaan" 
                                                       value="<?php echo set_value('pekerjaan', $nasabah->pekerjaan); ?>">
                                            </div>

                                            <!-- Status -->
                                            <div class="mb-3">
                                                <label for="status" class="form-label">
                                                    Status <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="aktif" <?php echo ($nasabah->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                    <option value="nonaktif" <?php echo ($nasabah->status == 'nonaktif') ? 'selected' : ''; ?>>Non-Aktif</option>
                                                </select>
                                            </div>

                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            
                                            <!-- Alamat -->
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">
                                                    Alamat Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="alamat" name="alamat" 
                                                          rows="3" required><?php echo set_value('alamat', $nasabah->alamat); ?></textarea>
                                            </div>

                                            <!-- No. Telepon -->
                                            <div class="mb-3">
                                                <label for="no_telepon" class="form-label">
                                                    No. Telepon <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control number-only" 
                                                       id="no_telepon" name="no_telepon" required
                                                       value="<?php echo set_value('no_telepon', $nasabah->no_telepon); ?>">
                                            </div>

                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" 
                                                       name="email" 
                                                       value="<?php echo set_value('email', $nasabah->email); ?>">
                                            </div>

                                            <!-- Saldo (Readonly) -->
                                            <div class="mb-3">
                                                <label for="saldo" class="form-label">Saldo Saat Ini</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control" 
                                                           value="<?php echo number_format($nasabah->saldo, 0, ',', '.'); ?>" 
                                                           readonly disabled>
                                                </div>
                                                <small class="text-muted">Saldo hanya dapat diubah melalui transaksi</small>
                                            </div>

                                            <!-- Tanggal Daftar (Info) -->
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Daftar</label>
                                                <input type="text" class="form-control" 
                                                       value="<?php echo date('d/m/Y H:i', strtotime($nasabah->tanggal_daftar)); ?>" 
                                                       readonly disabled>
                                            </div>

                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo base_url('nasabah'); ?>" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Data
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h6 class="fw-bold text-warning mb-3">
                                    <i class="fas fa-exclamation-triangle"></i> Perhatian
                                </h6>
                                <ul class="mb-0">
                                    <li>Nomor rekening tidak dapat diubah</li>
                                    <li>Saldo hanya dapat diubah melalui menu Transaksi (Setoran/Penarikan)</li>
                                    <li>Pastikan data yang diubah sudah benar sebelum menyimpan</li>
                                    <li>Status "Non-Aktif" akan membatasi nasabah untuk melakukan transaksi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>