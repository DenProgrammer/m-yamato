jQuery("document").ready(function($){
	$('ul.toppanel li a').click(function(){
		var href = $(this).attr('href');
		
		if (href == '/'){
			var cls = $(this).parent().attr('id');
				
			if ($(this).parent().hasClass('active')) {
				$('div.' + cls).removeClass('menupage_active');
				$(this).parent().removeClass('active');
			} else {
				$('ul.toppanel li').removeClass('active');
				$(this).parent().addClass('active');
				$('div.topmenu div.menupage').removeClass('menupage_active');
				$('div.' + cls).addClass('menupage_active');
			}
		} else {
			document.location = href;
		}
		return false;
	});
});