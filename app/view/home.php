<?php
View::style()->getStyle();
View::script()->getScript();
View::script()->getScriptFoot();
//echo $data['i'];
foreach($data['ids'] as $v) {
    echo $v['id'];
}
echo '<br>';
echo $data['i']
?>