$( document ).ready(function() {
    
    $('#banner .slides').cycle({ 
	    fx: 'fade',
	    speed: 'fast',
	    timeout: 5000, 
	    pause: true,
	    next: '.next',
	    prev: '.prev'
	});
	
	$('#banner .images ul').cycle({ 
	    fx: 'fade', 
	    speed: 'fast',
	    timeout: 1000,
	    pause: true
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