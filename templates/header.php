<?php if(!defined("BOOTSTRAP")) die("no bs"); ?>
<header>
    <div class="page-header">
        <h1>
            <?php echo APPNAME; ?>
            <?php if(defined("APPSUBNAME")): ?>
                <small><?php echo APPSUBNAME; ?></small>
            <?php endif; ?>
        </h1>
    </div>

    <?php $this->render("flash.php"); ?>

    <ul class="nav nav-tabs">
        <li role="presentation" class="<?php echo $activetab == "overview" ? "active" : ""; ?>">
            <a href="/overview">Overview</a>
        </li>

        <li role="presentation" class="<?php echo $activetab == "people" ? "active" : ""; ?>">
            <a class="not-dropdown-toggle" data-toggle="not-dropdown" href="javascript:void(0);">People</a>
            <ul class="dropdown-menu">
                <li><a href="/people/create">Create</a></li>
            </ul>
        </li>

        <li role="presentation" class="<?php echo $activetab == "organizations" ? "active" : ""; ?>">
            <a class="not-dropdown-toggle" data-toggle="not-dropdown" href="javascript:void(0);">Organizations</a>
            <ul class="dropdown-menu">
                <li><a href="/organizations/create">Create</a></li>
            </ul>
        </li>
    </ul>
</header>