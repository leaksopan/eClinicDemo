<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Surat</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('surat') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="<?= base_url('surat/cetak/' . $surat->id) ?>" class="btn btn-success btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nomor Surat</th>
                                    <td><?= $surat->nomor_surat ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Surat</th>
                                    <td><?= $surat->jenis_surat ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td><?= date('d F Y', strtotime($surat->tanggal)) ?></td>
                                </tr>
                                <tr>
                                    <th>Tujuan</th>
                                    <td><?= $surat->tujuan ?></td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td><?= date('d F Y H:i', strtotime($surat->created_at)) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Konten Surat</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $konten_data = json_decode($surat->konten_data, true);
                                    if (!empty($konten_data)) {
                                        echo '<table class="table table-striped">';
                                        foreach ($konten_data as $key => $value) {
                                            echo '<tr>';
                                            echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            echo '<td>' . $value . '</td>';
                                            echo '</tr>';
                                        }
                                        echo '</table>';
                                    } else {
                                        echo '<div class="alert alert-info">Tidak ada data konten tersedia</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Preview Surat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="border p-3">
                                        <?= $surat->konten_html ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 