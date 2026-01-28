<!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt"></i> Laporan Transaksi Per Bulan</h4>
                    <div>
                        <a href="<?php echo base_url('laporan'); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

                <!-- Filter Bulan & Tahun -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 fw-bold"><i class="fas fa-filter"></i> Filter Periode</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('laporan/transaksi_bulanan'); ?>" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Bulan</label>
                                    <select name="bulan" class="form-select" required>
                                        <?php 
                                        $nama_bulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                                                      'Juli','Agustus','September','Oktober','November','Desember'];
                                        for ($i = 1; $i <= 12; $i++): 
                                        ?>
                                            <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>" 
                                                    <?php echo ($bulan == str_pad($i, 2, '0', STR_PAD_LEFT)) ? 'selected' : ''; ?>>
                                                <?php echo $nama_bulan[$i]; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tahun</label>
                                    <select name="tahun" class="form-select" required>
                                        <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                            <option value="<?php echo $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>>
                                                <?php echo $y; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Tampilkan
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="window.print()">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar"></i> 
                                Periode: <strong><?php 
                                    $nama_bulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                                                  'Juli','Agustus','September','Oktober','November','Desember'];
                                    echo $nama_bulan[intval($bulan)] . ' ' . $tahun; 
                                ?></strong>
                            </h5>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card primary">
                            <div class="card-body">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                    Total Transaksi
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    <?php echo number_format($total_transaksi); ?>
                                </div>
                                <small class="text-muted">
                                    Setoran: <?php echo $jumlah_setoran; ?> | 
                                    Penarikan: <?php echo $jumlah_penarikan; ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
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

                    <div class="col-xl-3 col-md-6 mb-4">
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

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card info">
                            <div class="card-body">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                    Selisih
                                </div>
                                <div class="h4 mb-0 fw-bold">
                                    Rp <?php echo number_format($selisih, 0, ',', '.'); ?>
                                </div>
                                <small class="text-muted">Setoran - Penarikan</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Transaksi Per Hari -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 fw-bold"><i class="fas fa-chart-line"></i> Grafik Transaksi Per Hari</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartTransaksi" height="80"></canvas>
                    </div>
                </div>

                <!-- Tabel Transaksi -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 fw-bold"><i class="fas fa-list"></i> Daftar Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="12%">Tanggal</th>
                                        <th width="13%">No. Rekening</th>
                                        <th width="18%">Nama Nasabah</th>
                                        <th width="10%">Jenis</th>
                                        <th width="15%">Jumlah</th>
                                        <th width="15%">Saldo Akhir</th>
                                        <th width="12%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transaksi)): ?>
                                        <?php $no = 1; foreach ($transaksi as $t): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php echo date('d/m/Y', strtotime($t->tanggal)); ?><br>
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
                                                        <span class="badge bg-success">Setoran</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Penarikan</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong class="<?php echo $t->jenis_transaksi == 'setoran' ? 'text-success' : 'text-danger'; ?>">
                                                        <?php echo $t->jenis_transaksi == 'setoran' ? '+' : '-'; ?>
                                                        Rp <?php echo number_format($t->jumlah, 0, ',', '.'); ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    Rp <?php echo number_format($t->saldo_sesudah, 0, ',', '.'); ?>
                                                </td>
                                                <td>
                                                    <small><?php echo $t->keterangan ? substr($t->keterangan, 0, 20) : '-'; ?></small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Tidak ada transaksi pada periode ini</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <?php if (!empty($transaksi)): ?>
                                <tfoot>
                                    <tr class="table-info fw-bold">
                                        <td colspan="5" class="text-end">TOTAL:</td>
                                        <td>
                                            <div class="text-success">+ Rp <?php echo number_format($total_setoran, 0, ',', '.'); ?></div>
                                            <div class="text-danger">- Rp <?php echo number_format($total_penarikan, 0, ',', '.'); ?></div>
                                        </td>
                                        <td colspan="2">
                                            <div class="text-info">Selisih: Rp <?php echo number_format($selisih, 0, ',', '.'); ?></div>
                                        </td>
                                    </tr>
                                </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data untuk chart
            <?php
            // Siapkan data untuk chart
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $chart_labels = [];
            $chart_setoran = array_fill(0, $days_in_month, 0);
            $chart_penarikan = array_fill(0, $days_in_month, 0);
            
            for ($d = 1; $d <= $days_in_month; $d++) {
                $chart_labels[] = $d;
            }
            
            foreach ($data_per_hari as $data) {
                $day = date('j', strtotime($data->tanggal));
                if ($data->jenis_transaksi == 'setoran') {
                    $chart_setoran[$day - 1] = $data->total;
                } else {
                    $chart_penarikan[$day - 1] = $data->total;
                }
            }
            ?>

            const ctx = document.getElementById('chartTransaksi').getContext('2d');
            const chartTransaksi = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($chart_labels); ?>,
                    datasets: [
                        {
                            label: 'Setoran',
                            data: <?php echo json_encode($chart_setoran); ?>,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Penarikan',
                            data: <?php echo json_encode($chart_penarikan); ?>,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        </script>