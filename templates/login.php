    <nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($category_array as $value) { ?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?= $value['category_name']; ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    </nav>
    <?php $classname = isset($errors) ? "--invalid" : ""; ?>
    <form class="form container" action="../login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
        <?php $classname = isset($errors['email']) ? "form__input--error" : "";
        $value = isset($form['email']) ? $form['email'] : ""; ?>
      <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
          <?php if ($classname): ?>
        <span class="form__error"><?=$errors['email'];?></span>
          <?php endif; ?>
      </div>
        <?php $classname = isset($errors['password']) ? "form__input--error" : "";
        $value = isset($form['password']) ? $form['password'] : ""; ?>
      <div class="form__item form__item--last <?=$classname;?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" required>
          <?php if ($classname): ?>
        <span class="form__error"><?=$errors['password'];?></span>
          <?php endif; ?>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
