<?php

$deleteLink = $deleteIcon ? "<div class='pm_trash' title='Click to Romove' onclick='moRemoveMetaBox(this);'></div>" : null;
$display    = !$isOpen ? "style='display:none'" : "";
$toggle  = $toggle? "onclick='meta_option_toggole(this);'":null;
$html = "
<div id='side-sortables' class='meta-box-sortables'>
    <div id='user_meta' class='postbox '>
        $deleteLink
        <div class='handlediv' title='Click to toggle' $toggle ><br></div>
        <h3 class='hndle'>$title</h3>
        <div class='inside' $display>
            <p></p>
            $content
            <p></p>
        </div>
    </div>
</div> 
";
?>