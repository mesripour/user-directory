function submitRegister() {
   var passwordSignup = document.getElementById("passwordsignup").value;
   var passwordRepeat = document.getElementById("passwordsignup_confirm").value;
    var validate = true;
    if (passwordSignup.length < 6 || passwordRepeat.length < 6 || passwordSignup != passwordRepeat) {
        document.getElementById("passwordsignup").style = "border: 1px solid red";
        document.getElementById("passwordsignup_confirm").style = "border: 1px solid red";
        var labelPass = document.getElementsByClassName("label_pass");
        var elementNumber;
        for (elementNumber = 0; elementNumber < labelPass.length; elementNumber++) {
            labelPass[elementNumber].style.color = "red";
        }
        validate = false;
    }
    return validate
}