<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Struk</title>

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
			font-family: Courier New, Courier, monospace;
			font-size: 15pt;
		}

		main {
			margin-top: 15px;
			font-family: Courier New, Courier, monospace;
			font-size: 14pt;
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

		.pl {
			padding: 15px;
		}
	</style>
</head>

<body>
	<header>
		<label class="judul">Struk Pembelian</label>
	</header>
	<main>
		<br>
		<table style="width: 100%">
			<tr>
				<td width="50%">No. Invoice : <b><?= $list['transaction_id'] ?></b></td>
				<td width="50%" class="vt-right">Tgl. : <b><?= date("d/m/Y H:i:s", strtotime($list['created_at'])) ?></b></td>
			</tr>
		</table>
		<br><br>
		<table style="width: 100%">
			<?php foreach ($listDetail as $row) : ?>
				<tr>
					<td width="50%"><?= $row['product_name'] ?></td>
					<td width="20%">x<?= $row['qty'] ?></td>
					<td width="30%" class="vt-right">Rp. <?= number_format($row['price'], 0, ',', '.')  ?></td>
				</tr>
				<?php if(!empty($row['transaction_note'])) : ?>
					<tr>
						<td colspan="3" class="pl">- <?= $row['transaction_note'] ?></td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</table>
		<hr>
		<table style="width: 100%">
			<tr>
				<td width="50%"></td>
				<td width="20%" class="vt-right">Total</b></td>
				<td width="30%" class="vt-right">Rp. <?= number_format($list['transaction_value'], 0, ',', '.')  ?></b></td>
			</tr>
		</table>
	</main>
</body>

</html>
