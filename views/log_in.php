<div class="alert"><?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?></div>

<!-- login form box -->
<div class="cont_sirena"><img src="sirena.png" class="sirena"></div>
<div class="loginform">
<form method="post" name="loginform" class="">

    <label for="login_input_username">
        <?php if(isset($_GET['adminlogin']) || isset($_GET['dashboard'])) {
            echo 'Usuario';
        } else {
            echo 'Nombre de la tienda';
        }
        ?>
    </label>
    <input id="login_input_username" class="login_input" type="text" name="user_name" required /><br>

    <label for="login_input_password">Clave</label>
    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required /><br>

    <!-- <label for="login_input_email">Mail</label> -->
    <input type="hidden" value="a@a.c" id="login_input_email" class="login_input" type="email" name="user_email" autocomplete="off"  />
    <!-- <br> -->

    <input type="submit" name="login" value="entrar" />
    <div class="ornamenta"></div>

</form>
<div class="logo"></div>

<!-- <a href="register.php">Nueva cuenta</a> -->
</div>