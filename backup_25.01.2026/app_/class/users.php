<?php

//GET ALL USERS
class users {
    public function fetch_all() {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM user ORDER BY user_id ASC");
        $query->execute();
        return $query->fetchAll();
    }
}

//GET SINGLE USER BY ID
class singleUser {
    public function fetch_single_user($id) {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM user WHERE user_id = ?");
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetch();
    }
}

/***** EDIT *****/
if(isset($_GET['getUserReset'])){
    include_once('../../connection.php');
    $getUserReset = intval($_GET['getUserReset']);
    $user = new singleUser;
    $user = $user->fetch_single_user($getUserReset);
    echo "
        <!-- ID USERA -->
        <label for='user_id_'>ID корисника:</label>
        <input type='text' name='user_id_' value='$user[user_id]' readOnly>
        <!-- USERNAME -->
        <label for='user_name_'>Корисничко име:</label>
        <input type='text' name='user_name_' value='$user[user_name]' readOnly>
        <!-- TRENUTNI PASSWORD -->
        <label for='user_old_password_'>Тренутна лозинка:</label>
        <input class='' type='password' name='user_old_password_' placeholder='Унеси тренутну лозинку...'>
        <small></small>
        <!-- PASSWORD -->
        <label for='user_password_'>Нова лозинка:</label>
        <input class='' type='password' name='user_password_' placeholder='Унеси нову лозинку...'>
        <small></small>
        <!-- REPEAT PASSWORD -->
        <label for='user_password_repeat_'>Понови лозинку:</label>
        <input class='' type='password' name='user_password_repeat_' placeholder='Понови нову лозинку...'>
        <small></small>";
}
if(isset($_POST['passwordResetUpdate'])){
    $user_id_ = intval($_POST['user_id_']);
    $user = new singleUser;
    $user = $user->fetch_single_user($user_id_);
    if($user['user_password'] == md5($_POST['user_old_password_'])){
        echo("PASS_CHANGED");
        foreach($_POST as $key => $value) {
            //var_dump($key.$value);
            $$key = $value;
            $$key = str_replace('"', '\"', $$key);
        }
        $user_password_ = md5($user_password_);
        $query = $pdo->prepare('UPDATE user SET user_password ="'.$user_password_.'" WHERE user_id='.$user_id_);
        $query->execute();
    }else{
        echo("PASS_WRONG");
    }
}

/***** DELETE *****/
if(isset($_GET['deleteUser'])){
    $user_id = $_GET['deleteUser'];
    $query = $pdo->prepare('DELETE FROM user WHERE user_id = ?');
    $query->bindValue(1, $user_id);
    $query->execute();
    header('Location: korisnici.php');
}

?>