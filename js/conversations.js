function selectDiscussion(number_friend) {
    let actualselectedFriend = document.getElementsByClassName("selected_friends");
    let selectedFriend = document.getElementById('user'+number_friend);
	let nameSelectedFriend = document.getElementsByClassName('userName'+number_friend)[0].innerHTML;
    changeConversation(nameSelectedFriend);
    actualselectedFriend[0].classList.toggle("selected_friends");
    selectedFriend.classList.toggle("selected_friends");
}

function sendMessage() {
	let now = new Date();
	var tableauMois = new Array('janvier','février','mars','mai','juillet','septembre','novembre','décembre');
    //On récupère le message qui est écrit dans le champ message
    let message = document.getElementById("actual_writen_message").value;
	if(message == 0){
        return;
    }
	
    //On récupère la div conversation pour y ajouter la nouvelle bulle message
    let conversation = document.getElementById("conv");
	
    //On crée la nouvelle bulle avec la bonne classe
    let new_bulle = document.createElement("div");
    new_bulle.className = "bulle my_bulle_message";
	
    //Cette bulle doit contenir le contenu du message et les informations annexes avec les bonnes classes css
    let text_message = document.createElement("span");
    text_message.textContent = message;
    text_message.className = "text_message";
	
    let info_message = document.createElement("span");
    info_message.className = "message_info date_message";
    var minutes = now.getMinutes()
    if(minutes<10)
    minutes = "0" + minutes;
    date = now.getHours() + ":" + minutes + " - " + ('0'+now.getDate()).slice(-2) + " " + tableauMois[now.getMonth()];
	info_message.textContent = date;
    //Pour la mise en forme, il faut une div vide qui centre à droite la bulle
    let empty_div = document.createElement("div");
    empty_div.className = "my-empty-conv"
    //Le tout doit être mit dans une div qui prend 100% de la taille du champ conversation
    let mother_div = document.createElement("div");

    new_bulle.append(text_message);
    new_bulle.append(info_message);

    mother_div.append(empty_div);
    mother_div.append(new_bulle);

    conversation.prepend(mother_div);
    document.getElementById("actual_writen_message").value = "";
    sendMessageIntoDB(message);
    document.getElementById('current_speaking_date_last_message').innerHTML = date;
}
