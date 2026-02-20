<?php
    session_start();  
    $host = "localhost";  
    $database = "doktordakic_app";
    $username = "doktordakic_app";
    $password = "pFe.W2m%YY7*";  
    $message = "";
    try{  
        $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));  
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        if(isset($_POST["login"])){  
            if(empty($_POST["username"]) || empty($_POST["password"])){  
                $message = '<label>All fields are required</label>';  
            }else{
                $query = "SELECT * FROM user WHERE user_name = :username AND user_password = :password";  
                $statement = $connect->prepare($query);  
                $statement->execute(array(  
                    'username'     =>     $_POST["username"],  
                    'password'     =>     md5($_POST['password'])
                ));
                $count = $statement->rowCount();  
                $user = $statement->fetchAll();
                //var_dump($user);
                if($count > 0){  
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user']=$_POST['username'];
                    $_SESSION['user_id']=$user[0]['user_id'];
                    $_SESSION['user_ime']=$user[0]['user_ime'];
                    $_SESSION['user_prezime']=$user[0]['user_prezime'];
                    $_SESSION['user-type']=$user[0]['user_type'];
                    header("location:admin.php");
                }else{  
                     $message = '<label>Wrong Data</label>';  
                }  
            }  
        }  
    }catch(PDOException $error){  
        $message = $error->getMessage();  
    }  
 
    if(isset($_SESSION["logged_in"])){
        header("location:admin.php");
    }else{ 
        include_once('includes/head.php');     
    ?>
    <!-- BODY START -->
    <div id="main-wrapper">
        <!-- MAIN PAGE -->
        <div class="page-wrapper">
            <!-- MAIN CONTAINER -->
            <div class="container-fluid">
                <div class="login-wrapper">
                    <div class="login-inner">
                        <form method="post" action="index.php">
                            <h4 class="mb-4">Administracija sajta</h4>
                            <div class="username-holder d-flex justify-content-end mb-2">
                                <label class="mr-2" for="username">Korisničko ime:</label>
                                <input type="text" name="username" id="user_name">
                            </div>
                            <div class="password-holder d-flex justify-content-end mb-4">
                                <label class="mr-2" for="password">Lozinka:</label>
                                <input type="password" name="password" id="pass_word">
                            </div>
                            <div class="submit-holder">
                                <button class="btn btn-primary" name="login" type="submit">Prijava</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <style>
    .username-holder,.password-holder{
        width: 100%;
        max-width: 320px;
    }
    form{
        display: flex;
        flex-direction: column;
        align-content: center;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    
    </style>
    <!-- BODY END --> 
    <?php 
    include_once('includes/footer.php');
    } ?>