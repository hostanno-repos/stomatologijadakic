<?php 
    session_start();
    include_once("../connection.php");
    include_once('class/insertObject.php');
    include_once('class/users.php');
    include_once('includes/head.php'); 
    $_GET['administracija'] = 4; 
    //PODESITI NA KRAJU DA NE MOŽE NEULOGOVAN KORISNIK UĆI U ADMIN PANEL
    if(isset($_SESSION["logged_in"])){  
        $user = new users;
        $user = $user->fetch_all();
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
    
    <?php include_once('includes/sidebar.php') ?>
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    
        <!-- Main Content -->
        <div id="content">
    
            <?php include_once('includes/header.php') ?>
    
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <button class="btn btn-success" data-toggle="modal" data-target="#insertModal"><i class="me-3 mdi mdi-plus fs-3" aria-hidden="true"></i>Dodaj doktora</button>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ime</th>
                        <th scope="col">Prezime</th>
                        <th scope="col">Korisničko ime</th>
                        <!-- <th scope="col">Лозинка</th> -->
                        <th scope="col">Tip korisnika</th>
                        <th class="centeredContent" scope="col">Promjena lozinke</th>
                        <!-- <th class="centeredContent" scope="col">Уреди</th> -->
                        <?php if($_SESSION['user-type'] == 'admin' || $_SESSION['user-type'] == 'superAdmin') { ?>
                        <th class="centeredContent" scope="col">Izbriši</th>
                        <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $user) { ?>     
                        <tr>
                            <th scope="row"><?php echo $user['user_id'] ?></th>
                            <td><?php echo $user['user_ime'] ?></td>
                            <td><?php echo $user['user_prezime'] ?></td>
                            <td><?php echo $user['user_name'] ?></td>
                            <!-- <td><?php echo $user['user_password'] ?></td> -->
                            <td><?php echo $user['user_type'] ?></td>
                            <td class="centeredContent">
                                <?php if($_SESSION['user'] == $user['user_name'] || $_SESSION['user-type'] == "superAdmin") { ?>
                                <i 
                                    class="fa-solid fa-lock"
                                    data-toggle="modal" 
                                    data-target="#editResetPassword"
                                    aria-hidden="true"
                                    dataID="<?php echo $user['user_id'] ?>"
                                    onclick="showResetPassword(<?php echo $user['user_id'] ?>)"
                                ></i>
                                <?php } ?>
                            </td>
                            <!-- <td class="centeredContent"><i class="me-3 mdi mdi-pencil fs-3"></i> </td> -->
                            <?php if($_SESSION['user-type'] == 'admin' || $_SESSION['user-type'] == 'superAdmin') { ?>
                            <td class="centeredContent deleteUsers">
                                <?php if($user['user_type'] != "superAdmin" && $_SESSION['user'] != $user['user_name']) { ?>
                                <i 
                                    class="fa-solid fa-trash" 
                                    aria-hidden="true"
                                    data-toggle="modal" 
                                    data-target="#deleteUsersModal"
                                    dataID_="<?php echo $user['user_id'] ?>"
                                    dataLink="korisnici.php?deleteUser=<?php echo $user['user_id'] ?>"
                                ></i>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Modal INSERT -->
                <div class="modal fade" id="insertModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Dodaj doktora</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="korisnici.php" method="post" autocomplete="off" id="insert_form" enctype='multipart/form-data'>
                                <div class="modal-body">
                                    <!-- IME -->
                                    <label for="user_ime">Ime:</label>
                                    <input type="text" name="user_ime" placeholder="Unesi ime korisnika..." required>
                                    <!-- PREZIME -->
                                    <label for="user_prezime">Prezime:</label>
                                    <input type="text" name="user_prezime" placeholder="Unesi prezime korisnika..." required>
                                    <!-- USERNAME -->
                                    <label for="user_name">Korisničko ime:</label>
                                    <input type="text" name="user_name" placeholder="Unesi korisničko ime..." required>
                                    <!-- PASSWORD -->
                                    <label for="user_password">Lozinka:</label>
                                    <input class="user_password" type="password" name="user_password" placeholder="Unesi lozinku..." required>
                                    <small></small>
                                    <!-- REPEAT PASSWORD -->
                                    <label for="user_password_repeat">Ponovi lozinku:</label>
                                    <input class="user_repeat_password" type="password" name="user_password_repeat" placeholder="Ponovi lozinku..." required>
                                    <small></small>
                                    <!-- USER TYPE -->
                                    <label for="user_type">Tip korisnika:</label>
                                    <select name="user_type" id="user_type">
                                        <option value=""></option>
                                        <option value="publisher">Uređivač</option>
                                        <?php if($_SESSION['user-type'] == 'admin' || $_SESSION['user-type'] == 'superAdmin') { ?>
                                        <option value="admin">Administrator</option>
                                        <?php } if($_SESSION['user-type'] == 'superAdmin') { ?>
                                        <option value="superAdmin">Super administrator</option>
                                        <?php } ?>
                                    </select>
                                    <!-- AUTHOR -->
                                    <label for="user_autor">Autor:</label>
                                    <input name="user_autor" type="text" value="<?php echo $_SESSION['user'] ?>" readOnly>
                                    <!-- DATE -->
                                    <label for="user_datum">Datum unosa:</label>
                                    <input name="user_datum" type="date" value="<?php echo date('Y-m-d') ?>" readOnly>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                                    <button type="submit" class="btn btn-primary" name="submit_user">Sačuvaj</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal RESET PASSWORD -->
                <div class="modal fade" id="editResetPassword">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Resetuj lozinku doktora</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- <form action="" method="post" autocomplete="off" id="edit_form" enctype='multipart/form-data'> -->
                            <div id="password-changed">
                                <p>Vaša lozinka je uspješno izmijenjena..</p>
                            </div>
                            <div id="wrong-old-password">
                                <p>Unijeli ste pogrešnu trenutnu lozinku.</p>
                            </div>
                            <div id="passwords-didnt-match">
                                <p>Nova i ponovljena lozinka se ne poklapaju.</p>
                            </div>
                            <div id="password-too-short">
                                <p>Nova lozinka mora sadržavati najmanje 8 znakova..</p>
                            </div>
                            <div></div>
                            <div class="modal-body" id="poljaResetPassword">
                            </div>
                            <div class="modal-footer">
                                <button id="closeModalEditOglasi" type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                                <button onclick="resetPasswordNow()" class="btn btn-primary" name="editResetPassword">Sačuvaj</button>
                            </div>
                        <!-- </form> -->
                        </div>
                    </div>
                </div>

                <!-- Modal EDIT
                <div class="modal fade" id="editUsersModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Уреди категорију</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="kategorije.php" method="post" autocomplete="off" id="edit_form" enctype='multipart/form-data'>
                            <div class="modal-body" id="poljaKategorije">
                            </div>
                            <div class="modal-footer">
                                <button id="closeModalEditOglasi" type="button" class="btn btn-secondary" data-dismiss="modal">Одустани</button>
                                <button type="submit" class="btn btn-primary" name="editKategorija">Сачувај</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div> -->

                <!-- MODAL DELETE -->
                <div class="modal fade" id="deleteUsersModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Izbriši nalog</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Da li ste sigurni da želite obrisati nalog korisnika/doktora?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                                <a id="confirmDeleteUser" href="">
                                    <button type="submit" class="btn btn-primary" name="deleteUser">Izbriši</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    /* UNOS PASSWORDA ZA NOVOG KORISNIKA */
                    $(".user_password, .user_repeat_password").change(function(){
                        var value0 = $(".user_password").val();
                        var value1 = $(".user_repeat_password").val();
                        if(value0 != "" && value1 != ""){
                            if(value0 === value1){
                                $(".user_password").next("small").html("");
                                $(".user_repeat_password").next("small").html("");
                                if(value0.length < 8 || value1.length < 8){
                                    $(".user_password").next("small").html("Lozinka mora sadržavati najmanje 8 znakova.");
                                    $(".user_repeat_password").next("small").html("Lozinka mora sadržavati najmanje 8 znakova.");
                                }
                            }else{
                                $(".user_password").next("small").html("Lozinke se ne poklapaju.");
                                $(".user_repeat_password").next("small").html("Lozinke se ne poklapaju.");
                            }
                        }
                    });

                    //RESET PASSWORD
                    function showResetPassword(str) {
                        if (str == "") {
                            document.getElementById("poljaResetPassword").innerHTML = "";
                            console.log('test');
                            return;
                        } else {
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("poljaResetPassword").innerHTML = this.responseText;
                            }
                            };
                            xmlhttp.open("GET","class/users.php?getUserReset="+str,true);
                            xmlhttp.send();
                        }
                    }

                    //AJAX ZA PROMJENU PASSWORDA
                    function resetPasswordNow(){
                        var oldPass = $('input[name="user_old_password_"]').val();
                        var newPass = $('input[name="user_password_"]').val();
                        var newPassRep = $('input[name="user_password_repeat_"]').val();
                        if(oldPass != "" && newPass != "" && newPassRep != ""){
                            if(newPass != newPassRep){
                                //$('input[name="user_old_password_"]').val("");
                                //$('input[name="user_password_"]').val("");
                                //$('input[name="user_password_repeat_"]').val("");
                                $("#passwords-didnt-match").fadeIn();
                                setTimeout(function() { 
                                    $("#passwords-didnt-match").fadeOut();
                                }, 1000);
                            }else{
                                if(newPass.length < 8){
                                    //$('input[name="user_old_password_"]').val("");
                                    //$('input[name="user_password_"]').val("");
                                    //$('input[name="user_password_repeat_"]').val("");
                                    $("#password-too-short").fadeIn();
                                    setTimeout(function() { 
                                        $("#password-too-short").fadeOut();
                                    }, 1000);
                                }else{
                                    var form_data = new FormData();
                                    form_data.append('passwordResetUpdate', "yes");
                                    form_data.append('user_id_', $("input[name='user_id_']").val());
                                    form_data.append('user_name_', $("input[name='user_name_']").val());
                                    form_data.append('user_old_password_', $("input[name='user_old_password_']").val());
                                    form_data.append('user_password_', $("input[name='user_password_']").val());
                                    form_data.append('user_password_repeat_', $("input[name='user_password_repeat_']").val());
                                    }
                                    $.ajax({
                                        url: 'korisnici.php',
                                        type: 'POST',
                                        data: form_data,
                                        contentType: false,
                                        processData:false,
                                        success: function(response) {
                                            if(response.startsWith("PASS_CHANGED")){
                                                $('input[name="user_old_password_"]').val("");
                                                $('input[name="user_password_"]').val("");
                                                $('input[name="user_password_repeat_"]').val("");
                                                $("#password-changed").fadeIn();
                                                setTimeout(function() { 
                                                    $("#password-changed").fadeOut();
                                                }, 1000);
                                                setTimeout(function() { 
                                                    $("#editResetPassword .close").click();
                                                    window.location.replace("korisnici.php");
                                                }, 1100);
                                                console.log(response);
                                            }else if(response.startsWith("PASS_WRONG")){
                                                $('input[name="user_old_password_"]').val("");
                                                $('input[name="user_password_"]').val("");
                                                $('input[name="user_password_repeat_"]').val("");
                                                $("#wrong-old-password").fadeIn();
                                                setTimeout(function() { 
                                                    $("#wrong-old-password").fadeOut();
                                                }, 1000);
                                                console.log(response);
                                            }
                                        },
                                        error: function(xhr, textStatus, error) {
                                            console.log(xhr.responseText);
                                            console.log(xhr.statusText);
                                            console.log(textStatus);
                                            console.log(error);
                                        }             
                                    });
                                }
                            }
                        }

                        //GET DATA FOR DELETING USER
                        $(".deleteUsers>i").click(function(){
                        var dataID_ = $(this).attr("dataID_");
                        var dataLink = $(this).attr("dataLink");
                        $("input#dataID_").val(dataID_);
                        $("#confirmDeleteUser").attr('href', dataLink);
                        });
                </script>

                <style>
                    #password-changed,
                    #wrong-old-password,
                    #passwords-didnt-match,
                    #password-too-short{
                        max-width: 90%;
                        margin: 0 auto;
                        display: none;
                    }

                    #password-changed p{
                        color: green;
                        padding: 1rem 2rem;
                        font-size: 14px;
                        margin: 0.5rem;
                        border: 1px solid green;
                        background: rgb(0 128 0 / 20%);
                    }

                    #wrong-old-password p,
                    #passwords-didnt-match p,
                    #password-too-short p{
                        color: red;
                        padding: 1rem 2rem;
                        font-size: 14px;
                        margin: 0.5rem;
                        border: 1px solid red;
                        background: rgb(255 0 0 / 20%);
                    }
                    .modal-body{
                        display: flex;
                        flex-direction: column;
                    }
                    label {
                        display: inline-block;
                        margin-bottom: 0;
                        margin-top: 0.5rem;
                    }
                    th,td{
                        text-align: center;
                    }
                    small{
                        color: red;
                    }
                    select {
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        outline: none;
                    }
                    .fa-solid.fa-lock,
                    .fa-solid.fa-trash{
                        color: var(--blue);
                        cursor: pointer;
                    }
                </style>
        </div>
        <!-- /.container-fluid -->

        </div>
    <!-- End of Main Content -->

<?php 
    include_once('includes/footer.php');
}else {  
    header("location:index.php");  
}  
?>