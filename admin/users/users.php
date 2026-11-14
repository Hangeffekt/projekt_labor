<?php
    $data = users();
    $users = $data["users"];
?>
<a href="index.php?page=create_user">Új felhasználó létrehozása</a>
<?php include("error.php"); ?>
<table>
    <thead>
        <tr>
            <th scope="col">Felhasználó-azonosító</th>
            <th scope="col">Vásárló neve</th>
            <th scope="col">E-mail-cím</th>
            <th scope="col">Létrehozás dátuma</th>
            <th scope="col">Művelet</th>
        </tr>
    </thead>
    <tbody>
    <?php if($users != null): ?>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= $user['first_name']; ?> <?= $user['last_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['created_at']; ?></td>
                <td>
                    <a href="index.php?page=edit_user&id=<?= $user['id']; ?>" class="btn btn-primary">Megtekintés</a>
                </td>
            </tr>  
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">Nem található felhasználó.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>    
