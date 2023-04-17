
//Cherche le deuxième enfait de la div qui contient l'image commentaire. Le deuxième enfant est la div 'bulle commentaire' qui apparait et disparait quand on clique sur la div mère
function CommentSectionOpen(menu_id){
    menu_id = menu_id.replace('CommentSection', '');
    all_comments = createComments(menu_id);
    selected_comment_menu = document.getElementById("close" + menu_id);
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
                oImg.setAttribute('accept', 'image/jpeg, image/jpg, image/png');
                oImg.setAttribute('alt', 'na');
                oImg.setAttribute('width', '500px');
                oImg.setAttribute('class', 'post-input-images');

                // Créer un bouton de suppression pour cette image
                var deleteBtn = document.createElement("button");
                //deleteBtn.setAttribute('width', '500px');
                deleteBtn.innerHTML = "X";
                deleteBtn.addEventListener("click", function() {
                    divImages.removeChild(oImg);
                    divImages.removeChild(deleteBtn);
                });
                
                fetch(oImg.src) .then((res) => res.blob()) .then((blob) => {
                    // Read the Blob as DataURL using the FileReader API
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        oImg.src = reader.result;
                       
                    };
                    reader.readAsDataURL(blob);
                });
                
                divImages.appendChild(oImg);
                divImages.appendChild(deleteBtn);
            }
        })
} 

//Fonction qui envoie le commentaire écrit dans le champ input texte
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
    repondre_btn.id = "db_id_commentaire"
    repondre_btn.className = "comment-react comment-info"
    repondre_btn.onclick = function () {
        CreateInputTexte(this.id);
    };
    repondre_btn.textContent = "Répondre"

    //On crée la balise image de l'user qui envoie le message
    let img_user = document.createElement("img");
    img_user.src = "./images/user-3-pic.jpg";
    
    //Chaque ensemble doit être mis dans une div de mise en forme
    let mother_div = document.createElement("div");
    mother_div.className = "user-profil comment-box";

    let answer_div = document.createElement("div");
    answer_div.className = "answers_div";
    answer_div.id = "db_id_commentaire_answer_section2";

    new_bulle.append(username_message);
    new_bulle.append(text_message);

    info_message.append(repondre_btn)
    info_message.append(date_message)

    shadow_bulle_container.append(new_bulle);
    shadow_bulle_container.append(info_message);

    mother_div.append(img_user)
    mother_div.append(shadow_bulle_container);

    if(message != "") {
        comment_list[0].append(mother_div); //devra être comment_list[i] quand il y aura plusieurs posts ? ou alors créer des id pour chaque comment_list selon l'id du post
        comment_list[0].append(answer_div);
    }
    document.getElementById("actual_writen_message").value = "";

    //On scroll vers le bas quand on ajoute un message
    var objDiv = document.getElementsByClassName("comment-menu-height");
    objDiv[0].scrollTop = objDiv[0].scrollHeight;
}

//Fonction qui crée un champ input texte pour la réponse à un commentaire
function CreateInputTexte(db_id) { 
    //La div a créer
    /*<div class="send_menu_answer">
        <input id="actual_writen_answer" type="text" class="form-control comment-input" placeholder="Write your comment"  onkeypress="if (event.keyCode == 13) sendComment()">
        <div class="send_icon_message" onclick="sendAnswer()">
            <ion-icon name="send"></ion-icon>
        </div>
    </div>*/

    let trash_icon = document.createElement("ion-icon");
    trash_icon.name = "trash";

    let div_trash_icon = document.createElement("div");
    div_trash_icon.className = "send_icon_message";
    div_trash_icon.onclick = function () {
        removeInput(this.parentNode);
    };

    let send_icon = document.createElement("ion-icon");
    send_icon.name = "send";

    let div_send_icon = document.createElement("div");
    div_send_icon.className = "send_icon_message";
    div_send_icon.onclick = function () {
        sendAnswer(this.parentNode);
    };

    let input_answer = document.createElement("input");
    input_answer.id = "actual_writen_answer";
    input_answer.type = "text";
    input_answer.className = "form-control comment-input";
    input_answer.placeholder = "Write your answer";
    input_answer.onkeydown = function() {
        if (event.keyCode == 13) sendAnswer(this.parentNode) //Ce n'est pas pas deprecated, bug IDE*
    };
    

    let answer_sender = document.createElement("div");
    answer_sender.className = "send_menu_answer"

    div_trash_icon.append(trash_icon);

    div_send_icon.append(send_icon);

    answer_sender.append(div_trash_icon);
    answer_sender.append(input_answer);
    answer_sender.append(div_send_icon);

    answer_section_id = db_id + "_answer_section"
    let answer_section = document.getElementById(answer_section_id);
    answer_section.append(answer_sender);
    //object.parentNode.parentNode.parentNode.parentNode.append(answer_sender); a sup après

    //Donne le focus sur le input_answer fraichement créé
    input_answer.focus();
}

//Fonction qui écrit la réponse à un commentaire du post puis supprime le input_answer
function sendAnswer(input_answer) {

    let now = new Date();

    //On récupère le message qui est écrit dans le champ message
    let message = document.getElementById("actual_writen_answer").value;

    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    let answers_section = document.getElementById("db_id_commentaire_answer_section");

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
    repondre_btn.id = "db_id_commentaire" //et non pas du db answer
    repondre_btn.className = "comment-react comment-info"
    repondre_btn.onclick = function () {
        CreateInputTexte(this.id); //A modif ? On veut l'id du commentaire pas de la réponse ?
    };
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
        answers_section.append(mother_div);
    }
    document.getElementById("actual_writen_answer").value = "";

    removeInput(input_answer);
}

//Fonction qui supprime le input_answer
function removeInput(input_answer) {
    input_answer.remove();
}
