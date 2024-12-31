<?php

?>
<h3>Contact Page</h3>
<h2><?php \app\core\Application::$app->session->getFlash('success') ?? '';?></h2>
<form method="POST" action="/post-login">
    <input name="name" placeholder="enter email">

    <input name="email" value="<?php ?>" placeholder="enter password">
    <button>Login</button>
</form>
