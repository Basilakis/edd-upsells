jQuery( document ).ready( function($){

	var submit_form = false;
	var current_url = window.location;

	$(".js-data-example-ajax").select2({
		ajax: {
			url: ajaxurl,
			dataType: 'json',
			delay: 250,
			data: function (params) {
			  return {
			    q: params.term, // search term
			    page: params.page,
			    'action' : 'eddupsells_ajax_action',
			    'subaction' : 'upsells_products',
			  };
			},
			processResults: function (data, params) {
			  // parse the results into the format expected by Select2
			  // since we are using custom formatting functions we do not need to
			  // alter the remote JSON data, except to indicate that infinite
			  // scrolling can be used
			  params.page = params.page || 1;
			  $('.select2-dropdown--above').attr('id','fix');
				$('#fix').removeClass('select2-dropdown--above');
				$('#fix').addClass('select2-dropdown--below');
			  return {
			    results: data.items,
			    pagination: {
			      more: (params.page * 30) < data.total_count
			    }
			  };
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		minimumInputLength: 3,
		templateResult: formatRepo, // omitted for brevity, see the source of this page
		templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	}).on('select2:open',function(){

            $('.select2-dropdown--above').attr('id','fix');
            $('#fix').removeClass('select2-dropdown--above');
            $('#fix').addClass('select2-dropdown--below');

        });;

	function formatRepo (repo) {
      if (repo.loading) return repo.text;

      return repo.full_name;
    }

    function formatRepoSelection (repo) {
      return repo.full_name || repo.text;
    }

});