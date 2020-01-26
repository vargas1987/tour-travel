$(document).ready(function(){$('.order_vip_tour').click(function(){var text=$(this).parent().parent().find('.for_header_vip_modal').html();$('.header_vip_modal').html(text);var mode=$(this).parent().parent().find('.for_mode_vip_modal').val();$('.mode_vip_modal').val(mode);var img=$(this).parent().parent().find('.for_img_vip_modal').val();$('.img_vip_modal').attr('src',img);});$('#frm_order').find('#name_order').blur(function(){test_order_name(this);});$('#frm_order').find('#name_order').click(function(){$(this).parent().parent().find('.error-text_name.error-text').remove();});$('#frm_order').find('#num_order').blur(function(){test_order_num(this);});$('#frm_order').find('#num_order').click(function(){$(this).parent().parent().find('.error-text').remove();});$('#frm_order').find('#mail_order').blur(function(){test_order_mail(this);});$('#frm_order').find('#mail_order').click(function(){$(this).parent().parent().find('.error-text_mail.error-text').remove();});$('#frm_order').find('#text_order').blur(function(){test_order_text(this);});$('#frm_order').find('#text_order').click(function(){$(this).parent().find('.error-text').remove();});function test_order_name(elem){$(elem).parent().parent().find('correct-icon_name.correct-icon').remove();$(elem).parent().parent().find('error-text_name.error-text').remove();if($(elem).val().trim()!=""){$('<div class="correct-icon correct-icon_name" style="vertical-align: baseline; width: auto;"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent().parent().find('label.name_lbl'));$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите Ваше имя";break;case"en":data="Type in your name";break;case"cn":data="Type in your name";break;}
$('<div class="error-text error-text_name" style="right: 312px; top: 34px;">'+ data+'</div>').appendTo($(elem).parent().parent());return false;}
return true;}
function test_order_num(elem){$(elem).parent().parent().find('.correct-icon').remove();$(elem).parent().parent().find('.error-text').remove();if(!isNaN(parseInt($(elem).val()))){$('<div class="correct-icon"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent().parent());$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите кол-во участников";break;case"en":data="Type this field";break;case"cn":data="Type this field";break;}
$('<div class="error-text" >'+ data+'</div>').appendTo($(elem).parent().parent());return false;}
return true;}
function test_order_mail(elem){$(elem).parent().parent().find('.correct-icon_mail.correct-icon').remove();$(elem).parent().parent().find('.error-text_mail.error-text').remove();if(isValidEmail($(elem).val())){$('<div class="correct-icon correct-icon_mail" style="vertical-align: baseline; width: auto;"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent().parent().find('label.mail_lbl'));$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите Ваш E-mail";break;case"en":data="Type in your E-mail";break;case"cn":data="Type in your E-mail";break;}
$('<div class="error-text error-text_mail" style="top: 34px; right: 0px;">'+ data+'</div>').appendTo($(elem).parent().parent());return false;}
return true;}
function test_order_text(elem){$(elem).parent().find('.correct-icon').remove();$(elem).parent().find('.error-text').remove();if($(elem).val().trim()!=""){$('<div class="correct-icon" style="max-width: 60%; top: 6px; right: 0px; position: absolute;"><span class="form-validation-icon form-validation-ok"></span></div>').appendTo($(elem).parent());$(elem).removeAttr('incorrect');$(elem).attr('correct');}else{$(elem).attr('incorrect');$(elem).removeAttr('correct');var data="";switch(lang){case"ru":data="Укажите Ваши пожелания";break;case"en":data="Type this field";break;case"cn":data="Type this field";break;}
$('<div class="error-text" style="top: 13px; right: 0px; position: absolute; max-width: 60%;">'+ data+'</div>').prependTo($(elem).parent());return false;}
return true;}
$('#frm_order').find('#accept_order').click(function(){var ok=true;if(!test_order_name($('#frm_order').find('#name_order')))
ok=false;if(!test_order_num($('#frm_order').find('#num_order')))
ok=false;if(!test_order_mail($('#frm_order').find('#mail_order')))
ok=false;if(!test_order_text($('#frm_order').find('#text_order')))
ok=false;if(!ok)
return false;});});