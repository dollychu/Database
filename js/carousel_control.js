

$(".carousel.slide").on("slid.bs.carousel", carousel_control);

function carousel_control(){
  var $this = $(this);
  
  
  var $first = $('.carousel-inner .carousel-item:first');
  var $last = $(".carousel-inner .carousel-item:last").prevAll().eq(1);
  
  if($first.hasClass('active') && !$first.hasClass('disable') ) {
    $this.children('.carousel-control-prev').addClass('disable');
  } else if($last.hasClass('active') && !$last.hasClass('disable')) {
    $this.children('.carousel-control-next').addClass('disable');
  }
  else{
    $this.children('.carousel-control-next').removeClass('disable');
    $this.children('.carousel-control-prev').removeClass('disable');
  }
}


