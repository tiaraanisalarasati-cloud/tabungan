<!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>
                    <i class="fas fa-piggy-bank"></i>
                    Tabungan
                </h3>
                <small>Sistem Manajemen Tabungan</small>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="<?php echo site_url('dashboard'); ?>" <?php echo (strpos(current_url(), 'dashboard') !== false) ? 'class="active"' : ''; ?>>
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <?php 
                    $current_uri = $this->uri->segment(1);
                    $is_nasabah_page = ($current_uri == 'nasabah');
                    ?>
                    <a href="<?php echo site_url('nasabah'); ?>" <?php echo $is_nasabah_page ? 'class="active"' : ''; ?>>
                        <i class="fas fa-users"></i>
                        <span>Data Nasabah</span>
                    </a>
                </li>
                <li>
                    <?php 
                    $current_uri = $this->uri->segment(1);
                    $is_transaksi_page = in_array($current_uri, ['transaksi', 'setoran', 'penarikan', 'detail']);
                    ?>
                    <a href="<?php echo site_url('transaksi'); ?>" <?php echo $is_transaksi_page ? 'class="active"' : ''; ?>>
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <?php 
                    $current_uri = $this->uri->segment(1);
                    $is_laporan_page = ($current_uri == 'laporan');
                    ?>
                    <a href="<?php echo site_url('laporan'); ?>" <?php echo $is_laporan_page ? 'class="active"' : ''; ?>>
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('pengaturan'); ?>">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                
                <hr>
                
                <li>
                    <a href="<?php echo base_url('auth/logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            
            <!-- Sidebar Footer Info -->
            <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; text-align: center; padding: 15px; background: rgba(0,0,0,0.2); border-radius: 10px;">
                <small style="color: rgba(255,255,255,0.7); font-size: 0.7rem;">
                    <i class="fas fa-user-circle"></i> Admin User<br>
                    <span style="font-size: 0.65rem;">v1.0.0</span>
                </small>
            </div>
        </nav>