    <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container <?= $classname; ?>" action="login.php" method="POST">
      <h2>Вход</h2>
      <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= getPostVal('email'); ?>">
        <span class="form__error"><?= $errors['email']; ?></span>
      </div>
      <?php $classname = isset($errors['user_password']) ? "form__item--invalid" : ""; ?>
      <div class="form__item form__item--last <?= $classname; ?> ">
        <label for="user_password">Пароль <sup>*</sup></label>
        <input id="user_password" type="password" name="user_password" placeholder="Введите пароль" value="<?= getPostVal('user_password'); ?>">
        <span class="form__error"><?= $errors['user_password']; ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>

