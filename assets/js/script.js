$( document ).ready(function() {
    
    $('#banner').cycle({ 
	    fx: 'fade',
	    speed: 'fast'
	});
	
	$('#questions ol').hide();
	$('#questions ol:first').show();
	$('#questions nav a:first').addClass('active');
	$('#questions nav a').click(function(){
		$('#questions nav a').removeClass('active');
		$(this).addClass('active');
		var currentTab = $(this).attr('href');
		$('#questions ol').hide();
		$(currentTab).show();
		return false;
	});
    
});