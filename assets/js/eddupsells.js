jQuery( document ).ready( function($){

	var submit_form = false;
	var current_url = window.location;

	$('a.edd-add-to-cart').addClass('edd-has-js');

	$('#animatedModal').on('click', '.edd_go_to_checkout', function(e){
		$('#animatedModal .close-animatedModal').trigger('click');
	});

	$('#animatedModal .close-animatedModal').on('click', function(e){
		submit_form = true;
	});

	$('body').on('edd_cart_item_added', function(e){

		$('#edd_checkout_cart').addClass('loading');
		$('#animatedModal #edd_checkout_cart').addClass('loading');

		$("#open_animiatedModal").trigger('click');

		$.ajax({
			url: edd_scripts.ajaxurl,
			type: 'GET',
			data: { action: 'eddupsells_ajax_action', subaction: 'update_cart' },
			success: function(res) {
				$('#edd_checkout_cart').removeClass('loading');
				$('#animatedModal #edd_checkout_cart').removeClass('loading');
				$('#edd_checkout_cart').parent().html(res);
				$('#animatedModal #edd_checkout_cart').parent().html(res);
			},
			complete: function(res) {
				$('#edd_checkout_cart').removeClass('loading');
				$('#animatedModal #edd_checkout_cart').removeClass('loading');
			}
		})
	});

	
	$("#open_animiatedModal").animatedModal();


	$('#animatedModal').on('click', '.edd_cart_remove_item_btn', function(e){

		e.preventDefault();

		var url = $(this).attr('href');

		$('#animatedModal #edd_checkout_cart').addClass('loading');

		$.ajax({
			url: url,
			type: 'GET',
			complete: function(res) {
				$('body').trigger('edd_cart_item_added');
			}
		});

		return false;
	})
});