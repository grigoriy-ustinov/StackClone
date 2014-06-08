<table>
    <tr>   
        <th>Login</th>
    </tr>
    <?php foreach ($users as $user) : ?>
    <tr>
        <td><a href="<?=$this->url->create('users/profile/'.$user->id)?>"><?=$user->login?></a></td>
    </tr>
	<?php endforeach; ?>
</table> 