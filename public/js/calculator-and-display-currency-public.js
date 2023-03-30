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

	if ( $('#hlm-datatable').length > 0 ) {

		$.blockUI({ 
			message: '<p style="font-size:18px">Please wait...</p>',
			css: { 
				backgroundColor: 'transparent', 
				color: '#fff',
				border: 0
			} 
		});

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

		hlm_datatable.on('preXhr.dt', function ( e, settings, data ) {
			
			$.blockUI({ 
				message: '<p style="font-size:18px">Please wait...</p>',
				css: { 
					backgroundColor: 'transparent', 
					color: '#fff',
					border: 0
				} 
			});

		} );

		hlm_datatable.on('xhr.dt', function ( e, settings, data ) {
			
			var load_status = parseInt($('#hlm-load-status').val());
			$('#hlm-load-status').val(load_status+1);
			$('#hlm-load-status').trigger('change');

		} );

		$(document).on('change','#hlm-load-status',function(e){

			e.preventDefault();
			if ( $(this).val() == 2 ) {
				$.unblockUI();
			}

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

					hlm_chart.data.labels = response.labels;
					hlm_chart.data.datasets = response.datasets;
					hlm_chart.update();

					var load_status = parseInt($('#hlm-load-status').val());
					$('#hlm-load-status').val(load_status+1);
					$('#hlm-load-status').trigger('change');

				}
			});
		
		}

		hlm_get_chart_data();

		$(document).on('change','#hlm-datatable-filter select',function(e){

			e.preventDefault();

			$('#hlm-load-status').val(0);

			hlm_datatable.ajax.reload();
			hlm_get_chart_data();

			var val = $('#hlm-datatable-filter select#logam').val();
			if ( val === 'platinum' ) {

				var column = hlm_datatable.column(1);
				column.visible(true);

				var column = hlm_datatable.column(2);
				column.visible(false);

				var column = hlm_datatable.column(3);
				column.visible(false);

			} else if ( val === 'palladium' ) {

				var column = hlm_datatable.column(1);
				column.visible(false);

				var column = hlm_datatable.column(2);
				column.visible(true);

				var column = hlm_datatable.column(3);
				column.visible(false);

			} else if ( val === 'rhadium' ) {

				var column = hlm_datatable.column(1);
				column.visible(false);

				var column = hlm_datatable.column(2);
				column.visible(false);

				var column = hlm_datatable.column(3);
				column.visible(true);

			} else {

				var column = hlm_datatable.column(1);
				column.visible(true);

				var column = hlm_datatable.column(2);
				column.visible(true);

				var column = hlm_datatable.column(3);
				column.visible(true);

			}

		});

	}

	$(document).on('change','.calc-field',function(e){
		$('.hlm-harga-usd').text('_');
		$('.hlm-harga-result').text('_');
	});

	$(document).on('change','#calc_title',function(e){

		e.preventDefault();

		var calc_weight = '';
		var calc_pt = '';
		var calc_pd = '';
		var calc_ph = '';
		var val = $(this).val();
		var calc_titles = hlm_vars.calculator_title;

		if ( val && val in calc_titles ) {
			calc_weight = calc_titles[val].weight;
			calc_pt = calc_titles[val].pt;
			calc_pd = calc_titles[val].pd;
			calc_ph = calc_titles[val].ph;
		}

		$('#calc_weight').val(calc_weight);
		$('#calc_pt').val(calc_pt);
		$('#calc_pd').val(calc_pd);
		$('#calc_ph').val(calc_ph);

	});

	$(document).on('change','#mata_uang',function(e){

		e.preventDefault();

		var val = $(this).val();
		$('.hlm-harga-result-currency').text(val);
		$('.hlm-harga-result').text('_');

	});

	$(document).on('submit','#kalkulator-logam-mulia',function(e){

		e.preventDefault();

		var formdata = new FormData(this);

		$.ajax({
			url: hlm_vars.count_kalkulator_harga_logam_mulia.ajax_url,
			type: 'post',
			data: formdata,
			processData: false,
			contentType: false,
			beforeSend: function(){
				
				$.blockUI({ 
					message: '<p style="font-size:18px">Please wait...</p>',
					css: { 
						backgroundColor: 'transparent', 
						color: '#fff',
						border: 0
					} 
				});

			},
			success: function(response){

				$.unblockUI();

				$('.hlm-harga-usd').text(response.harga_usd);
				$('.hlm-harga-result').text(response.harga_konversi);

			}
		});

	});

})( jQuery );
