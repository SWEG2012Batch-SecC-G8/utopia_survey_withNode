<?php 
   session_start();
function urlaccess($method,$Filepath,$scriptname)
{   
    if ($_SESSION["logged_in"]!="yes"){
    $turePath= str_replace("\\","/",$Filepath);
    
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:log in.php' ) );
     if ( $method == "GET" && $turePath==$scriptname) 
            {  
            header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
            die( header( 'location:log in.php' ) );
            }
        }        
}
?>