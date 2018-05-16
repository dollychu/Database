var html=`
  <style>
    .row-equal > div[class*='col-']{
      display: flex;
      flex: 1 0 auto;
    }
    .row-equal .card{
      width: 100%;
    }
    .carousel-inner>.row-equal.active,
    .carousel-inner>.row-equal.next,
    .carousel-inner>.row-equal.prev{
      display: flex;
    }
    .carousel-inner>.row-equal.active.left,
    .carousel-inner>.row-equal.active.right{
      opacity: 0.5;
      display: flex;
    }
    
  </style>
  <div class='carousel slide mx-2 mb-2' id='firstSlide' data-interval='false' data-ride='carousel'>
    <ol class='carousel-indicators'>
      <li data-target='#firstSlide' data-slide-to='0' class='active'</li>
      <li data-target='#firstSlide' data-slide-to='1' class='active'</li>
      <li data-target='#firstSlide' data-slide-to='2' class='active'</li>
    </ol>
    
    
    <div class='container-fluid carousel-inner bg-secondary'>
      <div class='carousel-item active row-equal'>
        <div class='row'>
          <div class='col'>
          <div class='card bg-light'>
            <div class='card-header'>Hello</div>
            <div class='card-body'>
              <h5 class='card-title'>Light card</h5>
              <p class='card-text'>some information here.</p>
            </div>    
          </div>
          </div>
          
          <div class='col'>
          <div class='card bg-success'>
            <div class='card-header'>Hello</div>
            <div class='card-body'>
              <h5 class='card-title'>Light card</h5>
              <p class='card-text'>some information here.</p>
            </div>    
          </div>
          </div>
        </div>
      </div> <!--End of carousel-item-->

      <div class='carousel-item row-equal'>
        <div class='row'>
          <div class='card bg-success col'>
            <div class='card-header'>World</div>
            <div class='card-body'>
              <h5 class='card-title'>Light card</h5>
              <p class='card-text'>Dont know what to say....</p>
            </div>
          </div>
        </div>
      </div> <!--End of row-->
    </div> <!--End of carousel-inner-->

    <a class='carousel-control-prev' href='#firstSlide' role='button' data-slide='prev'>
      <span class='carouse-control-prev-icon' aria-hidden='true'></span>
      <span class='sr-only'>Previous</span>
    </a>
    <a class='carousel-control-next' href='#firstSlide' role='button' data-slide='next'>
      <span class='carousel-control-next-icon' aria-hidden='true'></span>
      <span class='sr-only'>Next</span>
    </a>
  </div> <!--End of carousel slide-->
`;

var tmp = `
  <script>
    $("#firstSlide").on("slide.bs.carousel", function(e){
      var $e = $(e.relatedTarget);
      var idx = $e.index();
      var itemsPerSlide = 4;
      var totalItems = $(".carousel-item").length;

      if(idx >= totalItems - (itemsPerSlide - 1)){
        var it = itemsPerSlide - (totalItems - idx);
        for(var i=0; i<it; i+=1){
          if(e.direction == "left"){
            $(".carousel-item")
              .eq(i)
              .appendTo(".carousel-inner");
          } else{
            $(".carousel-item")
              .eq(0)
              .appendTo($(this).find(".carousel-inner"));
          }
        }
      }
    });
  </script>
`;

document.write(html)

