<?php

$companyType = $_SESSION['username'];
if ($companyType == "Crystaline") {

    echo '
                        <footer class="footer">
            <p><a style="color: white">Crystaline Technologies Limited &copy; 2016. Designed by the Innovation Team .</a></p>
        </div>
        </div>
        </footer>';
        } else {
    echo '
                <footer class="footer">
                    <p><a style="color: white">LSO Contractors Technologies Limited &copy; 2016. Designed by the Innovation Team .</a></p>
                </div>
                </div>
                </footer>';
        }
   

