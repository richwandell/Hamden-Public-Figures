<?php use csc545\lib\Flash;

if(!defined("BOOTSTRAP")) die("no bs"); ?>
<!DOCTYPE html>
<html>
<?php $this->render("head.php", array(
    "css_files" => $this->css_files,
    "js_files" => $this->js_files
)); ?>

<?php $this->render("header.php", array("activetab" => "people")); ?>
<body>
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $person->full_name; ?></div>
        <div class="panel-body">
            <form action="/people/update" method="post">
                <p>
                    <b><?php echo $person->full_name; ?> is a member of the following organizations:</b> <br>
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
                    <?php foreach($person->organizations as $org): ?>
                        <tr>
                            <td><a href="/organization/info/<?php echo $org->org_id; ?>"><?php echo $org->organization_name; ?></a></td>
                            <td><?php echo $org->organization_job_title; ?></td>
                            <td><?php echo $org->person_start_date->format('m-d-Y'); ?></td>
                            <td><?php echo $org->person_end_date->format('m-d-Y'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                        <tr id="add-to-org-row">
                            <td>
                                <div class="form-group <?php if(Flash::hasFormError("organizations_select")): ?>has-error<?php endif; ?>">

                                    <input id="save_new_org" type="hidden" name="save_new_org" <?php
                                    if($show_new_org_row):
                                        ?>value="1"<?php
                                    else:
                                        ?>value="0"<?php
                                    endif; ?>/>

                                    <button type="button" class="btn-success <?php
                                    if($show_new_org_row):
                                        ?>hidden<?php
                                    endif; ?>">Add <?php echo $person->full_name; ?> to an Organization</button>

                                    <select class="form-control <?php if(!$show_new_org_row): ?>hidden<?php endif; ?>" name="organizations_select">
                                    <?php foreach($organizations as $org): ?>
                                        <?php if(!$person->isMemberOfOrganization($org)): ?>
                                        <option value="<?php echo $org->org_id; ?>" <?php
                                        if(Flash::getFormState("organizations_select") == $org->org_id):
                                            ?>selected="selected"<?php
                                        endif; ?>><?php echo $org->organization_name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group <?php if(!$show_new_org_row): ?>hidden<?php endif; ?>">
                                    <select class="form-control" name="job_title">
                                        <?php foreach($job_titles as $job): ?>
                                        <option value="<?php echo $job->job_title_id; ?>"><?php echo $job->job_title_text; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group <?php
                                if(Flash::hasFormError("new_org_start_date")):
                                    ?>has-error<?php
                                elseif(!$show_new_org_row):
                                    ?>hidden<?php
                                endif;
                                ?>">
                                    <input class="form-control" type="date" name="new_org_start_date" <?php
                                    if(Flash::hasFormState("new_org_start_date")):
                                        ?> value="<?php
                                        echo Flash::getFormState("new_org_start_date")->format('Y-m-d'); ?>" <?php
                                    endif; ?>/>
                                </div>
                            </td>
                            <td>

                                <div class="form-group <?php
                                if(Flash::hasFormError("new_org_end_date")):
                                    ?>has-error<?php
                                elseif(!$show_new_org_row):
                                    ?>hidden<?php
                                endif; ?>">

                                    <input class="form-control" type="date" name="new_org_end_date" <?php
                                    if(Flash::hasFormState("new_org_end_date")):
                                        ?>value="<?php
                                        echo Flash::getFormState("new_org_end_date")->format('Y-m-d'); ?>"<?php
                                    endif; ?>/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <input type="hidden" value="<?php echo $person->person_id; ?>" name="person_id" />
                <input type="hidden" value="<?php echo $this->csrf("update"); ?>" name="csrf_token" />
                <div class="form-group <?php if(Flash::hasFormError("first_name")): ?>has-error<?php endif; ?>" id="p-form-1">
                    <label for="fname_input">First Name</label>
                    <input value="<?php echo $person->first_name; ?>" type="text" class="form-control" id="fname_input" name="first_name" placeholder="First Name" />
                </div>
                <div class="form-group <?php if(Flash::hasFormError("last_name")): ?>has-error<?php endif; ?>" id="p-form-3">
                    <label for="lname_input">Last Name</label>
                    <input value="<?php echo $person->last_name; ?>" type="text" class="form-control" id="lname_input" name="last_name" placeholder="Last Name" />
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>