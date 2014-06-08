<?php $email = $user['email'];
$default = $this->request->getBaseUrl(). '/img/default-avatar-large.gif';
$size = 30;
$grav_url = "http://www.gravatar.com/avatar/" .
 md5( strtolower( trim( $email ) ) ) . 
 "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<img src="<?=$grav_url?>" alt="" />
<p><h3><?=$user['login'] ?></h3></p>
<p>Posts</p>
<?php foreach ($posts as $post): ?>
    <p><a href="<?=$this->url->create('question/get-one/'.$post['id'].'')?>"><?=$post['title']?></a></p>
<?php endforeach; ?>
<p>Answers</p>
<?php foreach($answers as $answer): ?>
	<?php if($answer['belongs'] == $post['id']): ?>
    <?php endif; ?>
    <p><a href="<?=$this->url->create('question/get-one/'.$answer['belongs'].'')?>"><?=$answer['text']?></a></p>
<?php endforeach;?>