$(document).ready(function(){
	initPopups();
	initTabs();
	initSlider();
	function initSlider(){
		if($(".vip-frame__slider").length){
			$(".vip-frame__slider").slick({
				dots: false,
				infinite: true,
				speed: 500,
				cssEase: 'linear',
				arrows: false,
				autoplay: true,
				autoplaySpeed: 4000,
				fade: false,
				slidesToShow: 4,
				slidesToScroll: 1,
				responsive: [
					{
						breakpoint: 1000,
						settings: {
						slidesToShow: 3,
						arrows: true
						}
					},
					{
						breakpoint: 768,
						settings: {
						slidesToShow: 2,
						arrows: true
						}
					}
					,
					{
						breakpoint: 640,
						settings: {
						slidesToShow: 1,
						arrows: true
						}
					}
				]
			});
		}
		if($(".command__slider").length){
			$(".command__slider").slick({
				dots: false,
				infinite: true,
				speed: 500,
				cssEase: 'linear',
				arrows: false,
				autoplay: true,
				autoplaySpeed: 4000,
				fade: false,
				slidesToShow: 6,
				slidesToScroll: 2,
				responsive: [
					{
						breakpoint: 1000,
						settings: {
						slidesToShow: 4,
						arrows: true
						}
					},
					{
						breakpoint: 768,
						settings: {
						slidesToShow: 3,
						arrows: true
						}
					},
					{
						breakpoint: 640,
						settings: {
						slidesToShow: 2,
						arrows: true
						}
					},
					{
						breakpoint: 380,
						settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: true
						}
					}
				]
			});
		}
		if($(".news-block__slider").length){
			if($(window).width() > 1000){
				var _rows = 2
			} else{
				var _rows = 1
			}
			$(".news-block__slider").slick({
				dots: false,
				infinite: true,
				speed: 500,
				cssEase: 'linear',
				arrows: false,
				autoplay: true,
				autoplaySpeed: 4000,
				fade: false,
				slidesToShow: 4,
				slidesToScroll: 1,
				rows: _rows,
				responsive: [
					{
						breakpoint: 1000,
						settings: {
						//centerMode: true,
						slidesToShow: 4,
						arrows: true
						}
					},
					{
						breakpoint: 850,
						settings: {
						slidesToShow: 3,
						arrows: true
						}
					},
					{
						breakpoint: 640,
						settings: {
						slidesToShow: 2,
						arrows: true
						}
					},
					{
						breakpoint: 480,
						settings: {
						slidesToShow: 1,
						arrows: true
						}
					}
				]
			});
		}
	}


	$('.price-slider').slick({
		slidesToShow:3,
		infinite:false,
		mobileFirst:true,
		responsive: [
			{
				breakpoint:420,
				settings:{
					slidesToShow:4
				}
			},
			{
				breakpoint:600,
				settings:{
					slidesToShow:5
				}
			},
			{
				breakpoint:750,
				settings:{
					slidesToShow:6
				}
			}
		]
	});

	$('.tour-cost .set-info.mobile-expanded h3').on('click', function() {
		$(this).closest('.col').toggleClass('open');
	});

	initRoutsSlider();
	initAnimalsSlider();
	initAccordion();
	initPackagesSlider();
	initParksSlider();
	initImgSlider();
	$('.packages-list.type2 .packages-item .description').matchHeight();
	initWorkSlider();
	initArticlesList();
	initClientsSlider();
	initVacanciesList();
	initScrollBtn();
	initClock();
	initWeatherTable();
	initInvoiceForm();
    initJoinGroupForm();
    initContactGroupForm();
	initPriceTabs();
	initFormPreloader();
	initEquipmentSlider();
	initPriceDetailForm();
	initDatepicker();
});

function initDatepicker() {
    $('input.date-input').each(function() {
        var format = $(this).data('format') || "d M yy";
        $(this).datepicker({
            dateFormat: format
        });
        if($(this).hasClass('from')){
            $(this).on('change',function() {
                $(this).closest('.datepicker-holder').find('input.to').datepicker( "option", "minDate", getDate( this ) );
            });
        }
        if($(this).hasClass('to')){
            $(this).on('change',function() {
                $(this).closest('.datepicker-holder').find('input.from').datepicker( "option", "maxDate", getDate( this ) );
            });
        }
        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( format, element.value );
          } catch( error ) {
            date = null;
          }
          return date;
        }
    });
};

function initPriceDetailForm() {
    var dateFormat = "d M yy",
      from = $( ".invoice-form .date-from" )
        .datepicker({
          defaultDate: "+1w"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".invoice-form .date-to" ).datepicker({
        defaultDate: "+1w"
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
};

function initEquipmentSlider() {
	$('.equipment-slider').slick({
		dots:false,
		arrows:false,
		asNavFor:'.equipment-switcher'
	});
	$('.equipment-switcher').slick({
		dots:false,
		arrows:false,
		slidesToShow:5,
		focusOnSelect:true,
		asNavFor:'.equipment-slider'
	});
};

function initFormPreloader() {
	$(window).on('enableFormLoader', function() {
		$('body').addClass('page-on-load');
	});
	$(window).on('disableFormLoader', function() {
		$('body').removeClass('page-on-load');
	});

	$(window).trigger('enableFormLoader');
};

function initPriceTabs() {
	$('.tab-type-list a').on('click', function(e) {
		e.preventDefault();
		var activeIndex = $(this).closest('li').index();
		$(this).closest('li').addClass('active').siblings('li.active').removeClass('active');
		$('.type-tabset > .tab').eq(activeIndex).addClass('active').siblings('.tab.active').removeClass('active');
	});
};

function initInvoiceForm() {
	$('.invoice-form input.text, .invoice-form textarea').on('blur', function() {
		if(($(this).hasClass('required') && $(this).val().length < 1) || $(this).is(':invalid')){
			$(this).closest('.form-row').addClass('has-error');
		} else if(!$(this).data('pattern')) {
			$(this).addClass('success');
		} else if ($(this).data('pattern')){
			var pattern = new RegExp($(this).data('pattern'), 'gi');
			if($(this).val().match(pattern)){
				$(this).addClass('success');
			} else {
				$(this).closest('.form-row').addClass('has-error');
			}
		}
	});
	$('.invoice-form input.text, .invoice-form textarea').on('focus', function() {
		$(this).removeClass('success');
		$(this).closest('.form-row').removeClass('has-error');
	});

	$('.invoice-form').on('submit', function() {
		$(this).find('input.text, textarea').blur();
		if($(this).find('.has-error').length){
			return false;
		}
	});
};

function initJoinGroupForm() {
	$('.join-group-form').on('submit', function() {
		$(this).find('input.text, textarea').blur();
		if($(this).find('.invalid').length){
			return false;
		}
	});
};

function initContactGroupForm() {
	$('.contact-form').on('submit', function() {
		$(this).find('input.text, textarea').blur();
		if($(this).find('.invalid').length){
			return false;
		}
	});
};

function initWorkSlider() {
	$('.work-slider').slick({
		slidesToScroll:4,
		slidesToShow:4,
		arrows:false,
		dots:true,
		responsive: [
			{
				breakpoint:851,
				settings:{
					slidesToScroll:3,
					slidesToShow:3,
					arrows:true,
					dots:false,
				}
			},
			{
				breakpoint:681,
				settings:{
					slidesToScroll:2,
					slidesToShow:2,
					arrows:true,
					dots:false,
				}
			},
			{
				breakpoint:401,
				settings:{
					slidesToScroll:1,
					slidesToShow:1,
					arrows:true,
					dots:false,
				}
			}
		]
	});
	$('.work-slider .item a').matchHeight();
};

function initArticlesList() {
	$('.articles-list > li').matchHeight();

	initSlider();
	$(window).on('resize', function() {
		initSlider();
	});
	function initSlider() {
		if($(window).innerWidth() <= 1024 && !$('.articles-list').hasClass('slick-initialized')) {
			$('.articles-list').slick({
				slidesToShow:2,
				slidesToScroll:2,
				responsive:[
					{
						breakpoint:1025,
						settings: {
							adaptiveHeight:true
						}
					},
					{
						breakpoint:601,
						settings: {
							slidesToShow:1,
							slidesToScroll:1,
							adaptiveHeight:true
						}
					}
				]
			});
		} else if($(window).innerWidth() > 1024 && $('.articles-list').hasClass('slick-initialized')){
			$('.articles-list').slick('unslick');
		}
	};
};

function initClientsSlider() {
	initSlider();
	$(window).on('resize', function() {
		initSlider();
	});
	function initSlider() {
		if($(window).innerWidth() <= 850 && !$('.clients-list2').hasClass('slick-initialized')) {
			$('.clients-list2').slick({
				slidesToShow:4,
				slidesToScroll:4,
				responsive:[
					{
						breakpoint:701,
						settings: {
							slidesToShow:3,
							slidesToScroll:3
						}
					},
					{
						breakpoint:561,
						settings: {
							slidesToShow:2,
							slidesToScroll:2
						}
					},
					{
						breakpoint:401,
						settings: {
							slidesToShow:1,
							slidesToScroll:1
						}
					},
				]
			});
		} else if($(window).innerWidth() > 850 && $('.clients-list2').hasClass('slick-initialized')){
			$('.clients-list2').slick('unslick');
		}
	};
};

function initVacanciesList() {
	$('.vacancies-list > li:not(.open) .expanded').hide();

	$('.vacancies-list .title').on('click', function() {
		var $parent = $(this).closest('li');
		$parent.toggleClass('open');
		if($parent.hasClass('open')){
			$parent.find('.expanded').stop().slideDown();
			$parent
				.siblings('li.open')
				.removeClass('open')
				.find('.expanded')
				.stop()
				.slideUp();
		} else {
			$parent.find('.expanded').stop().slideUp();
		}
	});
};

function initScrollBtn() {
	$('.scroll-btn').on('click', function(e) {
		e.preventDefault();
		var dest = $($(this).attr('href')).offset().top - $('.l-header').innerHeight();
		$('html, body').stop().animate({
			scrollTop: dest
		}, 500);
	});
};

function initClock() {
	$('.time-block .time').each(function() {
		var utc = parseInt($(this).data('utc')),
			self = this;
		
		var x = new Date(),
			currentTime = ((utc * 60) + x.getTimezoneOffset())*60*1000,
			zoneTime = new Date(x.getTime()+currentTime),
			minutes = preNum(zoneTime.getMinutes()),
			seconds = preNum(zoneTime.getSeconds());
		zoneTime = zoneTime.getHours() + ':' + minutes + ':' + seconds;
		$(self).text(zoneTime);
		setInterval(function() {
			var x = new Date(),
				currentTime = ((utc * 60) + x.getTimezoneOffset())*60*1000,
				zoneTime = new Date(x.getTime()+currentTime),
				minutes = preNum(zoneTime.getMinutes()),
				seconds = preNum(zoneTime.getSeconds());
			zoneTime = zoneTime.getHours() + ':' + minutes + ':' + seconds;
			$(self).text(zoneTime);
		}, 1000);
	});
	function preNum(num) {
		if(num < 10){
			return '0' + num;
		} else {
			return num;
		}
	};
};

function initWeatherTable() {
	$('.weather-table').each(function() {
		var table = this;
		$(window).on('load resize scroll', function() {
			if(!$(table).hasClass('animate')){
				if($(window).scrollTop() + $(window).innerHeight() > $(table).offset().top){
					$(table).addClass('animate');
					$(table).animate({
						scrollLeft: 1000
					}, 2000, function() {
						$(table).animate({
							scrollLeft:0
						}, 3000);
					});
				}
			}
		});

		$(table).on('touchmove', function() {
			if(!$(this).hasClass('touched')){
				$(this).addClass('touched');
				$(this).stop();
			}
		});
	});
	$('.weather-list').each(function() {
		var table = this;
		$(window).on('load resize scroll', function() {
			if(!$(table).hasClass('animate')){
				if($(window).scrollTop() + $(window).innerHeight() > $(table).offset().top){
					$(table).addClass('animate');
					$(table).animate({
						scrollLeft: 1000
					}, 2000, function() {
						$(table).animate({
							scrollLeft:0
						}, 3000);
					});
				}
			}
		});

		$(table).on('touchmove', function() {
			if(!$(this).hasClass('touched')){
				$(this).addClass('touched');
				$(this).stop();
			}
		});
	});
};

function initImgSlider() {
	$('.default-content-section .photo-list').slick({
		dots:true,
		slidesToShow:3,
		slidesToScroll:3,
		responsive: [
			{
				breakpoint:851,
				settings: {
					slidesToShow:2,
					slidesToScroll:2
				}
			},
			{
				breakpoint:601,
				settings: {
					slidesToShow:1,
					slidesToScroll:1
				}
			}
		]
	});
};

function initParksSlider() {
	$('.parks-list-slider').slick({
		dots:true,
		autoplay:true,
		slidesToShow:3,
		slidesToScroll:3,
		responsive: [
			{
				breakpoint:1281,
				settings: {
					slidesToShow:2,
					slidesToScroll:2
				}
			},
			{
				breakpoint:601,
				settings: {
					dots:false,
					arrows:true,
					slidesToShow:1,
					slidesToScroll:1
				}
			}
		]
	});
};

function initPackagesSlider() {
	$('.packages-list').each(function() {
		if(!$(this).hasClass('type2') && !$(this).hasClass('type3')){
			$(this).slick({
				dots:true,
				slidesToShow:3,
				slidesToScroll:3,
				responsive: [
					{
						breakpoint:1281,
						settings: {
							slidesToShow:2,
							slidesToScroll:2
						}
					},
					{
						breakpoint:851,
						settings: {
							slidesToShow:1,
							slidesToScroll:1
						}
					}
				]
			});
		}
	});

	initSlider();
	$(window).on('resize', function() {
		initSlider();
	});
	function initSlider() {
		if($(window).innerWidth() <= 1024 && !$('.packages-list.type3').hasClass('slick-initialized')){
			$('.packages-list.type3').slick({
				dots:true,
				slidesToShow:2,
				slidesToScroll:2,
				responsive: [
					{
						breakpoint:681,
						settings: {
							slidesToShow:1,
							slidesToScroll:1
						}
					}
				]
			})
		} else if ($(window).innerWidth() > 1024 && $('.packages-list.type3').hasClass('slick-initialized')){
			$('.packages-list.type3').slick('unslick');
		}
	};
};


function initRoutsSlider() {
	initSlider();
	$(window).on('resize', function() {
		initSlider();
	});
	function initSlider() {
		if($(window).innerWidth() < 851 && !$('.tours-list.mobile-slider').hasClass('slick-initialized')){
			$('.tours-list.mobile-slider').slick({
				slidesToShow:2,
				responsive:[
					{
						breakpoint:601,
						settings:{
							slidesToShow:1
						}
					}
				]
			});
		} else if($(window).innerWidth() > 850 && $('.tours-list.mobile-slider').hasClass('slick-initialized')) {
			$('.tours-list.mobile-slider').slick('unslick');
		}
	};
};



function initAnimalsSlider() {
	$('.animals-list-holder .button').on('click', function(e) {
		e.preventDefault();
		$(this).closest('.animals-list-holder').toggleClass('open');
	});

	initSlider();
	$(window).on('resize', function() {
		initSlider();
	});
	function initSlider() {
		if($(window).innerWidth() < 1025 && !$('.animals-list').hasClass('slick-initialized')){
			$('.animals-list').slick({
				slidesToShow:4,
				responsive:[
					{
						breakpoint:901,
						settings:{
							slidesToShow:3
						}
					},
					{
						breakpoint:681,
						settings:{
							slidesToShow:2
						}
					},
					{
						breakpoint:481,
						settings:{
							slidesToShow:1
						}
					}
				]
			});
		} else if($(window).innerWidth() > 1024 && $('.animals-list').hasClass('slick-initialized')) {
			$('.animals-list').slick('unslick');
		}
	};
};


function initAccordion() {
	var animationSpeed = 350;
	$('.accordion-list li:not(.open) .expanded').hide();
	$('.accordion-list .heading').on('click', function(e) {
		e.preventDefault();
		$(this).closest('li').toggleClass('open');
		if($(this).closest('li').hasClass('open')){
			$(this).closest('li').find('> .expanded').stop().slideDown(animationSpeed);
			$(this)
				.closest('li')
				.siblings('li.open')
				.removeClass('open')
				.find('> .expanded')
				.stop()
				.slideUp(animationSpeed);
		} else {
			$(this).closest('li').find('> .expanded').stop().slideUp(animationSpeed);
		}
		setTimeout(function() {
			$(window).resize();
		}, animationSpeed + 10);
	});
};



function initTabs() {
	$('.tab-control>li>a').on('click', function(e) {
		e.preventDefault();
		var ind = $(this).closest('li').index();
		$(this)
			.closest('li')
			.addClass('active')
			.siblings('li.active')
			.removeClass('active');
		$(this)
			.closest('.tabset')
			.find('> .tab-body > .tab')
			.eq(ind)
			.addClass('active')
			.siblings('.tab.active')
			.removeClass('active');

		if($(window).innerWidth() < 851){
			var dest = $(this).closest('li').offset().top - $('.nav--mobile__open-n').innerHeight();
			setTimeout(function() {
				$('html, body').stop().animate({
					scrollTop: dest
				}, 500);
			}, 100);
		}
	});
};











function initPopups() {
    $('body')
    .popup({
        "opener": ".open-msg-popup",
        "popup_holder": "#msg-popup",
        "popup": ".popup",
        "close_btn": ".close-popup"
    })
    .popup({
        "opener": ".open-join-popup",
        "popup_holder": "#join-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "beforeOpen": function() {
            if ($(this).data('inline-title')) {
                var id = $(this).data('id').trim();
                var mode = $(this).data('mode').trim();
                $('#join-popup').find('.join-popup-title').html($(this).data('inline-title'));
                $('#join-popup').find('.mode_group_pu_data').val(mode);
                $('#join-popup').find('.id_group_pu_data').val(id);
            } else {
                var header = $(this).data('header').trim(); 
                var start = $(this).data('start').trim();
                var end = $(this).data('end').trim();
                var id = $(this).data('id').trim();
                var mode = $(this).data('mode').trim();
                var title = $(this).data('title').trim();
                $('#join-popup').find('.join-popup-header').html(header);
                $('#join-popup').find('.join-popup-title').html(title+', '+start+' - '+end);
                $('#join-popup').find('.mode_group_pu_data').val(mode);
                $('#join-popup').find('.id_group_pu_data').val(id);
                $('#join-popup').find('form').attr('action','/scripts/standard/order_group.php');
            }
            $('#join-popup').find('.invalid').removeClass('invalid');
            $('#join-popup').find('.popup').show();
        }
    })
    .popup({
        "opener": ".open-join-climbing-popup",
        "popup_holder": "#join-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "beforeOpen": function() {
            var header = $(this).data('header').trim(); 
            var title = $(this).data('title').trim(); 
            var count_days = $(this).data('days'); 
            var climbing_id = $(this).data('id').trim(); 
            $('#join-popup').find('.join-popup-header').html(header);
            $('#join-popup').find('.join-popup-title').html(title);
            $('#join-popup').find('.count_days_pu_data').val(count_days);
            $('#join-popup').find('.climbing_id_pu_data').val(climbing_id);
            $('#join-popup').find('form').attr('action','/scripts/standard/order_climbing.php');
            $('#join-popup').find('.invalid').removeClass('invalid');
            $('#join-popup').find('.popup').show();
        }
    })
    .popup({
        "opener": ".open-join-safari-popup",
        "popup_holder": "#join-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "beforeOpen": function() {
            var header = $(this).data('header').trim(); 
            var title = $(this).data('title').trim();
            var safari_id = $(this).data('id').trim(); 
            $('#join-popup').find('.join-popup-header').html(header);
            $('#join-popup').find('.join-popup-title').html(title);
            $('#join-popup').find('.safari_id_pu_data').val(safari_id);
            $('#join-popup').find('form').attr('action','/scripts/standard/order_safari_tour.php');
            $('#join-popup').find('.invalid').removeClass('invalid');
            $('#join-popup').find('.popup').show();
        }
    })
    .popup({
        "opener": ".open-join-tour-popup",
        "popup_holder": "#join-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "beforeOpen": function() {
            var header = $(this).data('header').trim(); 
            var title = $(this).data('title').trim(); 
            var mode = $(this).data('mode').trim();
            var excursion_id = $(this).data('id').trim();
            $('#join-popup').find('.join-popup-header').html(header);
            $('#join-popup').find('.join-popup-title').html(title);
            $('#join-popup').find('.excursion_id_pu_data').val(excursion_id);
            $('#join-popup').find('.mode_group_pu_data').val(mode);
            $('#join-popup').find('form').attr('action','/scripts/standard/order_tour.php');
            $('#join-popup').find('.invalid').removeClass('invalid');
            $('#join-popup').find('.popup').show();
        }
    })
    .popup({
        "opener": ".open-contact-popup",
        "popup_holder": "#contact-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "beforeOpen": function() {
            $('#contact-popup').find('.invalid').removeClass('invalid');
            $('#contact-popup').find('.popup').show();
        }
    })
    .popup({
        "opener": ".open-write-us-contact-popup",
        "popup_holder": "#contact-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "beforeOpen": function() {
            $('#contact-popup').find('form').attr('action','/scripts/standard/write_us_form.php');
            $('#contact-popup').find('.invalid').removeClass('invalid');
            $('#contact-popup').find('.popup').show();
        }
    })
    .popup({
        "opener": ".open-review-popup",
        "popup_holder": "#review-popup",
        "popup": ".popup",
        "close_btn": ".close-popup",
        "close": function() {
        	$('.reviews-list > li.opened').removeClass('opened');
        }
    })
    .popup({
        "opener": ".open-confirm-popup",
        "popup_holder": "#confirm-popup",
        "popup": ".popup",
        "close_btn": ".close-popup"
    })
    .popup({
        "opener": ".open-invoice-popup",
        "popup_holder": "#invoice-popup",
        "popup": ".popup",
        "close_btn": ".close-popup"
    })
    .popup({
        "opener": ".open-language-popup",
        "popup_holder": "#language-popup",
        "popup": ".popup",
        "close_btn": ".close-popup"
    })
    .popup({
        "opener": ".open-price-detail-popup",
        "popup_holder": "#price-detail-popup",
        "popup": ".popup",
        "close_btn": ".close-popup"
    })


    $('.reviews-list .read-more-link').on('click', function(e) {
    	e.preventDefault();
    	var rate,
    		title = $(this).closest('li').find('.title').text(),
    		reviewer = $(this).closest('li').find('.reviewer').text(),
    		ico = $(this).closest('li').find('.info-panel .ico').html(),
    		body = $(this).closest('li').find('.full-review-text').text();

    	if($(this).closest('li').find('.rate-list').length){
    		$('#review-popup .reviews-list .rate-list2').removeClass('rate-list2').addClass('rate-list');
    		rate = $(this).closest('li').find('.rate-list li.active').length;
	    	$('#review-popup .reviews-list .rate-list li').removeClass('active');
	    	for(var i = 0; i < rate; i++){
	    		$('#review-popup .reviews-list .rate-list li').eq(i).addClass('active');
	    	}
    	} else if($(this).closest('li').find('.rate-list2').length) {
    		$('#review-popup .reviews-list .rate-list').removeClass('rate-list').addClass('rate-list2');
    		rate = $(this).closest('li').find('.rate-list2 li.active').length;
    		$('#review-popup .reviews-list .rate-list2 li').removeClass('active');
	    	for(var i = 0; i < rate; i++){
	    		$('#review-popup .reviews-list .rate-list2 li').eq(i).addClass('active');
	    	}
    	}

    	$(this)
    		.closest('li')
    		.addClass('opened')
    		.siblings('li.opened')
    		.removeClass('opened');

    	$('#review-popup .reviews-list .title').text(title);
    	$('#review-popup .reviews-list .reviewer').text(reviewer);
    	$('#review-popup .reviews-list .reviewer-info .ico').html(ico);
    	$('#review-popup .reviews-list .review-body p').text(body);

    	$('#review-popup').popup('show');
    });


	$('#review-popup .btn-panel a').on('click', function(e) {
    	e.preventDefault();

    	$('#review-popup').addClass('on-load');

    	var $activeReview = $('.reviews-list > li.opened'),
	    	self = this,
    		$nextReview;


    	if($(self).hasClass('next')){
    		if($activeReview.next().length){
    			$nextReview = $activeReview.next();
    		} else {
    			$nextReview = $activeReview.closest('.reviews-list').find('li:first-child');
    		}
    	} else if($(self).hasClass('prev')){
    		if($activeReview.prev().length){
    			$nextReview = $activeReview.prev();
    		} else {
    			$nextReview = $activeReview.closest('.reviews-list').find('li:last-child');
    		}
    	}

    	setTimeout(function() {
	    	$nextReview.find('.read-more-link').click();
	    }, 150);


    	$(window).resize();
    	setTimeout(function() {
	    	$(window).resize();
    		$('#review-popup').removeClass('on-load');
    	}, 300);

	});
};

$.fn.popup = function(o) {
    if (o === 'show') {
        this.fadeIn();
        $(window).resize();
    }
    if (o === 'hide') {
        this.fadeOut();
    }
    var o = $.extend({
        "opener": ".call-back a",
        "popup_holder": "#call-popup",
        "popup": ".popup",
        "close_btn": ".btn-close",
        "close": function() {},
        "beforeOpen": function(popup) {
            $(popup).css({
                'left': 0,
                'top': 0
            }).hide();
        }
    }, o);
    return this.each(function() {
        var container = $(this),
            opener = $(o.opener, container),
            popup_holder = $(o.popup_holder, container),
            popup = $(o.popup, popup_holder),
            close = $(o.close_btn, popup),
            bg = $('.bg', popup_holder),
            scroll_pos = 0;
        popup.css('margin', 0);
        opener.click(function(e) {
            o.beforeOpen.apply(this, [popup_holder]);
            popup_holder.css('left', 0);
            popup_holder.fadeIn(350);
            alignPopup();
            bgResize();
            e.preventDefault();
        });
		function alignPopup(){
			var deviceAgent = navigator.userAgent.toLowerCase();
			var agentID = deviceAgent.match(/(iphone|ipod|ipad|android)/i);
			if(agentID){
				if(popup.outerHeight()>window.innerHeight){
					popup.css({'top':$(window).scrollTop(),'left': ((window.innerWidth - popup.outerWidth())/2) + $(window).scrollLeft()});
				return false;
				}
				popup.css({
					'top': ((window.innerHeight-popup.outerHeight())/2) + $(window).scrollTop(),
					'left': ((window.innerWidth - popup.outerWidth())/2) + $(window).scrollLeft()
				});
				} else {
					if(popup.outerHeight()>$(window).outerHeight()){
						popup.css({'top':$(window).scrollTop(),'left': (($(window).width() - popup.outerWidth())/2) + $(window).scrollLeft()});
						return false;
					}
				popup.css({
					'top': (($(window).height()-popup.outerHeight())/2) + $(window).scrollTop(),
					'left': (($(window).width() - popup.outerWidth())/2) + $(window).scrollLeft()
				});
			}
			$('body').addClass('popup-open');
		}
        function bgResize() {
            var _w = $(window).width(),
                _h = $(document).height();
            bg.css({
                "height": _h,
                "width": _w + $(window).scrollLeft()
            });
        }
        $(window).resize(function() {
            if (popup_holder.is(":visible")) {
                bgResize();
                alignPopup();
            }
        });
        $(window).scroll(function(e) {
            if (popup_holder.is(":visible")) {
                var deviceAgent = navigator.userAgent.toLowerCase();
                var agentID = deviceAgent.match(/(iphone|ipod|ipad|android)/i);
                if (agentID) {
                    if (popup.outerHeight() > window.innerHeight) {
                        var scroll_s = $(document).innerHeight() - ($(document).innerHeight() - $(window).scrollTop());
                        var step = window.innerHeight - popup.outerHeight();
                        if (scroll_pos>scroll_s) {
                            if (popup.position().top<0) {
                                popup.css({top:popup.position().top+(scroll_pos-scroll_s)});
                            } else {
                                popup.css({top:0});
                            }
                        } else {
                            if (popup.position().top>step) {
                                popup.css({top:popup.position().top+(scroll_pos-scroll_s)});
                            } else {
                                popup.css({top:step});
                            }
                        }
//                        if (scroll_pos>scroll_s) {
//                            if (popup.position().top>step) {
//                                if ((popup.position().top+(scroll_s-scroll_pos))<step) {
//                                    popup.css({top:(popup.position().top+(scroll_s-scroll_pos))});
//                                } else {
//                                    popup.css({top:step});
//                                }
//                            }
//                        } else {
//                            if (popup.position().top<0) {
//                                if ((popup.position().top+(scroll_s-scroll_pos))<0) {
//                                    popup.css({top:(popup.position().top+(scroll_s-scroll_pos))});
//                                } else {
//                                    popup.css({top:0});
//                                }
//                            }
//                        }
                        scroll_pos = scroll_s;
                    }
                } else {
                    if (popup.outerHeight() > $(window).outerHeight()) {
                        var scroll_s = $(document).height() - ($(document).height() - $(window).scrollTop());
                        var step = $(window).outerHeight() - popup.outerHeight();
                        if (scroll_pos>scroll_s) {
                            if (popup.position().top<0) {
                                popup.css({top:popup.position().top+(scroll_pos-scroll_s)});
                            } else {
                                popup.css({top:0});
                            }
                        } else {
                            if (popup.position().top>step) {
                                popup.css({top:popup.position().top+(scroll_pos-scroll_s)});
                            } else {
                                popup.css({top:step});
                            }
                        }
                        scroll_pos = scroll_s;
                    }
                }
            }
        });
        if (popup_holder.is(":visible")) {
            bgResize();
            alignPopup();
        }
        close.add(bg).click(function(e) {
            var closeEl = this;
            popup_holder.fadeOut(350, function() {
                o.close.apply(closeEl, [popup_holder]);
            });
            $('body').removeClass('popup-open');
            e.preventDefault();
        });
    });
};

















/**
* jquery-match-height master by @liabru
* http://brm.io/jquery-match-height/
* License: MIT
*/

;(function(factory) { // eslint-disable-line no-extra-semi
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof module !== 'undefined' && module.exports) {
        // CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Global
        factory(jQuery);
    }
})(function($) {
    /*
    *  internal
    */

    var _previousResizeWidth = -1,
        _updateTimeout = -1;

    /*
    *  _parse
    *  value parse utility function
    */

    var _parse = function(value) {
        // parse value and convert NaN to 0
        return parseFloat(value) || 0;
    };

    /*
    *  _rows
    *  utility function returns array of jQuery selections representing each row
    *  (as displayed after float wrapping applied by browser)
    */

    var _rows = function(elements) {
        var tolerance = 1,
            $elements = $(elements),
            lastTop = null,
            rows = [];

        // group elements by their top position
        $elements.each(function(){
            var $that = $(this),
                top = $that.offset().top - _parse($that.css('margin-top')),
                lastRow = rows.length > 0 ? rows[rows.length - 1] : null;

            if (lastRow === null) {
                // first item on the row, so just push it
                rows.push($that);
            } else {
                // if the row top is the same, add to the row group
                if (Math.floor(Math.abs(lastTop - top)) <= tolerance) {
                    rows[rows.length - 1] = lastRow.add($that);
                } else {
                    // otherwise start a new row group
                    rows.push($that);
                }
            }

            // keep track of the last row top
            lastTop = top;
        });

        return rows;
    };

    /*
    *  _parseOptions
    *  handle plugin options
    */

    var _parseOptions = function(options) {
        var opts = {
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        };

        if (typeof options === 'object') {
            return $.extend(opts, options);
        }

        if (typeof options === 'boolean') {
            opts.byRow = options;
        } else if (options === 'remove') {
            opts.remove = true;
        }

        return opts;
    };

    /*
    *  matchHeight
    *  plugin definition
    */

    var matchHeight = $.fn.matchHeight = function(options) {
        var opts = _parseOptions(options);

        // handle remove
        if (opts.remove) {
            var that = this;

            // remove fixed height from all selected elements
            this.css(opts.property, '');

            // remove selected elements from all groups
            $.each(matchHeight._groups, function(key, group) {
                group.elements = group.elements.not(that);
            });

            // TODO: cleanup empty groups

            return this;
        }

        if (this.length <= 1 && !opts.target) {
            return this;
        }

        // keep track of this group so we can re-apply later on load and resize events
        matchHeight._groups.push({
            elements: this,
            options: opts
        });

        // match each element's height to the tallest element in the selection
        matchHeight._apply(this, opts);

        return this;
    };

    /*
    *  plugin global options
    */

    matchHeight.version = 'master';
    matchHeight._groups = [];
    matchHeight._throttle = 80;
    matchHeight._maintainScroll = false;
    matchHeight._beforeUpdate = null;
    matchHeight._afterUpdate = null;
    matchHeight._rows = _rows;
    matchHeight._parse = _parse;
    matchHeight._parseOptions = _parseOptions;

    /*
    *  matchHeight._apply
    *  apply matchHeight to given elements
    */

    matchHeight._apply = function(elements, options) {
        var opts = _parseOptions(options),
            $elements = $(elements),
            rows = [$elements];

        // take note of scroll position
        var scrollTop = $(window).scrollTop(),
            htmlHeight = $('html').outerHeight(true);

        // get hidden parents
        var $hiddenParents = $elements.parents().filter(':hidden');

        // cache the original inline style
        $hiddenParents.each(function() {
            var $that = $(this);
            $that.data('style-cache', $that.attr('style'));
        });

        // temporarily must force hidden parents visible
        $hiddenParents.css('display', 'block');

        // get rows if using byRow, otherwise assume one row
        if (opts.byRow && !opts.target) {

            // must first force an arbitrary equal height so floating elements break evenly
            $elements.each(function() {
                var $that = $(this),
                    display = $that.css('display');

                // temporarily force a usable display value
                if (display !== 'inline-block' && display !== 'flex' && display !== 'inline-flex') {
                    display = 'block';
                }

                // cache the original inline style
                $that.data('style-cache', $that.attr('style'));

                $that.css({
                    'display': display,
                    'padding-top': '0',
                    'padding-bottom': '0',
                    'margin-top': '0',
                    'margin-bottom': '0',
                    'border-top-width': '0',
                    'border-bottom-width': '0',
                    'height': '100px',
                    'overflow': 'hidden'
                });
            });

            // get the array of rows (based on element top position)
            rows = _rows($elements);

            // revert original inline styles
            $elements.each(function() {
                var $that = $(this);
                $that.attr('style', $that.data('style-cache') || '');
            });
        }

        $.each(rows, function(key, row) {
            var $row = $(row),
                targetHeight = 0;

            if (!opts.target) {
                // skip apply to rows with only one item
                if (opts.byRow && $row.length <= 1) {
                    $row.css(opts.property, '');
                    return;
                }

                // iterate the row and find the max height
                $row.each(function(){
                    var $that = $(this),
                        style = $that.attr('style'),
                        display = $that.css('display');

                    // temporarily force a usable display value
                    if (display !== 'inline-block' && display !== 'flex' && display !== 'inline-flex') {
                        display = 'block';
                    }

                    // ensure we get the correct actual height (and not a previously set height value)
                    var css = { 'display': display };
                    css[opts.property] = '';
                    $that.css(css);

                    // find the max height (including padding, but not margin)
                    if ($that.outerHeight(false) > targetHeight) {
                        targetHeight = $that.outerHeight(false);
                    }

                    // revert styles
                    if (style) {
                        $that.attr('style', style);
                    } else {
                        $that.css('display', '');
                    }
                });
            } else {
                // if target set, use the height of the target element
                targetHeight = opts.target.outerHeight(false);
            }

            // iterate the row and apply the height to all elements
            $row.each(function(){
                var $that = $(this),
                    verticalPadding = 0;

                // don't apply to a target
                if (opts.target && $that.is(opts.target)) {
                    return;
                }

                // handle padding and border correctly (required when not using border-box)
                if ($that.css('box-sizing') !== 'border-box') {
                    verticalPadding += _parse($that.css('border-top-width')) + _parse($that.css('border-bottom-width'));
                    verticalPadding += _parse($that.css('padding-top')) + _parse($that.css('padding-bottom'));
                }

                // set the height (accounting for padding and border)
                $that.css(opts.property, (targetHeight - verticalPadding) + 'px');
            });
        });

        // revert hidden parents
        $hiddenParents.each(function() {
            var $that = $(this);
            $that.attr('style', $that.data('style-cache') || null);
        });

        // restore scroll position if enabled
        if (matchHeight._maintainScroll) {
            $(window).scrollTop((scrollTop / htmlHeight) * $('html').outerHeight(true));
        }

        return this;
    };

    /*
    *  matchHeight._applyDataApi
    *  applies matchHeight to all elements with a data-match-height attribute
    */

    matchHeight._applyDataApi = function() {
        var groups = {};

        // generate groups by their groupId set by elements using data-match-height
        $('[data-match-height], [data-mh]').each(function() {
            var $this = $(this),
                groupId = $this.attr('data-mh') || $this.attr('data-match-height');

            if (groupId in groups) {
                groups[groupId] = groups[groupId].add($this);
            } else {
                groups[groupId] = $this;
            }
        });

        // apply matchHeight to each group
        $.each(groups, function() {
            this.matchHeight(true);
        });
    };

    /*
    *  matchHeight._update
    *  updates matchHeight on all current groups with their correct options
    */

    var _update = function(event) {
        if (matchHeight._beforeUpdate) {
            matchHeight._beforeUpdate(event, matchHeight._groups);
        }

        $.each(matchHeight._groups, function() {
            matchHeight._apply(this.elements, this.options);
        });

        if (matchHeight._afterUpdate) {
            matchHeight._afterUpdate(event, matchHeight._groups);
        }
    };

    matchHeight._update = function(throttle, event) {
        // prevent update if fired from a resize event
        // where the viewport width hasn't actually changed
        // fixes an event looping bug in IE8
        if (event && event.type === 'resize') {
            var windowWidth = $(window).width();
            if (windowWidth === _previousResizeWidth) {
                return;
            }
            _previousResizeWidth = windowWidth;
        }

        // throttle updates
        if (!throttle) {
            _update(event);
        } else if (_updateTimeout === -1) {
            _updateTimeout = setTimeout(function() {
                _update(event);
                _updateTimeout = -1;
            }, matchHeight._throttle);
        }
    };

    /*
    *  bind events
    */

    // apply on DOM ready event
    $(matchHeight._applyDataApi);

    // update heights on load and resize events
    $(window).bind('load', function(event) {
        matchHeight._update(false, event);
    });

    // throttled update heights on resize events
    $(window).bind('resize orientationchange', function(event) {
        matchHeight._update(true, event);
    });

});
