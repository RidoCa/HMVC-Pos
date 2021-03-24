 <div class="container my-4">
     <h6 class="page-subtitle">List Transaction Pending</h6>
     <hr>
     <div class="row">
         <div class="d-flex align-items-stretch flex-wrap w-100">
             <?php
                if (!empty($list)) :
                    foreach ($list as $row) :
                ?>
                     <div class="card shadow-sm border-0 mb-3 col-sm-12">
                         <div class="card-body">
                             <div class="media">
                                 <div class="col">
                                     <h5 class="font-weight-normal mb-1" style="font-size: 13pt"><?= $row['transaction_id'] ?></h5>
                                     <p class="text-mute font-weight-bold small mb-0"><?= $row['customer_name'] ?></p>
                                     <p class="text-mute font-weight-bold small text-success mb-0">Total : Rp. <?= number_format($row['transaction_value'], 0, ',', '.')  ?></p>
                                 </div>
                                 <div class="col-auto align-self-center">
                                     <a class="btn btn-35 default-shadow border-0 bg-warning btnAdd" title="Add Request" data-code="<?= $row['transaction_id'] ?>">
                                         <i class="fas fa-plus"></i>
                                     </a>
                                 </div>
                             </div>
                             <hr>
                             <div class="row">
                                 <a type="button" class="btn btn-sm btn-success btn-block default-shadow rounded-right-custom rounded-left-custom" href="<?= base_url() . 'transaction/cart/' . $row['transaction_id'] ?>">Pay</a>
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
         </div>
     </div>
 </div>
 <script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
 <script type="text/javascript">
     var save_method;
     var table;
     var base_url = '<?= base_url(); ?>';

     $(document).ready(function() {
         $('.btnAdd').click(function() {
             var id = $(this).data('code');
             window.location.href = "<?= base_url() . 'pending/list_pending/' ?>" + id;
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
         $('#modal_form').modal('show');
     }

     function save() {
         $('#btnSave').text('saving...');
         $('#btnSave').attr('disabled', true);
         var url;

         if (save_method == 'add') {
             url = "<?= site_url('category/ajax_add') ?>";
         } else if (save_method == 'delete') {
             url = "<?= site_url('category/ajax_delete') ?>";
         } else {
             url = "<?= site_url('category/ajax_update') ?>";
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
                 if (data.status == true) {
                     $('#modal_form').modal('hide');
                     location.reload();
                 } else if (data.status == false) {
                     Swal.fire(
                         'Gagal',
                         'Data sudah digunakan',
                         'error'
                     );
                     $('#modal_form').modal('hide');
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

     //  function add() {
     //      var id = $('.btnAdd').data("code");
     //      alert(id);
     //     //  window.location.href = "<?= base_url() . 'transaction/transaction' ?>";
     //  }
 </script>