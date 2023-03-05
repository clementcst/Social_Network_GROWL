var settingMenu = document.querySelector(".setting-menu");
var closeFriends = document.querySelector(".close-friends");

function settingMenuOpen(){
    
    if(settingMenu.id == "close"){
        settingMenu.classList.toggle("setting-menu-height");
        closeFriends.style.margin = "200px 0 0 0 ";
        settingMenu.id="open";
    }else{
        settingMenu.classList.toggle("setting-menu-height");
        closeFriends.style.margin = "0 0 0 0 ";
        settingMenu.id="close";
    }

}

let openBtn = document.querySelector(".nav-open");
let closeBtn = document.querySelector(".nav-close");
let navLaterral = document.querySelector(".nav-laterral");

function openNav(){
    navLaterral.style.left ="0";
    openBtn.style.display ="none";
}

function closeNav(){
    navLaterral.style.left ="-200%";
    openBtn.style.display ="block";
}

openBtn.addEventListener("click", openNav);
closeBtn.addEventListener("click",closeNav);

