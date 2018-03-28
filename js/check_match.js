var check_pwd_match = function(){
    if(document.getElementById('passwd').value ==
       document.getElementById('confirm_pwd').value){
        document.getElementById('pwd_confirm_status').setAttribute("class", "input-group-text bg-success text-white");
        document.getElementById('pwd_confirm_status').innerHTML = 'match';
    } else{
        document.getElementById('pwd_confirm_status').setAttribute("class", "input-group-text bg-danger text-white");
        document.getElementById('pwd_confirm_status').innerHTML = 'not match';
    }
}
