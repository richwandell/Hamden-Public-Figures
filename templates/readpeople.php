<?php if(!defined("BOOTSTRAP")) die("no bs"); ?>
<!DOCTYPE html>
<html>
    <?php $this->render("head.php", array(
        "css_files" => $this->css_files,
        "js_files" => $this->js_files
    )); ?>

    <?php $this->render("header.php", array("activetab" => "people")); ?>
    <body>
        <div class="panel panel-default">

            <div class="panel-heading">Panel heading</div>
            <div class="panel-body">
                <p>These are people that we have saved in our database</p>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <td>
                            First Name
                        </td>
                        <td>
                            Last Name
                        </td>
                        <td>
                            Gender
                        </td>
                    </tr>
                </thead>
                <?php foreach($people as $person): ?>
                    <tr>
                        <td><?php echo $person->firstname; ?></td>
                        <td><?php echo $person->lastname; ?></td>
                        <td><?php echo $person->gender; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
    <footer>
        
    </footer>
</html>