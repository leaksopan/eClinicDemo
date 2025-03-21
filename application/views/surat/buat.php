<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Surat Baru</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('surat') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?= form_open('surat/buat', ['id' => 'form-surat']); ?>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Template Surat</label>
                        <div class="col-sm-10">
                            <select name="template_id" class="form-control" id="template_id" required>
                                <option value="">-- Pilih Template Surat --</option>
                                <?php foreach ($templates as $t) : ?>
                                <option value="<?= $t->id ?>"><?= $t->nama_template ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Surat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nomor_surat" placeholder="Masukkan nomor surat" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tujuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tujuan" placeholder="Masukkan tujuan surat" required>
                        </div>
                    </div>

                    <div id="dynamic-fields">
                        <!-- Field dinamis akan ditambahkan di sini berdasarkan template yang dipilih -->
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#template_id').change(function() {
        var templateId = $(this).val();
        if (templateId !== '') {
            $.ajax({
                url: '<?= base_url('surat/get_template_fields/') ?>' + templateId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var fields = '';
                    $.each(response, function(index, field) {
                        fields += '<div class="form-group row">';
                        fields += '<label class="col-sm-2 col-form-label">' + field.label + '</label>';
                        fields += '<div class="col-sm-10">';
                        
                        if (field.type === 'text') {
                            fields += '<input type="text" class="form-control" name="field[' + field.name + ']" placeholder="' + field.placeholder + '" required>';
                        } else if (field.type === 'textarea') {
                            fields += '<textarea class="form-control" name="field[' + field.name + ']" rows="3" placeholder="' + field.placeholder + '" required></textarea>';
                        } else if (field.type === 'date') {
                            fields += '<input type="date" class="form-control" name="field[' + field.name + ']" required>';
                        } else if (field.type === 'select') {
                            fields += '<select class="form-control" name="field[' + field.name + ']" required>';
                            fields += '<option value="">-- Pilih ' + field.label + ' --</option>';
                            $.each(field.options, function(i, option) {
                                fields += '<option value="' + option.value + '">' + option.label + '</option>';
                            });
                            fields += '</select>';
                        }
                        
                        fields += '</div></div>';
                    });
                    $('#dynamic-fields').html(fields);
                }
            });
        } else {
            $('#dynamic-fields').html('');
        }
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 