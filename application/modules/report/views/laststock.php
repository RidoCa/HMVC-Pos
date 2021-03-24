<div class="container my-4">
	<form id="form">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
		<button type="button" class="btn btn-sm btn-success col-auto rounded-right-custom rounded-left-custom" id="btnPrint">
			<i class="fas fa-print"></i> Print
		</button>
		<!-- <button type="button" class="btn btn-sm btn-danger rounded-right-custom rounded-left-custom" id="btnPdf">
			<i class="far fa-file-pdf"></i> Download PDF
		</button> -->
	</form>
	<table id="tb_data" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Produk</th>
				<th>Nama Produk</th>
				<th>Stok</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;
			foreach ($list as $row) : ?>
				<tr>
					<td class="text-center"><?= $no ?></td>
					<td><?= $row['product_id'] ?></td>
					<td><?= $row['product_name'] ?></td>
					<td class="text-center"><?= $row['inventory_stock'] ?></td>
				</tr>
			<?php $no++;
			endforeach; ?>
		</tbody>
	</table>
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
			window.location.href = "<?= base_url() . 'report/printLaststock' ?>";
		});

		$('#btnPdf').click(function() {
			window.open('<?= base_url() . 'report/pdfLaststock' ?>', '_blank');
		});
	});
</script>
