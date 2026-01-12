<?php
   include './includes/header.inc.php';  
   include './includes/navbar.inc.php';

    
    if(isset($_GET['page'])){
        $page= $_GET['page'];
        if (in_array($page,$varailabel_pages)){  //call array 
            include './pages/' .$page .'.php';
        }else{
  
    }
    }else{
        echo '<h1>Home page</h1>';
    }


    
    
 
    include './includes/footer.inc.php'

?>