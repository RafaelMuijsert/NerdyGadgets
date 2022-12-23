<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Contact</title>
    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!--        <script src="js/resizer.js"></script>-->

    <!-- Style sheets-->
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>
<?php
include "header.php";
include "../src/functions.php";
?>

    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="order__wrapper bg-white bg-white--large">

                    <div id="Email" class="tabcontent">
                        <h3>Email</h3>
                        <p>Email: Nerdygadgets.shop</p>
                        <form action="mailto:s1190870@student.windesheim.nl" method="POST">
                            <div>
                                <button class="btn btn--primary" type="submit">Stuur een mail</button>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div id="Bellen" class="tabcontent">
                        <h3>Bellen</h3>
                        <p>Telefoonnummer: +31 6 18242168</p>
                        <div id="copy" style="display: none;">+31 6 18242168</div>
                        <button class="btn btn--primary" type="button" id="btnCopy">Kopieër nummer</button>
                        <script type="text/javascript">
                            var $body = document.getElementsByTagName('body')[0];
                            var $btnCopy = document.getElementById('btnCopy');
                            var $copy = document.getElementById('copy').innerHTML;

                            var copyToClipboard = function(copy) {
                                var $tempInput = document.createElement('INPUT');
                                $body.appendChild($tempInput);
                                $tempInput.setAttribute('value', $copy)
                                $tempInput.select();
                                document.execCommand('copy');
                                $body.removeChild($tempInput);
                            }

                            $btnCopy.addEventListener('click', function(ev) {
                                copyToClipboard($copy);
                            });
                        </script>
                    </div><br>

                    <div id="Address" class="tabcontent">
                        <h3>Address</h3>
                        <p>Huppelstraat 21
                            4466 TR, Japinko</p>
                        <div class="mapouter">
                            <div class="gmap_canvas">
                                <iframe width="600" height="600" id="gmap_canvas" src="https://maps.google.com/maps?q=Papendorpseweg%20100,%203528%20BJ%20Utrecht&t=k&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                <a href="https://2piratebay.org">pirate bay</a><br>
                                <style>.mapouter{position:relative;text-align:right;height:600px;width:600px;}</style>
                                <a href="https://www.embedgooglemap.net">embed map on website</a>
                                <style>.gmap_canvas {overflow:hidden;background:none!important;height:600px;width:600px;}</style>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>

</body>
</html>
