(function(w){

    var user = document.getElementById("username");
    var pass = document.getElementById("password");
    var confirm = document.getElementById("passwordconfirm");
    var error = document.getElementById("error");
    var register = document.getElementById("register");
    var form = document.getElementById("registerform")
    register.addEventListener("click", validate);


    //simple validation for a simple site right?
    function validate(){
        if(user.value.length > 5
        && pass.value.length > 5
        && confirm.value === pass.value){
            form.submit();
        }else{
            error.style.display = "block";
        }
    }

})(window);