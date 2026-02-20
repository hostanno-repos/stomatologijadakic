<?php 

if (!empty($_POST)) {

    global $editString;

    //GET UTM PARAMETERS
    $getCount = 0;
    $getString = "?";
    foreach ($_GET as $key => $value){
        if($getCount == 0){
            $getString = $getString.$key."=".$value;
        }else{
            $getString = $getString."&".$key."=".$value;
        }
    }

    //GET NUMBER OF FILES
    // $countfiles = count($_FILES);
    // for($i = 0; $i < $countfiles; $i++) {
    //     $helpVar = $_FILES['files']['name'];
    //     $helpVar = substr($helpVar[0], -4);
    //     $date = date('d-m-y');
    //     $time = date('h:i:s');
    //     $date = trim($date, " ");
    //     $time = str_replace(":", "", $time);
    //     $filename = $date."-".$time.$i.$helpVar;
    //     $target_file = '../uploads/'.$filename;
    //     $target_file_ = './uploads/'.$filename;
    //     $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
    //     $file_extension = strtolower($file_extension);
    //     $valid_extension = array("png","jpeg","jpg");
    //     if(in_array($file_extension, $valid_extension)){
    //         if(move_uploaded_file($_FILES['files']['tmp_name'][0],$target_file)) {
    //             //do nothing
    //             var_dump("DONE");
    //         }
    //     }
    // }

    // INSERT INTO TABLE START
    $i = 1;
    foreach($_POST as $key => $value) {
        if(strpos($key, 'edit') !== false){
            $nazivTabele = explode("_", $key)[1];
        }else{
            $$key = $value;
            
            if($i < count($_POST)-1){
                $editString = $editString.' '.$key.' = "'.$value.'", ';
                $i++;
            }else{
                $editString = $editString.' '.$key.' = "'.$value.'"';
                $i++;
            }
        }
    }

    // if($countfiles > 0){
    //     $nazivTabele_2 = $nazivTabele."_slika";
    //     $$nazivTabele_2 = $target_file;
    // }

    $queryColumns = $pdo->prepare("DESCRIBE ".$nazivTabele);
    $queryColumns->execute();
    $columnNames = $queryColumns->fetchAll(PDO::FETCH_COLUMN);
    if (($key = array_search($nazivTabele."_id", $columnNames)) !== false) {
        unset($columnNames[$key]);
    }
    if (($key = array_search($nazivTabele."_timestamp", $columnNames)) !== false) {
        unset($columnNames[$key]);
    }
    $columnNames = array_values($columnNames);
    $countColums = count($columnNames);

    global $columnsArrayString;
    global $querstionMarks;

    foreach($columnNames as $key => $value) {
        if($columnsArrayString == ""){
            $columnsArrayString = $value;
            $querstionMarks = "?";
        }else{
            $columnsArrayString = $columnsArrayString.",".$value;
            $querstionMarks = $querstionMarks.",?";
        }
    }

    $query = $pdo->prepare('UPDATE '.$nazivTabele.' SET '.$editString.' WHERE '.$nazivTabele.'_id = '.$_GET['id']);

    // $counterKeys = 0;
    // $counterBinds = 1;

    // while($counterKeys<$countColums){
    //     $$counterBinds = $columnNames[$counterKeys];
    //     $query->bindValue($counterBinds,$$$counterBinds);
    //     $counterKeys++;
    //     $counterBinds++;
    // }

    $query->execute();
    $thisFile = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

    switch($thisFile){
        case "dodaj-karton.php":
           header('Location: pregled-kartona.php'); 
           break;
        case "uredi-karton.php":
            header('Location: pregled-kartona.php'); 
            break;
        default:
            header('Location: '.basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']).$getString);
            break;
    }
    // INSERT INTO TABLE END
}

?>