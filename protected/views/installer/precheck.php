<?php
    echo CHtml::beginForm(['installer/precheck'], 'post', ['class' => 'form-horizontal']);
    $pass = empty($preCheck->errors);
    foreach($preCheck->getSafeAttributeNames() as $attribute) {
        $errors = $preCheck->getErrors($attribute);
        echo CHtml::openTag('div', [
            'class' => 'form-group ' . (empty($errors) ? 'has-success' : 'has-error')
        ]);
            echo CHtml::tag('label', ['class' => 'control-label col-sm-3'], $preCheck->getAttributeLabel($attribute));
            echo CHtml::openTag('div', ['class' => 'col-sm-9']);
            echo CHtml::openTag('div', ['class' => 'form-control']);
            $current = $preCheck->$attribute;
            echo TbHtml::icon(empty($errors) ? TbHtml::ICON_OK : TbHtml::ICON_REMOVE);
            if (!is_bool($current)) {
                echo " ".$current;
            }

            echo CHtml::closeTag('div');
            if (!empty($errors)) {
                echo CHtml::tag('span', ['class' => 'help-block'], $errors[0]);
            }

            echo CHtml::closeTag('div');
        echo CHtml::closeTag('div');
    }
    // Check optional modules.
    $preCheck->scenario = 'optional';
    $preCheck->validate();

    echo CHtml::openTag('div', [
            'class' => 'form-group ' . (empty($preCheck->errors) ? 'has-success' : 'has-warning')
        ]);
        echo CHtml::tag('label', ['class' => 'control-label col-sm-3'], gT('Optional modules'));

        echo CHtml::openTag('div', ['class' => 'col-sm-9']);
        foreach ($preCheck->getSafeAttributeNames() as $module) {
            echo CHtml::openTag('label', ['class' => 'checkbox-inline', 'style' => 'margin-left: 0px; margin-right: 10px']);
            echo TbHtml::icon(!isset($preCheck->errors[$module]) ? TbHtml::ICON_OK : TbHtml::ICON_REMOVE, ['style'=> 'padding-right: 15px;']);
            echo $preCheck->getAttributeLabel($module);
            echo CHtml::closeTag('label');

        }
        echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');

?>

<div class="btn-group pull-right">
    <?php 
        echo TbHtml::linkButton('Previous', ['url' => ['installer/license'], 'color' => TbHtml::BUTTON_COLOR_DEFAULT]);
        echo TbHtml::linkButton('Recheck', ['url' => ['installer/session'], 'color' => TbHtml::BUTTON_COLOR_DEFAULT]);
        echo TbHtml::submitButton('Next', ['disabled' => !$pass, 'color' => $pass ? TbHtml::BUTTON_COLOR_PRIMARY : TbHtml::BUTTON_COLOR_DANGER]);
    ?>

</div>
<?php 
    echo CHtml::endForm();
