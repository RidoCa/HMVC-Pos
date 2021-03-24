 <div class="container my-4">
     <h6 class="page-subtitle">List Price
         <a class="btn btn-35 float-right default-shadow border-0 bg-success" title="add" onclick="add()">
             <i class="fas fa-plus"></i>
         </a>
     </h6>
     <hr>
     <?php
        if (!empty($list)) :
            $last = array_key_last($listProduct);
            for ($i = 0; $i < (count($listProduct) - 1); $i++) :
        ?>
             <div class="card  border-0 shadow-sm mb-4 ">
                 <div class="card-body position-relative">
                     <div class="media">
                         <figure class="avatar avatar-50 mr-3">
                             <img src="<?= site_url() . 'assets/img/product/' . $listProduct[$i]['product_image'] ?>" alt="Generic placeholder image">
                         </figure>
                         <div class="media-body">
                             <h5 class="mb-1"><?= $listProduct[$i]['product_name'] ?></h5>
                             <?php if ($listProduct[$i]['price_value'] == null) : ?>
                                 <p class="small text-mute m-0 text-danger"><b>Harga belum dimasukkan <?= $last ?></b></p>
                             <?php else : ?>
                                 <p class="small text-mute m-0"><b><?= $listProduct[$i]['price_name'] ?></b></p>
                                 <p class="small text-mute m-0"><?= $listProduct[$i]['date_start'] . ' s.d ' . $listProduct[$i]['date_expired'] ?></p>
                             <?php endif; ?>
                         </div>
                     </div>
                     <hr>
                     <div class="row">
                         <?php if ($listProduct[$i]['price_value'] == null) : ?>
                             <div class="col">
                                 <h6 class="mb-1">Rp. <?= number_format($listProduct[$i]['price_value'], 0, ',', '.'); ?></h6>
                             </div>
                         <?php else : ?>
                             <div class="col">
                                 <h6 class="mb-1">Rp. <?= number_format($listProduct[$i]['price_value'], 0, ',', '.'); ?></h6>
                             </div>
                             <div class="col-auto">
                                 <a class="btn btn-35 default-shadow border-0 bg-danger btnDelete" title="delete" data-code="<?= $listProduct[$i]['price_id'] ?>">
                                     <i class="far fa-trash-alt"></i>
                                 </a>
                                 <a class="btn btn-35 default-shadow border-0 bg-warning btnEdit" title="edit" data-code="<?= $listProduct[$i]['price_id'] ?>">
                                     <i class="far fa-edit"></i>
                                 </a>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
         <?php
            endfor;
            for ($x = 0; $x < count(end($listProduct)); $x++) :
            ?>
             <div class="card  border-0 shadow-sm mb-4 ">
                 <div class="card-body position-relative">
                     <div class="media">
                         <figure class="avatar avatar-50 mr-3">
                             <img src="<?= site_url() . 'assets/img/product/' . $list[$last][$x]['product_image'] ?>" alt="Generic placeholder image">
                         </figure>
                         <div class="media-body">
                             <h5 class="mb-1"><?= $list[$last][$x]['product_name'] ?></h5>
                             <?php if ($list[$last][$x]['price_value'] == null) : ?>
                                 <p class="small text-mute m-0 text-danger"><b>Harga belum dimasukkan</b></p>
                             <?php else : ?>
                                 <p class="small text-mute m-0"><b><?= $list[$last][$x]['price_name'] ?></b></p>
                                 <p class="small text-mute m-0"><?= $list[$last][$x]['date_start'] . ' s.d ' . $list[$last][$x]['date_expired'] ?></p>
                             <?php endif; ?>
                         </div>
                     </div>
                     <hr>
                     <div class="row">
                         <?php if ($list[$last][$x]['price_value'] == null) : ?>
                             <div class="col">
                                 <h6 class="mb-1">Rp. <?= number_format($list[$last][$x]['price_value'], 0, ',', '.'); ?></h6>
                             </div>
                         <?php else : ?>
                             <div class="col">
                                 <h6 class="mb-1">Rp. <?= number_format($list[$last][$x]['price_value'], 0, ',', '.'); ?></h6>
                             </div>
                             <div class="col-auto">
                                 <a class="btn btn-35 default-shadow border-0 bg-danger btnDelete" title="delete" data-code="<?= $list[$last][$x]['price_id'] ?>">
                                     <i class="far fa-trash-alt"></i>
                                 </a>
                                 <a class="btn btn-35 default-shadow border-0 bg-warning btnEdit" title="edit" data-code="<?= $list[$last][$x]['price_id'] ?>">
                                     <i class="far fa-edit"></i>
                                 </a>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
         <?php
            endfor;
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
                                 <?php
                                    $last = array_key_last($arrProduct);
                                    for ($i = 0; $i < (count($arrProduct) - 1); $i++) :
                                    ?>
                                     <option value="<?= $arrProduct[$i]['product_id'] ?>" class="text-danger font-weight-bold"><?= $arrProduct[$i]['product_name'] ?></option>
                                 <?php endfor; ?>
                                 <?php for ($x = 0; $x < count(end($arrProduct)); $x++) : ?>
                                     <option value="<?= $product[$last][$x]['product_id'] ?>" class="text-success font-weight-bold"><?= $product[$i][$x]['product_name'] ?></option>
                                 <?php endfor; ?>
                             </select>
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Division</label>
                             <select class="form-control rounded-right-custom rounded-left-custom" id="division" name="division">
                                 <option value="">Pilih Satu</option>
                                 <?php foreach ($division as $row) : ?>
                                     <option value="<?= $row['division_id'] ?>"><?= $row['division_name'] ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Price Name</label>
                             <input type="text" class="form-control rounded-right-custom rounded-left-custom" id="name" name="name">
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Price</label>
                             <input type="number" class="form-control rounded-right-custom rounded-left-custom" id="price" name="price">
                             <span class="help-block small text-danger"></span>
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Date Start</label>
                             <input type="text" class="form-control datepicker rounded-right-custom rounded-left-custom" id="date1" name="date1" placeholder="Select Date">
                         </div>
                         <div class="form-group">
                             <label class="text-mute small">Date Expired</label>
                             <input type="text" class="form-control datepicker rounded-right-custom rounded-left-custom" id="date2" name="date2" placeholder="Select Date">
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
         /* calander picker */
         var start = moment().subtract(29, 'days');
         var end = moment();

         /* calander single  picker ends */
         $('.datepicker').daterangepicker({
             singleDatePicker: true,
             showDropdowns: true,
             drops: 'up',
             minYear: 1901
         }, function(start, end, label) {});

         $('.btnEdit').click(function() {
             save_method = 'update';
             $('#form')[0].reset();
             $('.form-group').removeClass('has-error');
             $('.help-block').empty();
             var id = $(this).data('code');

             $.ajax({
                 url: "<?= site_url('price/ajax_edit/') ?>" + id,
                 type: "GET",
                 dataType: "JSON",
                 success: function(data) {
                     $('[name="id"]').val(data.price_id);
                     $('[name="product"]').val(data.product_id).trigger("change");
                     $('[name="division"]').val(data.division_id).trigger("change");
                     $('[name="name"]').val(data.price_name);
                     $('[name="price"]').val(data.price_value);
                     $('[name="date1"]').val(data.date_start).trigger("change");
                     $('[name="date2"]').val(data.date_expired).trigger("change");

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
                         url: "<?php echo site_url('price/ajax_delete/') ?>" + id,
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
             url = "<?= site_url('price/ajax_add') ?>";
         } else if (save_method == 'delete') {
             url = "<?= site_url('price/ajax_delete') ?>";
         } else {
             url = "<?= site_url('price/ajax_update') ?>";
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