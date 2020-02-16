/*js*/

function right_position() {
	$('#amegamenu .adropdown').each(function (index, element) {
		var this_offset_right = 0,
			container_offset_right = 0,
			this_offset_left = 0,
			container_offset_left = 0;
		this_offset_right = Math.floor($(this).offset().left + $(this).outerWidth(true));
		container_offset_right = Math.floor($(".container").offset().left + $(".container").outerWidth())-15;
		this_offset_left = Math.floor($(this).offset().left);
		container_offset_left = Math.floor($(".container").offset().left)+15;
		// if($('#amegamenu').hasClass('fixed-menu')){
		// 	$(this).css("left","50%");
		// 	container_offset_right = Math.floor($("#amegamenu").offset().left + $("#amegamenu").outerWidth())-15;
		// 	container_offset_left = Math.floor($("#amegamenu").offset().left)+15;
		// }
		if (this_offset_left < container_offset_left ){
			$(this).offset({left: container_offset_left});
		}
		if (this_offset_right > container_offset_right){
			$(this).offset({left: (container_offset_right-$(this).outerWidth(true))});
		}
		// if (this_offset_left < container_offset_left || this_offset_right > container_offset_right){
		// 	$(this).offset({left: container_offset_left});
		// }

	});
}
$(document).ready(function () {
	var timerId_0=false;
	if($('#amegamenu').length >0){
		right_position();				
	
	 $(window).on('resize scroll', function() {
		clearTimeout(timerId_0);
		timerId_0 = setTimeout(function () {
			right_position();
		},10);
	});
	}
	 // mobile
	$(".arrow_down").on("click",function(){
	 	$(this).css("display","none");
	 	$(this).next().css("display","inline");
	 	$(this).closest(".amenu-item").find(".adropdown-mobile").slideDown();
	});
	$(".arrow_up").on("click",function(){
	 	$(this).css("display","none");
	 	$(this).prev().css("display","inline");
	 	$(this).closest(".amenu-item").find(".adropdown-mobile").slideUp();
	});
});
