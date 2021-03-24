<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Laporan Transaksi</title>

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
		<label class="judul">Laporan Transaksi</label>
	</header>
	<main>
		<table id="tb_data" class="row-border" style="width:100%">
			<thead>
				<tr class="row-border">
					<td class="font-weight-bold row-border vt-center">Tgl. Transaksi</td>
					<td class="font-weight-bold row-border vt-center">Invoice</td>
					<td class="font-weight-bold row-border vt-center">Produk</td>
					<td class="font-weight-bold row-border vt-center">QTY</td>
					<td class="font-weight-bold row-border vt-center">Biaya</td>
					<td class="font-weight-bold row-border vt-center">Catatan</td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i = 0; $i < count($list); $i++) : ?>
					<?php for ($x = 0; $x < count($list[$i]['product']); $x++) : ?>
						<tr class="row-border">
							<td class="row-border pg vt-center"><?= date("d/m/Y", strtotime($list[$i]['date'][$x])) ?></td>
							<td class="row-border pg vt-left"><?= $list[$i]['trx_id'] ?></td>
							<td class="row-border pg"><?= $list[$i]['product'][$x] ?></td>
							<td class="row-border pg vt-center"><?= $list[$i]['qty'][$x] ?></td>
							<td class="row-border pg vt-right">Rp. <?= number_format($list[$i]['price'][$x], 0, ',', '.'); ?></td>
							<td class="row-border pg vt-left"><?= (!empty($list[$i]['note'][$x]) ? $list[$i]['note'][$x] : '-') ?></td>
						</tr>
					<?php endfor; ?>
				<?php endfor; ?>
			</tbody>
		</table>
	</main>
</body>

</html>
