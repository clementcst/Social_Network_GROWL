
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

    //On récupère le message qui est écrit dans le champ message
    let message = document.getElementById("actual_writen_message").value;

    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    let comment_list = document.getElementsByClassName("comments-list");

    //On crée un container de bulle nécessaire pour le bon affichage des elements flex dans un flex grand-parent
    let shadow_bulle_container = document.createElement("div")

    //On crée la nouvelle bulle avec la bonne classe
    let new_bulle = document.createElement("div");
    new_bulle.className = "comment-pseudo-text";

    //Cette bulle doit contenir le contenu du message et les informations annexes avec les bonnes classes css
    let username_message = document.createElement("a")
    username_message.textContent = "username_from_db"
    username_message.className = "comment-pseudo"

    let text_message = document.createElement("p");
    text_message.textContent = message;
    text_message.className = "comment-text";

    //On crée la div qui va contenir les infos liés au commentaire
    let info_message = document.createElement("div");
    info_message.className = "comment-reaction";

    //On crée la balise qui contient la date du message et le bouton répondre
    let date_message = document.createElement("p")
    date_message.className = "comment-info"
	date_message.textContent = now.getFullYear() + "-" + ('0' + (now.getMonth() + 1)).slice(-2) + "-" + ('0'+now.getDate()).slice(-2) + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
    
    let repondre_btn = document.createElement("p")
    repondre_btn.className = "comment-react comment-info"
    repondre_btn.textContent = "Répondre"
    
    //Pour la mise en forme, il faut une div vide qui centre à droite la bulle
    //Le tout doit être mit dans une div qui prend 100% de la taille du champ conversation
    let mother_div = document.createElement("div");
    mother_div.className = "user-profil comment-box"

    //On crée la balise image de l'user qui envoie le message
    let img_user = document.createElement("img");
    img_user.src = "./images/user-3-pic.jpg"

    new_bulle.append(username_message);
    new_bulle.append(text_message);

    info_message.append(repondre_btn)
    info_message.append(date_message)

    shadow_bulle_container.append(new_bulle);
    shadow_bulle_container.append(info_message);

    mother_div.append(img_user)
    mother_div.append(shadow_bulle_container);

    if(message != "") {
        comment_list[0].append(mother_div);
    }
    document.getElementById("actual_writen_message").value = "";

    //On scroll vers le bas quand on ajoute un message
    var objDiv = document.getElementsByClassName("comment-menu-height");
    objDiv[0].scrollTop = objDiv[0].scrollHeight;
}
