$(document).ready(function() {
//	open-mob-menu
    $('.nav--mobile__open-n').click(function() {
        $('.js-header').addClass('active');
        $('body').addClass('menu-active');
        $('.nav--mobile__bg').fadeIn();
    });
	
//  open conten mob-menu  
    if($('.js-header-mob-content__link').length) {
			$('.js-header-mob-content__link').click(function()
			{
				$(this).next().slideToggle();
				$(this).toggleClass('open');
				return false;
			});
		}
		
	
// price table mob
		if($('.js-tab-row--main').length) {
			$('.js-tab-row--main').click(function()
			{
				$(this).next().slideToggle();
				$(this).toggleClass('open');
				return false;
			});
		}
	
// price table desctop
		if($('.js-n-plan-info').length) {
			$('.js-n-plan-info').click(function()
			{
				$(this).next('.js-n-plan-info__more').find('.js-n-plan-info__more-block').slideToggle();
				$(this).toggleClass('active');
				return false;
			});
		}
	
//scroll to id in price mob
		if($('.js-place-desctiption-mob__bnts').length) {
			$(".js-place-desctiption-mob__bnts").on("click","a", function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top-70}, 1500);
    });
		}
	

//validation form 
	
	function validateRegExp(regExp) {
        return function(value) {
            return regExp.test(value)
        }
    }

    function validateRequired(value) {
        return !!value;
    }

    function validateElement(data, target) {
        if (!data || !target) return false;

        var name = target.name;
        var value = target.value;
        var isValid = !data[name].some(function(el) {
            return el(value) === false;
        });

        if (isValid) {
            $(target).parent().addClass('valid');
            $(target).parent().removeClass('invalid');
        } else {
            $(target).parent().addClass('invalid');
            $(target).parent().removeClass('valid');
        }

        return isValid
    }

    function forceValidate(data, selector) {
        var key,
            value,
            isValid = true;

        for (key in data) {
            if (!validateElement(data, $('[name=' + key + ']' + selector)[0])) {
                isValid = false;
            }
        }

        return isValid;
    }

    var formData = {
        name: [
            validateRegExp(/^([а-я]|[А-Я]|[a-z]|[A-z]){2,40}$/)
        ],
        email: [
            validateRegExp(/^.+@.+[.].{2,}$/i)
        ],
        phone: [
            validateRegExp(/[+38 (]+(([\d]){3})+[)]+ (([\d]){3})+(( [\d]{2}){2})/)
        ],
				number: [
						validateRegExp(/^[0-9]+$/)
				],
				textarea: [
            validateRegExp(/^([а-я]|[А-Я]|[a-z]|[A-z]){2,1000}$/)
        ]
			
    }

    var FORM_SELECTOR1 = '.form-validation-1'
   
     $('.js-trip-details__form input:not([type="submit"])')
        .blur(function(event) {
            event.preventDefault();
            forceValidate(formData, FORM_SELECTOR1)
        })
	
			$('.js-trip-details__form textarea')
        .blur(function(event) {
            event.preventDefault();
            forceValidate(formData, FORM_SELECTOR1)
        })
  
    // end validation

//		if($('#trip_details_form')[0]){
//		
//			$('#trip_details_form').validate({
//
//				errorClass: "error",
//				validClass: "success",
//
//				highlight: function(element, errorClass, validClass) {
//
//					$(element).parent().addClass(errorClass).removeClass(validClass);
//					checkBoxHeight();
//
//				},
//
//				unhighlight: function(element, errorClass, validClass) {
//
//					$(element).parent().removeClass(errorClass).addClass(validClass);
//
//				},
//
//				rules: {
//
//						trip_details_name: {
//							required: true
//						},
//
//						trip_details_email: {
//							email: true,
//							required: true
//						},
//						
//						trip_details_number: {
//							number: true,
//							required: true
//						},
//
//						trip_details_textarea: {
//							required: true
//						}
//
//				},			
//				messages: {
//					trip_details_name: "Tipe in your name here",
//					trip_details_email: "Tipe in your e-mail",
//					trip_details_number: "Tipe in how many people will go with you",
//					trip_details_textarea: "Tipe this field"
//				}
//			});
//		}
	
	
	
	
	
});