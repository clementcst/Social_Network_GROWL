var settingMenu = document.querySelector(".setting-menu");
var closeFriends = document.querySelector(".close-friends");

function settingMenuOpen(){
    
    if (closeFriends == null) {
        settingMenu.classList.toggle("setting-menu-height");
    }

    if(settingMenu.id == "close"){
        closeFriends.style.transitionDelay = "0s";
        closeFriends.style.margin = "280px 0 0 0 ";
        settingMenu.id="open";
    }else{
        closeFriends.style.transitionDelay = "0.18s";
        closeFriends.style.margin = "0 0 0 0 ";
        settingMenu.id="close";
    }
    settingMenu.classList.toggle("setting-menu-height");
}

var darkBtn = document.getElementById("dark-mode-btn")

function toggleDarkMode() {
    darkBtn.classList.toggle("dark-mode-on");
    document.body.classList.toggle("dark-theme");
}

  
darkBtn.onclick = toggleDarkMode;