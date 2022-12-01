
<?php
$total = 0;
foreach($_SESSION['cart'] as $id => $quantity): ?>
    <?php $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
    $price = round($stockItem['SellPrice'], 2);
    $total += $price * $quantity;
    ?>
    <div class="p-2 m-3 border rounded row text-left align-items-center">
        <div class="col-6">
            <label for="quantity" class="mb-0"><?=$stockItem['StockItemName']?></label>
        </div>
        <div class="text-right col">
            <label>
                <input name="quantity" type="number" disabled value="<?=$quantity?>">
            </label>
        </div>

        <div class="text-right col">
            <p class="mb-0">&euro;<?=number_format($price * $quantity, 2)?></p>
        </div>
    </div>
<?php endforeach; ?>
