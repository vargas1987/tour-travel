$(document).ready(function(){firstTime=false;$('#frm_order_tour').find('#name_order').blur(function(){test_cost_name(this);});$('#frm_order_tour').find('#name_order').click(function(){$(this).parent().parent().find('.error-text_name.error-text').remove();});$('#frm_order_tour').find('#mail_order').blur(function(){test_cost_mail(this);});$('#frm_order_tour').find('#mail_order').click(function(){$(this).parent().parent().find('.error-text_mail.error-text').remove();});$('#frm_order_tour').find('#mes_order').blur(function(){test_cost_text(this);});$('#frm_order_tour').find('#mes_order').click(function(){$(this).parent().find('.error-text').remove();});function test_cost_name(elem){$(elem).parent().parent().find('.correct-icon_name.correct-icon').remove();$(elem).parent().parent().find('.error-text_name.error-text').remove();if($(elem).val().trim()!=""){$('<div class="correct-icon correct-icon_name" style="vertical-align: baseline; width: auto;"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent().parent().find('label.name_lbl'));$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите Ваше имя";break;case"en":data="Type in your name";break;case"cn":data="Type in your name";break;}
$('<div class="error-text error-text_name" style="right: 312px; top: 34px;">'+ data+'</div>').appendTo($(elem).parent().parent());return false;}
return true;}
function test_cost_mail(elem){$(elem).parent().parent().find('.correct-icon_mail.correct-icon').remove();$(elem).parent().parent().find('.error-text_mail.error-text').remove();if(isValidEmail($(elem).val())){$('<div class="correct-icon correct-icon_mail" style="vertical-align: baseline; width: auto;"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent().parent().find('label.mail_lbl'));$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите Ваш E-mail";break;case"en":data="Type in your E-mail";break;case"cn":data="Type in your E-mail";break;}
$('<div class="error-text error-text_mail" style="top: 34px;">'+ data+'</div>').appendTo($(elem).parent().parent());return false;}
return true;}
function test_cost_text(elem){$(elem).parent().find('.correct-icon').remove();$(elem).parent().find('.error-text').remove();if($(elem).val().trim()!=""){$('<div class="correct-icon" style="max-width: 60%; top: 6px; right: 0px; position: absolute;"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent());$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите Ваши пожелания";break;case"en":data="Type this field";break;case"cn":data="Type this field";break;}
$('<div class="error-text" style="top: 13px; right: 0px; position: absolute; max-width: 60%;">'+ data+'</div>').prependTo($(elem).parent());return false;}
return true;}
$('#frm_order_tour').find('#accept_request_cost').click(function(){var ok=true;if(!test_cost_name($('#frm_order_tour').find('#name_order')))
ok=false;if(!test_cost_mail($('#frm_order_tour').find('#mail_order')))
ok=false;if(!test_cost_text($('#frm_order_tour').find('#mes_order')))
ok=false;if(!ok)
return false;$('#frm_order_tour').submit();});$('#popup-book').click(function(){$('.overlay').remove();});$('#popup-book').find('.icon-close').click(function(){$('#popup-book').fadeOut('fast',function(){$('.overlay').click();$('.overlay').remove();});});$('#popup-book').click(function(){$('<div class="overlay1"></div>').appendTo('body');setTimeout(function(){$('.overlay1').removeClass('overlay1').addClass('overlay');},0);});$('#close_book_modal').click(function(){$('#popup-book').fadeOut('fast',function(){$('.overlay').remove();});});});