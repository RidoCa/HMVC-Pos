 <div class="container my-4">
     <h6 class="page-subtitle">List Inventory
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
                             <h5 class="font-weight-normal mb-1"><?= $row['product_name'] ?></h5>
                             <p class="text-mute small text-secondary mb-2"><?= $row['inventory_stock'] . ' ' . $row['inventory_units'] ?></p>
                         </div>
                         <div class="col-auto align-self-center">
                             <a class="btn btn-35 default-shadow border-0 bg-danger btnDelete" title="delete" data-code="<?= $row['inventory_id'] ?>">
                                 <i class="far fa-trash-alt"></i>
                             </a>
                             <a class="btn btn-35 default-shadow border-0 bg-warning btnEdit" title="edit" data-code="<?= $row['inventory_id'] ?>">
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
                             <label class="text-mute small">Product</label>
                             <input type="hidden" name="id">
                             <select class="form-control rounded-right-custom rounded-left-custom" id="product" name="product">
                                 <option value="">Pilih Satu</option>
                                 <?php foreach ($product as $row) : ?>
                                     <option value="<?= $row['product_id'] ?>"><?= $row['product_name'] ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Stock</label>
                             <input type="number" class="form-control rounded-right-custom rounded-left-custom" id="stock" name="stock">
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Unit</label>
                             <select class="form-control rounded-right-custom rounded-left-custom" id="unit" name="unit">
                                 <option value="">Pilih Satu</option>
                                 <option value="Unit">Unit</option>
                                 <option value="Lembar">Lembar</option>
                                 <option value="Bungkus">Bungkus</option>
                             </select>
                             <span class="help-block small text-danger"></span>
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
                 url: "<?= site_url('inventory/ajax_edit/') ?>" + id,
                 type: "GET",
                 dataType: "JSON",
                 success: function(data) {
                     $('[name="id"]').val(data.inventory_id);
                     $('[name="product"]').val(data.product_id).trigger("change");
                     $('[name="stock"]').val(data.inventory_stock);
                     $('[name="unit"]').val(data.inventory_units);

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
                         url: "<?php echo site_url('inventory/ajax_delete/') ?>" + id,
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
                                 'danger'
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
             url = "<?= site_url('inventory/ajax_add') ?>";
         } else if (save_method == 'delete') {
             url = "<?= site_url('inventory/ajax_delete') ?>";
         } else {
             url = "<?= site_url('inventory/ajax_update') ?>";
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
                     'danger'
                 );
                 $('#btnSave').text('Save');
                 $('#btnSave').attr('disabled', false);

             }
         });
     }
 </script>