$(function(){		
	$( '#dl-menu' ).dlmenu();
})
$(function(){
    var myElement= document.getElementById('carousel-example-generic')
    var hm=new Hammer(myElement);
    hm.on("swipeleft",function(){
        $('#carousel-example-generic').carousel('next')
    })
    hm.on("swiperight",function(){
        $('#carousel-example-generic').carousel('prev')
    })
})

$(function(){
	$(".phone-btn").click(function(){
		$(".phone_menu").css("left","0")
	})
	$(".phone_close").click(function(){
		$(".phone_menu").css("left","-100%")
	})
})

$(function(){
	$(".docu_list").find("li").mouseover(function(){
		var index = $(this).index();
		$(this).addClass("on").siblings().removeClass("on")
		$(".docu_main").find(".docu_box").eq(index).show().siblings().hide();
	})
})

$(function(){
	$(".choose_l").find(".choose_btn").mouseover(function(){
		var index = $(this).index();
		$(this).addClass("on").siblings().removeClass("on")
		$(".choose_r").find(".choose_box").eq(index).show().siblings().hide();
	})
})

$(function(){
	$(".message_t").find("li").mouseover(function(){
		var index = $(this).index();
		$(this).addClass("on").siblings().removeClass("on")
		$(".message_content").find(".message_box").eq(index).show().siblings().hide();
	})
})
$(function(){
	$(".join_l").find("li").mouseover(function(){
		var index = $(this).index();
		$(this).addClass("on").siblings().removeClass("on")
		$(".join_r").find(".join_box").eq(index).show().siblings().hide();
	})
})

$(function(){
	$(".exper_mask .see").click(function(){
		$(this).siblings(".exper_pic").show()
	})
	$(".e_close").click(function(){
		$(".exper_pic").hide()
	})
})

$(function(){
	$(".g_more").click(function(){
		$(".g_content").toggle()
	})
})

$(function() {
    var Accordion = function(el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;
        var links = this.el.find('.link');
        links.on('click', {
            el: this.el,
            multiple: this.multiple
        },
        this.dropdown)
    }
    Accordion.prototype.dropdown = function(e) {
        var $el = e.data.el;
        $this = $(this),
        $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('open');
        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
    }
    var accordion = new Accordion($('#accordion'), false);
    var accordion = new Accordion($('#accordion1'), false);
});