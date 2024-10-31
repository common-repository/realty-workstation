(function( $ ) {
	'use strict';
	$( document ).ready(function() {
		$('.cn_close').click(function() {
			$(".cn_model").hide();
			jQuery('#cn_model_body').html('');
		});

		$('.open_cn_model').click(function() {
			$('.mylod').show();
				var open_cn_model_id = $(this).attr('data-target');
				$(open_cn_model_id).show();
			setTimeout(function() {
				$('.mylod').hide();
			}, 1000);
		});
	})
})( jQuery );

function showmsg(type,title,text,Button=false,timer=1600){
	swal({
		type: 'success',
		title: 'Added successfully',
		text: '',
		showConfirmButton: false,
		timer: 1600
	});
}

function addRecord(title){
	jQuery('.mylod').show();
	jQuery.post(cn_plugin_vars.ajaxurl,{
		'action': 'car_booking_ajax',
		'param': 'add_vehicle',
	}, function(response){
		jQuery('.cn_card-header .text').text(title);
		jQuery('#cn_model_body').html(response)
		jQuery(".cn_model").show();
		jQuery('.mylod').hide();
	});

}

function editRecord(id,title){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	editAllRecord(title);
}
function editAllRecord(title){
	jQuery('.cn_card-header .text').text(title);
  	var vehicle_ids = jQuery("input[name='post']:checked").map(function() {
		 return this.value;
	}).get().join(',');
	if (vehicle_ids=='') {
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
			'action': 'car_booking_ajax',
			'param': 'edit_all_vehicle',
			'vehicle_ids': vehicle_ids
		}, function(response){
			jQuery('#cn_model_body').html(response)
			jQuery(".cn_model").show();
			jQuery('.mylod').hide();
		});
	}
}
function deleteRecord(id){
	jQuery(".cn_checkbox").prop({'checked':''});
	jQuery("#cn"+id).prop({'checked':'checked'});
	deleteAllRecord();
}
function deleteAllRecord(){
  	var vehicle_ids = jQuery("input[name='post']:checked").map(function() {
		 return this.value;
	}).get().join(',');
	if (vehicle_ids=='') {
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
			'action': 'car_booking_ajax',
			'param': 'delete_all_vehicle',
			'vehicle_ids': vehicle_ids
		}, function(response){
			jQuery('.mylod').hide();
			var vehicle_id=vehicle_ids.split(',');
				for(var i=0;i<vehicle_id.length;i++){
				        jQuery('.Vehicle'+vehicle_id[i]).remove();
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


