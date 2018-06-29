var ori_v = "";

$("#AccInfo input")
  .focus(function(event){
    ori_v = $(this).val();
    $(this).removeClass("form-control-plaintext");
    $(this).addClass("form-control");
  })
  .focusout(function(){
    $(this).val(ori_v);
    $(this).removeClass("form-control");
    $(this).addClass("form-control-plaintext");
  });

$(document).keypress(function(e){
  var selected = $("#AccInfo input:focus");
  if(e.which == 13 && selected.is(":valid")){
    var new_v = selected.val();
    if(new_v !== ori_v){
      var this_id = selected.attr("id");
       

      $.ajax({
          url:      "../php/updateAccountCtrl.php",
          data:     {field: this_id, data: new_v},
          method:   "POST",
          dataType: "json",
        })
        .done(function(result){
          if(result.success){
            ori_v = result.hasOwnProperty("msg") ? result.msg : new_v;
            remindStatus(this_id, "update-success");
          }
          else{
            alert("Failed: " + result.msg);
            remindStatus(this_id, "update-fail");
          }
        })
        .fail(function(jxx, textStatus, errorMsg){
          alert("Ajax error: "+textStatus+"/"+errorMsg);
          remindStatus(this_id, "update-fail");
        })
        .always(function(){
          selected.trigger("focusout");
        });
    }
  }
});

function remindStatus(id, new_class){
  var item = $("#AccInfo #"+id);
  item.addClass(new_class);
  
  setTimeout(function(){
    item.css("transition", "border 1s");
    item.removeClass(new_class);
  }, 1000);

  setTimeout(function(){
    item.css("transition", "none");
  }, 1);
}

