<section class="account">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="bg-white acc-menu">

                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="btn btn--grey nav-link active" id="v-pills-home-tab" data-toggle="tab" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Gebruikersprofiel</a>
                        <?php if(isset($_SESSION['account']) && $_SESSION['account']['role'] == 'Admin'): ?>
                            <a class="btn btn--grey nav-link" id="v-pills-account-tab" data-toggle="tab" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="false">Account beheer</a>
                            <a class="btn btn--grey nav-link" id="v-pills-settings-tab" data-toggle="tab" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Admin instellingen</a>
                        <?php else: ?>
                            <a class="btn btn--grey nav-link" id="v-pills-orders-tab" data-toggle="tab" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">Mijn bestellingen</a>
                        <?php endif; ?>
                        <form class="profile__logout" method="POST" action="">
                            <input name="logoutSubmit" type="submit" class="btn btn--red" value="Uitloggen">
                        </form>
                        <?php
                            if (isset($_POST['logoutSubmit']) && $_POST['logoutSubmit']):
                                $_SESSION['account'] = [];
                                $_SESSION['isLoggedIn'] = false;
                                echo "<script>window.location.replace('./account.php')</script>";
                            endif;
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-9">
                <div class="bg-white bg-white--large">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <?php include 'account/profile.php'?>
                        </div>
                        <?php if(isset($_SESSION['account']) && $_SESSION['account']['role'] == 'Admin'): ?>
                            <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                                <?php include 'account/user-conroll.php'?>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <?php include 'account/settings.php'?>
                            </div>
                        <?php else: ?>
                            <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                                <?php include 'account/my-orders.php'?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var hash = $(e.target).attr('href');
        if (history.pushState) {
            history.pushState(null, null, hash);
        } else {
            location.hash = hash;
        }
    });

    console.log('asdfasdfas' + window.location.hash)

    if(window.location.hash === ''){
        location.href = '#v-pills-home';
    }

    var hash = window.location.hash;
    if (hash) {
        $('.nav-link[href="' + hash + '"]').tab('show');
    }
</script>