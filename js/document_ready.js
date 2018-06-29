
$(document).ready(function(){
  $('#HEADER').load('../HEADER.php');
  $('body').css({
      "background-image"     : "url('../image/zen01.jpg')",
      "background-size"      : "50%",
      "background-repeat"    : "no-repeat",
      "background-position"  : "50% 80%",
      "background-attachment": "fixed"
    });
  $('.card').css("background-color", "rgba(255, 255, 255, 0.75)");
});

