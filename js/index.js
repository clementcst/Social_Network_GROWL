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

//Cherche le deuxième enfait de la div qui contient l'image commentaire. Le deuxième enfant est la div 'bulle commentaire' qui apparait et disparait quand on clique sur la div mère
function CommentSectionOpen(number_menu){
    number_menu = number_menu.replace('menu', '')
    selected_comment_menu = document.getElementById("close" + number_menu)
    selected_comment_menu.classList.toggle("comment-menu-height");
}

function getfile(){
    document.getElementById('hiddenfile').click();
}

function displayFile(){
    var path = document.getElementById('hiddenfile').value.replace("\\fakepath","");
    /*console.log(path);
    console.log(encodeURIComponent(path));*/
    console.log(document.getElementById('hiddenfile').files[0]);
    document.getElementById('displayfile').src=document.getElementById('hiddenfile').files[0];
}
