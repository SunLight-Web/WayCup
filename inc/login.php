      <div class="login-form">
    <?php
    if (isset($_GET['error'])) { ?>


    <p class="error">Что-то пошло не так!</p>

    <?php }                      ?> 
    
       <form action="inc/loginProcess.php" method="post" name="login_form">
         <ul>
           <li>
            Пользователь:
            <input type="text" name="username" />
           </li>
           <li>
            Пароль:
            <input type="password" name="password" id="password" />
           </li>
           <li>
            <input type="button" class="btn" value="Вход" onclick="formhash(this.form, this.form.password);" />
            <label for="check"><input type="checkbox" id="check"> Запомнить меня </label>
           </li>
         </ul>
       </form>
     </div>
   </div>
