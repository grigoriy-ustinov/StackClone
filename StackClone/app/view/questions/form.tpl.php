<?php if($this->session->get('users',[])): ?>
<form method="post">
    <fieldset>
    	<legend>Add new question</legend>
        <p>Title : </p><input type="test" name="title"/>
        <p>Question: </p><textarea name="text"></textarea>
        <p>Tags must be separated with #: </p><input type="text" name="tags" />
        <input type="hidden" name="redirect" value="<?=$this->url->create('questions')?>" />
        <input type="submit" name="submit" value="Submit" onClick="this.form.action ='<?=$this->url->create('question/add')?>'"/>
    </fieldset>
</form>
<?php endif;?>