<main>
    <?= $header; ?>

    <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container <?= $classname; ?>" action="sign-up.php" method="POST" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>

      <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= getPostVal('email'); ?>">
        <span class="form__error"><?= $errors['email']; ?></span>
      </div>

      <?php $classname = isset($errors['user_password']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="user_password">Пароль <sup>*</sup></label>
        <input id="user_password" type="password" name="user_password" placeholder="Введите пароль" >
        <span class="form__error"><?= $errors['user_password']; ?></span>
      </div>

      <?php $classname = isset($errors['user_name']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="user_name">Имя <sup>*</sup></label>
        <input id="user_name" type="text" name="user_name" placeholder="Введите имя" value="<?= getPostVal('user_name'); ?>">
        <span class="form__error"><?= $errors['user_name']; ?></span>
      </div>

      <?php $classname = isset($errors['contacts']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="contacts">Контактные данные <sup>*</sup></label>
        <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться"><?= getPostVal('contacts'); ?></textarea>
        <span class="form__error"><?= $errors['contacts']; ?></span>
      </div>

      <?php if (isset($errors)): ?>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <?php endif; ?>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
