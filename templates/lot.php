<nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($category_array as $value) { ?>
                <li class="nav__item">
                    <a href="all-lots.php"> <?=$value['category_name']; ?> </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <!--<php foreach ($lots_array as $value) { ?> -->
      <h2><?= htmlspecialchars($lot['name']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= htmlspecialchars($lot['image']); ?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['category_name']); ?></span></p>
          <p class="lot-item__description"><?= htmlspecialchars($lot['description']); ?></p>
        </div>
        <div class="lot-item__right">
            <?php if(isset($_SESSION['user'])): ?>
          <div class="lot-item__state">
            <div class="lot-item__timer timer">
                <?php
                $lot_end = strtotime($lot['end_time']);
                $time_left = $lot_end - time();
                $format_time = gmdate("H:i", $time_left);
                ?>
                <?= $format_time;?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                  <span class="lot-item__cost"></span><?= getCurPrice($lot);?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?=getMinBet($lot) . ' ₽'; ?></span>
              </div>
            </div>
            <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
              <p class="lot-item__form-item">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="number" name="cost" placeholder="<?=getMinBet ($lot); ?>">
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
            <?php endif; ?>
         <!-- <div class="history">
            <h3>История ставок (<span>?= $lot['MAX(bet.price)']?></span>)</h3>
            <table class="history__list">
              <tr class="history__item">
                <td class="history__name" value="?=$lot['user_id']?>">?= $lot['name']?></td>
                <td class="history__price">?=$bet['price']?></td>
                  <td class="history__time"></td></td>
              </tr>
            </table>
          </div> -->
        </div>
      </div>
    </section>
