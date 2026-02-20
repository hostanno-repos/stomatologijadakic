<?php
ob_start();
session_start();
include_once ('includes/head.php');
$host = "localhost";  
include_once("../cred.php");
$message = "";

try {
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';
        } else {
            $query = "SELECT * FROM user WHERE user_name = :username AND user_password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username' => $_POST["username"],
                    'password' => md5($_POST['password'])
                )
            );
            $count = $statement->rowCount();
            $user = $statement->fetchAll();
            //var_dump($user);
            if ($count > 0) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['user_id'] = $user[0]['user_id'];
                $_SESSION['user_ime'] = $user[0]['user_ime'];
                $_SESSION['user_prezime'] = $user[0]['user_prezime'];
                $_SESSION['user-type'] = $user[0]['user_type'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (60 * 60 * 24);
                header("location:admin.php");
            } else {
                $message = '<label>Wrong Data</label>';
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
}

$now = time();

if (isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']) {
    header("location:admin.php");
} else {
    session_destroy();
    include_once ('includes/head.php');
    ?>
    <section class="vh-100 p-0">
        <div class="container-fluid h-custom vh-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5 text-center px-3">
                    <img src="assets/brand/logo-horizontal.svg" class="img-fluid login-logo" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post" action="index.php">
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Korisničko ime:</label>
                            <input name="username" type="text" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Unesite korisničko ime..." />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Lozinka:</label>
                            <input name="password" type="password" id="form3Example4" class="form-control form-control-lg"
                                placeholder="Unesite lozinku..." />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;" name="login">Prijava</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        body {
            background: transparent linear-gradient(180deg, #00335E 0%, #0A0C10 100%) 0% 0% no-repeat padding-box;
            background: transparent linear-gradient(180deg, #00335E 0%, #0A0C10 100%) 0% 0% no-repeat padding-box;
            color: #fff;
        }

        .form-control-lg {
            font-size: 1rem;
        }

        .btn-group-lg>.btn,
        .btn-lg {
            font-size: 1rem;
        }

        label {
            color: #fff;
        }

        .username-holder,
        .password-holder {
            width: 100%;
            max-width: 320px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-content: center;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        input {
            min-width: 280px;
        }
    </style>
    <!-- BODY END -->
    <?php include_once ('includes/footer.php');
} ?>