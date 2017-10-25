<h1 class="main-heading pixel">Pixels</h1>
<div class="switch">
<!-- 	<h4>Include Tax and Shipping</h4>
    <input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" name="tax_shipping" value="">
    <label for="cmn-toggle-4"></label> -->
    <h4>Include Tax and Shipping</h4>
    <input type="checkbox" <?php if($taxValue['enable_tax_ship'] == 'true') { echo "checked"; } ?> id="toggle-event" data-toggle="toggle" name="tax_ship" value='<?php echo $taxValue['enable_tax_ship']; ?>'>
</div>
<style type="text/css">
	.ajaxloader {
    position: fixed;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #666;
    background-image: url('../app/include/images/ajax-loader.gif');
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;
}
</style>
<div class="ajaxloader" style="display: none;"></div>
<div class="inner-container">
	
	<!-- Lists of Pixel ids -->
	<div class="pixel-ids-list table-responsive">
		<?php if($count == 6 || $total > 6) {?>
		<div class="alert alert-danger alert-dismissable" id="alertFlash"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>You can add only 6 pixel ids only</div>
		<?php } ?>
		<?php if($get_pixel_ids->num_rows > 0) { ?>	
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Pixel Id</th>
					<th>Date Added</th>
					<!-- <th>Include Taxes & Shipping?</th> -->
					<!-- <th>Include Shipping?</th> -->
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php while($data_pixel = $get_pixel_ids->fetch_assoc()) {?>
				<tr>
					<td><?php echo $data_pixel['pixel_id']; ?></td>
					<td><?php echo $data_pixel['created_at']; ?></td>
					<!-- <td><input type="checkbox" <?php echo $data_pixel['tax_status'] == 1 ? 'checked':''; ?> disabled></td> -->
					<!-- <td><input type="checkbox" <?php echo $data_pixel['shipping_status'] == 1 ? 'checked':''; ?> disabled></td> -->
					<td>
						<a  data-toggle="modal" data-target="#myModal_<?php echo $data_pixel['id'];?>" class="cursorlink"> <span class="glyphicon glyphicon-edit"></span></a> | 
						<a class = "del_pixel_id cursorlink" data-id="del_form_<?php echo $data_pixel['id'];?>"><span class="glyphicon glyphicon-trash"></span></a>
						<!-- Start Edit Pixel Id Modal -->
						<div class="modal fade" id="myModal_<?php echo $data_pixel['id'];?>" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Edit Pixel Id</h4>
									</div>
									<div class="modal-body">
										<form method="post">
											<div class="row">
												<div class="form-group col-md-offset-2 col-md-8">
													<label for="usr" class="col-md-4 form-pixel-label">Add Pixel Id:</label>
													<input type="hidden" name="pixel_main_id" value="<?php echo $data_pixel['id'];?>">
													<input type="text" class="form-control" name="Update-pixel-id" value="<?php echo $data_pixel['pixel_id']; ?>" onkeypress="return isNumber(event)" required="required">
												</div>	

												<div class="col-md-offset-1 col-md-8 form-group">
													<!-- <label class="checkbox-inline">
														<input type="checkbox" name="Update-tax" <?php echo $data_pixel['tax_status'] == 1 ? 'checked':''; ?>>
														Include Taxes & Shipping ?
													</label> -->
													<!-- <label class="checkbox-inline">
														<input type="checkbox" name="update-shipping" <?php echo $data_pixel['shipping_status'] == 1 ? 'checked':''; ?>>
														Include Shipping ?
													</label> -->
												</div>


												<div class="col-md-4 col-md-offset-1">	
													<input type="submit" name="update-pixel" value="Update" class="btn btn-success">
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer"></div>
								</div>

							</div>
						</div>
						<!-- End Edit Pixel Id Modal -->
						<!-- Delete Pixel Id From -->
						<form method="post" id="del_form_<?php echo $data_pixel['id']; ?>">
							<input type="hidden" name="del_id" value="<?php echo $data_pixel['id']; ?>">
						</form>
						<!-- Delete Pixel Id From -->
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>
	</div>
	<!-- Lists of Pixel ids -->
	<!-- Pixel Id Form -->
	<div class="pixel-form-container">
		<form method="post" id="pixel-form">
			<div class="row">
				<div class="col-md-12">
					<label>Add Pixel Id:</label>
				</div>
				<div class="col-md-12">	
					<div class="form-group col-md-4 addtextbox">				      
						<input type="text" class="form-control pixel_val" name="pixel-id[]" onkeypress="return isNumber(event)">
					<!-- 	<label class="checkbox-inline"><input type="checkbox"><input type="hidden" name="tax-status[]" value="0">Include Taxes & Shipping?</label> -->
						<!-- <label class="checkbox-inline"><input type="checkbox"><input type="hidden" name="shipping-status[]" value="0">Include Shipping?</label> -->
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-primary" id="addmore">Add More</button>
					</div>
				</div>
				
			</div>
			
		</form>
	</div>
	<!-- Pixel Id Form -->
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var html = "";
		jQuery("#addmore").click(function(){
			localStorage.setItem('check_empty',true);
			html = '<div class="appendfield"><input type="text" class="form-control pixel_val" name="pixel-id[]" onkeypress="return isNumber(event)"> \
			<label class="checkbox-inline" style="visibility:hidden"><input type="checkbox"><input type="hidden" name="tax-status[]" value="0">Include Taxes & Shipping?</label> \
			<label class="checkbox-inline" style="visibility:hidden"><input type="checkbox"><input type="hidden" name="shipping-status[]" value="0">Include Shipping?</label><span class="glyphicon glyphicon-remove removefield" data-toggle="tooltip" data-placement="right" title="Remove Field"></span></div>';
			jQuery(".addtextbox").append(html);
			jQuery('[data-toggle="tooltip"]').tooltip();
			jQuery(".removefield").click(function(){
				jQuery(this).parent().remove();
			});
		});

		jQuery(document).on("click","input[type='checkbox']",function () {
			if(jQuery(this).parent().find("input[type='hidden']").val() == 0){
				jQuery(this).parent().find("input[type='hidden']").val(1);
			}else{
				jQuery(this).parent().find("input[type='hidden']").val(0);
			} 
		});

	});
	jQuery(document).ready(function(){
		window.setTimeout(function() {
			$("#alertFlash").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);
	});

    jQuery('#toggle-event').change(function() {
       var chbx =  jQuery(this).is(':checked')  
      if(chbx){
      	jQuery.ajax({
       		METHOD:'post',
       		url:'updateTax.php',
       		data: 'value='+chbx,
       		beforeSend: function() {
		       jQuery('.ajaxloader').show();
		    },
       		success:function(resp){
       			window.location.reload();
       		}
       	});
      }else{
      	jQuery.ajax({
       		METHOD:'post',
       		url:'updateTax.php',
       		data: 'value='+'false',
       		beforeSend: function() {
		       jQuery('.ajaxloader').show();
		    },
       		success:function(resp){
       			window.location.reload();
       		}
       	});
      }
    });
</script>