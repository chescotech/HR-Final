<?php
        // Check if the 'HTTP_REFERER' variable is set
        if(isset($_SERVER['HTTP_REFERER'])){
            // Create a back button that redirects to the previous page
            echo '<li class="back <?php echo $iconClass; ?>" style="list-style: none; text-decoration:none; font-size:165%; margin:5rem;"x><a href="'.$_SERVER['HTTP_REFERER'].'"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i></a></li>';
        } else {
            // If 'HTTP_REFERER' is not set, create a back button that redirects to the homepage
            echo '<li class="back <?php echo $iconClass; ?>" style="list-style: none; text-decoration:none; font-size:165%;margin:5rem;"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i></a></li>';
        }
        ?>