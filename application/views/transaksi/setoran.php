<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-arrow-down"></i> Transaksi Setoran</h4>
                    <div>
                        <a href="<?php echo base_url('transaksi'); ?>" class="btn btn-secondary btn-sm">
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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="m-0 fw-bold">
                                    <i class="fas fa-money-bill-wave"></i> Form Setoran Tabungan
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo base_url('transaksi/setoran_aksi'); ?>" method="POST" id="formSetoran">
                                    
                                    <!-- Pilih Nasabah -->
                                    <div class="mb-3">
                                        <label for="id_nasabah" class="form-label">
                                            Pilih Nasabah <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="id_nasabah" name="id_nasabah" required>
                                            <option value="">-- Pilih Nasabah --</option>
                                            <?php foreach ($nasabah_list as $n): ?>
                                                <option value="<?php echo $n->id_nasabah; ?>"
                                                        data-saldo="<?php echo $n->saldo; ?>"
                                                        data-nama="<?php echo $n->nama_nasabah; ?>"
                                                        data-norek="<?php echo $n->no_rekening; ?>"
                                                        <?php echo ($nasabah_selected && $nasabah_selected->id_nasabah == $n->id_nasabah) ? 'selected' : ''; ?>>
                                                    <?php echo $n->no_rekening . ' - ' . $n->nama_nasabah; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Info Nasabah -->
                                    <div id="infoNasabah" class="mb-3" style="display: none;">
                                        <div class="alert alert-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Nama:</strong> <span id="displayNama">-</span><br>
                                                    <strong>No. Rekening:</strong> <span id="displayNorek">-</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Saldo Saat Ini:</strong><br>
                                                    <h4 class="text-success mb-0">
                                                        Rp <span id="displaySaldo">0</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jumlah Setoran -->
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">
                                            Jumlah Setoran <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" id="jumlah" 
                                                   name="jumlah" required min="1000" step="1000"
                                                   placeholder="0">
                                        </div>
                                        <small class="text-muted">Minimal setoran Rp 1.000</small>
                                    </div>

                                    <!-- Preview Saldo Baru -->
                                    <div id="previewSaldo" class="mb-3" style="display: none;">
                                        <div class="alert alert-success">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Saldo Saat Ini:</strong><br>
                                                    <span class="h5">Rp <span id="saldoSekarang">0</span></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Saldo Setelah Setoran:</strong><br>
                                                    <span class="h5 text-success">
                                                        Rp <span id="saldoBaru">0</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" 
                                                  rows="3" placeholder="Keterangan transaksi (opsional)"></textarea>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo base_url('transaksi'); ?>" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check"></i> Proses Setoran
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="card">
                            <div class="card-body">
                                <h6 class="fw-bold text-success mb-3">
                                    <i class="fas fa-info-circle"></i> Informasi Setoran
                                </h6>
                                <ul class="mb-0">
                                    <li>Pilih nasabah terlebih dahulu untuk melihat saldo</li>
                                    <li>Minimal setoran adalah Rp 1.000</li>
                                    <li>Pastikan jumlah setoran sudah benar sebelum diproses</li>
                                    <li>Saldo akan otomatis bertambah setelah transaksi berhasil</li>
                                    <li>Transaksi akan tercatat dalam riwayat nasabah</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional JavaScript -->
        <script>
            // Variable untuk menyimpan saldo
            let saldoSekarang = 0;

            // Event saat nasabah dipilih
            document.getElementById('id_nasabah').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (this.value) {
                    const nama = selectedOption.dataset.nama;
                    const norek = selectedOption.dataset.norek;
                    saldoSekarang = parseFloat(selectedOption.dataset.saldo);
                    
                    // Tampilkan info nasabah
                    document.getElementById('displayNama').textContent = nama;
                    document.getElementById('displayNorek').textContent = norek;
                    document.getElementById('displaySaldo').textContent = formatRupiah(saldoSekarang);
                    document.getElementById('infoNasabah').style.display = 'block';
                    
                    // Update preview jika ada jumlah
                    updatePreview();
                } else {
                    document.getElementById('infoNasabah').style.display = 'none';
                    document.getElementById('previewSaldo').style.display = 'none';
                }
            });

            // Event saat jumlah diisi
            document.getElementById('jumlah').addEventListener('input', function() {
                updatePreview();
            });

            // Function update preview
            function updatePreview() {
                const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
                
                if (saldoSekarang > 0 && jumlah > 0) {
                    const saldoBaru = saldoSekarang + jumlah;
                    
                    document.getElementById('saldoSekarang').textContent = formatRupiah(saldoSekarang);
                    document.getElementById('saldoBaru').textContent = formatRupiah(saldoBaru);
                    document.getElementById('previewSaldo').style.display = 'block';
                } else {
                    document.getElementById('previewSaldo').style.display = 'none';
                }
            }

            // Function format rupiah
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Trigger change jika nasabah sudah terpilih
            window.addEventListener('load', function() {
                const selectNasabah = document.getElementById('id_nasabah');
                if (selectNasabah.value) {
                    selectNasabah.dispatchEvent(new Event('change'));
                }
            });

            // Validasi sebelum submit
            document.getElementById('formSetoran').addEventListener('submit', function(e) {
                const idNasabah = document.getElementById('id_nasabah').value;
                const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
                
                if (!idNasabah) {
                    e.preventDefault();
                    alert('Silakan pilih nasabah terlebih dahulu!');
                    return false;
                }
                
                if (jumlah < 1000) {
                    e.preventDefault();
                    alert('Jumlah setoran minimal Rp 1.000!');
                    return false;
                }
                
                if (!confirm('Apakah Anda yakin ingin memproses setoran sebesar Rp ' + formatRupiah(jumlah) + '?')) {
                    e.preventDefault();
                    return false;
                }
            });
        </script>