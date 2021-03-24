<div class="container my-4">
    <div class="card  border-0 shadow-sm mb-4 ">
        <div class="card-body position-relative">
            <div class="media">
                <div class="media-body">
                    <h5 class="mb-1"><?= $role['role_name'] ?></h5>
                    <p class="small text-mute">List Access</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <?php foreach ($list as $row) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="access" name="access" <?= check_access($role['role_id'], $row['menu_id']) ?> data-role="<?= $role['role_id'] ?>" data-menu="<?= $row['menu_id'] ?>" onclick="access(this)">
                            <label class="form-check-label" for="defaultCheck1">
                                <?= $row['menu_name'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
<script type="text/javascript">
    var save_method;
    var table;
    var base_url = '<?= base_url(); ?>';

    function access(elem) {
        var menuId = $(elem).data('menu');
        var roleId = $(elem).data('role');

        $.ajax({
            url: "<?= site_url('role/ajax_access') ?>",
            type: "POST",
            data: {
                menuId: menuId,
                roleId: roleId,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    window.location.href = "<?= site_url('role/access/') ?>" + roleId;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire(
                    'Gagal',
                    'Gagal menambah / merubah data',
                    'danger'
                );
            }
        });
    }
</script>