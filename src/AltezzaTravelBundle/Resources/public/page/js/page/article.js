$(document).ready(function(){var images=$('.only_text_article img');var count_images=images.length;var count_group=0;for(var i=0;i<count_images;i++){var current_elem=images[i];var first_elem=current_elem;while($(current_elem).next().prop("tagName")=="img"||$(current_elem).next().prop("tagName")=="IMG"){current_elem=$(current_elem).next();$(current_elem).addClass('common_image_gr_'+ count_group);$(current_elem).css('display','none');i++;}
$(first_elem).addClass('common_image_gr_'+ count_group);$(first_elem).css('display','none');count_group++;}
for(var i=0;i<count_group;i++){var imgs=$('.only_text_article .common_image_gr_'+ i);if(imgs.length==0)
continue;var count_three_rows=Math.floor(imgs.length/3);if(count_three_rows>=1)
count_three_rows--;var count_two_rows=Math.floor((imgs.length- count_three_rows*3)/ 2);
var count_one_row=imgs.length-(count_two_rows*2+ count_three_rows*3);var insert_text='<div style="margin-bottom: 10px;">';for(var j=0;j<count_one_row;j++){var title="";if($(imgs[j]).attr('title'))
title=$(imgs[j]).attr('title');var alt="";if($(imgs[j]).attr('alt'))
alt=$(imgs[j]).attr('alt');insert_text='<div class="img-line clearfix common_l"><div class="img-line--item"><img rel="group1" data-glisse-big="'+ $(imgs[j]).attr('src')+'" class="myphotos artile_myphotos" src="'+ $(imgs[j]).attr('src')+'" style="width: 100%" title="'+ title+'" alt="'+ alt+'">';if($(imgs[j]).attr('title'))
insert_text+='<span class="title">'+ $(imgs[j]).attr('title')+'</span>';insert_text+='</div></div>';}
if(count_two_rows>0){for(var j=0;j<count_two_rows;j++){insert_text+='<div class="img-line img-line--2 clearfix common_l second_img_line">';for(var k=0;k<=1;k++){var title="";if($(imgs[count_one_row+ j*2+ k]).attr('title'))
title=$(imgs[count_one_row+ j*2+ k]).attr('title');var alt="";if($(imgs[count_one_row+ j*2+ k]).attr('alt'))
alt=$(imgs[count_one_row+ j*2+ k]).attr('alt');insert_text+='<div class="img-line--item"><img rel="group1" data-glisse-big="'+ $(imgs[count_one_row+ j*2+ k]).attr('src')+'" class="myphotos artile_myphotos" src="'+ $(imgs[count_one_row+ j*2+ k]).attr('src')+'" title="'+ title+'" style="width: 100%" alt="'+ alt+'">';if($(imgs[count_one_row+ j*2+ k]).attr('title'))
insert_text+='<span class="title">'+ $(imgs[count_one_row+ j*2+ k]).attr('title')+'</span>';insert_text+='</div>';}
insert_text+='</div>';}}
if(count_three_rows>0){for(var j=0;j<count_three_rows;j++){insert_text+='<div class="img-line img-line--3 clearfix third_img_line">';for(var k=0;k<=2;k++){var title="";if($(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('title'))
title=$(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('title');var alt="";if($(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('alt'))
alt=$(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('alt');insert_text+='<div class="img-line--item"><img rel="group1" data-glisse-big="'+ $(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('src')+'" class="myphotos artile_myphotos" src="'+ $(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('src')+'" title="'+ title+'" style="width: 100%" alt="'+ alt+'">';if($(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('title'))
insert_text+='<span class="title">'+ $(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('title')+'</span>';insert_text+='</div>';}
insert_text+='</div>';}}
insert_text+='</div>';$(insert_text).insertBefore(imgs[0]);$(imgs).remove();}
$('.myphotos').glisse({speed:500,changeSpeed:550,effect:'fade',fullscreen:false});});