<?php
$users = getAllUsers($databaseConnection);

//print_r($users);

//if (isset($_POST['editID'])) {
//    $userID = $_POST['editID'];
//    $userResult = getUser($userID, $databaseConnection);
//    print_r($userResult);
//}

if (isset($_POST['update'])) {
    $updated = $_POST['edit'];
    print_r($updated);
    editUser($updated['firstname'], $updated['prefixName'], $updated['surname'], $updated['birthDate'], $updated['phone'], $updated['street'], $updated['housenumber'], $updated['postcode'], $updated['city'], $updated['id'], $databaseConnection);
}

if (isset($_POST['deleteID'])) {
    $deleteID = $_POST['deleteID'];
    deleteUser($deleteID, $databaseConnection);
}
?>

<div class="users">
    <div class="users__header">
        <h1>Account beheer</h1>
            <hr>
        <?php
        if (isset($_POST['editID'])):
        $userID = $_POST['editID'];
        $userResult = getUser($userID, $databaseConnection);
        ?>
            <form action="" method="post">
                <input type="text" name="edit[id]" value="<?= @$userResult[0]['id'] ?>" style="display: none">
                <input type="text" name="edit[firstname]" value="<?= @$userResult[0]['voornaam'] ?>" placeholder="Voornaam">
                <input type="text" name="edit[prefixName]" value="<?= @$userResult[0]['tussenvoegsel'] ?>" placeholder="Tussenvoegsel">
                <input type="text" name="edit[surname]" value="<?= @$userResult[0]['achternaam'] ?>" placeholder="Achternaam">
<!--                <input type="email" name="edit[email]" value="--><?php //= @$userResult[0]['email'] ?><!--" placeholder="Email">-->
                <input type="date" name="edit[birthDate]" value="<?= @$userResult[0]['geboortedatum'] ?>" placeholder="Datum">
                <input type="text" name="edit[phone]" value="<?= @$userResult[0]['telefoonnummer'] ?>" placeholder="Telefoonnummer">
                <input type="text" name="edit[street]" value="<?= @$userResult[0]['straat'] ?>" placeholder="Straat">
                <input type="text" name="edit[housenumber]" value="<?= @$userResult[0]['huisnummer'] ?>" placeholder="Huisnummer">
                <input type="text" name="edit[postcode]" value="<?= @$userResult[0]['postcode'] ?>" placeholder="Postcode">
                <input type="text" name="edit[city]" value="<?= @$userResult[0]['stad'] ?>" placeholder="Stad">
                <button type="submit" name="update">Update</button>
            </form>
        <?php endif; ?>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Naam</th>
            <th scope="col">E-mail</th>
            <th scope="col">Geboortedatum</th>
            <th scope="col">Telefoonnummer</th>
            <th scope="col">Adres</th>
            <th scope="col">Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($users as $user) {
            $name = $user['voornaam'] . ' ' . $user['achternaam'];
            $address = $user['straat'] . ' ' . $user['huisnummer'] . ', ' . $user['postcode'] . ' ' . $user['stad'];

            if (isset($user['tussenvoegsel'])) {
                $name = $user['voornaam'] . ' ' . $user['tussenvoegsel'] . ' ' . $user['achternaam'];
            }
            ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $name ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['geboortedatum'] ?></td>
                <td><?= $user['telefoonnummer'] ?></td>
                <td><?= $address ?></td>
                <td>
                    <form action="" method="post">
                        <input type="text" name="editID" value="<?= $user['id'] ?>" style="display: none">
                        <button type="submit">Edit</button>
                    </form>
                    <form action="" method="post">
                        <input type="text" name="deleteID" value="<?= $user['id'] ?>" style="display: none">
                        <button type="submit">Delete</button>
                    </form>
                </td>
<!--                <td>-->
<!--                    <a href="account.php#v-pills-account?edit=--><?php //= $user['id'] ?><!--" class="btn btn-info">Edit</a>-->
<!--                    <a href="account.php#v-pills-account?delete=--><?php //= $user['id'] ?><!--" class="btn btn-danger">Delete</a>-->
<!--                </td>-->
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>