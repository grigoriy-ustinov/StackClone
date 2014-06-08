<form method='post'>
<fieldset>
    <legend>Login</legend>
        <label> Login: <input type='text' name='login' value='' /></label><br>
        <label> Email: <input type="email" name="email" value="" /></label><br>
        <label>Password: <input type='password' name='password' value='' /></label><br>
        <input type='submit' value='Submit' name='submit' onClick="this.form.action = '<?=$this->url->create('users/add')?>'">
    </fieldset>
</form> 