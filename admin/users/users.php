<?php
    $data = users();
    $users = $data["users"];
?>
<a href="index.php?page=create_user">Create New User</a>
<?php include("error.php"); ?>
<table>
    <thead>
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">Customer Name</th>
            <th scope="col">E-mail</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
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
                    <a href="index.php?page=edit_user&id=<?= $user['id']; ?>" class="btn btn-primary">View</a>
                </td>
            </tr>  
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No user found.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>    
