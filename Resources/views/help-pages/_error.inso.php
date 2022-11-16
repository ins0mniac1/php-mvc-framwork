<?php
/** @var Exception $e */
?>
<div style="padding: 2em; color: rgba(0,0,0,0.5)">
    <h1>
        <?= $e->getCode(); ?> - <?= $e->getMessage(); ?>
    </h1>
</div>
