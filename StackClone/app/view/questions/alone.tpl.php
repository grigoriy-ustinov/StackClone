<?php if($questions):?>
	<?php foreach($authors as $author): ?><!-- may need for each at authors -->
		<?php if($questions['author'] == $author['login']):
            $email = $author['email'];
            $default = $this->request->getBaseUrl(). '/img/default-avatar-large.gif';
            $size = 80;
            $grav_url = "http://www.gravatar.com/avatar/" .
             md5( strtolower( trim( $email ) ) ) . 
             "?d=" . urlencode( $default ) . "&s=" . $size;
            ?>
            <img src="<?=$grav_url?>" alt="" />
            <a href="<?=$this->url->create('users/profile/'.$author['id'].'')?>"><?=$author['login']?></a>
       	<?php endif;?>
    <?php endforeach; ?>
    
    <h4><?=$questions['title']?></h4>
    <?php $questions['text'] = $this->textFilter->doFilter($questions['text'], 'markdown');?>
    <?=$questions['text']?>
    <?=date('D-j H:i:s',$questions['created'])?>
    <!--Question ands here -->
	<?php if($tags != null):?>
		<?php foreach($tags as $tag): ?>
            <?=$tag['name']?>
        <?php endforeach;?>
    <?php endif;?>
    <?php if($user != null): ?>
		<a href="<?=$this->url->create('question/commentform/'.$questions['id'].'/qt')?>">Comment this question</a>
        <a href="<?=$this->url->create('question/answerform/'.$questions['id'].'')?>">Answer this question</a>
    <?php endif;?>
    <?php if($comments != null): ?>
		<?php foreach($comments as $comment): ?>
        	<?php foreach ($authors as $author) : ?>
				<?php if($comment['belongs'] == $questions['id']): ?>
                    <?php if($comment['author'] == $author['login']&& $comment['belongs'] == $questions['id'] &&  $comment['type'] == 'qt'): ?><!--may need authors foreach-->
                        <div class="commentbox">
						<?php  $email = $author['email'];
                            $default = $this->request->getBaseUrl(). '/img/default-avatar-large.gif';
                            $size = 50;
                            $grav_url = "http://www.gravatar.com/avatar/" .
                             md5( strtolower( trim( $email ) ) ) . 
                             "?d=" . urlencode( $default ) . "&s=" . $size;?>
                             <img src="<?=$grav_url?>" alt="" />
                             <a href="<?=$this->url->create('users/profile/'.$author['id'].'')?>"><?=$author['login']?></a>
                             <?php $comment['text'] = $this->textFilter->doFilter($comment['text'], 'markdown');?>
                             <?=$comment['text']?>
                             <p><?=date('D-j H:i:s',$comment['created'])?></p>
                            </div>
                    <?php endif; ?>
                <?php endif; ?>
        	<? endforeach; ?>
        <?php endforeach;?>
	<?php endif; ?>
    <?php if($answers != null): ?>
    	<?php foreach($answers as $answer): ?>
        	<?php foreach($authors as $author): ?>
				<?php if($answer['author'] == $author['login']): ?>
                <div class="answerbox">
                    <?php  $email = $author['email'];
                    $default = $this->request->getBaseUrl(). '/img/default-avatar-large.gif';
                    $size = 80;
                    $grav_url = "http://www.gravatar.com/avatar/" .
                     md5( strtolower( trim( $email ) ) ) . 
                     "?d=" . urlencode( $default ) . "&s=" . $size;?>
                     <img src="<?=$grav_url?>" alt="" />
                     <a href="<?=$this->url->create('users/profile/'.$author['id'].'')?>"><?=$author['login']?></a>
                     <?php $answer['text'] = $this->textFilter->doFilter($answer['text'], 'markdown');?>
                     <?=$answer['text']?>
                     <p><?=date('D-j H:i:s',$answer['created'])?></p>
                     <?php if($user != null): ?>
                     <a href="<?=$this->url->create('question/commentform/'.$answer['id'].'/an')?>">Comment this answer</a>
                     
                    <?php endif;?>
                    </div>
                     <?php foreach($comments as $comment): ?>
                        <?php if($answer['id'] == $comment['belongs']):?>
                            <?php foreach($authors as $author): ?>
                                <?php if(($comment['author'] == $author['login']) && $comment['belongs'] == $answer['id'] && $comment['type'] == 'an'): ?>
                                <div class="commentbox">
                                    <?php  $email = $author['email'];
                                    $default = $this->request->getBaseUrl(). '/img/default-avatar-large.gif';
                                    $size = 80;
                                    $grav_url = "http://www.gravatar.com/avatar/" .
                                     md5( strtolower( trim( $email ) ) ) . 
                                     "?d=" . urlencode( $default ) . "&s=" . $size;?>
                                     <img src="<?=$grav_url?>" alt="" />
                                     <a href="<?=$this->url->create('users/profile/'.$author['id'].'')?>"><?=$author['login']?></a>
                                     <?php $comment['text'] = $this->textFilter->doFilter($comment['text'], 'markdown');?>
                                     <?=$comment['text']?>
                                     <p><?=date('D-j H:i:s',$comment['created'])?></p>
                                     </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                     <?php endforeach;?>
                <?php endif;?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif;?>
<?php endif; ?>