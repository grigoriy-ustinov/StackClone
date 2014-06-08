    <form method="post">
    <fieldset>
    	Add answer:<textarea name="text"></textarea>
        <input type="hidden" name="belongs" value="<?=$questions['id']?>" />
        <input type="submit" name="submit" value="Submit"  onClick="this.form.action ='<?=$this->url->create('question/add-answer')?>'"/>
    </fieldset>
    </form>