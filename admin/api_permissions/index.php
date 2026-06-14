<?php

$page_title = "API Permissions";

include '../includes/admin-header.php';

$db = (new Config())->db();

$permissions = $db->query("
SELECT *
FROM api_permissions
ORDER BY id DESC
")->fetchAll(PDO::FETCH_OBJ);

?>

<div class="content-wrapper">

    <div class="page-header">
        <h2>API Permissions</h2>

        <a href="create.php" class="btn btn-primary">
            + Add Permission
        </a>
    </div>

    <?php adminflashMessage(); ?>

    <div class="card">

        <table class="table table-hover">

            <thead>

            <tr>
                <th>ID</th>
                <th>Permission Key</th>
                <th>Description</th>
                <th width="180">Action</th>
            </tr>

            </thead>

            <tbody>

            <?php foreach($permissions as $permission): ?>

                <tr>

                    <td><?= $permission->id ?></td>

                    <td>
                        <code>
                            <?= $permission->permission_key ?>
                        </code>
                    </td>

                    <td>
                        <?= $permission->description ?>
                    </td>

                    <td>

                        <a href="edit.php?id=<?= $permission->id ?>"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <a href="delete.php?id=<?= $permission->id ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete permission?')">

                            Delete

                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include '../includes/footer.php'; ?>