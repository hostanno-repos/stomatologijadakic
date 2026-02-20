<?php

/**
 * Statistika: broj intervencija po tipu, naplaćeno po tipu, ukupno naplaćeno
 * Od 2020 do danas, po mjesecima i godinama.
 */
class Statistika
{
    /** Početna godina za statistiku */
    const YEAR_FROM = 2020;

    /**
     * Broj intervencija po tipu, po mjesecima (od 2022).
     * Vraća: godina, mjesec, id_tipa, naziv_tipa, broj
     */
    public static function intervencije_po_mjesecima()
    {
        global $pdo;
        $sql = "
            SELECT 
                YEAR(i.intervencije_datum) AS godina,
                MONTH(i.intervencije_datum) AS mjesec,
                t.tipoviintervencija_id AS id_tipa,
                t.tipoviintervencija_naziv AS naziv_tipa,
                COUNT(*) AS broj
            FROM intervencije i
            LEFT JOIN tipoviintervencija t ON t.tipoviintervencija_id = i.intervencije_idtipa
            WHERE i.intervencije_datum >= ?
            GROUP BY YEAR(i.intervencije_datum), MONTH(i.intervencije_datum), i.intervencije_idtipa
            ORDER BY godina, mjesec, id_tipa
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([self::YEAR_FROM . '-01-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Broj intervencija po tipu, po godinama (od 2022).
     */
    public static function intervencije_po_godinama()
    {
        global $pdo;
        $sql = "
            SELECT 
                YEAR(i.intervencije_datum) AS godina,
                t.tipoviintervencija_id AS id_tipa,
                t.tipoviintervencija_naziv AS naziv_tipa,
                COUNT(*) AS broj
            FROM intervencije i
            LEFT JOIN tipoviintervencija t ON t.tipoviintervencija_id = i.intervencije_idtipa
            WHERE i.intervencije_datum >= ?
            GROUP BY YEAR(i.intervencije_datum), i.intervencije_idtipa
            ORDER BY godina, id_tipa
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([self::YEAR_FROM . '-01-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Naplaćeno po tipu intervencije (računi povezani s intervencijom), po mjesecima.
     * Vraća: godina, mjesec, id_tipa, naziv_tipa, iznos
     */
    public static function naplaceno_po_tipu_mjesec()
    {
        global $pdo;
        $sql = "
            SELECT 
                YEAR(r.racuni_datum) AS godina,
                MONTH(r.racuni_datum) AS mjesec,
                t.tipoviintervencija_id AS id_tipa,
                t.tipoviintervencija_naziv AS naziv_tipa,
                SUM(r.racuni_iznos) AS iznos
            FROM racuni r
            INNER JOIN intervencije i ON i.intervencije_id = r.racuni_idintervencije
            LEFT JOIN tipoviintervencija t ON t.tipoviintervencija_id = i.intervencije_idtipa
            WHERE r.racuni_datum >= ?
            GROUP BY YEAR(r.racuni_datum), MONTH(r.racuni_datum), i.intervencije_idtipa
            ORDER BY godina, mjesec, id_tipa
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([self::YEAR_FROM . '-01-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Naplaćeno po tipu intervencije, po godinama.
     */
    public static function naplaceno_po_tipu_godina()
    {
        global $pdo;
        $sql = "
            SELECT 
                YEAR(r.racuni_datum) AS godina,
                t.tipoviintervencija_id AS id_tipa,
                t.tipoviintervencija_naziv AS naziv_tipa,
                SUM(r.racuni_iznos) AS iznos
            FROM racuni r
            INNER JOIN intervencije i ON i.intervencije_id = r.racuni_idintervencije
            LEFT JOIN tipoviintervencija t ON t.tipoviintervencija_id = i.intervencije_idtipa
            WHERE r.racuni_datum >= ?
            GROUP BY YEAR(r.racuni_datum), i.intervencije_idtipa
            ORDER BY godina, id_tipa
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([self::YEAR_FROM . '-01-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ukupno naplaćeno po mjesecima (svi računi).
     */
    public static function ukupno_naplaceno_po_mjesecima()
    {
        global $pdo;
        $sql = "
            SELECT 
                YEAR(racuni_datum) AS godina,
                MONTH(racuni_datum) AS mjesec,
                SUM(racuni_iznos) AS ukupno
            FROM racuni
            WHERE racuni_datum >= ?
            GROUP BY YEAR(racuni_datum), MONTH(racuni_datum)
            ORDER BY godina, mjesec
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([self::YEAR_FROM . '-01-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ukupno naplaćeno po godinama.
     */
    public static function ukupno_naplaceno_po_godinama()
    {
        global $pdo;
        $sql = "
            SELECT 
                YEAR(racuni_datum) AS godina,
                SUM(racuni_iznos) AS ukupno
            FROM racuni
            WHERE racuni_datum >= ?
            GROUP BY YEAR(racuni_datum)
            ORDER BY godina
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([self::YEAR_FROM . '-01-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Nazivi mjeseci na srpskom */
    public static function naziv_mjeseca($m)
    {
        $mjeseci = [
            1 => 'Januar', 2 => 'Februar', 3 => 'Mart', 4 => 'April',
            5 => 'Maj', 6 => 'Jun', 7 => 'Jul', 8 => 'Avgust',
            9 => 'Septembar', 10 => 'Oktobar', 11 => 'Novembar', 12 => 'Decembar'
        ];
        return isset($mjeseci[(int)$m]) ? $mjeseci[(int)$m] : (string)$m;
    }
}
