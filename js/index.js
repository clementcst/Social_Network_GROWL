
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

function sendComment() {
	let now = new Date();
	var tableauMois = new Array('janvier','février','mars','mai','juillet','septembre','novembre','décembre');
    //On récupère le message qui est écrit dans le champ message
    let message = document.getElementById("actual_writen_message").value;
    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    let comment_list = document.getElementById("comments-list");
    //On crée la nouvelle bulle avec la bonne classe
    let new_bulle = document.createElement("div");
    new_bulle.className = "comment-pseudo-text";
    //Cette bulle doit contenir le contenu du message et les informations annexes avec les bonnes classes css
    let text_message = document.createElement("p");
    text_message.textContent = message;
    text_message.className = "comment-text";
    let info_message = document.createElement("div");
    info_message.className = "comment-reaction";
	info_message.textContent = now.getHours() + ":" + now.getMinutes() + " - " + ('0'+now.getDate()).slice(-2) + " " + tableauMois[now.getMonth()];
    //Pour la mise en forme, il faut une div vide qui centre à droite la bulle
    //Le tout doit être mit dans une div qui prend 100% de la taille du champ conversation
    let mother_div = document.createElement("div");

    new_bulle.append(text_message);
    new_bulle.append(info_message);

    mother_div.append(new_bulle);

    comment_list.prepend(mother_div);
    document.getElementById("actual_writen_message").value = "";
}
