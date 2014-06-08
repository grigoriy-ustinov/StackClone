<?php
$email = $user['email'];
$default = $this->request->getBaseUrl(). '/img/default-avatar-large.gif';
$size = 80;
$grav_url = "http://www.gravatar.com/avatar/" .
 md5( strtolower( trim( $email ) ) ) . 
 "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<strong><p>Nickname: <?=$user['login']?></p></strong>
<img src="<?=$grav_url?>" alt="" />
<form method=post>
<p>Change password:</p> 
<input type="password" name="password"/>
<p>Change email:</p> 
<input type="email" name="email" />
<input type="hidden" name="id" value="<?=$user['id']?>" />
<input type="hidden" name="refirect" value="<?=$this->request->getCurrentUrl()?>" />
<input type="submit" name="passchange" value="Change password" onClick="this.form.action ='<?=$this->url->create('users/changepass')?>'" />
<input type="submit" name="emailchange" value="Change email" onClick="this.form.action ='<?=$this->url->create('users/changemail')?>'" />
</form>
<strong><p>Email: <?=$user['email']?></p></strong>
<p><a href="<?=$this->url->create('users/logout')?>">Logout</a></p>