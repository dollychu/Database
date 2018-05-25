
function checkMatch(){
  if($("#newPwd").val() == $("#conPwd").val()){
    $("#confirm_status").attr("class", "input-group-text bg-success text-light");
    $("#confirm_status").text("match");
    $("#submit").removeClass("disabled");
    return true;
  }
  else{
    $("#confirm_status").attr("class", "input-group-text bg-danger text-white");
    $("#confirm_status").text("mismatch");
    $("#submit").addClass("disabled");
    return false;
  }
}

