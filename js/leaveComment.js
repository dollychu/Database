
var played = false;
$("#audioPlayer").on('play', function(){
  var path = decodeURI($.urlParam('path'));
  if(!played){
    played = true;
    $.post("php/increaseMusicViewedNum.php", { music_path: path })
      .done(function(data){
        //alert(data); // To debug, uncomment this line
      })
      .fail(function(jqXHR, textStatus, errorMsg){
        alert("There is something wrong updating the viewed num: "+errorMsg);
      });
  }
});

$("#commitCmt").click(function(){
  var cmt = $("#cmtMSG").val();
  var music = decodeURI($.urlParam('path'));
  $.post("php/insertMusicComment.php", { comment: cmt, music_path: music })
    .done(function(last_id){
      $("#playerPane").after($.cardTemplate(cmt, last_id));
      $("#comment_"+last_id).hide().fadeIn(1200);
      $("#cmtMSG").val('');
    })
    .fail(function(jqXHR, textStatus ){
      alert('fail' + textStatus);
    });
});
$.cardTemplate = function(text, id){
  var user_name = "<?php echo $_SESSION['UserName']; ?>";
  return "<div class='card mb-1' id='comment_"+ id +"'>\
            <div class='card-header'>"+ user_name +"</div>\
            <div class='card-body'>\
              <p class='card-text'>" + text + "</p>\
            </div>\
          </div>";
};
