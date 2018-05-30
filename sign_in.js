

$("#submit").click(function(){
  var _name = $("#inputEmail").val();
  var _passwd = $("#inputPassword").val();
  
  var result = "";
  var redirect = "index.html"
  var request = $.ajax({
      method: "POST",
      url: "php/authenticate.php",
      dataType: "json",
      data: { name: _name, passwd: _passwd, submit: true },
      cache: false
    })
    .done(function(msg) {
      if(msg.status==1) redirect = "index.html";
      else redirect = "sign_in.php";
      alert("done: " + msg.msg);
    })
    request.fail(function(msg){
      alert("Failed: " + msg.msg);
    });
  
  alert();
  window.location.replace(redirect); 
  alert();
});
  
  

