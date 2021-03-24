<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Laporan Stok Barang</title>

	<style>
		@page {
			margin: 25px 25px;
		}

		header {
			text-align: center;
		}

		.judul {
			text-transform: uppercase;
			font-weight: bold;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12pt;
		}

		main {
			margin-top: 15px;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11pt;
			margin-left: 1cm;
			margin-right: 1cm;
			margin-bottom: 0.5cm;
		}

		.row-border {
			border: 1px solid black;
			border-collapse: collapse;
		}

		.vt-center {
			vertical-align: middle !important;
			text-align: center
		}

		.vt-left {
			vertical-align: middle !important;
			text-align: left
		}

		.vt-right {
			vertical-align: middle !important;
			text-align: right
		}

		.pg {
			padding: 5px;
		}
	</style>
</head>

<body>
	<header>
		<label class="judul">Laporan <br> Stok Produk Terakhir</label>
	</header>
	<main>
		<table id="tb_data" class="row-border" style="width:100%">
			<thead>
				<tr class="row-border">
					<th class="row-border vt-center">No</th>
					<th class="row-border vt-center">Kode Produk</th>
					<th class="row-border vt-center">Nama Produk</th>
					<th class="row-border vt-center">Stok</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($list as $row) : ?>
					<tr class="row-border">
						<td class="row-border pg vt-center"><?= $no ?></td>
						<td class="row-border pg"><?= $row['product_id'] ?></td>
						<td class="row-border pg"><?= $row['product_name'] ?></td>
						<td class="row-border pg vt-center"><?= $row['inventory_stock'] ?></td>
					</tr>
				<?php $no++;
				endforeach; ?>
			</tbody>
		</table>
	</main>
</body>

</html>
