<div class="container-fluid px-0">
	<div class="list-group list-group-flush my-0 w-100 border-top border-bottom">
		<div class="list-group-item bg-light text-left py-2 text-mute font-weight-bold">Detail Order</div>
		<form id="form">
			<?php
			if (!empty($checkDetail)) :
				foreach ($checkDetail as $row) :
			?>
					<div class="list-group-item">
						<div class="row">
							<div class="col-auto">
								<figure class="avatar avatar-40">
									x<?= $row['qty'] ?>
								</figure>
							</div>
							<div class="col pl-0 align-self-center">
								<input type="hidden" value="<?= $row['product_id'] ?>" name="productid[]">
								<input type="hidden" value="<?= $row['qty'] ?>" name="transactionqty[]">
								<h6 class="mb-1 font-weight-normal"><b><?= $row['product_name'] ?></b></h6>
								<p class="small text-mute"><?= (!empty($row['transaction_note']) ? $row['transaction_note'] : '-') ?></p>
								<!-- <a href="<?= base_url() . 'transaction/detail/' . $row['product_id']  ?>" class="btn p-0 text-default">Edit</a>
                                <button type="button" data-product="<?= $row['product_id'] ?>" data-trx="<?= $row['transaction_id'] ?>" class="btn p-0 text-danger btnDelete">Delete</button> -->
							</div>
							<span class="mr-2 text-default">Rp. <?= number_format($row['price'], 0, ',', '.')  ?></span>
						</div>
					</div>
				<?php
				endforeach;
			else :
				?>
				<img class="img-fluid" src="<?= site_url() . 'assets/img/notfound.png' ?>">
			<?php endif; ?>
	</div>
</div>
<div class="container">
	<div class="card border-0 shadow-sm mt-4 mb-4">
		<div class="card-body position-relative">
			<div class="media">
				<div class="media-body">
					<h5 class="mb-1 col-md-6 pl-0 pr-0">Total : Rp. <?= number_format($check['transaction_value'], 0, ',', '.')  ?></h5>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h5 class="mb-1">Payment</h5>
					<div class="form-group">
						<label class="text-mute small"></label>
						<select class="form-control rounded-right-custom rounded-left-custom" id="payment" name="payment">
							<option value="">Select Payment Method</option>
							<?php foreach ($payment as $row) : ?>
								<option value="<?= $row['payment_id'] ?>"><?= $row['payment_name'] ?></option>
							<?php endforeach; ?>
						</select>
						<span class="help-block small text-danger"></span>
					</div>
					<div class="form-group">
						<label for="tax"></label>
						<input type="hidden" value="<?= $check['transaction_value'] ?>" id="total" name="total">
						<input type="hidden" value="<?= $check['transaction_id'] ?>" id="invoice" name="invoice">
						<input type="number" class="form-control rounded-right-custom rounded-left-custom" id="tax" name="tax" aria-describedby="emailHelp" placeholder="Enter nominal tax">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					</div>
					<div class="form-group float-right">
						<h5>Change : <span id="change">Rp. 0</span></h5>
					</div>
					<button type="button" class="btn btn-block btn-success default-shadow rounded-right-custom rounded-left-custom" id="btnPay" onclick="pay()">Submit</button>
					</form>
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

	$(document).ready(function() {
		$('.btnDelete').click(function() {
			var id = $(this).data('product');
			var trx = $(this).data('trx');
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

					$.ajax({
						url: "<?php echo site_url('transaction/ajax_delete_detail/') ?>" + trx + "/" + id,
						type: "GET",
						dataType: "JSON",
						success: function(data) {
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

		$('#tax').change(function() {
			var tax = $(this).val();
			var total = $('#total').val();

			var change = parseInt(tax) - parseInt(total);

			$('#change').html('Rp. ' + change);
		});
	});

	function pay() {
		$('#btnPay').text('loading...');
		$('#btnPay').attr('disabled', true);
		var url;
		url = "<?= site_url('transaction/ajax_pay') ?>";
		var invoice = $('#invoice').val();

		var formData = new FormData($('#form')[0]);

		Swal.fire({
			title: 'Cetak Struk?',
			// text: "Cetak Struk",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: url,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						if (data.status) {
							Swal.fire({
								title: 'Berhasil',
								text: "Pembayaran anda berhasil",
								icon: 'success',
								showCancelButton: false,
								confirmButtonColor: '#3085d6',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.value) {
									// window.open('<?= base_url() . 'transaction/printStruct/' ?>' + invoice, '_blank');
									window.location.href = "<?= base_url() . 'transaction/printStruct/' ?>" + invoice;
									// window.location.href = "<?= base_url() . 'transaction' ?>";
								}
							})
						} else {
							for (var i = 0; i < data.inputerror.length; i++) {
								$('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
								$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
							}
						}
						$('#btnPay').text('Pay');
						$('#btnPay').attr('disabled', false);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						Swal.fire(
							'Gagal',
							'Gagal menambah / merubah data',
							'error'
						);
						$('#btnPay').text('Pay');
						$('#btnPay').attr('disabled', false);

					}
				});
			} else {
				$.ajax({
					url: url,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						if (data.status) {
							Swal.fire({
								title: 'Berhasil',
								text: "Pembayaran anda berhasil",
								icon: 'success',
								showCancelButton: false,
								confirmButtonColor: '#3085d6',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.value) {
									window.location.href = "<?= base_url() . 'transaction' ?>";
								}
							})
						} else {
							for (var i = 0; i < data.inputerror.length; i++) {
								$('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
								$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
							}
						}
						$('#btnPay').text('Pay');
						$('#btnPay').attr('disabled', false);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						Swal.fire(
							'Gagal',
							'Gagal menambah / merubah data',
							'error'
						);
						$('#btnPay').text('Pay');
						$('#btnPay').attr('disabled', false);

					}
				});
			}
		})

	}
</script>
