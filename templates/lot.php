<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($category_array as $value) { ?>
            <li class="nav__item">
                <a href="all-lots.php?category=<?=$value['id'];?>"> <?=$value['category_name']; ?> </a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
    <section class="lot-item container">
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
              <?php if(isset($_SESSION['user']) && $lot['author_id'] !== $_SESSION['user']['id']  && $lot['end_time'] <= time() && !$allowed): ?>
            <form class="lot-item__form" action="../lot.php?id=<?=$id;?>" method="post">
                <?php $classname = isset($error['cost']) ? "--invalid" : "";?>
              <p class="lot-item__form-item <?=$classname;?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="number" name="cost" placeholder="<?=getMinBet ($lot); ?>" required>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
              <?php endif; ?>
              <?php if(!empty($error)): ?>
                  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
                  <ul>
                      <div style="color: red; font-size: 14px;"> <?=$error;?></div>
                  </ul>
              <?php endif; ?>
          </div>

          <div class="history">
              <?php if (isset($bet_query_array)):  ?>
            <h3>История ставок (<span><?=count($bet_query_array);?></span>)</h3>
              <?php endif; ?>
            <table class="history__list">
                <?php foreach($bet_query_array as $key=>$val): ?>
              <tr class="history__item">
                <td class="history__name"><?=$val['user_name'];?></td>
                <td class="history__price"><?=formatThePrice($val['price']);?></td>
                  <td class="history__time"><?php print(formatBetTime($val['date']));?></td></td>
              </tr>
                <?php endforeach; ?>
            </table>

          </div>
        </div>
      </div>
    </section>