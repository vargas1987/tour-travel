$(document).ready(function(){setTimeout(function(){$('.unshow_block').css('position','absolute');$('.unshow_block').css('visibility','hidden');},0);if(id_review)
$('.review_'+ id_review).find('.show_review_data').click();$('.unshow_btn').click(function(){$('.unshow_block').css('position','relative');$('.unshow_block').css('visibility','visible');$(this).remove();$(window).trigger('resize').trigger('scroll');});$('#popup-testimonial-full').find('.prev').click(function(){$('#popup-testimonial-full').find('.icon-close').click();setTimeout(function(){var prev=parseInt($('#full_review_num').val())- 1;var count_reviews=$('.show_review_data').length- 1;if($('.rev_'+ prev).length!=0)
$('.rev_'+ prev).find('.list-testimonials__lnk-more').click();else
$('.rev_'+ count_reviews).find('.list-testimonials__lnk-more').click();},500);});$('#popup-testimonial-full').find('.next').click(function(){$('#popup-testimonial-full').find('.icon-close').click();setTimeout(function(){var next=parseInt($('#full_review_num').val())+ 1;if($('.rev_'+ next).length!=0)
$('.rev_'+ next).find('.list-testimonials__lnk-more').click();else
$('.rev_0').find('.list-testimonials__lnk-more').click();},500);});$('.add-photo__button').fileupload({dataType:'json',done:function(e,data){if(data.result.status=="error"){alert("Ошибка загрузки изображения!");return;}
cropImage(data.result.name);},fail:function(e,data){alert("Ошибка загрузки изображения! (1)");}});$('#accept_rev').click(function(){var name=$('#rr_name').val().trim();var mail=$('#rr_mail').val().trim();var text=$('#rr_text').val().trim();if(!(name!=""&&mail!=""&&text!="")){alert("Заполните все обязательные поля!");return false;}
if(!isValidEmail(mail)){alert("Email введен неверно!");return false;}
$('#rate_star').val($('.raty').find('input').val());$('#frm_rev').submit();});function openModal(popup){$('body').append('<div class="overlay"></div>');if(popup.is('.non-fixed')){popup.fadeIn(300).position({of:window,my:"center top",at:"center top+50px"});}else{var height=$(popup).height()/ 2;var width=$(popup).width()/ 2;popup.css({top:"50%",marginTop:"-"+ height+"px",left:"50%",marginLeft:"-"+ width+"px"});popup.fadeIn(300).position({of:window});}}
function cropImage(picture){$('#crop_picture').attr('src',picture);var cropper=new Cropper(document.getElementById('crop_picture'),{aspectRatio:1/1,viewMode:3,minContainerWidth:300,minContainerHeight:300,ready:function(){cropper.zoomTo(-0.5);}});$('#cl_btn_o').unbind();$('#cl_btn_o').click(function(){console.log("x");cropper.destroy();});$('body').on('click','.overlay, .popup .close',function(){console.log("body x");cropper.destroy();});$('#accept_crop').unbind();$('#accept_crop').click(function(){cropper.getCroppedCanvas().toBlob(function(blob){var formData=new FormData();formData.append('upl',blob);$.ajax('/scripts/standard/upload_ava_resize.php',{method:"POST",data:formData,dataType:"json",processData:false,contentType:false,success:function(data){$('#set_upl_photo').css('background-image','url('+ data.name+')');$('#set_upl_photo').find('.no-photo-text').css('display','none');$('#img_ava').val(data.name);$('#cl_btn_o').click();},error:function(){console.log('Upload error');}});});});openModal($("#popup-crop"));}});