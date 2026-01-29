<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Tambah Nasabah</h4>
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
                                <h6 class="m-0 fw-bold"><i class="fas fa-edit"></i> Form Tambah Nasabah Baru</h6>
                            </div>
                            <div class="card-body">
                                <?php echo form_open('nasabah/tambah_aksi', ['id' => 'formTambah']); ?>
                                    
                                    <div class="row">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            
                                            <!-- No. Rekening -->
                                            <div class="mb-3">
                                                <label for="no_rekening" class="form-label">
                                                    No. Rekening <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="no_rekening" 
                                                           name="no_rekening" required readonly
                                                           value="<?php echo set_value('no_rekening'); ?>">
                                                    <button class="btn btn-primary" type="button" id="btnGenerate">
                                                        <i class="fas fa-sync"></i> Generate
                                                    </button>
                                                </div>
                                                <small class="text-muted">Klik Generate untuk membuat nomor rekening otomatis</small>
                                                <?php echo form_error('no_rekening', '<div class="text-danger">', '</div>'); ?>
                                            </div>

                                            <!-- Nama Nasabah -->
                                            <div class="mb-3">
                                                <label for="nama_nasabah" class="form-label">
                                                    Nama Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nama_nasabah" 
                                                       name="nama_nasabah" required
                                                       placeholder="Masukkan nama lengkap"
                                                       value="<?php echo set_value('nama_nasabah'); ?>">
                                                <?php echo form_error('nama_nasabah', '<div class="text-danger">', '</div>'); ?>
                                            </div>

                                            <!-- Jenis Kelamin -->
                                            <div class="mb-3">
                                                <label for="jenis_kelamin" class="form-label">
                                                    Jenis Kelamin <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="L" <?php echo set_select('jenis_kelamin', 'L'); ?>>Laki-laki</option>
                                                    <option value="P" <?php echo set_select('jenis_kelamin', 'P'); ?>>Perempuan</option>
                                                </select>
                                                <?php echo form_error('jenis_kelamin', '<div class="text-danger">', '</div>'); ?>
                                            </div>

                                            <!-- Tanggal Lahir -->
                                            <div class="mb-3">
                                                <label for="tanggal_lahir" class="form-label">
                                                    Tanggal Lahir <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" class="form-control" id="tanggal_lahir" 
                                                       name="tanggal_lahir" required
                                                       value="<?php echo set_value('tanggal_lahir'); ?>">
                                                <?php echo form_error('tanggal_lahir', '<div class="text-danger">', '</div>'); ?>
                                            </div>

                                            <!-- Pekerjaan -->
                                            <div class="mb-3">
                                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                                <input type="text" class="form-control" id="pekerjaan" 
                                                       name="pekerjaan" 
                                                       placeholder="Masukkan pekerjaan"
                                                       value="<?php echo set_value('pekerjaan'); ?>">
                                            </div>

                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            
                                            <!-- Alamat -->
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">
                                                    Alamat <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2" 
                                                          required><?php echo set_value('alamat'); ?></textarea>
                                                <?php echo form_error('alamat', '<div class="text-danger">', '</div>'); ?>
                                            </div>

                                            <!-- No. Telepon -->
                                            <div class="mb-3">
                                                <label for="no_telepon" class="form-label">
                                                    No. Telepon <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="no_telepon" 
                                                       name="no_telepon" required
                                                       placeholder="Contoh: 081234567890"
                                                       value="<?php echo set_value('no_telepon'); ?>">
                                                <?php echo form_error('no_telepon', '<div class="text-danger">', '</div>'); ?>
                                            </div>

                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" 
                                                       name="email" 
                                                       placeholder="contoh@email.com"
                                                       value="<?php echo set_value('email'); ?>">
                                            </div>

                                            <!-- Saldo Awal -->
                                            <div class="mb-3">
                                                <label for="saldo" class="form-label">
                                                    Saldo Awal <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control" id="saldo" 
                                                           name="saldo" required min="0" step="1000"
                                                           value="<?php echo set_value('saldo', '0'); ?>">
                                                </div>
                                                <?php echo form_error('saldo', '<div class="text-danger">', '</div>'); ?>
                                                <small class="text-muted">Minimal Rp 0 (dapat diisi 0 jika belum ada setoran)</small>
                                            </div>

                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo base_url('index.php/nasabah'); ?>" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Data
                                        </button>
                                    </div>

                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-info-circle"></i> Informasi Penting
                                </h6>
                                <ul class="mb-0">
                                    <li>Field yang bertanda <span class="text-danger">*</span> wajib diisi</li>
                                    <li>Nomor rekening akan di-generate otomatis dengan format TAB + Tanggal + Counter</li>
                                    <li>Pastikan data yang diinput sudah benar sebelum menyimpan</li>
                                    <li>Saldo awal dapat diisi 0 jika nasabah belum melakukan setoran</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Generate nomor rekening saat halaman dimuat
                if (document.getElementById('no_rekening').value === '') {
                    generateNoRekening();
                }
                
                // Event listener untuk tombol generate
                document.getElementById('btnGenerate').addEventListener('click', function(e) {
                    e.preventDefault();
                    generateNoRekening();
                });
                
                // Fungsi untuk generate nomor rekening
                function generateNoRekening() {
                    // Format: TAHUNBULANTANGGAL + 4 digit random
                    const now = new Date();
                    const year = now.getFullYear().toString().substr(-2);
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const random = Math.floor(1000 + Math.random() * 9000);
                    
                    const noRekening = 'TAB' + year + month + day + random;
                    document.getElementById('no_rekening').value = noRekening;
                }

                // Validasi form sebelum submit
                document.getElementById('formTambah').addEventListener('submit', function(e) {
                    const noRek = document.getElementById('no_rekening').value;
                    const saldo = document.getElementById('saldo').value;
                    
                    if (noRek === '') {
                        e.preventDefault();
                        alert('Silakan generate nomor rekening terlebih dahulu!');
                        return false;
                    }
                    
                    if (parseFloat(saldo) < 0) {
                        e.preventDefault();
                        alert('Saldo tidak boleh kurang dari 0');
                        return false;
                    }
                    
                    // Tampilkan loading
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                });
            });
        </script>