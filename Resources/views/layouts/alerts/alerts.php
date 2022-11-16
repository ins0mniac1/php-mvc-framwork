<div class="container my-5">
    <?php if (getFlash('success')) : ?>
        <div class="alert alert-success">
            <?= getFlash('success'); ?>
        </div>
    <?php elseif (getFlash('error')) : ?>
        <div class="alert alert-danger">
            <?= getFlash('error'); ?>
        </div>
    <?php elseif (getFlash('warning')) : ?>
        <div class="alert alert-warning">
            <?= getFlash('warning'); ?>
        </div>
    <?php endif; ?>
</div>
