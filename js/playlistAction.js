var musicPath = "https://databasentnucourse.me/Music/";
var audio     = $("#playingAudio"); 
var player    = $("#audioPlayer")[0]; 
var listLen   = $("ul > a").length;
var mode      = $('#ctrlBtn > label.active').children().attr("id");


$('#ctrlBtn > label').click(function(){
  var kid = $(this).children();
  mode = kid.attr("id");
});

$("ul > a").on("click", function(){
  var lid = $(this).index();
  loadMusic(lid);
});

$("#audioPlayer").on("ended", function(){
  var lid = $("ul > a.active").index();
  
  mode = $('#ctrlBtn > label.active').children().attr("id");
  
  if(mode === "once") lid += 1;
  else if(mode === "loop") lid = (lid+1) % listLen;
  else lid += 1;
  
  loadMusic(lid);
});

var loadMusic = function(id){
  $("ul > a.active").removeClass("active"); 
  var cur = $("ul > a:eq(" + id + ")");
   
  cur.addClass("active");
  var m_path = cur.attr("m_path");
  var viewed = cur.attr("viewed");
  audio.attr("src", musicPath + m_path).detach().appendTo("#audioPlayer");
  
  refreshPane(m_path, id);
};

var refreshPane = function(path, id){
  var name = path.split('/');
  name = name[name.length-1].split('.')[0];

  $("#audioCardTitle").html(name);
  
  var url = "https://databasentnucourse.me/musicPlayer.php?path="+path+"&list_id="+id+"&playing=1";
  
  var mode = $('#ctrlBtn > label.active').children().attr("id");
  url += "&play_mode="+mode;
  
  window.location.href = url;
}


