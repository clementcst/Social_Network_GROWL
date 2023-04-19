function getXhr()//cree objetXHR
{
    if (window.XMLHttpRequest) // Pour la majorité des navigateurs
        return new XMLHttpRequest() ;
    else if(window.ActiveXObject){ // Anciens navigateurs (IE<7)
        try {
            return new ActiveXObject("Msxml2.XMLHTTP") ;
        } catch (e) {
            return new ActiveXObject("Microsoft.XMLHTTP") ;
        }
    }
    else { // XMLHttpRequest non supporté par le navigateur
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...") ; 
    }
    return NULL ;
}

/*Fonction d'envoie de requetes Ajax*/

function AddNewPost(){
    var requestCartA= getXhr();
    requestCartA.open("POST","./php/ajaxRequest.php",true);
    requestCartA.onreadystatechange = function(){
        if(requestCartA.readyState == 4 && requestCartA.status == 200){
            var reponse=requestCartA.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
        }
    }
    requestCartA.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestCartA.send('fct=AddNP');
    return 0;    
}

function addNewMessage(){
    var content = document.getElementById("actual_writen_message").value
    var requestNewM= getXhr();
    requestNewM.open("POST","./php/ajaxRequest.php",true);
    requestNewM.onreadystatechange = function(){
        if(requestNewM.readyState == 4 && requestNewM.status == 200){
            var reponse=requestNewM.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
        }
    }
    requestNewM.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestNewM.send('fct=AddNM'+ '&content=' + content + '&UsernameReceiver=' + userNameReceiver);
    return 0;    
}

function changeConversation(username_friend){
    var requestChangeC= getXhr();
    requestChangeC.open("POST","./php/ajaxRequest.php",true);
    requestChangeC.onreadystatechange = function(){
        if(requestChangeC.readyState == 4 && requestChangeC.status == 200){
            var reponse=requestChangeC.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
            var number_messages = (res.length-4)/6;
            let all_messages = [];
            let data = [res[0],res[1],res[3]];//variable contenant les informations de l'ami dont la fenetre de discussion est ouverte avec un 0 son username et en 1 sa photo
            for(var j=0;j<(number_messages);j++){
                all_messages[j] = []; // tableau de la taille du nombre de message
                for(var k = 0;k<6;k++){
                    all_messages[j][k] = res[6*j+4+k]// dans le tableau on y met un tableau contenant toutes les infos du message
                }
            }
            // console.log(all_messages[0][2]);
            updateConvMessage(data,all_messages);
        }
    }
    requestChangeC.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestChangeC.send('fct=chngCV ' + '&usernameFriend=' + username_friend);
    return 0;    
}

function sendMessageIntoDB(content, type){
    encodeURI(content);  
    var username_friend = document.getElementById('current_speaking').innerHTML;
    username_friend = username_friend.trim();
    var requestsendMIDB= getXhr();
    requestsendMIDB.open("POST","./php/ajaxRequest.php",true);
    requestsendMIDB.onreadystatechange = function(){
        if(requestsendMIDB.readyState == 4 && requestsendMIDB.status == 200){
            var reponse=requestsendMIDB.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
            //updateFriendsOrder(res[1]);
        }
    }
    requestsendMIDB.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestsendMIDB.send('fct=sendMIDB '+ '&usernameFriend=' + username_friend + '&content=' + content + '&type=' + type);
    return 0;   
}

function createComments(post_id){
    var requestCCM= getXhr();
    requestCCM.open("POST","./php/ajaxRequest.php",true);
    requestCCM.onreadystatechange = function(){
        if(requestCCM.readyState == 4 && requestCCM.status == 200){
            var reponse=requestCCM.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split("***");
            res[0] = res[0].replace(' \r\n\r\n\r\n\r\n\r\n','');
            var number_comments = res.length/6;
            let comments = [];
            for(var i=0; i<number_comments;i++){ 
                comments[i]=[];
                comments[i][0] = res[i*4];
                comments[i][1] = res[i*4+1];
                comments[i][2] = res[i*4+2];
                comments[i][3] = res[i*4+3];
                comments[i][4] = res[i*4+4];
                comments[i][5] = res[i*4+5];
            }
            console.log(comments);
            createBulleComments(comments, post_id);
        }
    }
    requestCCM.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestCCM.send('fct=CCM '+ '&postID=' + post_id);
}

//Fonction qui crée la bulle comments selon la database chargé en ajax lors du clique sur l'icone commentaire
function createBulleComments(comments, post_id) {
    for(i=0; i<comments.length; i++) {
        let comment_icon = document.getElementById("CommentSection" + post_id).parentNode;
        let div_comments = document.createElement("div");
        div_comments.className = "comment-menu comment-menu-height";
        div_comments.id = "close" + post_id;

        let comments_list = document.createElement("div");
        comments_list.className = "comments-list";

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

        let div_send_comment = document.createElement("div");
        div_send_comment.className = "send_menu_comment";

        let input_comment_message = document.createElement("input");
        input_comment_message.id = "actual_writen_message";
        input_comment_message.type = "text";
        input_comment_message.className = "form-control comment-input";
        input_comment_message.placeholder = "Write your comment";
        input_comment_message.onkeydown = function() {
            if (event.keyCode == 13) sendComment() //Ce n'est pas pas deprecated, bug IDE*
        };

        let div_comment_send_icon = document.createElement("div");
        div_comment_send_icon.className = "send_icon_message";
        div_comment_send_icon.onclick = function () {
            sendComment();
        };

        let comment_send_icon = document.createElement("ion-icon");
        comment_send_icon.name = "send";

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
        div_comment_send_icon.append(comment_send_icon);
        div_send_comment.append(input_comment_message);
        div_send_comment.append(div_comment_send_icon);
        div_comments.append(comments_list);
        div_comments.append(div_send_comment);
        comment_icon.after(div_comments);
    }
}

function getAnswers(comment_id){
    var requestgA= getXhr();
    requestgA.open("POST","./php/ajaxRequest.php",true);
    requestgA.onreadystatechange = function(){
        if(requestgA.readyState == 4 && requestgA.status == 200){
            var reponse=requestgA.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
            res[0] = res[0].replace(' \r\n\r\n\r\n\r\n\r\n','');
            var number_answers = res.length/4;
            let answers = [];
            for(var i=0; i<number_answers;i++){
                answers[i]=[];
                answers[i][0] = res[i*4];
                answers[i][1] = res[i*4+1];
                answers[i][2] = res[i*4+2];
                answers[i][3] = res[i*4+3];
            }
            console.log(answers);
            //écris les fonction ici Adam
        }
    }
    requestgA.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestgA.send('fct=gA '+ '&commentID=' + comment_id);
    return 0;   
}


function NewFilter(){
    var requestCartF= getXhr();
    requestCartF.open("POST","./php/ajaxRequest.php",true);
    requestCartF.onreadystatechange = function(){
        if(requestCartF.readyState == 4 && requestCartF.status == 200){
            var reponse=requestCartF.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
        }
    }
    requestCartF.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestCartF.send('fct=NewF');
    return 0;    
}

/*-------------*/
function changeFormatDate(date_complete, id, have_to_whrite) {    
    var tableauMois = new Array('janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
    var date_split = date_complete.split('\u0020');
    var day = date_split[0].split("-");
    var hour = date_split[1].split("\u003A");
    var final_date = hour[0] + ":" + hour[1] + " - " + day[2] + " " + tableauMois[Number(day[1])-1];
    if(have_to_whrite){
        var text_zone = document.getElementById(id);
        text_zone.innerHTML = final_date;
    }
    
    return final_date;
}


function createBulbleMessage(name_friend, text_message, base_media, type_media, date_message, im_speaker,div_one_message){  
    var number_message = document.getElementsByClassName('bulle');
    var bulle_message = document.createElement('div');
    if(im_speaker == 1){
        bulle_message.className = 'bulle my_bulle_message';
    }else{
        bulle_message.className = 'bulle friend_bulle_message';
    }    

    var speaker = document.createElement('span');
    if(im_speaker == 1){
        speaker.className = 'message_info';
        speaker.innerHTML = "Me";
    } else {
        speaker.className = 'message_info friend_name_message';
        speaker.innerHTML = name_friend;
    }
    bulle_message.appendChild(speaker);                

    if(text_message.length != 0){
        var text = document.createElement('span');
        text.className = 'text_message';
        text.innerHTML = decodeURI(text_message);
        bulle_message.appendChild(text);
    } else if(type_media.length != 0){
        content = document.createElement("img");
        base_media = decodeURI(base_media);
        content.src = "data:"+type_media+";base64,"+base_media;
        content.id = "image_message";
        content.className = "text_message";
        bulle_message.appendChild(content);
    }

    var date_message_buble = document.createElement('span');
    date_message_buble.id = number_message.length + 1;
    date_message_buble.className = 'message_info date_message';
    date = changeFormatDate(date_message, number_message.length + 1, 0);
    date_message_buble.innerHTML = date;
    bulle_message.appendChild(date_message_buble);

    div_one_message.appendChild(bulle_message);
}


function updateConvMessage(data, messages){
    var zone_message = document.getElementById('conv');
    zone_message.innerHTML="";
    var number_messages = messages.length;
    document.getElementById('current_speaking').innerHTML = data[0];
    document.getElementById('current_speaking_date_last_message').innerHTML = "";
    if(messages[0][0] == "") //Aucun message
        return;
    document.getElementById('current_speaking_date_last_message').innerHTML = changeFormatDate(messages[number_messages-1][4], 'current_speaking_date_last_message');
    for(var i=number_messages-1; i>=0;i--){
        var div_one_message = document.createElement('div');
        if(i>0){
            var space_between_message = document.createElement('div');
            space_between_message.className = 'my-empty-conv';
            zone_message.appendChild(space_between_message);
        }
        if((messages[i][0]) == data[2]){
            createBulbleMessage(data[0], messages[i][2],messages[i][3], messages[i][5],messages[i][4],"1", div_one_message);
        } else {
            createBulbleMessage(data[0], messages[i][2],messages[i][3], messages[i][5],messages[i][4],"0", div_one_message);               
        }   
        zone_message.appendChild(div_one_message );
    }
}

function updateFriendsOrder(friend_name) {
    friend_name = friend_name.replace('\r\n         </script>\r\n      ', '');
    var recent_one = document.getElementsByName(friend_name);
    recent_one = recent_one[0].id;
    if(recent_one == "friend1"){
        return 0;
    }
    var test = document.createElement("p")
    test.innerHTML = 'test';
    // var number_friend = document.getElementsByClassName('friends_list');
    // console.log(number_friend.length)
    var parent = document.getElementsByClassName('close-friends');
    console.log(parent[0].firstChild);
    parent.insertBefore(test,parent.firstChild);
}
