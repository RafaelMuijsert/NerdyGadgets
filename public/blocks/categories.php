<?php
    $StockGroups = getStockGroups($databaseConnection);
?>
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="categories__title">Alle categorieën</h2>
            </div>
        </div>

        <div class="row">
            <?php if (isset($StockGroups)) {
                for ($i = 0; $i < 6; $i++) {
                    if ($i == 0):
                        $columnSize = "col-12";
                    elseif ($i == 4 || $i == 5):
                        $columnSize = "col-6";
                    else:
                        $columnSize = "col-4";
                    endif ?>

                    <div class="<?= $columnSize ?> spacing">
                        <a class="categories__item" href="<?= "browse.php?category_id=" . $StockGroups[$i]["StockGroupID"] ?>">
                            <div class="categories__item-inner" id="StockGroup<?= $i + 1; ?>"
                                 style="background-image: url('img/stock-group/<?= $StockGroups[$i]["ImagePath"]; ?>')">
                                <h4 class="categories__item-title"><?= $StockGroups[$i]["StockGroupName"]; ?></h4>
                            </div>
                        </a>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</section>