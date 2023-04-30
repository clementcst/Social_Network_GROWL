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
        //db_newMessage($id_user, $id_receiver, $message);                                                                           
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
            if($conversation[$i][4] != NULL){
                $media = db_selectColumns(
                table_name:'media',
                columns:['Base64', 'Type'], 
                filters:['MediaID' => ['LIKE', '"'.$conversation[$i][4].'"','0']]
             );
             $conversation[$i][4] = $media[0][0];
             $conversation[$i][6] = $media [0][1];
            //  str_replace(' ',"+", $conversation[$i][4]);
            } else {
                $conversation[$i][6] = NULL;
            }
            echo $conversation[$i][1].";".$conversation[$i][2].";".$conversation[$i][3].";".$conversation[$i][4].";".$conversation[$i][5].";".$conversation[$i][6];
            if($i<$number_message-1)echo";";
        }
        return 0;
    }

    function sendMessageIntoDB($username_friend, $content, $type) {
        echo($content);
        echo(';');
        // echo($type);
        $media = NULL;
        if($type != 'null') {// si le contenu est un média, on créé le média et le contenu devient
            $id = db_generateId("media");
            $content = str_replace(' ',"+", $content);
            db_addMedia($content,$type);
            $content = NULL;
            $media = $id;
        }
        $id_user_connected=$_SESSION['connected'];
        $id_friend = db_selectColumns(
            table_name:'user',
            columns:['UserID'], 
            filters:['Username' => ['LIKE', '"'.$username_friend.'"','0']]
         );
        db_newMessage($id_user_connected, $id_friend[0][0], $content, $media);        
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
            if($i<$numberComments-1)echo"***";
        }
        if($numberComments == 0) echo "empty";
        return 0;
    }

    function searchProfil($inputValue){
        $userTab = db_selectColumns(
            table_name:'user',
            columns:['UserID'], 
            filters:['Username' => ['LIKE', '"'.$inputValue.'%"','0']]
        );

        $numberUsers =count($userTab);
        for($i=0;$i<$numberUsers;$i++){
            $user = db_getUserData($userTab[$i][0]);
            echo $userTab[$i][0]."***".$user[0]."***".$user[9];
            if($i<$numberUsers-1)echo";;;";
        }
        return 0;
    }

   
    //Ecrit le commentaire dans la db, puis recupere les infos du commentaire créé et les echo vers le js
    function createCommentsFromWeb($post_id, $content){
        $id_user_connected=$_SESSION['connected'];
        $id_comment = db_generateId("comment");
        //La fonction php me renvoie le commentaire qu'elle a mit dans la db
        $comment = db_newComment($id_comment, $content, $id_user_connected, $post_id);
        $UserInfo = db_selectColumns(
            table_name:'user',
            columns:['Username', 'ProfilPic'], 
            filters:['UserID' => ['LIKE', '"'.$id_user_connected.'"','0']]
        );
        $profpic = db_selectColumns('media', ['Base64','Type'], ['MediaID' => ['=',"'".$UserInfo[0][1]."'", '0']])[0];
        $UserInfo[0][1] = 'data:'.$profpic[1].';base64,'.$profpic[0];
        echo "***".$comment['CommentID']."***".$comment['Content']."***".$comment['PostedBy_UserID']."***".$comment['ReplyTo_PostID']."***".$UserInfo[0][0]."***".$UserInfo[0][1];
        return 0;
    }

    //Fonction qui prend en parametres la liste des ID de tous les commentaires d'un post pour en generer les réponses.
    function createAnswers($comment_id_list){
        $id_user_connected=$_SESSION['connected'];
        $comment_id_list = explode(",", $comment_id_list);
        for($i=0;$i<count($comment_id_list);$i++){
            $answers[$comment_id_list[$i]] = db_selectColumns(
                table_name:'answer',
                columns:['Answer_DateTime', 'Content'], 
                filters:['ReplyTo_CommentID' => ['LIKE', '"'.$comment_id_list[$i].'"','0']]
            );
            $number_answers = count($answers[$comment_id_list[$i]]);
            for($j=0; $j<$number_answers; $j++){
                $user = db_getUserData($id_user_connected);
                echo $answers[$comment_id_list[$i]][$j][0]."***".$answers[$comment_id_list[$i]][$j][1]."***".$comment_id_list[$i]."***".$user[0]."***".$user[9]."***";
                //Ajout d'un *** car on ne sait pas quand on atteindra la derniere réponse du dernier commentaire
            }
        }
        return 0;
    }

    function createAnswerFromWeb($comment_id, $content){
        $id_user_connected=$_SESSION['connected'];
        $id_answer = db_generateId("answer");
        //La fonction php me renvoie le commentaire qu'elle a mit dans la db
        $answer = db_newAnswer($id_answer, $content, $id_user_connected, $comment_id);
        $UserInfo = db_selectColumns(
            table_name:'user',
            columns:['Username', 'ProfilPic'], 
            filters:['UserID' => ['LIKE', '"'.$id_user_connected.'"','0']]
        );
        $profpic = db_selectColumns('media', ['Base64','Type'], ['MediaID' => ['=',"'".$UserInfo[0][1]."'", '0']])[0];
        $UserInfo[0][1] = 'data:'.$profpic[1].';base64,'.$profpic[0];
        echo "***".$answer['AnswerID']."***".$answer['Answer_DateTime']."***".$answer['Content']."***".$answer['PostedBy_UserID']."***".$answer['ReplyTo_CommentID']."***".$UserInfo[0][0]."***".$UserInfo[0][1];
        return 0;
    }
    
    function NewFilter()
    {
        //faire la recherche sur le serveur pour afficher un filtre sur une image                                                                                  
        // renvoyer les valeurs sous cette forme : echo $tmptab[0].";".$tmptab[1].";".$ret_ses.";".$tmptab[2].";".$tmptab[3].";".$tmptab[4];    
        return 0;
    }

    function LikePost(string $postID) { //add a like to a post in the db
        $userID = $_SESSION["connected"];
        if(count(db_selectColumns("liked_post", ["*"],["UserID" => ["LIKE", "'".$userID."'", "1"],
                                                                    "PostID" => ["LIKE", "'".$postID."'", "0"]])) 
           != 0) //if the post is already liked by the user
        {
            echo "***0";
        } else {
            db_newRow("liked_post", ["UserID" => $userID, "PostID" => $postID]);
            db_updateColumns("post", ["NumberOfLikes" => count(db_selectColumns("liked_post",["*"],["PostID" => ["LIKE", "'".$postID."'", "0"]]))], ["PostID" => ["LIKE", "'".$postID."'", "0"]]);
            echo "***1";
        }
    }

    function UnlikePost(string $postID) { //remove a like from a post in db
        $userID = $_SESSION["connected"];
        if(count(db_selectColumns("liked_post", ["*"],["UserID" => ["LIKE", "'".$userID."'", "1"],
                                                       "PostID" => ["LIKE", "'".$postID."'", "0"]])) 
           == 0) //if the post is not liked by the user
        { 
            echo "***0";
        } else {
            db_deleteRows("liked_post", ["UserID" => ["LIKE", "'".$userID."'", "1"],
                                        "PostID" => ["LIKE", "'".$postID."'", "0"]]);
            db_updateColumns("post", ["NumberOfLikes" => count(db_selectColumns("liked_post",["*"],["PostID" => ["LIKE", "'".$postID."'", "0"]]))], ["PostID" => ["LIKE", "'".$postID."'", "0"]]);
            echo "***1";
        }
    }

    if($_POST['fct']!== null)
    {
        $fct=$_POST['fct'];
        switch($fct) {  //switch the ajax request, call the right function
            case 'AddNP' :
                if(1)//mettre des parametres si besoin
                    AddNewPost();
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'AddNM' :
                if($_POST['content']!== null && $_POST['UsernameReceiver'])
                    AddNewMessage($_POST['Message'], $_POST['UsernameReceiver']);
                else
                    php_err("error, not enough POST in ajax request");
                break;   
            case 'chngCV ' :
                if($_POST['usernameFriend']!== null)
                    changeConversation($_POST['usernameFriend']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'sendMIDB ' :
                if($_POST['usernameFriend']!== null && $_POST['content']!== null)
                    sendMessageIntoDB($_POST['usernameFriend'], $_POST['content'], $_POST['type']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'CCM ' :
                if($_POST['postID']!== null)
                    createComment($_POST['postID']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'SP ' :
                    if($_POST['inputValue']!== null)
                        searchProfil($_POST['inputValue']);
                    else
                        php_err("error, not enough POST in ajax request");
                    break;
            case 'cA ' :
                if($_POST['commentIDlist']!== null)
                    createAnswers($_POST['commentIDlist']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            // case 'NewF ' :
            //     if(1)               
            //         NewFilter();            // 
            //     else
            //         php_err("error, not enough POST in ajax request");
            //     break;  
            case 'newCMFW ' :
                if($_POST['postID'] != null && $_POST['content'] != null)
                    createCommentsFromWeb($_POST['postID'], $_POST['content']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'newAFW ' :
                if($_POST['commentID'] != null && $_POST['content'])
                    createAnswerFromWeb($_POST['commentID'], $_POST['content']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'LikeP' :
                if($_POST['postID'] != null)
                    LikePost($_POST['postID']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            case 'UnlikeP' :
                if($_POST['postID'] != null)
                    UnlikePost($_POST['postID']);
                else
                    php_err("error, not enough POST in ajax request");
                break;
            default :
                php_err("error POST fct invalid in ajax request");      
                break;      
        }
    }
    else
    {
       php_err("error POST fct not defined in ajax request");
    }
?>
