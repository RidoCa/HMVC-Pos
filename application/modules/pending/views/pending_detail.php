<style>
    .qty .count {
        color: #000;
        display: inline-block;
        vertical-align: top;
        font-size: 25px;
        font-weight: 700;
        line-height: 30px;
        padding: 0 2px;
        min-width: 50px;
        text-align: center;
    }

    .qty .plus {
        cursor: pointer;
        display: inline-block;
        vertical-align: top;
        color: rgba(20, 59, 224, 0.85);
        width: 30px;
        height: 30px;
        font: 30px/1 Arial, sans-serif;
        text-align: center;
        /* border-radius: 50%; */
    }

    .qty .minus {
        cursor: pointer;
        display: inline-block;
        vertical-align: top;
        color: rgba(20, 59, 224, 0.85);
        width: 30px;
        height: 30px;
        font: 30px/1 Arial, sans-serif;
        text-align: center;
        /* border-radius: 50%; */
        background-clip: padding-box;
    }

    /*Prevent text selection*/
    .span-qty {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .input-qty {
        border: 0;
        width: 2%;
        background-color: transparent;
    }

    .input-qty::-webkit-outer-spin-button,
    .input-qty::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div class="section-100">
    <div class="container h-100">
        <?php
        $inv = $this->uri->segment(4);
        foreach ($detail as $row) : ?>
            <form id="form">
                <div class="row h-100 justify-content-center">
                    <div class="col-12 col-md-11 col-lg-10 align-self-center">
                        <p class="font-weight-bold text-center"><?= $row['product_name'] ?></p>
                        <img class="img-fluid w-100" src="<?= base_url() . 'assets/img/product/' . $row['product_image'] ?>" alt="Card image">
                        <input type="hidden" name="product" id="product" value="<?= $row['product_id'] ?>">
                        <input type="hidden" name="currstok" id="currstok" value="<?= $row['inventory_stock'] ?>">
                        <input type="hidden" name="invoice" id="invoice" value="<?= $inv ?>">
                        <input type="text" class="form-control mt-2 rounded-right-custom rounded-left-custom" name="catatan" id="catanan" maxlength="30" placeholder="catatan">
                        <span class="text-small text-mute text-left">contoh : tidak pedas</span>
                        <div class="qty mt-2 text-center">
                            <span class="minus border border-primary span-qty">-</span>
                            <input type="number" class="count input-qty" name="qty" id="qty" value="0">
                            <span class="plus border border-primary span-qty">+</span>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <button class="btn btn-block btn-default default-shadow mt-5" type="button" onclick="save()">Add to Basket</button>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>

<script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
<script type="text/javascript">
    var save_method;
    var table;
    var base_url = '<?= base_url(); ?>';

    $(document).ready(function() {
        $('.count').prop('readonly', true);
        $(document).on('click', '.plus', function() {
            var currstock = parseInt($('#currstok').val());
            $('.count').val(parseInt($('.count').val()) + 1);
            if ($('.count').val() >= currstock) {
                $('.count').val(currstock);
            }
        });
        $(document).on('click', '.minus', function() {
            $('.count').val(parseInt($('.count').val()) - 1);
            if ($('.count').val() < 1) {
                $('.count').val(0);
            }
        });
    });

    function save() {
        var inv = $('#invoice').val();
        var url;
        url = "<?= site_url('pending/ajax_cart/') ?>" + inv;

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
                    location.reload();
                } else if (data.status == false) {
                    Swal.fire(
                        'Gagal',
                        'Nilai Harga tidak ditemukan',
                        'error'
                    );
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
</script>