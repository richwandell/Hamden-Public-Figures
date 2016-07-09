<?php if(!defined("BOOTSTRAP")) die("no bs"); ?>
<head>
    <link rel="stylesheet" href="/cssjs/global.css" />
    <?php foreach($css_files as $file): ?>
        <link rel="stylesheet" href="/cssjs/<?php echo $file; ?>" />
    <?php endforeach; ?>

    <?php foreach($js_files as $file): ?>
        <script src="/cssjs/<?php echo $file; ?>" ></script>
    <?php endforeach; ?>
</head>