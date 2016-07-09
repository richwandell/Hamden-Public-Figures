<?php if(!defined("BOOTSTRAP")) die("no bs"); ?>
<!DOCTYPE html>
<html>
<?php $this->render("head.php", array(
    "css_files" => $this->css_files,
    "js_files" => $this->js_files
)); ?>

<?php $this->render("header.php", array("activetab" => "people")); ?>
    <body>
        <form action="/people/add" method="POST">
            <input type="hidden" value="<?php echo $this->csrf("add"); ?>" name="csrf_token" />
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name"
                <?php if(!empty($_SESSION["form.state"]["first_name"])): ?>
                value="<?php echo $_SESSION["form.state"]["first_name"]; unset($_SESSION["form.state"]["first_name"]); ?>"
                <?php endif; ?>
                />
            </div>
            <div class="form-group">
                <label for="last_name">Password</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
            </div>
            <div class="form-group">
                <label for="gender">
                    Gender
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender1" value="male"> Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender2" value="female"> Female
                </label>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </body>
    <footer>

    </footer>
</html>