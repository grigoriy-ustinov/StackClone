<form method='post'>
<fieldset>
    <legend>Login</legend>
        <label><p> Login: </p>
        <input type='text' name='login' value='' /></label><br>
        <label><p>Password:</p>
        <input type='password' name='password' value='' /></label><br>
        <input type='submit' value='Submit' name='submit' onClick="this.form.action = '<?=$this->url->create('users/login')?>'">
    </fieldset>
</form> 
<a href="<?=$this->url->create('users/registrate')?>">or registrate</a>