<?php

//GET ALL OBJECTS
class allObjects
{
    public function fetch_all_objects($table, $orderBy, $ordering)
    {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM " . $table . " ORDER BY " . $orderBy . " " . $ordering);
        $query->execute();
        return $query->fetchAll();
    }
}

//GET SINGLE OBJECT
class singleObject
{
    public function fetch_single_object($table, $columnToGet, $idToGet)
    {
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM " . $table . " WHERE " . $columnToGet . " = ?");
        $query->bindValue(1, $idToGet);
        $query->execute();
        return $query->fetch();
    }
}

?>