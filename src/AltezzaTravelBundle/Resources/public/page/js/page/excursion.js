$(document).ready(function(){var images=$('.info_excursions img');var count_images=images.length;var count_group=0;for(var i=0;i<count_images;i++){var current_elem=images[i];var first_elem=current_elem;while($(current_elem).next().prop("tagName")=="img"||$(current_elem).next().prop("tagName")=="IMG"){current_elem=$(current_elem).next();$(current_elem).addClass('common_image_gr_'+ count_group);$(current_elem).css('display','none');i++;}
$(first_elem).addClass('common_image_gr_'+ count_group);$(first_elem).css('display','none');count_group++;}
for(var i=0;i<count_group;i++){var imgs=$('.info_excursions .common_image_gr_'+ i);if(imgs.length==0)
continue;var count_three_rows=Math.floor(imgs.length/3);if(count_three_rows>=1)
count_three_rows--;var count_two_rows=Math.floor((imgs.length- count_three_rows*3)/ 2);
insert_text+='<span class="title">'+ $(imgs[j]).attr('title')+'</span>';insert_text+='</div></div>';}
if(count_two_rows>0){for(var j=0;j<count_two_rows;j++){insert_text+='<div class="img-line img-line--2 clearfix common_l second_img_line" style="margin-left: -10px; margin-right: -14px;">';for(var k=0;k<=1;k++){insert_text+='<div class="img-line--item"><img src="'+ $(imgs[count_one_row+ j*2+ k]).attr('src')+'" style="width: 100%" alt="">';if($(imgs[count_one_row+ j*2+ k]).attr('title'))
insert_text+='<span class="title">'+ $(imgs[count_one_row+ j*2+ k]).attr('title')+'</span>';insert_text+='</div>';}
insert_text+='</div>';}}
if(count_three_rows>0){for(var j=0;j<count_three_rows;j++){insert_text+='<div class="img-line img-line--3 clearfix third_img_line" style="margin-left: -10px; margin-right: -14px;">';for(var k=0;k<=2;k++){insert_text+='<div class="img-line--item"><img src="'+ $(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('src')+'" style="width: 100%" alt="">';if($(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('title'))
insert_text+='<span class="title">'+ $(imgs[count_one_row+ count_two_rows*2+ j*3+ k]).attr('title')+'</span>';insert_text+='</div>';}
insert_text+='</div>';}}
insert_text+='</div>';$(insert_text).insertBefore(imgs[0]);$(imgs).remove();}});