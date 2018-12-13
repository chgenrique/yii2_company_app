<?php

use yii\helpers\Html;

?>

<?php echo Html::beginForm(); ?>

<div id="language-select">
    
    <?php 
        if(sizeof($languages) < 4)
        {
            $lastElement = end($languages);
            foreach($languages as $key=>$value)
            {
                if($key != $currentLang)
                {
                    echo Html::ajaxLink($value,'',
                            array('type'=>'post',
                                  'data'=>'_lang='.$key,
                                   'success' => 'function(data) {window.location.reload();}'
                                ),array());
                }else
                {
                    echo '<br>'.$value.'</br>';
                }
                
                if($value != $lastElement)
                {
                    echo ' | ';
                }
            }
        }
        else
        {
            echo yii\helpers\Html::dropDownList('_lang', $currentLang, $languages, array('onchange'=> 'language_change(this)','csrf'=>true));
        }
        ?>
        <script type="text/javascript">
            function language_change(selected)
            {
                <?php echo '$.ajax('.Yii::$app->getUrlManager()->createUrl('site/language').'';
                echo "{'type':'post',";
                echo "success: function(data){window.location.reload();},";
                echo "'data': '_lang='+selected.value";
                ?>
                }
            }
        </script>
    
</div>


<?php echo Html::endForm(); ?>
