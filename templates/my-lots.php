<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($category_array as $value) { ?>
            <li class="nav__item">
                <a href="../all-lots.php?category=<?=$value['id'];?>"> <?=$value['category_name']; ?> </a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
          <?php foreach ($lots_array as $value) { ?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?=htmlspecialchars($value['image']); ?>" width="54" height="40" alt="Сноуборд">
            </div>
              <div>
            <h3 class="rates__title"><a href="lot.php?id=<?=$value['id'];?>"><?= htmlspecialchars($value['name']); ?></a></h3>
              <p><?=$value['contacts'];?></p>
              </div>
          </td>
          <td class="rates__category">
              <?= htmlspecialchars($value['category_name']) ?>
          </td>
          <td class="rates__timer">
            <div class="timer timer--finishing">
                <?php
                $lot_end = strtotime($value['end_time']);
                $time_left = $lot_end - time();
                $format_time = gmdate("H:i", $time_left);
                ?>
                <?=$format_time;?>
            </div>
          </td>
          <td class="rates__price">
              <?=htmlspecialchars(formatThePrice($value['MAX(bet.price)'])); ?>
          </td>
          <td class="rates__time">
              <?=formatBetTime($value['date']); ?>
          </td>
        </tr>
              <?php
          }
          ?>
      </table>
    </section>