var settingMenu = document.querySelector(".setting-menu");
var closeFriends = document.querySelector(".close-friends");

function settingMenuOpen(){
    
    if(settingMenu.id == "close"){
        closeFriends.style.transitionDelay = "0s";
        closeFriends.style.margin = "280px 0 0 0 ";
        settingMenu.id="open";
    }else{
        closeFriends.style.transitionDelay = "0.14s";
        closeFriends.style.margin = "0 0 0 0 ";
        settingMenu.id="close";
    }
    settingMenu.classList.toggle("setting-menu-height");
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

var darkBtn = document.getElementById("dark-mode-btn")

darkBtn.onclick = function (){
    darkBtn.classList.toggle("dark-mode-on");
    document.body.classList.toggle("dark-theme");
}


//Cherche le deuxième enfait de la div qui contient l'image commentaire. Le deuxième enfant est la div 'bulle commentaire' qui apparait et disparait quand on clique sur la div mère
function CommentSectionOpen(number_menu){
    number_menu = number_menu.replace('menu', '')
    selected_comment_menu = document.getElementById("close" + number_menu)
    selected_comment_menu.classList.toggle("comment-menu-height");
}
