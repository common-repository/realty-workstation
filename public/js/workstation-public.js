(function( $ ) {
	'use strict';
jQuery(document).ready( function () {
	    jQuery('#myTable').DataTable({
			columnDefs: [
				{ width: "25%", targets: 0 },
				{ width: "20%", targets: 1 }
			],
			"order": []
		});
		// $('.nav.nav-second-level').on('hidden.bs.collapse', function (e) {
		// 	$('.nav.nav-second-level').collapse('show')
		//   })
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
				console.log(broker_referral.is(":checked"));
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
			commission_calculated = commission_calculated.toFixed(2);
			console.log(commission_calculated);
			agent_payout.val(commission_calculated);
			$("#agent_payout").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
		}
		$(document).on("keyup", "input[name=total_commision]", function() {
			calculateCommission();
		});
		$(document).on("change", "input[name=broker_referral]", function() {
			calculateCommission();
			console.log("Hello");
		});
	} );
	$(document).on("change", ".uploader input[type=file]", function(e) {
		$(document).find("form").submit();
	});
	// Delete Agent
	$(document).on("click", ".btn-delete-agent", function() {
		Swal.fire({
			title: "Would you like to delete this agent?",
			text: "This cannot be undone. Ensure you have saved recent changes.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
		  }).then(function(result) {
			if (result.isConfirmed) {
				$(document).find("#add_Questions").submit();
			}
		});
	});
})( jQuery );

function file_delete (argument) {
	jQuery('.mylod').show();
		jQuery.post(cn_plugin_vars.ajaxurl,{
			'action': 'workstation_public_ajax',
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
			'action': 'workstation_public_ajax',
			'param': 'update_price_and_commission',
			'id': argument,
			'sale_price': jQuery("input[name='sale_price']").maskMoney('unmasked')[0],
			'total_commision': jQuery("input[name='total_commision']").maskMoney('unmasked')[0],
			'broker_referral': jQuery("input[name='broker_referral']").is(":checked"),
		}, function(response){
			window.location.href='?'+recode_for+'&trans_closed=closed&trans_id='+argument;
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
			'action': 'workstation_public_ajax',
			'param': 'update_price_and_commission',
			'id': argument,
			'sale_price': jQuery("input[name='sale_price']").maskMoney('unmasked')[0],
			'total_commision': jQuery("input[name='total_commision']").maskMoney('unmasked')[0],
			'broker_referral': jQuery("input[name='broker_referral']").is(":checked"),
		}, function(response){
	  		window.location.href='?'+recode_for+'&trans_cancel=cancel&trans_id='+argument;
		});
	});
	
}
function deletemytransactionsRecord(id){
	Swal.fire({
		title: "Would you like to delete this transaction?",
		text: "This cannot be undone. Ensure you have saved recent changes.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, Delete it!",
		closeOnConfirm: false
	  }).then(function(result) {
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
				jQuery('#Cn_mytransactions'+id).remove();
				var response =JSON.parse(response);
				Swal.fire({
					icon: 'success',
					title: response.msg,
					text: '',
					showConfirmButton: false,
					timer: 1600
				});
				
			});
	  });
	

	//deleteAllusersRecord();
}