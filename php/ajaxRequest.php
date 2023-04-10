<?php
    function AddNewPost()
    {   
        //faire la recherche sur le serveur d'un nouveau post                                                                                        
        // renvoyer les valeurs sous cette forme : echo $tmptab[0].";".$tmptab[1].";".$ret_ses.";".$tmptab[2].";".$tmptab[3].";".$tmptab[4];    
        // càd  un tableau dont chaque case contient une valeur qui nous intéresse (peut aussi etre un tableau de valeur dans l'une des cases du tableau)
        // on peut aussi simplement renvoyer des valeurs unique sans tableau c'est un exemple pour mieux les organiser dans la fonction mais penser à bien séparer les valeurs par ";"
        return 0;
    }

    function AddNewMessage()
    {   
        //faire la recherche sur le serveur d'un nouveau message privé                                                                                     
        // renvoyer les valeurs sous cette forme : echo $tmptab[0].";".$tmptab[1].";".$ret_ses.";".$tmptab[2].";".$tmptab[3].";".$tmptab[4];    
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
        if($fct=='AddNP')
        {
            if(1)//mettre des parametres si besoin
            {
                //Fonction php avec des parametres si besoin
                AddNewPost();
            }
            else
                echo "error, not enough POST in ajax request";
        }
        elseif($fct=='AddNM')
        {
            if(1)
            {
                //Fonction php
                AddNewMessage();
            }
            else
                echo "error, not enough POST in ajax request";
        }
        elseif($fct=='NewF')
        {
            if(1)
            {
                //Fonction php                
                NewFilter();
            }
            else
                echo "error, not enough POST in ajax request";
        }
    }
    else
    {
        echo "error POST fct not defined in ajax request";
    }
?>