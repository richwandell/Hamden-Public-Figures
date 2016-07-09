<?php use csc545\lib\Flash;

if(!defined("BOOTSTRAP")) die("no bs"); ?>
<!DOCTYPE html>
<html>
<?php $this->render("head.php", array(
    "css_files" => $this->css_files,
    "js_files" => $this->js_files
)); ?>

<?php $this->render("header.php", array("activetab" => "organizations")); ?>
<body>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo $organization->organization_name; ?></div>
    <div class="panel-body">
        <form action="/organization/removePerson" method="post">
            <p>
                <b>The following people are members of this organization:</b> <br>
            </p>
            <table class="table">
                <thead>
                <tr>
                    <td></td>
                    <td>Job Title</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($organization->people as $person): ?>
                    <tr>
                        <td><a href="/people/info/<?php echo $person->person_id; ?>"><?php echo $person->full_name; ?></a></td>
                        <td><?php echo $person->job_title; ?></td>
                        <td><?php echo $person->start_date->format('m-d-Y'); ?></td>
                        <td><?php echo $person->end_date->format('m-d-Y'); ?></td>
                        <td><button name="delete_button" value="<?php echo $person->person_id; ?>" type="submit" class="btn btn-primary">Remove</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <input type="hidden" value="<?php echo $organization->org_id; ?>" name="organization_id" />
            <input type="hidden" value="<?php echo $this->csrf("removePerson"); ?>" name="csrf_token" />
        </form>
    </div>
</div>
</body>
</html>