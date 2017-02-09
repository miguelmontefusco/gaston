// materealize
$(document).ready(function(){
	$(".button-collapse").sideNav();
});

$(document).ready(function() {
	$('select').material_select();
});

$('#play-video').on('click', function(e){
	e.preventDefault();
	$('#video-overlay').addClass('open');
	$("#video-overlay").append('<iframe width="80%" height="80%" src="https://www.youtube.com/embed/13wt6cmCRK0?autoplay=1&showinfo=0" frameborder="0" allowfullscreen></iframe>');
});

$('.video-overlay, .video-overlay-close').on('click', function(e){
	e.preventDefault();
	close_video();
});

$(document).keyup(function(e){
	if(e.keyCode === 27) { close_video(); }
});

function close_video() {
	$('.video-overlay.open').removeClass('open').find('iframe').remove();
};
//Est. sliders
/*galeria de libros*/
$(document).ready(function(){
	$('.bxslider').bxSlider({   
		pagerCustom: '#bx-pager'
	});
	$('#slider2').bxSlider({
		mode: 'vertical',
    minSlides: 4,
    maxSlides: 4,
		auto: true,
		autoControls: false,
		pause: 3000,
		slideMargin: 20
	});
});

// galeria video
 $(document).ready(function(){
    $('.bxsliderr').bxSlider({    
      pagerCustom: '#bx-pagerr'
    });
    $('#slider4').bxSlider({
      slideWidth: 200,
      minSlides: 1,
      maxSlides: 4,
      auto: true,
      autoControls: false,
      pause: 3000,
      slideMargin: 20
    });
  });

// slider normal
/*$(document).ready(function(){
	$('.bxslider3').bxSlider();
	auto: true
});*/
$('#slider3').bxSlider({
  auto: true,
  autoControls: true,
  pause: 3000
})


// slider articulos
$(document).ready(function(){
  $('.slidercinco').bxSlider({
    auto: true,
    slideWidth: 500,
    minSlides: 1,
    maxSlides: 3,
    slideMargin: 20
  });
});

//slider mas articulos
 $(document).ready(function(){
  $('.slidermasarticulos').bxSlider({
    //slideWidth: 200,
    minSlides: 1,
    maxSlides: 3,
    slideMargin: 10
  });
});

//slider articulo individual
$('#sliderseis').bxSlider({
  auto: true,
  autoControls: true,
  pause: 3000,
  slideMargin: 20
});

//slider autores
$(document).ready(function(){
  $('.sliderautoresmin').bxSlider({
    slideWidth: 200,
    minSlides: 5,
    maxSlides: 5,
    slideMargin: 10
  });
});

/****scroll ligero***/
	$('a[href*="#"]:not([href="#"])').click(function() {
  if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    if (target.length) {
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 1000);
      return false;
    }
  }
});