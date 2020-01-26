$(document).ready(function(){
	initAccordion();
	function initAccordion() {
		if($('.accordion').length){
			$(".item .heading").click(function(e){
				$(this).next().slideToggle(400,function(){
					$(this).parent().toggleClass('active');
				});
				$(this).parent().siblings(".active").children(".expanded").slideUp(400,function(){
					$(this).parent().removeClass('active');
				});
				e.preventDefault();
			})
		}
	};
});