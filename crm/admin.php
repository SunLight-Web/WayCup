<?php include('menu_items.php'); ?>
<div class="span10">
     <div class="main-content">
		<h3 class="main-title">Позиции в меню:</h3><br/>
		<div class="table-menu">
		   <table>
             <thead>
               <td>Название</td>
               <td>Цена</td>
               <td>Категория</td>
               <td>Изменить</td>
             </thead>
             <tbody>
              <?php 
                foreach ($menu['elements'] as $element) {
                  $element->showAsRow();
                }
              ?>
             </tbody>
           </table>
   </div>


	</div>
</div>