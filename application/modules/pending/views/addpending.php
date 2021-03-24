<div class="container my-4">
    <div id="fieldSearch">
        <?php
        $inv = $this->uri->segment(3);
        if (count($list) > 0) {
            for ($i = 0; $i < count($list); $i++) {
        ?>
                <h6 class="page-subtitle"><?= $list[$i]['category'] ?></h6>
                <div class="swiper-container swiper-offers swiper-container-horizontal swiper-container-android">
                    <div class="swiper-wrapper">
                        <?php for ($y = 0; $y < count($list[$i]['product']); $y++) { ?>
                            <div class="swiper-slide w-auto p-2 swiper-slide-active" style="margin-right: 10px;">
                                <div class="card shadow-sm w-200 border-0">
                                    <a href="<?= base_url() . 'pending/detail/' . $list[$i]['product_id'][$y] . '/' . $inv  ?>">
                                        <img class="card-img-top h-100" src="<?= base_url() . 'assets/img/product/' . $list[$i]['image'][$y] ?>" alt="Card image">
                                    </a>
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold"><?= $list[$i]['product'][$y] ?></h6>
                                        <?php if ($list[$i]['inventory_stock'][$y] < 5) : ?>
                                            <p class="small p-0 text-danger">Stock hampir habis</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
        <?php }
        } ?>
    </div>

    <div class="modal fade" id="modal_form" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form_customer">
                    <div class="modal-header bg-default">
                        <label class="font-weight-bold modal-title" id="modalLabel"> Add
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="text-mute small">Customer</label>
                            <select class="form-control rounded-right-custom rounded-left-custom" id="customer" name="customer">
                                <option value="">Pilih Satu</option>
                                <?php foreach ($customer as $row) : ?>
                                    <option value="<?= $row['customer_id'] ?>"><?= $row['customer_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="help-block small text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label class="text-mute small">New Customer <span class="text-danger">(optional)</span></label>
                            <input type="text" class="form-control rounded-right-custom rounded-left-custom" id="newCust" name="newCust" placeholder="New Customer">
                            <span class="help-block small text-danger"></span>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-default default-shadow" id="btnSave" onclick="save_customer()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php //if (!empty($check)) : 
    ?>
    <!-- <div class="footer-tabs footer-spaces border-top text-left">
            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" style="width: 100%">
                    <button class="btn btn-block btn-default default-shadow rounded-right-custom rounded-left-custom" onclick="cart()">
                        <p class="float-left mb-0">View Basket &nbsp;<?= $checkDetail ?> Item </p>
                        <p class="float-right mb-0"> Rp. <?= number_format($check['transaction_value'], 0, ',', '.')  ?></p>
                    </button>
                </li>
            </ul>
        </div> -->
    <?php //endif; 
    ?>
</div>

<script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
<script type="text/javascript">
    var save_method;
    var table;
    var base_url = '<?= base_url(); ?>';

    $(document).ready(function() {
        // $('#modal_form').modal('show');
        // $('.modal-title').text('Add Customer');
        // var isshow = localStorage.getItem('isshow');
        // if (isshow == null) {
        //     localStorage.setItem('isshow', 1);

        //     // Show popup here
        //     $('#modal_form').modal('show');
        // }

        $('#search').keyup(function() {
            var search = $(this).val();
            var token = '<?= $this->security->get_csrf_hash(); ?>';

            $.ajax({
                url: "<?= site_url('transaction/ajax_search') ?>",
                type: "POST",
                data: {
                    search: search,
                    token: token
                },
                dataType: "JSON",
                success: function(data) {
                    var length = data.length;
                    var field = "";
                    for (var i = 0; i < length; i++) {
                        field += '<h6 class="page-subtitle">' + data[i]['category'] + '</h6>';
                        field += '<div class="swiper-container swiper-offers swiper-container-horizontal swiper-container-android">';
                        field += '<div class="swiper-wrapper">';
                        for (var y = 0; y < data[i]['product'].length; y++) {
                            field += '<div class="swiper-slide w-auto p-2 swiper-slide-active" style="margin-right: 10px;">';
                            field += '<div class="card shadow-sm w-200 h-200 border-0">';
                            field += '<img class="card-img-top h-100" src="<?= base_url() . 'assets/img/product/' ?>' + data[i]['image'][y] + '" alt="Card image">';
                            field += '<div class="card-body">';
                            field += '<h6 class="card-title font-weight-bold">' + data[i]['product'][y] + '</h6>';
                            field += '</div>';
                            field += '</div>';
                            field += '</div>';
                        }
                        field += '</div>';
                        field += '</div>';
                    }

                    $('#fieldSearch').html(field);
                }
            });
        });
    });

    function add() {
        save_method = 'add';
        $('#form_customer')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        $('#modal_form').modal('show');
        $('.modal-title').text('Add Customer');
    }

    function save_customer() {
        var url;
        url = "<?= site_url('transaction/ajax_add') ?>";

        var formData = new FormData($('#form_customer')[0]);
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
                    $('#form')[0].reset();
                    $('.form-group').removeClass('has-error');
                    $('.help-block').empty();
                    // location.reload();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire(
                    'Gagal',
                    'Gagal menambah / merubah data',
                    'error'
                );
            }
        });
    }

    function cart() {
        window.location.href = "<?= base_url() . 'transaction/cart' ?>";
    }
</script>