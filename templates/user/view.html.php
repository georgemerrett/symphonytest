<!-- templates/user/view.html.php-->
<div class="container">
        <div class="table" id="users">
            <thead>
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Email Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user){ ?>
                    <tr>
                        <td scope="col"><?= $user->getFirstname() ?></td>
                        <td scope="col"><?= $user->getLastname() ?></td>
                        <td scope="col"></td>
                        <td scope="col"><?= $user->getEmail() ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </div>
</div>