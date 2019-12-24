<?php
    require 'db.php';
?>

<?php  if( isset($_SESSION['logged_user'])) : ?>
    <?php
    header('Location:/SendCoursWorkSite/home.php');
    ?>
<?php else : ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="css/mine.css">
    <title>Student Course Work Login in</title>
</head>
<body>
<?php
    $data = $_POST;

    if (isset($data['do_login'])) {
        $errors = array();
        $user = R::findOne('users', 'user_name = ?', array($data['user_name']));
        if ($user) {
            if ( password_verify($data['password'], $user->password)) {
                $_SESSION['logged_user'] = $user;
                header('Location:/SendCoursWorkSite/home.php');
            } else {
                $errors[] = 'The incorrect password entered. ';
            }
        } else {
            $errors[] = 'User with this user name not found. ';
        }

        if (!empty($errors)) {
            echo "<div id='log_error_message' class='ui warning message'><h3>" . array_shift($errors) . "</h3></div>";
        }
    }
?>
<div class="ui three column grid">
    <div class="column"></div>
<div class="column">
    <h1 id="logo">Send your course work <p role="image" aria-label="hamburger">😉</p></h1>
    <form id="form_log_in" class="ui form" action="index.php" method="post">
        <div class="field">
            <label>First Name</label>
            <input name="user_name" value="<?php echo@$data['user_name']; ?>" type="text"/>
        </div>
        <div class="field">
            <label>Password</label>
            <input name="password" type="password"/>
        </div>
        <button name="do_login" id="btn_log_in" class="ui red button" type="submit">Log in</button>
        <a href="signup.php" id="btn_registration" class="ui orange button">Registration</a>
    </form>
</div>
    <div class="column"></div>
</div>
</body>
</html>
<?php endif; ?>
