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

// La fonction previewPicture
function previewPicture(e){
        
    var divImages = document.getElementById("new-post-images");
        Array.from(e.files).forEach(element => {

            if (element) {
                var oImg = document.createElement("img");
                oImg.setAttribute('src', URL.createObjectURL(element));
                oImg.setAttribute('alt', 'na');
                oImg.setAttribute('width', '500px');
                oImg.setAttribute('class', 'post-input-images');
                
                fetch(oImg.src) .then((res) => res.blob()) .then((blob) => {
                    // Read the Blob as DataURL using the FileReader API
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        oImg.src = reader.result;
                       
                    };
                    reader.readAsDataURL(blob);
                });
                divImages.appendChild(oImg);
            }
        })
} 
