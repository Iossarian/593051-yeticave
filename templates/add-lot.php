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
        <form class="form form--add-lot container form--invalid" action="../add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
            <h2>Добавление лота</h2>
            <div class="form__container-two">
                <?php $classname = isset($valid_errors['name']) ? "form__item--invalid" :"";
                $value = isset($lot['name']) ? $lot['name'] : ""; ?>
                <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
                    <label for="lot-name">Наименование</label>
                    <input id="lot-name" value="<?=$value?>" type="text" name="$lot[name]" placeholder="Введите наименование лота" required>
                    <span class="form__error">Введите наименование лота</span>
                </div>
                <?php $classname = isset($valid_errors['category']) ? "form__item--invalid" :"";
                $value = isset($lot['category']) ? $lot['category'] : ""; ?>
                <div class="form__item <?=$classname;?>">
                    <label for="category">Категория</label>
                    <select id="category" name="$lot[category]" required>
                        <option value="">Выберите категорию</option>
                            <?php foreach ($category_array as $value) { ?>
                            <option value="<?=$value['id']?>"><?=$value['category_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="form__error">Выберите категорию</span>
                </div>
            </div>
            <?php $classname = isset($valid_errors['description']) ? "form__item--invalid" :"";
            $value = isset($lot['description']) ? $lot['description'] : ""; ?>
            <div class="form__item form__item--wide <?=$classname;?>">
                <label for="message">Описание</label>
                <textarea id="message" name="$lot[description]" value="<?=$value?>" placeholder="Напишите описание лота" required></textarea>
                <span class="form__error">Напишите описание лота</span>
            </div>
            <?php $classname = isset($valid_errors['image']) ? "form__item--invalid" :"";
            $value = isset($lot['image']) ? $lot['image'] : ""; ?>
            <div class="form__item form__item--file <?=$classname;?>"> <!-- form__item--uploaded -->
                <label>Изображение</label>
                <div class="preview">
                    <button class="preview__remove" type="button">x</button>
                    <div class="preview__img">
                        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                    </div>
                </div>
                <div class="form__input-file">
                    <input class="visually-hidden" type="file" name="$lot[image]" id="photo2" value="">
                    <label for="photo2">
                        <span>+ Добавить</span>
                    </label>
                </div>
            </div>
            <div class="form__container-three">
                <?php $classname = isset($valid_errors['start_price']) ? "form__item--invalid" :"";
                $value = isset($lot['start_price']) ? $lot['start_price'] : ""; ?>
                <div class="form__item form__item--small <?=$classname;?>">
                    <label for="lot-rate">Начальная цена</label>
                    <input id="lot-rate" type="number"  name="$lot[start_price]" placeholder="0" value="<?=$value;?>" required>
                    <span class="form__error">Введите начальную цену</span>
                </div>
                <?php $classname = isset($valid_errors['bet_step']) ? "form__item--invalid" :"";
                $value = isset($lot['bet_step']) ? $lot['bet_step'] : ""; ?>
                <div class="form__item form__item--small <?=$classname;?>">
                    <label for="lot-step">Шаг ставки</label>
                    <input id="lot-step" type="number"  name="$lot[bet_step]" placeholder="0" value="<?=$value;?>" required>
                    <span class="form__error">Введите шаг ставки</span>
                </div>
                <?php $classname = isset($valid_errors['end_time']) ? "form__item--invalid" :"";
                $value = isset($lot['end_time']) ? $lot['end_time'] : ""; ?>
                <div class="form__item <?=$classname;?>">
                    <label for="lot-date">Дата окончания торгов</label>
                    <input class="form__input-date" id="lot-date" type="date" name="$lot[end_time]" value="<?=$value;?>" required>
                    <span class="form__error">Введите дату завершения торгов</span>
                </div>
            </div>
            <?php if (isset($valid_errors)): ?>
            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
                <ul>
                    <?php foreach($valid_errors as $err => $val): ?>
                        <li><strong><?=$dict[$err];?>:</strong> <?=$val;?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <button type="submit" class="button">Добавить лот</button>
        </form>
