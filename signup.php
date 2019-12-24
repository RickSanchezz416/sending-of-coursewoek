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
        <title>Student Course Work Registration</title>
    </head>
    <body>
    <?php
    $data = $_POST;
    if (isset($data['do_signup'])) {
        $errors = array();
        if (empty($data['user_name'])) {
            $errors[] = 'You must enter your user name. :) ';
        } elseif ( strlen($data['user_name']) < 5  || strlen($data['user_name']) > 20) {
            $errors[] = 'Your user name mast be minimum 5 symbols and max 20 symbols. :) ';
        } elseif (R::count('users', 'user_name = ?', array($data['user_name'])) > 0  ) {
            $errors[] = 'This user name already exist. :) ';
        }


        if (empty($data['fk_number'])) {
            $errors[] = 'You must enter your faculty number. :) ';
        } elseif ( strlen($data['fk_number']) <  10 || strlen($data['fk_number']) >  10) {
            $errors[] = 'Your faculty number must be exactly 10 symbols. :) ';
        }

        if (empty($data['name'])) {
            $errors[] = 'You must enter your name. :) ';
        } elseif ( strlen($data['name']) >  100 ) {
            $errors[] = 'Your name must be not more 100 symbols. :) ';
        }

        if ( empty($data['last_name'])) {
            $errors[] = 'You must enter your Second Name. :) ';
        } elseif ( strlen($data['last_name']) >  100 ) {
            $errors[] = 'Your Last Name must be not more 100 symbols. :) ';
        }

        if(!empty($data['password'])) {
            $password = $data['password'];
            if (strlen($data['password']) < 6 || strlen($data['password']) > 30) {
                $errors[] = "Your password mast be minimum 6 symbols and max 30 symbols. :) ";
            } elseif (!preg_match("#[0-9]+#", $password)) {
                $errors[] = "Your Password Must Contain At Least 1 Number!";
            } elseif (!preg_match("#[A-Z]+#", $password)) {
                $errors[] = "Your Password Must Contain At Least 1 Capital Letter!";
            } elseif (!preg_match("#[a-z]+#", $password)) {
                $errors[] = "Your Password Must Contain At Least 1 Lowercase Letter!";
            } elseif (!preg_match("/\W/", $password)) {
                $errors[] = "Password should contain at least one special character";
            }
        } else {
            $errors[] = 'You must enter your password. :) ';
        }

        if (empty($data['second_password'])) {
            $errors[] = 'You must confirm yor password. :) ';
        } elseif ($data['password'] != $data['second_password']) {
            $errors[] = 'Your passwords are not identical. :) ';
        }

        if (empty($data['specialty'])) {
            $errors[] = 'You must enter your specialty. :) ';
        } elseif ( strlen($data['specialty']) >  100 ) {
            $errors[] = 'Your specialty must be not more 100 symbols. :) ';
        }

        if (empty($data['course'])) {
            $errors[] = 'You must enter your course. :) ';
        }

        if (empty($data['form_of_education'])) {
            $errors[] = 'You must enter your form of education. :) ';
        }

        if (empty($errors)) {
            $user = R::dispense('users');
            $user->user_name =  $data['user_name'];
            $user->fk_number =  $data['fk_number'];
            $user->name =  $data['name'];
            $user->middle_name =  $data['middle_name'];
            $user->last_name =  $data['last_name'];
            $user->password =  password_hash($data['password'], PASSWORD_DEFAULT);
            $user->email = $data['email'];
            $user->specialty =  $data['specialty'];
            $user->course =  $data['course'];
            $user->form_of_education =  $data['form_of_education'];
            $user->on_create = date("Y/m/d");
            R::store($user);
            header('Location:/SendCoursWorkSite/index.php');
        } else {
            echo "<div id='registration_error_message' class='ui warning message'><h3>" . array_shift($errors) . "</h3></div>";
        }
    }
    ?>
    <a href="index.php" id="btn-back" class="ui olive labeled icon button"><i class="left chevron icon"></i>Back</a>
    <form action="signup.php" method="post">
        <h1 id="header_registration_page">Become a new user <p role="image" aria-label="Pick emoji">😀</p></h1>
        <div id="form-registration" class="ui form">
            <div class="two fields">
                <div class="field required">
                    <label>User Name</label>
                    <input name="user_name" value="<?php echo@$data['user_name']; ?>" type="text"/>
                </div>
                <div class="field required">
                    <label>Faculty Number</label>
                    <input name="fk_number" value="<?php echo@$data['fk_number']; ?>" type="text"/>
                </div>
            </div>
            <div class="equal width fields">
                <div class="field required">
                    <label>First name</label>
                    <input name="name" value="<?php echo@$data['name']; ?>" type="text"/>
                </div>
                <div class="field">
                    <label>Middle name</label>
                    <input name="middle_name" value="<?php echo@$data['middle_name']; ?>" type="text"/>
                </div>
                <div class="field required">
                    <label>Last name</label>
                    <input name="last_name" value="<?php echo@$data['last_name']; ?>" type="text"/>
                </div>
            </div>
            <div class="equal width fields">
                <div class="field required">
                    <label>Password</label>
                    <input name="password" type="password"/>
                </div>
                <div class="field required">
                    <label>Confirm Password</label>
                    <input name="second_password" type="password"/>
                </div>
                <div class="field required">
                    <label>Email</label>
                    <input type="email" value="<?php echo@$data['email']; ?>" name="email" />
                </div>
            </div>
            <div class="equal width fields">
                <div class="field required">
                    <label>Specialty</label>
                    <input name="specialty" value="<?php echo@$data['specialty']; ?>"  type="text"/>
                </div>
                <div class="field required">
                    <label>Course</label>
                    <select class="ui fluid dropdown" name="course" >
                        <option value=""> </option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="field required">
                    <label>Form of education</label>
                    <select class="ui fluid dropdown" name="form_of_education" >
                        <option value=""></option>
                        <option value="Full time student">Full time student</option>
                        <option value="Study by correspondence">Study by correspondence</option>
                    </select>
                </div>
            </div>
            <button id="btn_registration_page_registration" class="ui orange button" type="submit" name="do_signup">Register me</button>
        </div>
    </form>
    </body>
    </html>
<?php endif; ?>