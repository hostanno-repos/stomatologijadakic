<?php
session_start();
include_once ('../connection.php');
include_once ('./class/termini.php');
include_once ('./class/kartoni.php');
include_once ('./class/users.php');
include_once ('includes/head.php');

$now = time();
if (isset($_SESSION["logged_in"]) && $now < $_SESSION['expire']) {

    //GET ALL KARTONI PACIJENATA DESKTOP
    $kartonipacijenata_0 = new kartoniPacijenata;
    $kartonipacijenata = $kartonipacijenata_0->fetch_all_kartonipacijenata();
    //GET ALL KARTONI PACIJENATA MOBILE
    $kartonipacijenata_1 = new kartoniPacijenata;
    $kartonipacijenata_2 = $kartonipacijenata_1->fetch_all_kartonipacijenata();


    ?>

    <body>
        <!-- SIDEBAR -->
        <?php include_once ('includes/sidebar.php'); ?>

        <div class="wrapper d-flex flex-column bg-light">

            <!-- HEADER -->
            <?php include_once ('includes/header.php'); ?>

            <div class="body flex-grow-1 px-3">
                <div class="container-fluid">
                    <div class="row desktop-content">
                        <h4 class="ms-2 mb-3">PREGLED KARTONA</h4>
                        <div class="col-lg-12 mx-2 mb-3">
                            Ime:
                            <input type="text" id="getName" class="mr-2">
                            Prezime:
                            <input type="text" id="getSurname" class="mr-2">
                            <!-- Matični broj:
                            <input type="text" id="getMaticni" class="mr-2">
                            Datum rođenja:
                            <input type="date" id="getBirth" lang="sr-RS"> -->
                            <i class="fa-solid fa-search mx-2"
                                style="background: #fff;padding:7px;border-radius:5px;cursor:pointer"
                                onclick="searchKarton()"></i>
                        </div>
                        <div class="col-lg-12">
                            <table class="table centeredTable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Ime</th>
                                        <th scope="col">Ime roditelja</th>
                                        <th scope="col">Prezime</th>
                                        <th scope="col">Datum rođenja</th>
                                        <th scope="col">Matični broj</th>
                                        <th scope="col">Pol</th>
                                        <th scope="col">Telefon</th>
                                        <th scope="col">Datum kreiranja</th>
                                        <th scope="col">Detalji</th>
                                        <th scope="col">Uredi</th>
                                        <th scope="col">Obriši</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mobile-content">
                        <h4 class="ms-2 mb-3">PREGLED KARTONA</h4>
                        <div class="col-lg-12 px-0 mb-3 d-flex flex-column search_form">
                            Ime:
                            <input type="text" id="getName_" class="mr-2">
                            Prezime:
                            <input type="text" id="getSurname_" class="mr-2">
                            <!-- Matični broj:
                            <input type="text" id="getMaticni" class="mr-2">
                            Datum rođenja:
                            <input type="date" id="getBirth" lang="sr-RS"> -->
                            <i class="mx-2" style="" onclick="searchKarton()">Pretraži</i>
                        </div>
                        <div class="col-lg-12 mx-0 px-0">
                            <div id="cards-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include_once ('includes/footer.php'); ?>

        <!-- Modal delete -->
        <div class="modal fade" id="deleteKartonipacijenataModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteKartonipacijenataModalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteKartonipacijenataModalModalLabel">Izbriši karton pacijenta
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Da li ste sigurni da želite izbrisati odabrani karton pacijenta?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                        <a id="submit_delete_tip_intervencije" href="">
                            <button type="submit" class="btn btn-primary"
                                name="submit_delete_kartoniradnika">Izbriši</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(".delete-object").click(function () {
                var dataID_ = $(this).attr("dataID_");
                var dataLink = $(this).attr("dataLink");
                //$("input#dataID_").val(dataID_);
                $("#submit_delete_tip_intervencije").attr('href', dataLink);
                console.log(dataLink);
            });

            function searchKarton() {
                if($("#getName_").val() != ""){
                    var getName = $("#getName_").val();
                }else{
                    var getName = $("#getName").val();
                }
                
                if($("#getName_").val() != ""){
                    var getSurname = $("#getSurname_").val();
                }else{
                    var getSurname = $("#getSurname").val();
                }
                
                //console.log(getName);
                var getSurname = $("#getSurname").val();
                //console.log(getSurname);
                //var getMaticni = $("#getMaticni").val();
                //console.log(getMaticni);
                //var getBirth = $("#getBirth").val();
                //console.log(getBirth);

                var form_data = new FormData();
                form_data.append('getKarton', 'YES');
                form_data.append('kartonipacijenata_ime', getName);
                form_data.append('kartonipacijenata_prezime', getSurname);
                //form_data.append('kartonipacijenata_maticnibroj', getMaticni);
                //form_data.append('kartonipacijenata_datumrodjenja', getBirth);

                $.ajax({
                    url: 'getKartoni.php',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#tableBody").html("");
                        $("#cards-body").html("");
                        //console.log(response);
                        $.each(JSON.parse(response), function (i, item) {

                            //console.log(item.kartonipacijenata_datumrodjenja);

                            if (item.kartonipacijenata_datumrodjenja != null) {
                                //datum rodjenja izmjena formata
                                var datumRodjenja = item.kartonipacijenata_datumrodjenja.split("-");
                                datumRodjenja = datumRodjenja[2] + "." + datumRodjenja[1] + "." + datumRodjenja[0] + ".";
                            } else {
                                var datumRodjenja = "";
                            }


                            //datum kreiranja izmjena formata
                            var datumKreiranja = item.kartonipacijenata_timestamp.split(" ");
                            var vrijemeKreiranja = datumKreiranja[1];
                            datumKreiranja = datumKreiranja[0].split("-");
                            datumKreiranja = datumKreiranja[2] + "." + datumKreiranja[1] + "." + datumKreiranja[0] + ".";

                            $("#tableBody").append(
                                '<tr><td scope="row">' + item.kartonipacijenata_id + '</td><td>' + item.kartonipacijenata_ime + '</td><td>' + item.kartonipacijenata_roditelj + '</td><td>' + item.kartonipacijenata_prezime + '</td><td>' + datumRodjenja + '</td><td>' + item.kartonipacijenata_maticnibroj + '</td><td>' + item.kartonipacijenata_pol + '</td><td>' + item.kartonipacijenata_telefon + '</td><td>' + datumKreiranja + " " + vrijemeKreiranja + '</td><td><a class="clearCookieSectionActive" href="detalji-kartona.php?detaljiKartona=' + item.kartonipacijenata_id + '"><button type="button" class="btn btn-info"><i class= "fa-solid fa-arrow-up-right-from-square" ></i > Detalji</button></a></td><td><a href="uredi-karton.php?id=' + item.kartonipacijenata_id + '"><button type="button" class="btn btn-warning"><i class="fa-solid fa-user-pen"></i> Uredi</button></a></td><td><button type="button" class="btn btn-danger delete-object" data-toggle="modal" data-target="#deleteKartonipacijenataModal" dataID_="' + item.kartonipacijenata_id + '" dataLink="pregled-kartona.php?delete_kartonipacijenata=' + item.kartonipacijenata_id + '"><i class="fa-solid fa-trash"></i> Izbriši</button> </td></tr > ');
                            $("#cards-body").append(
                                //'<div class="card border-dark mb-3"><div class="card-header bg-transparent border-dark"><h5 class="card-title mb-0">' + item.kartonipacijenata_ime + ' ' + item.kartonipacijenata_prezime + '</h5></div><div class="card-body text-dark">Datum rođenja: ' + datumRodjenja + '<br />Telefon: ' + item.kartonipacijenata_telefon + '<br /><p class="card-text"><br /></p></div><div class="card-footer bg-transparent border-dark"><div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width:100%;"><button onclick="location.href="detalji-kartona.php?detaljiKartona=' + item.kartonipacijenata_id + '" class="btn btn-outline-info" type="button">Detalji</button><button onclick="location.href="uredi-karton.php?id=' + item.kartonipacijenata_id + '" class="btn btn-outline-info" type="button">Uredi</button><button class="btn btn-outline-info delete-object" type="button" data-toggle="modal" data-target="#deleteKartonipacijenataModal" dataID_=' + item.kartonipacijenata_id + '" dataLink="pregled-kartona.php?delete_kartonipacijenata=' + item.kartonipacijenata_id + '">Izbriši</button></div></div></div>');
                                '<div class="single_mobile_result d-flex p-2""><i class="fa-solid fa-user"></i><p class="mb-0">' + item.kartonipacijenata_ime + ' ' + item.kartonipacijenata_prezime + '<br>' + datumRodjenja + '</p><div><button onclick="location.href=`detalji-kartona.php?detaljiKartona=' + item.kartonipacijenata_id + '`" class="btn btn-outline-info" type="button"><i class="fa-solid fa-arrow-up-right-from-square"></i></button><button onclick="location.href=`uredi-karton.php?id=' + item.kartonipacijenata_id + '`" class="btn btn-outline-info" type="button"><i class="fa-solid fa-pen-to-square"></i></button><button class="btn btn-outline-info delete-object" type="button" data-toggle="modal" data-target="#deleteKartonipacijenataModal" dataID_=' + item.kartonipacijenata_id + '" dataLink="pregled-kartona.php?delete_kartonipacijenata=' + item.kartonipacijenata_id + '"><i class="fa-solid fa-ban"></i></button></div></div>');
                        })
                    },
                    error: function (xhr, textStatus, error) {
                        //console.log(xhr.responseText);
                        //console.log(xhr.statusText);
                        //console.log(textStatus);
                        //console.log(error);
                    }
                });
            }
        </script>

        <?php
        include_once ('includes/footer.php');
} else {
    session_destroy();
    header("location:index.php");
    echo "<script>window.location.href = 'index.php';</script>";
}
?>