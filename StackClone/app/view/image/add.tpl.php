<form method=post enctype='multipart/form-data'>
<p><label>Picture: <br/><input type='file' name='picture' value=''/></label></p>
<input type="submit" name="add" value="save" onClick="this.form.action = '<?=$this->url->create('image/save')?>'"/>
</form>