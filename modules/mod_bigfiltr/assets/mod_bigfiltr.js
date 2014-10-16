
jQuery(function($){
	var url_tpl = 'index.php?option=com_virtuemart&Itemid=2';
	var search_param = '';
	var limit = parseInt($('#limit').val());
	
	$('#add_btn').data('offset', 0);
	
	$('#car_marka').change(function(){
		search();
	});
	$('#car_model').change(function(){
		search();
	});
	$('#car_year1').change(function(){
		search();
	});
	$('#car_year2').change(function(){
		search();
	});
	$('#car_search').change(function(){
		search();
	});
	
	function search() {		
		get_search_param();
		if (search_param){
			document.location = url_tpl + search_param;
		}
	}
	
	function get_search_param() {
		var marka = $('#car_marka').val();
		var model = $('#car_model').val();
		var year1 = $('#car_year1').val();
		var year2 = $('#car_year2').val();
		var search = $('#car_search').val();
		
		search_param = '';
		search_param += '&marka=' + marka;
		search_param += '&model=' + model;
		search_param += '&find_text=' + search;
		search_param += '&data_in=' + year1;
		search_param += '&data_out=' + year2;
	}
	
	$('.filtr_el').change(function() {
		if ($(this).attr('type') == 'checkbox' && $(this).attr('id') != 'filtr_all' && $(this).is(':checked') == false) {
			$('#filtr_all').removeAttr('checked');
		}
		var all = $('#filtr_all').is(':checked');
		if (all == true) {
			$('.chb').attr('checked','checked');
		}
		
		search();
	});
	function formReset(){
		$('#car_marka').val('');
		$('#car_model').val('');
		$('#car_year1').val('');
		$('#car_year2').val('');
		$('#car_search').val('');
		search();
	}
	
	$('#reset').click(function(){
		formReset();
	});
	
	$('#search_img').click(function(){
		search();
	});
});