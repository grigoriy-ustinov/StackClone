    <form method="post">
    <fieldset>
    	Add comment:<textarea name="text"></textarea>
        <input type="hidden" name="belongs" value="<?=$questions['id']?>" />
        <input type="submit" name="submit" value="Submit"  onClick="this.form.action ='<?=$this->url->create('question/add-comment')?>'"/>
    </fieldset>
    </form>