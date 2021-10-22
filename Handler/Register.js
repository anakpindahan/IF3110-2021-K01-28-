function validation(){
    var pass1 = document.getElementById("password").value;
    var pass2 = document.getElementById("k-password").value;
    if (pass1 != pass2) {
        document.getElementById("password").style.borderColor = "red";
        document.getElementById("k-password").style.borderColor = "red";
        document.getElementById("pesan").innerHTML = "password tidak sama";
        return false;
    }
    return true;
}

function usernameCheck(username){
    var req = new XMLHttpRequest();
    req.open("GET", "scriptRegister.php?user="+username, true);
    req.send();
    req.onreadystatechange = function(){
        if (req.readyState==4 && req.status==200){
            document.getElementById("username").style.borderColor = req.responseText;
        }
    }
    
}
function emailCheck(email){
    var req = new XMLHttpRequest();
    req.open("GET", "scriptRegister.php?email="+email, true);
    req.send();
    req.onreadystatechange = function(){
        if (req.readyState==4 && req.status==200){
            document.getElementById("email").style.borderColor = req.responseText;
        }
    }
    
}