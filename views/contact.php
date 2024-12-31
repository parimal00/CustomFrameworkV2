<?php

?>
<h3>Contact Page</h3>
<h2><?php \app\core\Application::$app->session->getFlash('success') ?? '';?></h2>
<form method="POST">
    <input name="name" value="<?php  echo $user->name ?>" placeholder="enter name">
    <span style="color: red"><?php echo $user->getFirstError('name') ?></span> <br>

    <input name="email" value="<?php  echo $user->email ?>" placeholder="enter email">
    <span style="color: red"><?php echo $user->getFirstError('email') ?></span> <br>

    <input name="password" placeholder="enter password">
    <span style="color: red"><?php echo $user->getFirstError('password') ?></span> <br>

    <input name="confirmPassword" placeholder="repeat password">
    <span style="color: red"><?php echo $user->getFirstError('confirmPassword') ?></span> <br>
    <button>Submit</button>
</form>
