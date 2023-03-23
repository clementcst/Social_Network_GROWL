function displayOnglet(name){
    if (name == "logIn"){
        document.getElementById("form-registration").style.display="hidden";
        document.getElementById("submit_Login").style.display="inline-block";
    }else{
        document.getElementById("form-registration").style.display="inline-block";
        document.getElementById("submit_Login").style.display="hidden";
    }
}