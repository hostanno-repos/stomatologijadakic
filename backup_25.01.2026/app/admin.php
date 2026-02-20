<?php 
session_start();
include_once('../connection.php'); 
include_once('./class/termini.php');
include_once('./class/kartoni.php');
include_once('./class/users.php');
include_once('includes/head.php');

$now = time();
if(isset($_SESSION["logged_in"]) && isset($_SESSION["user"])){

// $danas = date('Y-m-d');
// //DANAŠNJI DESKTOP
// $danasnji = new zakazaniJedanDan;
// $danasnji = $danasnji->fetch_all_danas($danas);
// //DANAŠNJI MOBILE
// $danasnji_ = new zakazaniJedanDan;
// $danasnji_ = $danasnji_->fetch_all_danas($danas);

// $sutra = date("Y-m-d", strtotime("tomorrow"));
// //SUTRAŠNJI DESKTOP
// $sutrasnji = new zakazaniJedanDan;
// $sutrasnji = $sutrasnji->fetch_all_danas($sutra);
// //SUTRAŠNJI MOBILE
// $sutrasnji_ = new zakazaniJedanDan;
// $sutrasnji_ = $sutrasnji_->fetch_all_danas($sutra);

// //check the current day
// if(date('D')!='Mon')
// {    
// //take the last monday
// $staticstart = date('Y-m-d',strtotime('last Monday'));

// }else{
//     $staticstart = date('Y-m-d');
// }

// //always next saturday

// if(date('D')!='Sat')
// {
//     $staticfinish = date('Y-m-d',strtotime('next Saturday'));
// }else{

//         $staticfinish = date('Y-m-d'); 
// }

// $ovaSedmica = new zakazaniBetween;
// $ovaSedmica = $ovaSedmica->fetch_all_sedmica($staticstart, $staticfinish);

// $ovaSedmica_ = new zakazaniBetween;
// $ovaSedmica_ = $ovaSedmica_->fetch_all_sedmica($staticstart, $staticfinish);

// $first_day_this_month = date('Y-m-01');
// $last_day_this_month  = date('Y-m-t');

// $ovajMjesec = new zakazaniBetween;
// $ovajMjesec = $ovajMjesec->fetch_all_sedmica($first_day_this_month, $last_day_this_month);

// $ovajMjesec_ = new zakazaniBetween;
// $ovajMjesec_ = $ovajMjesec_->fetch_all_sedmica($first_day_this_month, $last_day_this_month);

// $timestamp = strtotime(date('F',strtotime('first day of +1 month'))." ".date('Y'));
// $first_second = date('Y-m-01', $timestamp);
// $last_second  = date('Y-m-t', $timestamp);

// $sledeciMjesec = new zakazaniBetween;
// $sledeciMjesec = $sledeciMjesec->fetch_all_sedmica($first_second, $last_second);

// $sledeciMjesec_ = new zakazaniBetween;
// $sledeciMjesec_ = $sledeciMjesec_->fetch_all_sedmica($first_second, $last_second);

?>

  <body>
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php'); ?>

    <div class="wrapper d-flex flex-column bg-light">

      <!-- HEADER -->
      <?php include_once('includes/header.php'); ?>

      <div class="body flex-grow-1 px-3">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="--noshadow evo-calendar" id="demoEvoCalendar"></div>
            </div>
          </div>
        </div>
      </div>
      <script>

        // $('html').on('DOMSubtreeModified', function(){
        //   $('a').click(function(event){
        //     event.preventDefault();
        //     //do whatever
        //   });
        // });

        $(".number-item").click(function(){
          $(".calendar-today").removeClass("calendar-today");
          $(this).addClass("calendar-today");
        });
      </script>

      <style>
        p{
          margin-bottom: 0;
          cursor: pointer;
        }
      </style>
    <!-- FOOTER -->
    <?php include_once('includes/footer.php');
}else {  
    session_destroy();
    header("location:index.php");
    echo"<script>window.location.href = 'index.php';</script>";  
}  
?>