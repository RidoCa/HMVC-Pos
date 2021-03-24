<div class="container my-4">
	<form id="form">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
		<button type="button" class="btn btn-sm btn-success col-auto rounded-right-custom rounded-left-custom" id="btnPrint">
			<i class="fas fa-print"></i> Print
		</button>
		<!-- <button type="button" class="btn btn-sm btn-danger col-auto rounded-right-custom rounded-left-custom" id="btnPdf">
			<i class="far fa-file-pdf"></i> Download PDF
		</button> -->
		<button type="button" class="btn btn-sm btn-info  col-auto rounded-right-custom rounded-left-custom" id="btnFilter">
			<i class="fas fa-filter"></i> Filter Date
		</button>
	</form>
	<table id="tb_data" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
		<thead>
			<tr>
				<td class="font-weight-bold">Tgl. Transaksi</td>
				<td class="font-weight-bold">Invoice</td>
				<td class="font-weight-bold">Produk</td>
				<td class="font-weight-bold">QTY</td>
				<td class="font-weight-bold">Biaya</td>
				<td class="font-weight-bold">Catatan</td>
			</tr>
		</thead>
		<tbody>
			<?php for ($i = 0; $i < count($list); $i++) : ?>
				<!-- <tr>
					<td colspan="5">No. Inv (<?= $list[$i]['trx_id'] ?>)</td>
				</tr> -->
				<?php for ($x = 0; $x < count($list[$i]['product']); $x++) : ?>
					<tr>
						<td class="text-center"><?= date("d/m/Y", strtotime($list[$i]['date'][$x])) ?></td>
						<td class="text-left"><?= $list[$i]['trx_id'] ?></td>
						<td><?= $list[$i]['product'][$x] ?></td>
						<td class="text-center"><?= $list[$i]['qty'][$x] ?></td>
						<td class="text-right">Rp. <?= number_format($list[$i]['price'][$x], 0, ',', '.'); ?></td>
						<td class="text-left"><?= (!empty($list[$i]['note'][$x]) ? $list[$i]['note'][$x] : '-') ?></td>
					</tr>
				<?php endfor; ?>
			<?php endfor; ?>
		</tbody>
	</table>
	<div class="modal fade" id="modal_form" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">
						Choose the date
					</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<form action="<?= base_url('report/filter') ?>" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12 form-inline">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">
											Start Date
										</label>
										<input type="date" name="start" id="start" class="form-control rounded-right-custom rounded-left-custom" required />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">
											End Date
										</label>
										<input type="date" name="finish" id="finish" class="form-control rounded-right-custom rounded-left-custom" required />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
						<input type="submit" class="btn btn-primary rounded-right-custom rounded-left-custom" value="Submit">
						<button type="button" class="btn btn-secondary rounded-right-custom rounded-left-custom" data-dismiss="modal">
							Cancel
						</button>
					</div>
				</form>

			</div>

		</div>

	</div>
</div>

<script src="<?= base_url() . 'assets/js/jquery-3.3.1.min.js' ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tb_data').DataTable({
			"bLengthChange": false, //thought this line could hide the LengthMenu
			"bInfo": false,
			"bFilter": false
		});

		$('#btnPrint').click(function() {
			window.location.href = "<?= base_url() . 'report/printTransaction' ?>";
			// window.open('<?= base_url() . 'report/printTransaction' ?>', '_blank');
		});

		$('#btnPdf').click(function() {
			window.open('<?= base_url() . 'report/pdfTransaction' ?>', '_blank');
		});

		$('#btnFilter').click(function() {
			$('#modal_form').modal({
				show: true // added property here
			});
		});
	});
</script>
