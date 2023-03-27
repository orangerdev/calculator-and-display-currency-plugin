(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	let hlm_datatable = new DataTable('#hlm-datatable',{
		searching: false,
		processing: true,
        serverSide: true,
		ajax: {
			url: hlm_vars.get_list_harga_logam_mulia.ajax_url,
			data: function( d ) {
				d.filter = $('#hlm-datatable-filter').serialize()
			},
			type: 'post',
		},
		columns: [
			{ data: "date" },
			{ data: "platinum" },
			{ data: "palladium" },
			{ data: "rhadium" }
		]
	});

	const hlm_ctx = document.getElementById('hlm-chart-js');

	var hlm_chart = new Chart(hlm_ctx, {
	  type: 'line',
	  data: {
		labels: [],
		datasets: []
	  },
	  options: {
		scales: {
		  y: {
			beginAtZero: true
		  }
		}
	  }
	});

	function hlm_get_chart_data() {

		var filter = $('#hlm-datatable-filter').serialize();

		$.ajax({
			url: hlm_vars.get_riwayat_harga_logam_mulia.ajax_url,
			type: 'post',
			data: filter,
			beforeSend: function(){
			},
			success: function(response){
				console.log(response);

				hlm_chart.data.labels = response.labels;
				hlm_chart.data.datasets = response.datasets;
				hlm_chart.update();

			}
		})
	
	}

	hlm_get_chart_data();

	$(document).on('change','#hlm-datatable-filter select',function(e){

		e.preventDefault();
		hlm_datatable.ajax.reload();
		hlm_get_chart_data();

	});

})( jQuery );
