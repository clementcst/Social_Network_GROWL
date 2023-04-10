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

function AddNewMessage(){
    var requestCartM= getXhr();
    requestCartM.open("POST","./php/ajaxRequest.php",true);
    requestCartM.onreadystatechange = function(){
        if(requestCartM.readyState == 4 && requestCartM.status == 200){
            var reponse=requestCartM.responseText;
            if(reponse==0){
                return 0;
            }
            var res=reponse.split(";");
        }
    }
    requestCartM.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    requestCartM.send('fct=AddNM');
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