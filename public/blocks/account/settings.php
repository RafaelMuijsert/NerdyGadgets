<?php
if (isset($_POST['remove'])) {
    removeKortingscode($_POST['remove'], $databaseConnection);
    unset($_POST['remove']);
}
$waarschuwing = 0;
if (isset($_POST['KortingNaam']) && isset($_POST['KortingProcent'])) {
    $gelijk = 0;
    foreach (kortingscodes($databaseConnection) as $kortingscode){
        if ($kortingscode['codenaam'] == $_POST['KortingNaam']){
            $gelijk ++;
        }
    }
    if (((strlen($_POST['KortingNaam'])) >= 1) && (strlen($_POST['KortingNaam']) <= 10) && ($gelijk == 0)) {
        if (($_POST['KortingProcent'] > 0) && ($_POST['KortingProcent'] < 100)){
            if ($_POST['KortingDate'] == ''){
                $_POST['KortingDate'] = NULL;
            }
            if ($_POST['KortingDate'] < date("Y-m-d") && !($_POST['KortingDate'] == NULL)){
                $waarschuwing = 3;
            }
            else {
                if ($_POST['KortingUses'] == '') {
                    $_POST['KortingUses'] = NULL;
                }
                if ($_POST['KortingUses'] < 1 && !($_POST['KortingUses'] == NULL)) {
                    $waarschuwing = 4;
                }
                else {
                    addKortingscode($_POST['KortingNaam'], $_POST['KortingProcent'], $_POST['KortingDate'], $_POST['KortingUses'], $databaseConnection);
                }
            }
        }
        else $waarschuwing = 2;
    }
    else if (!($gelijk == 0)){
        if (($_POST['KortingProcent'] > 0) && ($_POST['KortingProcent'] < 100)){
            if ($_POST['KortingDate'] == ''){
                $_POST['KortingDate'] = NULL;
            }
            if ($_POST['KortingDate'] < date("Y-m-d") && !($_POST['KortingDate'] == NULL)){
                $waarschuwing = 4;
            }
            else {
                if ($_POST['KortingUses'] == '') {
                    $_POST['KortingUses'] = NULL;
                }
                if ($_POST['KortingUses'] < 1 && !($_POST['KortingUses'] == NULL)) {
                    $waarschuwing = 5;
                }
                else {
                    updateKortingscode($_POST['KortingNaam'], $_POST['KortingProcent'], $_POST['KortingDate'], $_POST['KortingUses'], $databaseConnection);
                }
            }
        }
    }
    else $waarschuwing = 1;
}
?>
<div class="settings">
    <h1 class="settings__title">Admin instellingen</h1>
    <h5>Verzendkosten</h5>
    <form>
        <div class="row">
            <div class="col-2">
                <label>Verzendkosten Grens:</label>
            </div>
            <div class="col">
                <input type="text">
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <label>Verzendkosten Aantal:</label>
            </div>
            <div class="col">
                <input type="text">
            </div>
        </div>
        <input type="submit">

    </form>
    <br><br>
    <h5>Kortingscodes</h5>
    <div>
        <div class="table" style="width: 90%; background-color: var(--main-bg-color);border-radius: var(--border-radius) !important;color: var(--text-color);">
            <div class="row" style="border-bottom: 4px solid white">
                <div class="col-1">ID</div>
                <div class="col-3">Kortingscode</div>
                <div class="col-2">Procent</div>
                <div class="col-2">Geldig Tot</div>
                <div class="col-2">Uses</div>
                <div class="col-2"></div>
            </div>
            <?php foreach (kortingscodes($databaseConnection) as $kortingscode): ?>
                <div class="row">
                    <div class="col-1" style="border-right: 2px solid white"><?php print ($kortingscode['kortingID'])?></div>
                    <div class="col-3" style="width: 30%; border-right: 2px solid white"><?php print ($kortingscode['codenaam'])?></div>
                    <div class="col-2" style="border-right: 2px solid white"><?php print (round($kortingscode['procent'], 2))?></div>
                    <div class="col-2" style="border-right: 2px solid white"><?php if ($kortingscode['geldigtot'] == ''){
                        print ("-");
                        }
                        else print ($kortingscode['geldigtot'])?></div>
                    <div class="col-2" style="border-right: 2px solid white"><?php if ($kortingscode['uses'] == ''){
                            print ("-");
                        }
                        else print ($kortingscode['uses'])?></div>
                    <div class="col-2" style="border-right: 2px solid white">
                        <form method="post">
                            <label style="min-width: min-content; width: 70%" class="btn--primary text-center">
                                Remove
                                <input style="display: none" type="submit" name="remove" value="<?= $kortingscode['kortingID']; ?>">
                            </label>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <form method="post">
                <div class="row">
                    <div class="col-1" style="border-right: 2px solid white"></div>
                    <div class="col-3" style="border-right: 2px solid white">
                        <input style="width: 100%" type="text" maxlength="10" name="KortingNaam" required>
                    </div>
                    <div class="col-2" style="border-right: 2px solid white">
                        <input style="width: 100%" type="text" name="KortingProcent" required>
                    </div>
                    <div class="col-2" style="border-right: 2px solid white">
                        <input style="width: 100%" type="date" name="KortingDate">
                    </div>
                    <div class="col-2" style="border-right: 2px solid white">
                        <input style="width: 100%" type="text" maxlength="4" name="KortingUses">
                    </div>
                    <div class="col-2">
                        <input style="width: 70%; min-width: min-content;" class="btn--primary" type="submit" value="update/add">
                    </div>
                </div>
            </form>
        </div>
        <div class="text-warning"><?php
                if ($waarschuwing == 1){
                    print ("Geen geldige naam! Probeer opnieuw.");
                }
                else if ($waarschuwing == 2){
                    print ("Geen geldig perentage! Probeer opnieuw.");
                }
                else if ($waarschuwing == 3){
                    print ("Geen geldige datum! Probeer opnieuw!");
                }
                else if ($waarschuwing == 4){
                    print ("Geen geldig aantal uses! Probeer opnieuw");
                }
            ?>
        </div>
        <form method="post">
            <input type="submit" name="cleanUp" value="Verwijder ongeldige codes">
        </form>
    </div>
</div>