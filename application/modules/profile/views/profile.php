<div class="container my-4">
    <h6 class="page-subtitle">Personal Details</h6>
    <hr>
    <?php foreach($profile as $row) : ?>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="text-mute">Name</label>
                <p><?= $row['user_name'] ?></p>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="text-mute">Email Address</label>
                <p><?= $row['user_email'] ?></p>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="text-mute">Registered</label>
                <p><?= $row['user_regist'] ?></p>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="text-mute">Status</label>
                <p><?= ($row['is_active'] == '1' ?  'Active' : 'Non Active'); ?></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <a href="<?= base_url().'password' ?>" class="btn btn-lg btn-default default-shadow btn-block">Change Password</a>
</div>