$(document).ready(function(){
	initFlexImage();
	function initFlexImage(){
		$('.blog-frame .visual img, .flex-img').each(function(){
			$(this).closest('.visual, .flex-img-parent').css({
				'background':'url('+$(this).attr('src')+') no-repeat 50% 50%',
				'background-size':'cover'
			})
		});
	}
});
