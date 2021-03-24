 <div class="container my-4">
 		<div class="col-xs-12">
 			<form id="form">
 				<div class="form-group">
 					<label for="curr_pass" class="control-label">Current Password</label>
 					<input type="password" class="form-control" id="curr_pass" name="curr_pass">
 					<span class="help-block"></span>
 				</div>
 				<div class="form-group">
 					<label for="new_pass" class="control-label">New Password</label>
 					<input type="password" class="form-control" id="new_pass" name="new_pass">
 					<span class="help-block"></span>
 				</div>
 				<div class="form-group">
 					<label for="re_pass" class="control-label">Repear New Password</label>
 					<input type="password" class="form-control" id="re_pass" name="re_pass">
 					<span class="help-block"></span>
 				</div>

 				<button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-block">
 					<i class="fa fa-fw fa-key"></i> Update
 				</button>
 				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
 			</form>
 	</div>
 </div>

 <script src="<?php echo base_url() . 'assets/plugins/jQuery/jquery-2.1.4.min.js' ?>"></script>

 <script type="text/javascript">
 	var save_method;
 	var table;
 	var base_url = '<?php echo base_url(); ?>';

 	$(document).ready(function() {
 		$("input").change(function() {
 			$(this).parent().removeClass('has-error');
 			$(this).next().empty();
 		});
 	});

 	function save() {
 		$('#btnSave').html('<i class="fa fa-fw fa-spinner fa-spin"></i> menyimpan...');
 		$('#btnSave').attr('disabled', true);
 		var url;

 		url = "<?php echo site_url('password/ajax_update') ?>";

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
 					Swal.fire({
 						title: 'Berhasil',
 						text: "Kata sandi berhasil dirubah.",
 						icon: 'success',
 						showCancelButton: false,
 						confirmButtonColor: '#3085d6',
 						confirmButtonText: 'Ok'
 					}).then((result) => {
 						if (result.value) {
 							window.location.href = "<?php echo base_url() . 'login/logout'; ?>";
 						}
 					})
 				} else {
 					for (var i = 0; i < data.inputerror.length; i++) {
 						$('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
 						$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
 					}
 				}
 				$('#btnSave').html('<i class="fa fa-fw fa-key"></i> Ubah Kata Sandi');
 				$('#btnSave').attr('disabled', false);
 			},
 			error: function(jqXHR, textStatus, errorThrown) {
 				Swal.fire(
 					'Gagal',
 					'Gagal menambah / merubah data',
 					'danger'
 				);
 				$('#btnSave').html('<i class="fa fa-fw fa-key"></i> Ubah Kata Sandi');
 				$('#btnSave').attr('disabled', false);
 			}
 		});
 	}
 </script>