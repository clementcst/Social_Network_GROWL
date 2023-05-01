
//Regarde si la box commentaire a déjà été crée, et appelle les fonctions selon ce test
function CommentSectionCall(menu_id) {
    menu_id = menu_id.replace('CommentSection', '');
    let existCommentSection = document.getElementById("close" + menu_id);
    if(existCommentSection == null){
        CommentSectionCreate(menu_id);
    }
    else{
        CommentSectionOpen(menu_id);
    }
}

//Crée la bulle commentaire avec Ajax lors du premier clique sur la commentSection. Pour les clics suivants, ce sera la fonction CommentSectionOpen qui ouvrira/fermera la section commentaire
function CommentSectionCreate(menu_id) {
    createComments(menu_id);
}

//Cherche le deuxième enfant de la div qui contient l'image commentaire. Le deuxième enfant est la div 'bulle commentaire' qui apparait et disparait quand on clique sur la div mère
function CommentSectionOpen(menu_id){
    selected_comment_menu = document.getElementById("close" + menu_id);
    selected_comment_menu.classList.toggle("comment-menu-height");
}

function getfile(){
    document.getElementById('hiddenfile').click();
}

// La fonction previewPicture
function previewPicture(e){
    countImg = document.getElementsByClassName('post-input-images').length;
    if(countImg >= 4){
        return;
    }
    var divImages = document.getElementById("new-post-images");
    var cmpImg = countImg;
        Array.from(e.files).forEach(element => {

            if (element && cmpImg < 4) {
                var oImg = document.createElement("img");
                oImg.setAttribute('src', URL.createObjectURL(element));
                oImg.setAttribute('accept', 'image/jpeg, image/jpg, image/png');
                oImg.setAttribute('alt', 'na');
                oImg.setAttribute('width', '500px');
                oImg.setAttribute('class', 'post-input-images');
                var base = document.createElement("input");
                base.type = "hidden";
                base.name = "base"+ cmpImg;
                var type = document.createElement("input");
                type.type = "hidden";
                type.name = "type"+ cmpImg;
                var isPost = document.createElement("input");
                isPost.name = "isPost";
                isPost.value = "1";
                isPost.type = "hidden";
            
                // Créer un bouton de suppression pour cette image
                var deleteBtn = document.createElement("button");
                //deleteBtn.setAttribute('width', '500px');
                deleteBtn.innerHTML = "X";
                deleteBtn.addEventListener("click", function() {
                    divImages.removeChild(oImg);
                    divImages.removeChild(isPost);
                    divImages.removeChild(deleteBtn);
                });
                
                fetch(oImg.src) .then((res) => res.blob()) .then((blob) => {
                    // Read the Blob as DataURL using the FileReader API
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        oImg.src = reader.result;
                        base.value = (reader.result).split("base64,")[1];
                        type.value =(reader.result).split(";")[0].split("data:")[1];
                    };
                    reader.readAsDataURL(blob);
                });
                
                divImages.appendChild(isPost);
                divImages.appendChild(oImg);
                divImages.appendChild(deleteBtn);
                divImages.appendChild(base);
                divImages.appendChild(type);
                cmpImg++;
            }
        })
} 

//Fonction qui envoie le commentaire écrit dans le champ input texte
function sendComment(comment_id, content, user_id, post_id, username, PP) {
	let now = new Date();

    //On recupere la page commentaire pour scroll vers le bas quand l'utilisateur poste un commentaire 
    let comment_section = document.getElementById("close" + post_id);

    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    let comment_list = document.getElementById(post_id + "_comments_list");

    //On crée un container de bulle nécessaire pour le bon affichage des elements flex dans un flex grand-parent
    let shadow_bulle_container = document.createElement("div")

    //On crée la nouvelle bulle avec la bonne classe
    let new_bulle = document.createElement("div");
    new_bulle.className = "comment-pseudo-text";

    //Cette bulle doit contenir le contenu du message et les informations annexes avec les bonnes classes css
    let username_message = document.createElement("a")
    username_message.textContent = username;
    username_message.className = "comment-pseudo"

    let text_message = document.createElement("p");
    text_message.textContent = content;
    text_message.className = "comment-text";

    //On crée la div qui va contenir les infos liés au commentaire
    let info_message = document.createElement("div");
    info_message.className = "comment-reaction";

    //On crée la balise qui contient la date du message et le bouton répondre
    let date_message = document.createElement("p")
    date_message.className = "comment-info"
	date_message.textContent = now.getFullYear() + "-" + ('0' + (now.getMonth() + 1)).slice(-2) + "-" + ('0'+now.getDate()).slice(-2) + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
    
    let repondre_btn = document.createElement("p")
    repondre_btn.id = comment_id;
    repondre_btn.className = "comment-react comment-info"
    repondre_btn.onclick = function () {
        CreateInputTexte(this.id);
    };
    repondre_btn.textContent = "Répondre"

    //On crée la balise image de l'user qui envoie le message
    let img_user = document.createElement("img");
    img_user.src = PP;
    
    //Chaque ensemble doit être mis dans une div de mise en forme
    let mother_div = document.createElement("div");
    mother_div.className = "user-profil comment-box";

    let answer_div = document.createElement("div");
    answer_div.className = "answers_div";
    answer_div.id = comment_id + "_answer_section";

    new_bulle.append(username_message);
    new_bulle.append(text_message);

    info_message.append(repondre_btn)
    info_message.append(date_message)

    shadow_bulle_container.append(new_bulle);
    shadow_bulle_container.append(info_message);

    mother_div.append(img_user)
    mother_div.append(shadow_bulle_container);

    if(content != "") {
        comment_list.append(mother_div); //devra être comment_list[i] quand il y aura plusieurs posts ? ou alors créer des id pour chaque comment_list selon l'id du post
        comment_list.append(answer_div);
    }
    document.getElementById("actual_writen_message").value = "";

    //On scroll vers le bas quand on ajoute un message
    comment_section.scrollTop = comment_section.scrollHeight;
}

//Fonction qui crée la bulle comments selon la database chargé en ajax lors du clique sur l'icone commentaire
function createBulleComments(comments, post_id) {
    let div_comments = document.createElement("div");
    div_comments.className = "comment-menu comment-menu-height";
    div_comments.id = "close" + post_id;
    let comment_icon = document.getElementById("CommentSection" + post_id).parentNode;
    let comments_list = document.createElement("div");
    comments_list.id = post_id + "_comments_list";
    comments_list.className = "comments-list";
    for(i=0; i<comments.length; i++) {

        let comment_box = document.createElement("div");
        comment_box.className = "user-profil comment-box"

        let user_image_comments = document.createElement("img");
        user_image_comments.src = comments[i][5];

        let shadow_comment_div = document.createElement("div"); //Necessaire pour la mise en forme

        let comment_pseudo_text_div = document.createElement("div");
        comment_pseudo_text_div.className = "comment-pseudo-text";

        let pseudo = document.createElement("a");
        pseudo.className = "comment-pseudo";
        pseudo.innerHTML = comments[i][4];

        let text = document.createElement("p");
        text.className = "comment-text";
        text.innerHTML = comments[i][2];
        
        let reactions_div = document.createElement("div");
        reactions_div.className = "comment-reaction";

        let repondre_btn = document.createElement("p");
        repondre_btn.id = comments[i][0];
        repondre_btn.className = "comment-react comment-info";
        repondre_btn.onclick = function () {
            CreateInputTexte(this.id);
        };
        repondre_btn.innerHTML = "Répondre";

        let comment_date = document.createElement("p");
        comment_date.className = "comment-info";
        comment_date.innerHTML = comments[i][1];

        let answer_section = document.createElement("div");
        answer_section.id = comments[i][0] + "_answer_section";
        answer_section.className = "answers_div";
        

        comment_pseudo_text_div.append(pseudo);
        comment_pseudo_text_div.append(text);
        reactions_div.append(repondre_btn);
        reactions_div.append(comment_date);
        shadow_comment_div.append(comment_pseudo_text_div);
        shadow_comment_div.append(reactions_div);
        comment_box.append(user_image_comments);
        comment_box.append(shadow_comment_div);
        comments_list.append(comment_box);
        comments_list.append(answer_section);
    }

    let input_comment_message = document.createElement("input");
    input_comment_message.id = "actual_writen_message";
    input_comment_message.type = "text";
    input_comment_message.className = "form-control comment-input";
    input_comment_message.placeholder = "Write your comment";
    input_comment_message.onkeydown = function() {
    if (event.keyCode == 13) createCommentsFromWeb(post_id, this.value) //Ce n'est pas pas deprecated, bug IDE*
    };

    let comment_send_icon = document.createElement("ion-icon");
    comment_send_icon.name = "send";

    let div_send_comment = document.createElement("div");
    div_send_comment.className = "send_menu_comment";

    let div_comment_send_icon = document.createElement("div");
    div_comment_send_icon.className = "send_icon_message";
    div_comment_send_icon.onclick = function () {
        createCommentsFromWeb(post_id, input_comment_message.value);
    };

    div_comments.append(comments_list);
    div_send_comment.append(input_comment_message);
    div_comment_send_icon.append(comment_send_icon);
    div_send_comment.append(div_comment_send_icon);
    div_comments.append(div_send_comment);
    comment_icon.after(div_comments);
}

//Fonction qui crée un champ input texte pour la réponse à un commentaire
function CreateInputTexte(commentID) {

    let trash_icon = document.createElement("ion-icon");
    trash_icon.name = "trash";

    let div_trash_icon = document.createElement("div");
    div_trash_icon.className = "send_icon_message";
    div_trash_icon.onclick = function () {
        removeInput(this.parentNode);
    };

    let send_icon = document.createElement("ion-icon");
    send_icon.name = "send";

    let input_answer = document.createElement("input");
    input_answer.id = commentID + "_answer_input";
    input_answer.type = "text";
    input_answer.className = "form-control comment-input";
    input_answer.placeholder = "Write your answer";
    input_answer.onkeydown = function() {
        if (event.keyCode == 13) createAnswerFromWeb(commentID, input_answer.value) //Ce n'est pas pas deprecated, bug IDE*
    };

    let div_send_icon = document.createElement("div");
    div_send_icon.className = "send_icon_message";
    div_send_icon.onclick = function () {
        createAnswerFromWeb(commentID, input_answer.value);
    };
    

    let answer_sender = document.createElement("div");
    answer_sender.className = "send_menu_answer"

    div_trash_icon.append(trash_icon);

    div_send_icon.append(send_icon);

    answer_sender.append(div_trash_icon);
    answer_sender.append(input_answer);
    answer_sender.append(div_send_icon);

    answer_section_id = commentID + "_answer_section";
    let answer_section = document.getElementById(answer_section_id);
    answer_section.append(answer_sender);
    //object.parentNode.parentNode.parentNode.parentNode.append(answer_sender); a sup après

    //Donne le focus sur le input_answer fraichement créé
    input_answer.focus();
}

//Fonction qui crée les bulles answers selon la database chargé en ajax lors du clique sur l'icone commentaire
function createBulleAnswer(answerDate, answerContent, commentID, userName, userPP) { //0: AnswersId ; 1: AnswersDate ; 2: AnswersContent ; 3: UserID ; 4: CommentID ; 5: Username ; 6: PP



    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    answers_section_id = commentID + "_answer_section";
    let answers_section = document.getElementById(answers_section_id);

    //On crée un container de bulle nécessaire pour le bon affichage des elements flex dans un flex grand-parent
    let shadow_bulle_container = document.createElement("div");

    //On crée la nouvelle bulle avec la bonne classe
    let new_bulle = document.createElement("div");
    new_bulle.className = "comment-pseudo-text";

    //Cette bulle doit contenir le contenu du message et les informations annexes avec les bonnes classes css
    let username_message = document.createElement("a");
    username_message.textContent = userName;
    username_message.className = "comment-pseudo";

    let text_message = document.createElement("p");
    text_message.textContent = answerContent;
    text_message.className = "comment-text";

    //On crée la div qui va contenir les infos liés au commentaire
    let info_message = document.createElement("div");
    info_message.className = "comment-reaction";

    //On crée la balise qui contient la date du message et le bouton répondre
    let date_message = document.createElement("p");
    date_message.className = "comment-info";
    date_message.textContent = answerDate;
    
    let repondre_btn = document.createElement("p");
    repondre_btn.id = commentID; //et non pas du db answer
    repondre_btn.className = "comment-react comment-info";
    repondre_btn.onclick = function () {
        CreateInputTexte(this.id); 
    };
    repondre_btn.textContent = "Répondre";
    
    //Pour la mise en forme, il faut une div vide qui centre à droite la bulle
    //Le tout doit être mit dans une div qui prend 100% de la taille du champ conversation
    let mother_div = document.createElement("div");
    mother_div.className = "user-profil comment-box"

    //On crée la balise image de l'user qui envoie le message
    let img_user = document.createElement("img");
    img_user.src = userPP;

    new_bulle.append(username_message);
    new_bulle.append(text_message);

    info_message.append(repondre_btn)
    info_message.append(date_message)

    shadow_bulle_container.append(new_bulle);
    shadow_bulle_container.append(info_message);

    mother_div.append(img_user)
    mother_div.append(shadow_bulle_container);

    answers_section.appendChild(mother_div);
}

//A sup
//Fonction qui écrit la réponse à un commentaire du post puis supprime le input_answer
function sendAnswer(input_answer, comment_id) {

    let now = new Date();

    //On récupère le message qui est écrit dans le champ message
    let message = document.getElementById(comment_id + "_answer_input").value;

    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    answers_section_id = comment_id + "_answer_section";
    let answers_section = document.getElementById(answers_section_id);

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
    repondre_btn.id = comment_id; //et non pas du db answer
    repondre_btn.className = "comment-react comment-info"
    repondre_btn.onclick = function () {
        CreateInputTexte(this.id); 
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
    document.getElementById(comment_id + "_answer_input").value = "";

    //ce qui est plus haut est remplacé par l'appel ajax
    createAnswer(comment_id); //appel fonction ajax 
    removeInput(input_answer);
}

//Fonction qui supprime le input_answer
function removeInput(input_answer) {
    input_answer.remove();
}

//Fonction qui partage un post
function shareSocial(e) {
    // On récupère la div qui contient l'ensemble du post
    var postToShare = e.parentNode.parentNode.parentNode.parentNode;
    var userName = postToShare.querySelector("#userName_Post").innerHTML;
    postToShare.style.border = "1px solid black";
  
    // On utilise la bibliothèque html2canvas pour créer une capture d'écran de la div
    html2canvas(postToShare).then(function(canvas) {
      postToShare.style.border = "none";  
      // On récupère l'image au format base64
      var postBase64 = canvas.toDataURL();
      var base = (postBase64).split("base64,")[1];
      var type = (postBase64).split(";")[0].split("data:")[1];
  
      // On crée un formulaire pour envoyer l'image au serveur
      var form = document.createElement("form");
      form.method = "POST";
      form.name = "sharePost";
      form.action = "php/postProcess.php"
  
      // On crée des champs cachés pour envoyer les données de l'image
      var baseShare = document.createElement("input")
      baseShare.name = "baseShare";
      baseShare.value = base;
      baseShare.type = "hidden";
  
      var typeShare = document.createElement("input")
      typeShare.name = "typeShare";
      typeShare.value = type;
      typeShare.type = "hidden";
  
      var isShare = document.createElement("input");
      isShare.name = "isShare";
      isShare.value = userName;
      isShare.type = "hidden";
  
      var submit = document.createElement("input")
      submit.type = "submit";
      submit.style.display = "none";
  
      // On ajoute les champs cachés au formulaire
      form.appendChild(baseShare);
      form.appendChild(typeShare);
      form.appendChild(isShare);
      form.appendChild(submit);
  
      // On ajoute le formulaire à la fin de la div
      postToShare.appendChild(form);
  
      // On soumet le formulaire pour envoyer l'image au serveur
      submit.click();
    });    
  }
  