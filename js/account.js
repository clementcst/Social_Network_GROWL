function displayOnglet(name){
    if (name == "logIn"){
        document.getElementById("log-in-account").classList.add("choosen-options");
        document.getElementById("sign-up-account").classList.remove("choosen-options")
        document.getElementById("form-registration").style.display="none";
        document.getElementById("submit_Login").style.display="block";
    }else{
        document.getElementById("sign-up-account").classList.add("choosen-options");
        document.getElementById("log-in-account").classList.remove("choosen-options");
        document.getElementById("form-registration").style.display="block";
        document.getElementById("submit_Login").style.display="none";
    }
}
