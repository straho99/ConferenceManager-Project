<?php /** @var \RedDevil\ViewModels\UsersRolesPageViewModel $model */
?>

<div class="col-md-9">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Roles</th>
            <th>Assign</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        ?>
        <?php foreach($model->getUsersRoles() as $user): ?>
        <tr>
            <th scope="row"><?php echo $i++; ?></th>
            <td><?php echo $user->getUsername(); ?></td>
            <td><?php echo $user->getFullName(); ?></td>
            <td>
                <?php foreach($user->getRoleTitles() as $title): ?>
                <span class="label label-info"><?php echo $title; ?></span>
                <br/>
                <?php endforeach; ?>
            </td>
            <td>
                <form action="/admin/addRole" method="POST">
                    <input type="text" name="userId" hidden value="<?php echo $user->getUserId(); ?>"/>
                    <select name="roleId" id="roleId">
                        <?php foreach($model->getRoleTitles() as $role): ?>
                            <option value="<?php echo $role['roleId']; ?>"><?php echo $role['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" class="btn btn-xs btn-info" value="Assign"/>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>