<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create(''.$toEdit['page'].'')?>">
        <fieldset>
        <legend>Leave a comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$toEdit['content']?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$toEdit['name']?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$toEdit['web']?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$toEdit['mail']?>'/></label></p>
        <p class=buttons>
        <input type="hidden" name="id" value="<?=$toEdit['id']?>"/>
        <input type=hidden name="page" value="<?=$toEdit['page']?>">
            <input type='submit' name='edit' value='Edit' onClick="this.form.action = '<?=$this->url->create('comment/save-one')?>'"/>
            <input type='reset' value='Reset'/>
        </p>
        </fieldset>
    </form>
</div>
