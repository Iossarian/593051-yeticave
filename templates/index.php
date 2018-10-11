    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>

        <ul class="promo__list" >

            <!--заполните этот список из массива категорий-->
            <?php foreach ($category_array as $value) { ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="all-lots.php"> <?=$value['category_name']; ?> </a>
                </li>
                <?php
            }
            ?>

        </ul >


    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
         <?php foreach ($lots_array as $value) { ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($value['image']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($value['category_name']) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value['id'];?>"><?= htmlspecialchars($value['name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= htmlspecialchars(formatThePrice($value['start_price'])); ?></span>
                            </div>
                            <div class="lot__timer timer">
                                <?php
                                $lot_end = strtotime($value['end_time']);
                                $time_left = $lot_end - time();
                                $format_time = gmdate("H:i", $time_left);
                                ?>
                                <?= $format_time;?>

                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </section>
