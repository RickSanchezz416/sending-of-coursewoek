<?php
    require 'db.php';
?>
<?php  if( isset($_SESSION['logged_user'])) : ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
        <link rel="stylesheet" href="css/mine.css">
        <title>Add mew course work</title>
    </head>
    <body>
    <div id="top_menu" class="ui menu">
        <a class="item">Hello <?php echo $_SESSION['logged_user']->user_name; ?></a>
        <div class="right menu">
            <a href="logout.php" class="item" name="logout">Log out</a>
        </div>
    </div>
    <form class="ui form form-add-new-coursework" action = "" method = "POST" enctype = "multipart/form-data">
        <div class="ui container add-new-work-form">
            <h1 class="add-new-course-work-h1">Add your coursework <p aria-label="Pick emoji">😁</p> </h1>
            <div class="field">
                <label>Title</label>
                <input type = "text" name = "title"/>
            </div>
            <div class="field">
            <input type="file" name = "file" (change)="fileEvent($event)" class="inputfile green" id="embedpollfileinput" />
                <label for="embedpollfileinput" class="ui huge yellow left floated button btn-add-course-work">
                    <i class="ui upload icon"></i>
                    Upload image
                </label>
            </div>
            <div class="field">
            <input type = "submit" class="ui orange button btn-add-course-work"/><br>
            <a class="ui olive icon button left floated" href="home.php">
                <i class="left chevron icon"></i>
                Back
            </a>
            </div>
        </div>
    </form>
    <?php
    $data = $_POST;
    if (isset($_FILES['file'])) {
        $errors = array();
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        if (empty($data['title'])) {
            $errors[] = 'You must enter a Title. :) ';
        }
        if(empty($_FILES['file']['name'])) {
            $errors[] = 'You must upload a file. :) ';
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "courseWorks/" . $file_name);
            $path = "courseWorks/";
            $course = R::dispense('courses');
            $course->title = $data['title'];
            $course->path = $path;
            $course->file_name = $file_name;
            $course->on_create = date("Y/m/d");
            R::store($course);
            header("Location:/SendCoursWorkSite/home.php");
        } else {
            echo "<div class='ui warning message error-message-add-new-coursework'>" . array_shift($errors) . "</div>";
        }
    }
    ?>
</body>
</html>
<?php else : ?>
    <?php
    header('Location:/SendCoursWorkSite/index.php');
    ?>
<?php endif; ?>
