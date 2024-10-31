(function( $ ) {
	'use strict';
	jQuery(document).ready( function () {
		$(document).on("change", ".uploader input[type=file]", function(e) {
			$(document).find("button[name=btn_update_transactions]").click();
		});
	    jQuery('#myTable').DataTable();
		$('body').on( 'click', '.btn-upload-files', function(e){
			e.preventDefault();
			var custom_uploader = wp.media({
				title: 'Select Files',
				library : {
					// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
					// type : 'image'
				},
				button: {
					text: 'Use these files' // button label text
				},
				multiple: true
			}).on('select', function() { // it also has "open" and "close" events
				var selection = custom_uploader.state().get('selection');
				var fileNames = [];
				var fileUrls = [];
				var fileIds = [];
				selection.map( function( attachment ) {
					var filename = attachment.toJSON().url.substring(attachment.toJSON().url.lastIndexOf('/')+1);
					fileNames.push(filename);
					fileUrls.push(attachment.toJSON().url);
					fileIds.push(attachment.toJSON().id);
				});
				$(document).find("input[name=files]").val(fileNames.join(", "));
				$(document).find("input[name=files_urls]").val(fileUrls.join(", "));
				$(document).find("input[name=files_ids]").val(fileIds.join(", "));
			}).open();
		
		});
		$("#sale_price").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
		$("#total_commision").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
		calculateCommission();
		function calculateCommission() {
			var total_commision = $(document).find("input[name=total_commision]");
			var broker_referral = $(document).find("input[name=broker_referral]");
			var agent_payout = $(document).find("input[name=agent_payout]");
			var agent_payout_class = $(document).find(".agent-payout");
			var commission_amount = agent_payout_class.data("commission");
			var admin = agent_payout_class.data("admin");
			var commission_calculated = 0;
			if (commission_amount && total_commision.val()) {
				if (broker_referral.is(":checked")) {
					if (!admin) {
						agent_payout_class.text("50");
						commission_calculated = total_commision.val().replace(/,/g, "") * 0.5;
					} else {
						return false;
					}
				} else {
					agent_payout_class.text(commission_amount * 100);
					commission_calculated = total_commision.val().replace(/,/g, "") * commission_amount;
				}
			}
			agent_payout.val(commission_calculated);
			$("#agent_payout").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
		}
		$(document).on("keyup", "input[name=total_commision]", function() {
			calculateCommission();
		});
		$(document).on("change", "input[name=broker_referral]", function() {
			calculateCommission();
		});
	} );

})( jQuery );

function cn_export_db(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'export_data',
	}, function(response){
		//console.log(response);
		window.location.href=response;
		jQuery('.mylod').hide();
	});
}

function cn_export_file(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'export_file',
	}, function(response){
		console.log(response);
		 window.location.href=response;
		 jQuery('.mylod').hide();
	});
}

function cn_backup(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'backup_data',
	}, function(response){
		//console.log(response);
		JSON.parse(response).forEach(element => {
			var temporaryDownloadLink = document.createElement("a");
			temporaryDownloadLink.style.display = 'none';
			document.body.appendChild( temporaryDownloadLink );
			temporaryDownloadLink.setAttribute( 'href', element );
			var filename = element.substring(element.lastIndexOf('/')+1);
			temporaryDownloadLink.setAttribute( 'download', filename );
			temporaryDownloadLink.click();
			document.body.removeChild( temporaryDownloadLink );
		});
		jQuery('.mylod').hide();
	});
}

function addusersRecord(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'add_users',
	}, function(response){
		jQuery('#cn_model_body').html(response)
		jQuery(".cn_model").show();
		jQuery('.mylod').hide();
	});
}

function addSubusersRecord(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'add_sub_users',
	}, function(response){
		jQuery('#cn_model_body').html(response)
		jQuery(".cn_model").show();
		jQuery('.mylod').hide();
	});
}

function editusersRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	editAllusersRecord();
}
function editAllusersRecord(){
  	var users_ids = jQuery("input[name='post']:checked").map(function() {
		 return this.value;
	}).get().join(',');
	if (users_ids=='') {
		swal({
		type: 'warning',
		title: 'Please select at least one record',
		text: '',
		showConfirmButton: false,
		timer: 1600
	});
	}else{
		jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'edit_all_users',
			'users_ids': users_ids,
		}, function(response){
			jQuery('#cn_model_body').html(response)
			jQuery(".cn_model").show();
			jQuery('.mylod').hide();
		});
	}
}

function ResetPasswordusersRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	editAllResetPasswordusersRecord();
}
function editAllResetPasswordusersRecord(){
  	var users_ids = jQuery("input[name='post']:checked").map(function() {
		 return this.value;
	}).get().join(',');
	if (users_ids=='') {
		swal({
			type: 'warning',
			title: 'Please select at least one record',
			text: '',
			showConfirmButton: false,
			timer: 1600
		});
	}else{

		swal({
            title: "Are you sure?", //Bold text
            text: "You want to change the password to '123456'?", //light text
            type: "warning", //type -- adds appropiriate icon
            showCancelButton: true, // displays cancel btton
            confirmButtonColor: "red",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: true, //do not close popup after click on confirm, usefull when you want to display a subsequent popup
            closeOnCancel: false
        }, 
        function(isConfirm){ 
            if(isConfirm){
            	jQuery('.mylod').show();
				jQuery.post(cn_plugin_vars.ajaxurl,{
					'action': 'workstation_ajax',
					'param': 'edit_all_reset_password_users',
					'users_ids': users_ids,
				}, function(response){
					var response =JSON.parse(response);
					jQuery('.mylod').hide();
					swal({
						type: 'success',
						title: response.msg,
						text: '',
						showConfirmButton: false,
						timer: 1600
					});
				});
           		
            } else {
                swal({
                	type: 'error',
					title: 'Cancel',
					text: '',
					showConfirmButton: false,
					timer: 1600
                });
            }
        });

		
	}
}

function deleteusersRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	deleteAllusersRecord();
}
function deleteAllusersRecord(){
  	var users_ids = jQuery("input[name='post']:checked").map(function() {
		 return this.value;
	}).get().join(',');
	if (users_ids=='') {
		swal({
			type: 'warning',
			title: 'Please select at least one record',
			text: '',
			showConfirmButton: false,
			timer: 1600
		});
	}else{
		jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'delete_all_users',
			'users_ids': users_ids
		}, function(response){
			console.log(response);
			jQuery('.mylod').hide();
			var users_id=users_ids.split(',');
				for(var i=0;i<users_id.length;i++){
				        jQuery('#Cn_users'+users_id[i]).remove();
				}
			var response =JSON.parse(response);
			swal({
				type: 'success',
				title: response.msg,
				text: '',
				showConfirmButton: false,
				timer: 1600
			});
			
		});
	}
}

//////
function deleteTransactionsRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});

	jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'edit_all_agent_transactions',
			'transaction_ids': id
		}, function(response){
			console.log(response);
			jQuery('.mylod').hide();
			jQuery('#transactions'+id).remove();
			var response =JSON.parse(response);
			swal({
				type: 'success',
				title: response.msg,
				text: '',
				showConfirmButton: false,
				timer: 1600
			});
			
		});

	//deleteAllusersRecord();
}
function deleteAllTransactionsRecord(){
  	var users_ids = jQuery("input[name='post']:checked").map(function() {
		 return this.value;
	}).get().join(',');
	if (users_ids=='') {
		swal({
			type: 'warning',
			title: 'Please select at least one record',
			text: '',
			showConfirmButton: false,
			timer: 1600
		});
	}else{
		jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'delete_all_users',
			'users_ids': users_ids
		}, function(response){
			console.log(response);
			jQuery('.mylod').hide();
			var users_id=users_ids.split(',');
				for(var i=0;i<users_id.length;i++){
				        jQuery('#Cn_users'+users_id[i]).remove();
				}


			var response =JSON.parse(response);
			swal({
				type: 'success',
				title: response.msg,
				text: '',
				showConfirmButton: false,
				timer: 1600
			});
			
		});
	}
}
///////

function addmytransactionsRecord(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'add_mytransactions',
	}, function(response){
		jQuery('#cn_model_body').html(response)
		jQuery(".cn_model").show();
		jQuery('.mylod').hide();
	});
}

function addagenttransactionsRecord(){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'workstation_ajax',
		'param': 'add_agenttransactions',
	}, function(response){
		jQuery('#cn_model_body').html(response)
		jQuery(".cn_model").show();
		jQuery('.mylod').hide();
	});
}

function editmytransactionsRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	editAllmytransactionsRecord(id);
}
function editAllmytransactionsRecord(){
  	var mytransactions_ids = id;
	if (mytransactions_ids=='') {
		swal({
		type: 'warning',
		title: 'Please select at least one record',
		text: '',
		showConfirmButton: false,
		timer: 1600
	});
	}else{
		jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'edit_all_mytransactions',
			'mytransactions_ids': mytransactions_ids,
		}, function(response){
			jQuery('#cn_model_body').html(response)
			jQuery(".cn_model").show();
			jQuery('.mylod').hide();
		});
	}
}

function deletemytransactionsRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	deleteAllmytransactionsRecord(id);
}
function deleteAllmytransactionsRecord(id){
  	var mytransactions_ids = id;
	if (mytransactions_ids=='') {
		swal({
			type: 'warning',
			title: 'Please select at least one record',
			text: '',
			showConfirmButton: false,
			timer: 1600
		});
	}else{
		jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'delete_all_mytransactions',
			'mytransactions_ids': mytransactions_ids
		}, function(response){
			console.log(response);
			jQuery('.mylod').hide();
			var mytransactions_id=mytransactions_ids.split(',');
				for(var i=0;i<mytransactions_id.length;i++){
				        jQuery('#Cn_mytransactions'+mytransactions_id[i]).remove();
				}


			var response =JSON.parse(response);
			swal({
				type: 'success',
				title: response.msg,
				text: '',
				showConfirmButton: false,
				timer: 1600
			});
			
		});
	}
}


function file_delete (argument) {
	jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'delete_file',
			'file_ids': argument
		}, function(response){
			console.log(response);
			jQuery('.mylod').hide();
			jQuery('.tr_files_'+argument).remove();
			var response =JSON.parse(response);
			swal({
				type: 'success',
				title: response.msg,
				text: '',
				showConfirmButton: false,
				timer: 1600
			});
			
		});
}

function transactionClose (argument,recode_for) {
	swal({
	  title: "Would you like to close this transaction?",
	  text: "This cannot be undone. Ensure you have saved recent changes.",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, close it!",
	  closeOnConfirm: false
	},
	function(){
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'update_price_and_commission',
			'id': argument,
			'sale_price': jQuery("input[name='sale_price']").maskMoney('unmasked')[0],
			'total_commision': jQuery("input[name='total_commision']").maskMoney('unmasked')[0],
			'broker_referral': jQuery("input[name='broker_referral']").is(":checked"),
		}, function(response){
			window.location.href='?page='+recode_for+'&trans_closed=closed&trans_id='+argument;
		});
	});
	
}

function transactionCancel (argument,recode_for) {
	swal({
	  title: "Would you like to cancel this transaction?",
	  text: "This cannot be undone. Ensure you have saved recent changes.",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, Cancel it!",
	  closeOnConfirm: false
	},
	function(){
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_ajax',
			'param': 'update_price_and_commission',
			'id': argument,
			'sale_price': jQuery("input[name='sale_price']").maskMoney('unmasked')[0],
			'total_commision': jQuery("input[name='total_commision']").maskMoney('unmasked')[0],
			'broker_referral': jQuery("input[name='broker_referral']").is(":checked"),
		}, function(response){
			window.location.href='?page='+recode_for+'&trans_cancel=cancel&trans_id='+argument;
		});
	});
	
}