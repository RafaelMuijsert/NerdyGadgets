<div class="settings">
    <h1 class="settings__title">Admin instellingen</h1>
    <h5>Verzendkosten</h5>

    <h5>Kortingscodes</h5>
        <div>
    <?php foreach (kortingscodes($databaseConnection) as $kortingscode):
        print_r($kortingscode);
    ?>
    <br>
    <?php endforeach; ?>
        </div>
    [voeg hieronder kortingscodes toe]
</div>