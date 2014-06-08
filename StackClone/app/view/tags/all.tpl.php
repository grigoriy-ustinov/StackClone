<?php foreach($tags as $tag): ?>
<p><a href="<?=$this->url->create('question/getByTag/'.$tag['name'].'')?>"><?=$tag['name']?></a></p>
<?php endforeach; ?>