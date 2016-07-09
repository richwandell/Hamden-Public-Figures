<?php use csc545\lib\Flash;

if(Flash::hasErrorMessages()): ?>
    <?php foreach(Flash::flashErrorMessages() as $error): ?>
        <p class="bg-danger top-message">
            <?php print_r($error); ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

    <?php if(Flash::hasSuccessMessages()): ?>
    <?php foreach(Flash::flashSuccessMessages() as $success): ?>
        <p class="bg-success top-message">
            <?php echo $success; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

    <?php if(Flash::hasInfoMessages()): ?>
    <?php foreach(Flash::flashInfoMessages() as $info): ?>
        <p class="bg-info top-message">
            <?php echo $info; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

    <?php if(Flash::hasWarningMessages()): ?>
    <?php foreach(Flash::flashWarningMessages() as $warning): ?>
        <p class="bg-warning top-message">
            <?php echo $warning; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>