jQuery(function($){
		$(window).load(
			function() {



				var wW = $(window).width();
				var wH = $(window).height();
				
				var slide = $(".fondo .superSlide img"); 
				var img = 0;

				sSize();
				$(window).stop().resize(function() {
					wW = $(window).width();
					wH = $(window).height();
					sSize();

					});
				slide.eq(0).show();
				var veces = 0
				var intervalo = setInterval(function(){ 
					veces++
										if (img < slide.length -1) { img++ } else { img = 0 };
					slide.hide();
					slide.eq(img).show();
				},150);


				function sSize() {
//					alert(wW + ' ' + wH);
					slide.each(function() {
						w = $(this).width();
						h = $(this).height();

						if (wW/wH < w/h ) {
							slide.height('100%');
							w = slide.width();
							mW = - (w/2 - wW/2);
							slide.css({ width: '',  marginTop : '', marginLeft : mW});

						} else {
							slide.width('100%');
							h = slide.height();
							mH = - (h/2 - (wH)/2);
							slide.css({ height: '',  marginTop : mH, marginLeft : ''});
						}
					});

				}
			});


		
    });
		    