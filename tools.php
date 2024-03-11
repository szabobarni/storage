<?php

Class Tools
{
    static function showCreateDatabaseButton()
    {
        echo '
            <form method="post" action="mysqli.php">
                <button id="btn-change" name="btn-change" title="change" value="">
                    Create Database
                </button>
            </form>
        ';
    }
    static function getCsvData($file){
        $array = [];
        if(!file_exists($file)){
            echo "$file nem található";
            return false;
        }
        $csv = fopen($file, 'r');
        $line = fgetcsv($csv);
        while (!feof($csv)) {
            $line = fgetcsv($csv);
            $array[] = $line;
        }
        fclose($csv);
        return $array;
    }
    static function getStorages() {
        $datas = self::getCsvData("stores.csv");
        $storages = [];
        for ($i=0; $i < count( $datas )-1; $i++) { 
            $a = $datas[$i][1];
            if(!in_array($a, $storages)) {
                array_push($storages, $a);
            }
        }
        return $storages;
    }
    static function showStoragesDropdown(array $storages) 
    {
        $result = '<form method="post">
            <label for="storages-dropdown">Choose a storage:</label>
            <select id="storages-dropdown" name="storages-dropdown">
            <option value = "" selected></option>';
        foreach ($storages as $storage) {
            if  ($storage == "") {
                
            }
            else {
                $result .= ('<option value = ' . $storage . '>' . $storage . '</option>');
            }
            
        }
        $result .= '</select>
                    <button type="submit" name="submit">Submit</button>
                    </form>';
        echo $result;
    }
    static function getByStore($mysqli,$a){
        $query = "SELECT products.name FROM `products` INNER JOIN stores On products.id_store = stores.id WHERE stores.name = $a";

        return $mysqli->query($query)->fetch_all();
    }
    static function showCity($asd) {
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        }
        </style>
        <table>
        <tr>
          <th>Products</th>
        </tr>
        ";
        for ($i = 0; $i < count($asd); $i++) { 
            $a1 = $asd[$i][0];
            echo "
            <tr>
                <td>$a1</td>
            </tr>
            ";
        }
        echo "</table>";
    }
}