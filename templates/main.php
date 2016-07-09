<?php use csc545\lib\Debug;

if(!defined("BOOTSTRAP")) die("no bs"); ?>
<!DOCTYPE html>
<html>
<?php $this->render("head.php", array(
    "css_files" => $this->css_files,
    "js_files" => $this->js_files
)); ?>

<?php $this->render("header.php", array("activetab" => "overview")); ?>
<body>
    <div class="panel panel-default">
        <div class="panel-heading">Choose an organization that you want to be involved in</div>
        <div class="panel-body">
            <p>
                <ol>
                    <li>Select an organization type to filter the organization list
                    <li>Select an organization from the organization list to display the associated members
                    <li>Select a member name to display contact information
                </ol>
            </p>
        </div>
    </div>
    <select id="organization-type">
        <option
            value="<?php echo $all_type->type_id; ?>"
            <?php if($selected_type->type_id == $all_type->type_id): ?>
                selected="selected"
            <?php endif; ?>
        >
            <?php echo $all_type->type; ?>
        </option>
        <?php foreach($organization_types as $type): ?>
            <option
                value="<?php echo $type->type_id; ?>"
                <?php if($selected_type->type_id == $type->type_id): ?>
                    selected="selected"
                <?php endif; ?>
            >
                <?php echo $type->type; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="list-group">
                        <?php foreach($organizations as $org): ?>
                        <li class="list-group-item <?php if($selected_org->org_id == $org->org_id):
                            $_selected_org_name = $org->organization_name; ?>list-group-item-info<?php endif;?>">
                            <span class="badge"><?php echo $org->person_count; ?></span>
                            <a href="/overview?org=<?php echo $org->org_id ."&type=" . $selected_type->type_id; ?>">
                                <?php echo $org->organization_name; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <u><b>Top Organization Influencers</b></u>
                    <?php if(isset($_selected_org_name)): ?>
                    <br> <?php echo $_selected_org_name; ?>
                    <?php endif; ?>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                    <?php if($selected_org->org_id > 0): ?>
                        <?php foreach($people_in_org as $person): ?>
                        <li class="list-group-item">
                            <a href="/people/info/<?php echo $person->person_id; ?>">
                                <?php echo @$person->full_name; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>

</footer>
</html>