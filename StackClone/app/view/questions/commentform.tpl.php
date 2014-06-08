    <form method="post">
    <fieldset>
    	Add comment:<textarea name="text"></textarea>
        <input type="hidden" name="belongs" value="<?=$id?>" />
        <input type="hidden" name="type" value="<?=$type?>" />
        <input type="hidden" name="redirect" value="<?=$this->request->getBaseUrl()?>" />
        <input type="submit" name="submit" value="Submit"  onClick="this.form.action ='<?=$this->url->create('question/add-comment')?>'"/>
    </fieldset>
    </form>