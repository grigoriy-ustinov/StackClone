<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<div class='commentalone'>
<div class ='username'>
<?=$comment->name?>
</div>
<p><?=$comment->content?></p>
<div class ='timestamp'>
<form method=post>
<input type="hidden" name="redirect" value="<?=$this->url->create(''.$comment->page.'')?>">
<input type="hidden" name="id" value="<?=$comment->id?>"/>
<input type="hidden" name="page" value="<?=$comment->page?>"/>
<input type="submit" class="enjoy-css" name="removeOne" value="Remove" onClick="this.form.action = '<?=$this->url->create('comment/remove-one')?>'"/>
<input type="submit" class="enjoy-css" name="edit" value="Edit" onClick="this.form.action = '<?=$this->url->create('comment/edit-one')?>'"/>
</form>
<?=date('D-j H:i:s',$comment->timestamp)?>
</div>

</div>
<?php endforeach; ?>
</div>
<?php endif; ?>