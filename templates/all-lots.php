
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($category_array as $value) { ?>
                <li class="nav__item">
                    <a href="../all-lots.php?category=<?=$value['id'];?>"><?= $value['category_name']; ?></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
    <div class="container">
      <section class="lots">

        <h2>Все лоты в категории <span><?=$category_name;?></span></h2>
        <ul class="lots__list">
            <?php foreach ($lots_array  as $value) { ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?=htmlspecialchars($value['image']); ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= htmlspecialchars($value['category_name']) ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value['id'];?>"><?= htmlspecialchars($value['name']); ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= htmlspecialchars(formatThePrice($value['start_price'])); ?><b class="rub">р</b></span>
                </div>
                <div class="lot__timer timer">
                    <?php
                    $lot_end = strtotime($value['end_time']);
                    $time_left = $lot_end - time();
                    $format_time = gmdate("H:i", $time_left);
                    ?>
                    <?=$format_time;?>
                </div>
              </div>
            </div>
          </li>
                <?php
            }
            ?>
        </ul>
      </section>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
    </div>