       <div class="span2">
         <div class="menu-left">
          <ul>
            <?php
            for ($i = 0; $i <= (count($navElements) - 1); $i++) { 
                echo '<li><a href="?page=' . $i . '"' . $navElements[$i]->isActive() . '><i class="' . $navElements[$i]->classname . '"></i>' . $navElements[$i]->name . '</a></li>';
              }
            ?>
          </ul>
         </div>
       </div>