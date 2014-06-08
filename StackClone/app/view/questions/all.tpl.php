<?php if($questions != null):?>
    <div id='questions'>
        <?php foreach ($questions as $question):?>
            <div class="questionlink">
                <a href="<?=$this->url->create('question/get-one/'.$question['id'].'')?>"><?=$question['title']?></a>
                <?php if(!isset($tags)):?>
                    <?php foreach($tags as $tag): ?>
                        <?php if($tags['belongs'] == $question['id']) :?>
                            <div class="tags">
                                <?=$tag['name']?>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>