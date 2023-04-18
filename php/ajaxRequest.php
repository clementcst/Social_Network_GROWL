<?php
    if(file_exists("./required.php"))
        require_once("./required.php");
    else
        require_once("./php/required.php");

    function AddNewPost()
    {   
        //faire la recherche sur le serveur d'un nouveau post                                                                                        
        // renvoyer les valeurs sous cette forme : echo $tmptab[0].";".$tmptab[1].";".$ret_ses.";".$tmptab[2].";".$tmptab[3].";".$tmptab[4];    
        // càd  un tableau dont chaque case contient une valeur qui nous intéresse (peut aussi etre un tableau de valeur dans l'une des cases du tableau)
        // on peut aussi simplement renvoyer des valeurs unique sans tableau c'est un exemple pour mieux les organiser dans la fonction mais penser à bien séparer les valeurs par ";"
        return 0;
    }

    function addNewMessage($message, $receiver)
    {   
        $media = 'NULL';
        $Extension=strrev(substr(strrev($message),0,strpos(strrev($message),'.')));
        if(preg_match('/png|jpg|jpeg|gif/',$Extension)){
            $media= $message;
        }
        $id_user = $_SESSION['connected'];
        $id_receiver = db_selectColumns('user', ['UserID'], ['Username' => ['=', "'".$receiver."'", "0"]]);  
        db_newMessage($id_user, $id_receiver, $message);                                                                           
        // renvoyer les valeurs sous cette forme : echo $tmptab[0].";".$tmptab[1].";".$ret_ses.";".$tmptab[2].";".$tmptab[3].";".$tmptab[4];    
        return 0;
    }

    function changeConversation($username_friend) {
        $id_user_connected=$_SESSION['connected'];
        $id_friend = db_selectColumns(
            table_name:'user',
            columns:['UserID'], 
            filters:['Username' => ['LIKE', '"'.$username_friend.'"','0']]
         );
        $friend_data = db_getUserData($id_friend[0][0]);
        echo $friend_data[0].";".$friend_data[9].";".$id_user_connected.";";
        $conversation = db_getConversation($id_user_connected, $id_friend[0][0]);
        $number_message=count($conversation);
        for($i=0;$i<$number_message;$i++){
            echo $conversation[$i][1].";".$conversation[$i][2].";".$conversation[$i][3].";".$conversation[$i][4].";".$conversation[$i][5];
            if($i<$number_message-1)echo";";
        }
        return 0;
    }

    function sendMessageIntoDB($username_friend, $content) {
        $id_user_connected=$_SESSION['connected'];
        $id_friend = db_selectColumns(
            table_name:'user',
            columns:['UserID'], 
            filters:['Username' => ['LIKE', '"'.$username_friend.'"','0']]
         );
        db_newMessage($id_user_connected, $id_friend[0][0], $content);        
        echo $username_friend;
        return 0;
    }

    function createComment($post_id){
        $comments = db_selectColumns(
            table_name:'comment',
            columns:['CommentID', 'Comment_DateTime', 'Content', 'PostedBy_UserID'], 
            filters:['ReplyTo_PostID' => ['LIKE', '"'.$post_id.'"','0']]
        );
        $numberComments =count($comments);
        for($i=0;$i<$numberComments;$i++){
            $user = db_getUserData($comments[$i][3]);
            echo $comments[$i][0]."***".$comments[$i][1]."***".$comments[$i][2]."***".$comments[$i][3]."***".$user[0]."***".$user[9];
            if($i<$numberComments-1)echo";";
        }
        return 0;
    }

    function getAnswers($comment_id){
        $answers = db_selectColumns(
            table_name:'answer',
            columns:['AnswerID', 'Answer_DateTime', 'Content', 'PostedBy_UserID'], 
            filters:['ReplyTo_CommentID' => ['LIKE', '"'.$comment_id.'"','0']]
         );
        $numberAnswer =count($answers);
        for($i=0;$i<$numberAnswer;$i++){
            echo $answers[$i][0].";".$answers[$i][1].";".$answers[$i][2].";".$answers[$i][3];
            if($i<$numberAnswer-1)echo";";
        }
        return 0;
    }
    
    function NewFilter()
    {
        //faire la recherche sur le serveur pour afficher un filtre sur une image                                                                                  
        // renvoyer les valeurs sous cette forme : echo $tmptab[0].";".$tmptab[1].";".$ret_ses.";".$tmptab[2].";".$tmptab[3].";".$tmptab[4];    
        return 0;
    }

    if($_POST['fct']!== null)
    {
        $fct=$_POST['fct'];
        switch($fct) {
            case 'AddNP' :
                if(1)//mettre des parametres si besoin
                {
                    //Fonction php avec des parametres si besoin
                    AddNewPost();
                }
                else
                    echo "error, not enough POST in ajax request";
                break;
            case 'AddNM' :
                if($_POST['content']!== null && $_POST['UsernameReceiver'])
                {
                    AddNewMessage($_POST['Message'], $_POST['UsernameReceiver']);
                }
                else
                    echo "error, not enough POST in ajax request";
                break;   
            case 'chngCV ' :
                if($_POST['usernameFriend']!== null)
                {
                    changeConversation($_POST['usernameFriend']);
                }
                else
                    echo "error, not enough POST in ajax request";
                break;
            case 'sendMIDB ' :
                if($_POST['usernameFriend']!== null && $_POST['content']!== null)
                {
                    sendMessageIntoDB($_POST['usernameFriend'], $_POST['content']);
                }
                else
                    echo "error, not enough POST in ajax request";
                break;
            case 'CCM ' :
                if($_POST['postID']!== null)
                {
                    createComment($_POST['postID']);
                }
                else
                    echo "error, not enough POST in ajax request";
                break;
            case 'gA ' :
                if($_POST['commentID']!== null)
                {
                    getAnswers($_POST['commentID']);
                }
                else
                    echo "error, not enough POST in ajax request";
                break;
            case 'NewF ' :
                if(1)
                {   //Fonction php                
                    NewFilter();
                }
                else
                    echo "error, not enough POST in ajax request";
                break;  
            default :
                echo "error POST fct invalid in ajax request";            
        }
    }
    else
    {
        java_log('oskour');
        echo "error POST fct not defined in ajax request";
    }
?>
