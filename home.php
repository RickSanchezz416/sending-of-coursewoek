
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
    <title>Document</title>
</head>
<body>
<div id="top_menu" class="ui menu">
    <a class="item">Hello <?php echo $_SESSION['logged_user']->user_name; ?></a>
    <div class="right menu">
        <a href="logout.php" class="item" name="logout">Log out</a>
    </div>
</div>
<?php
    if (R::find('courses') == true) {
        $course = R::findAll('courses');
        $work = null;
        echo "<div id='course_works_wrapper'>";
        echo "<table class='ui celled table course_works_table'><thead><tr><th>Date of adding</th><th>Title</th><th>Link to download</th></tr></thead>";
        foreach ($course as $work) {
            echo "<tbody>
                        <tr>
                            <td data-label='name'>$work->onCreate</td>
                            <td data-label='age'>$work->title</td>
                            <td data-label='link_to_download'><a href='home.php?file={$work->file_name}'>" . $work->file_name . "</a></td>
                        </tr>
                   </tbody>";
        }
        echo "</table>";
        echo "<a id='add_course_work' class='ui yellow button' href='AddCourseWork.php'>" . "Add new Work" . "</a>";
        echo "</div>";
            if (isset($_GET['file'])) {
                $filename = basename($work->file_name);
                $filepath = $work->path . $filename;
                if (!empty($filename) && file_exists($filepath)) {

                    header("Cache-Control: public");
                    header("Content-Description: FIle Transfer");
                    header("Content-Disposition: attachment; filename=$filename");
                    header("Content-Type: application/zip");
                    header("Content-Transfer-Emcoding: binary");

                    readfile($filepath);
                    exit;
                }
            }
    } else {
        echo "<h2>You have no works to show.</h2> " . "<a class='ui yellow button' href='AddCourseWork.php'>" . "Add new Work" . "</a>";
    }
?>
</body>
</html>
<?php else : ?>
<?php
    header('Location:/SendCoursWorkSite/index.php');
?>
<?php endif; ?>