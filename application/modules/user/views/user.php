 <div class="container my-4">
     <h6 class="page-subtitle">List User
         <a class="btn btn-35 float-right default-shadow border-0 bg-success" title="add" onclick="add()">
             <i class="fas fa-plus"></i>
         </a>
     </h6>
     <hr>
     <?php
        if (!empty($list)) :
            foreach ($list as $row) :
        ?>
             <div class="card shadow-sm border-0 mb-3">
                 <div class="card-body">
                     <div class="row">
                         <div class="col">
                             <h5 class="font-weight-normal mb-1" style="font-size: 13pt"><?= $row['user_name'] ?></h5>
                             <p class="text-mute small text-primary mb-0"><?= $row['store_name'] ?></p>
                             <p class="text-mute small text-secondary mb-2"><?= $row['role_name'] ?><?= ($row['is_active'] == '1' ?  ' (Active)' : ' (Non Active)'); ?></p>
                         </div>
                         <div class="col-auto align-self-center">
                             <a class="btn btn-35 default-shadow border-0 bg-info btnChange" title="change" data-code="<?= $row['user_id'] ?>">
                                 <i class="fas fa-user-lock"></i>
                             </a>
                             <a class="btn btn-35 default-shadow border-0 bg-danger btnDelete" title="delete" data-code="<?= $row['user_id'] ?>">
                                 <i class="far fa-trash-alt"></i>
                             </a>
                             <a class="btn btn-35 default-shadow border-0 bg-warning btnEdit" title="edit" data-code="<?= $row['user_id'] ?>">
                                 <i class="far fa-edit"></i>
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
         <?php
            endforeach;
        else :
            ?>
         <img class="img-fluid" src="<?= site_url() . 'assets/img/notfound.png' ?>">
     <?php
        endif;
        ?>

     <div class="modal fade" id="modal_form" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                 <form id="form">
                     <div class="modal-header bg-default">
                         <label class="font-weight-bold modal-title" id="modalLabel"> Add
                     </div>
                     <div class="modal-body">
                         <div class="form-group">
                             <label class="text-mute small">Role</label>
                             <input type="hidden" name="id">
                             <select class="form-control rounded-right-custom rounded-left-custom" id="role" name="role">
                                 <option value="">Pilih Satu</option>
                                 <?php foreach ($role as $row) : ?>
                                     <option value="<?= $row['role_id'] ?>"><?= $row['role_name'] ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Store</label>
                             <input type="hidden" name="id">
                             <select class="form-control rounded-right-custom rounded-left-custom" id="store" name="store">
                                 <option value="">Pilih Satu</option>
                                 <?php foreach ($store as $row) : ?>
                                     <option value="<?= $row['store_id'] ?>"><?= $row['store_name'] ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Name</label>
                             <input type="text" class="form-control rounded-right-custom rounded-left-custom" id="name" name="name">
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Email</label>
                             <input type="email" class="form-control rounded-right-custom rounded-left-custom" id="email" name="email">
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <div class="col-sm-offset-3 col-sm-9">
                                 <div class="checkbox">
                                     <label>
                                         <input type="checkbox" id="is_active" name="is_active" value="1"> Active ?
                                     </label>
                                 </div>
                             </div>
                         </div>
                         <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                     </div>
                     <div class="modal-footer justify-content-between">
                         <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                         <button type="button" class="btn btn-default default-shadow" id="btnSave" onclick="save()">Save</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
 <script type="text/javascript">
     var save_method;
     var table;
     var base_url = '<?= base_url(); ?>';

     $(document).ready(function() {
         $('.btnEdit').click(function() {
             save_method = 'update';
             $('#form')[0].reset();
             $('.form-group').removeClass('has-error');
             $('.help-block').empty();
             var id = $(this).data('code');

             $.ajax({
                 url: "<?= site_url('user/ajax_edit/') ?>" + id,
                 type: "GET",
                 dataType: "JSON",
                 success: function(data) {
                     $('[name="id"]').val(data.user_id);
                     $('[name="role"]').val(data.role_id).trigger("change");
                     $('[name="name"]').val(data.user_name);
                     $('[name="email"]').val(data.user_email);

                     if (data.is_active == 1) {
                         $('[name="is_active"]').prop("checked", true);
                     } else {
                         $('[name="is_active"]').prop("checked", false);
                     }

                     $('#modal_form').modal('show');
                     $('.modal-title').text('Edit');
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     Swal.fire(
                         'Gagal',
                         'Gagal mendapatkan data',
                         'danger'
                     );
                 }
             });
         });

         $('.btnDelete').click(function() {
             var id = $(this).data('code');
             Swal.fire({
                 title: 'Anda yakin?',
                 text: "data anda akan hilang",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Ya',
                 cancelButtonText: 'Batal'
             }).then((result) => {
                 if (result.value) {
                     save_method == 'delete'
                     $('#form')[0].reset();
                     $('.form-group').removeClass('has-error');
                     $('.help-block').empty();

                     $.ajax({
                         url: "<?php echo site_url('user/ajax_delete/') ?>" + id,
                         type: "GET",
                         dataType: "JSON",
                         success: function(data) {
                             $('#modal_form').modal('hide');
                             location.reload();
                         },
                         error: function(jqXHR, textStatus, errorThrown) {
                             Swal.fire(
                                 'Gagal',
                                 'Data tidak terhapus',
                                 'error'
                             );
                         }
                     });
                 }
             })
         });

         $('.btnChange').click(function() {
             var id = $(this).data('code');
             Swal.fire({
                 title: 'Anda yakin?',
                 text: "kata sandi ini akan kembali ke pengaturan awal",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Ya',
                 cancelButtonText: 'Batal'
             }).then((result) => {
                 if (result.value) {
                     $('.form-group').removeClass('has-error');
                     $('.help-block').empty();

                     $.ajax({
                         url: "<?php echo site_url('user/ajax_changepass/') ?>" + id,
                         type: "GET",
                         dataType: "JSON",
                         success: function(data) {
                             if (data.status) {
                                 location.reload();
                             }
                         },
                         error: function(jqXHR, textStatus, errorThrown) {
                             Swal.fire(
                                 'Gagal',
                                 'Kata sandi tidak berubah',
                                 'error'
                             );
                         }
                     });
                 }
             })
         });

         $("input").change(function() {
             $(this).parent().parent().removeClass('has-error');
             $(this).next().empty();
         });
         $("textarea").change(function() {
             $(this).parent().parent().removeClass('has-error');
             $(this).next().empty();
         });
         $("number").change(function() {
             $(this).parent().parent().removeClass('has-error');
             $(this).next().empty();
         });
     });

     function add() {
         save_method = 'add';
         $('[name="acronim"]').prop("readonly", false);
         $('#form')[0].reset();
         $('.form-group').removeClass('has-error');
         $('.help-block').empty();

         $('#photo-preview').hide();
         $('#label-photo').text('Unggah Logo');

         $('#modal_form').modal('show');
         $('.modal-title').text('Add');
     }

     function save() {
         $('#btnSave').text('saving...');
         $('#btnSave').attr('disabled', true);
         var url;

         if (save_method == 'add') {
             url = "<?= site_url('user/ajax_add') ?>";
         } else if (save_method == 'delete') {
             url = "<?= site_url('user/ajax_delete') ?>";
         } else {
             url = "<?= site_url('user/ajax_update') ?>";
         }

         var formData = new FormData($('#form')[0]);
         $.ajax({
             url: url,
             type: "POST",
             data: formData,
             contentType: false,
             processData: false,
             dataType: "JSON",
             success: function(data) {

                 if (data.status) {
                     $('#modal_form').modal('hide');
                     location.reload();
                 } else {
                     for (var i = 0; i < data.inputerror.length; i++) {
                         $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                         $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                     }
                 }
                 $('#btnSave').text('Save');
                 $('#btnSave').attr('disabled', false);
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 Swal.fire(
                     'Gagal',
                     'Gagal menambah / merubah data',
                     'error'
                 );
                 $('#btnSave').text('Save');
                 $('#btnSave').attr('disabled', false);

             }
         });
     }
 </script>