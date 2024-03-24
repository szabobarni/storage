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
        $line = fgetcsv($csv,0,";");
        while (!feof($csv)) {
            $line = fgetcsv($csv,0,";");
            $array[] = $line;
        }
        fclose($csv);
        return $array;
    }
    static function getCsvData2($file){
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
    static function resetDatabase($mysqli, $data, $truncate = false){
        if($truncate) {
            $mysqli->query("TRUNCATE TABLE products");
        } 
        for($i = 0 ; $i < count($data); $i++) {
            $a1 = $data[$i][1];
            $a2 = $data[$i][1];
            $a3 = $data[$i][2];
            $a4 = $data[$i][3];
            $a5 = $data[$i][4];
            $a6 = $data[$i][5];
            $a7 = $data[$i][6];
            $a8 = $data[$i][7];
            $a9 = $data[$i][8];
            $mysqli->query("INSERT INTO products (id ,id_store, id_row, id_collumn, id_shelf, name, price, quantity, min_quantity) VALUES ('$a1', '$a2', '$a3','$a4','$a5','$a6','$a7','$a8','$a9')");
        }
    }
    static function getStorages() {
        $datas = self::getCsvData2("stores.csv");
        $storages = [];
        for ($i=0; $i < count( $datas )-1; $i++) { 
            $a = $datas[$i][1];
            if(!in_array($a, $storages)) {
                array_push($storages, $a);
            }
        }
        return $storages;
    }
    static function getRows() {
        $datas = self::getCsvData2("rows.csv");
        $rows = [];
        for ($i=0; $i < count( $datas )-1; $i++) { 
            $a = $datas[$i][1];
            if(!in_array($a, $rows)) {
                array_push($rows, $a);
            }
        }
        return $rows;
    }
    static function getCollumns() {
        $datas = self::getCsvData2("collumns.csv");
        $collumns = [];
        for ($i=0; $i < count( $datas )-1; $i++) { 
            $a = $datas[$i][1];
            if(!in_array($a, $collumns)) {
                array_push($collumns, $a);
            }
        }
        return $collumns;
    }
    static function showStoragesDropdown(array $storages) 
    {
        $result = '<form method="post">
            <label for="storages-dropdown">Choose a storage:</label><br>
            <select id="storages-dropdown" name="storages-dropdown">
            <option value = "" selected></option>';
        foreach ($storages as $storage) {
            if  ($storage == "") {
                
            }
            else {
                $result .= ('<option value = ' . $storage . '>' . $storage . '</option>');
            }
            
        }
        $result .= '</select><br>
                    <button type="submit" name="submit">Submit</button>
                    <button type="all" name="all">All</button>
                    </form>';
        echo $result;
    }
    static function getByStore($mysqli,$store){
        $query = "SELECT products.name FROM `products` INNER JOIN stores On products.id_store = stores.id WHERE stores.name LIKE '$store%'";

        return $mysqli->query($query)->fetch_all();
    }
    static function showProducts($products) {
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
        for ($i = 0; $i < count($products); $i++) { 
            $a1 = $products[$i][0];
            echo "
            <tr>
                <td>$a1</td>
            </tr>
            ";
        }
        echo "</table>";
    }
    static function showSearch() {
        echo "
            <form action='' method='post'>
                <label for='inputField'>Search:</label><br>
                <input type='text' id='inputField' name='inputField'><br>
                <button type='submit' name='submitButton'>Search</button>
                <button type='submit' name='reset'>Reset database</button>
            </form>
            ";
    }
    static function Search($mysqli, string $name)
    {
        $query = "SELECT name FROM products WHERE name LIKE '$name%'";

        return $mysqli->query($query)->fetch_all();
    }
    static function searchResult($search) {
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        }
        </style>
        <br>
        <table>
        <tr>
          <th>Products</th>
          <th>Functions</th>
        </tr>
        ";
        for ($i = 0; $i < count($search); $i++) { 
            $a = $search[$i][0];
            echo "
            <tr>
                <td>$a</td>
                <td>";
                    self::showButton($a);
                echo"</td>
            </tr>
            ";
        }
        echo "</table>";
    }
    static function showButton($name) {
        echo '
        <form method="post" action="">
            <button id="btn-more" name="btn-more" title="more" value="'.$name.'">
            <i class="fa fa-ellipsis-v "></i>
            </button>
            <button id="btn-edit" name="btn-edit" title="edit" value="'.$name.'">
            <i class="fa fa-edit"></i>
            </button>
            <button id="btn-delete" name="btn-delete" title="delete" value="'.$name.'">
            <i class="fa fa-trash"></i>
            </button>           
        </form>
        ';
    }
    static function delete($mysqli, $name)
    {
        $query = "DELETE FROM products WHERE name = '$name'";

        $mysqli->query($query);
    }
    static function showEdit($mysqli,$name){
        echo '<br>
        <form method="post">
        <label for="input1">name</label><br>
          <input type="text" id="input1" name="input1" value="'.$name.'"><br>
          <label for="input2">price</label><br>
          <input type="text" id="input2" name="input2" value="'.self::getPrice($mysqli,$name)['price'].'"><br>
          <label for="input3">quantity</label><br>
          <input type="text" id="input3" name="input3" value="'.self::getQuantity($mysqli,$name)['quantity'].'"><br>
          <button type="submit" name="edit" value="'.$name.'">Edit</button>
          <button type="submit" name="btn-back" value="">Back</button>
        </form>';
    }
    static function getPrice($mysqli,$name){
        $query = "SELECT price FROM products WHERE name= '$name'";
        return $mysqli->query($query)->fetch_assoc();
    }
    static function getQuantity($mysqli,$name){
        $query = "SELECT quantity FROM products WHERE name= '$name'";
        return $mysqli->query($query)->fetch_assoc();
    }
    static function edit($mysqli,$nameOG,$name,$price,$quantity){
        $query = "UPDATE products SET name='$name', price='$price', quantity='$quantity' WHERE name = '$nameOG';";
        $mysqli->query($query);
    }
    static function more($mysqli,$name){
        $query = "SELECT p.name,s.name,p.price,p.quantity FROM products p INNER JOIN shelves s ON p.id_shelf = s.id WHERE p.name = '$name';";
        return $mysqli->query($query)->fetch_assoc();
    }
    static function showMore($mysqli,$name,$more){
        $a1 = $more['name'];
        $a2 = $more['price'];
        $a3 = $more['quantity'];
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        }
        </style>
        <br>
        <table>
        <tr>
          <th>Product</th>
          <th>Shelf</th>
          <th>Price</th>
          <th>Quantity</th>
        </tr>
        <tr>
                <td>$name</td>
                <td>$a1</td>
                <td>$a2</td>
                <td>$a3</td>
            </tr>
        </table>
        <form method='post'>
        <button type='submit' name='btn-back' value=''>Back</button>
        </form>
        ";
    }
    static function showStockButton(){
        echo '
        <br>
        <form method="post" >
            <button id="btn-lowstock" name="btn-lowstock" title="lowstock" value="">
                Low Stock
            </button>
        </form>
    ';
    }
    static function getLowStock($mysqli){
        $query = 'SELECT name, quantity, min_quantity FROM products WHERE quantity<min_quantity;';
        return $mysqli->query($query)->fetch_all();
    }
    static function showStock($stock){
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        }
        </style>
        <br>
        <table>
        <tr>
          <th>Products</th>
          <th>Quantity</th>
          <th>Min Quantity</th>
        </tr>
        ";
        for ($i = 0; $i < count($stock); $i++) { 
            $a1 = $stock[$i][0];
            $a2 = $stock[$i][1];
            $a3 = $stock[$i][2];
            echo "
            <tr>
                <td>$a1</td>
                <td>$a2</td>
                <td>$a3</td>

            </tr>
            ";
        }
        echo"</table>
        <form method='post'>
        <button type='submit' name='btn-back' value=''>Back</button>
        </form>
        ";
    }
    static function showAddButton(){
        echo '
        <br>
        <form method="post" >
            <button id="btn-add" name="btn-add" title="add" value="">
                Add new product
            </button>
        </form>';
    }
    static function showStoragesDropdown2(array $storages) 
    {
        $result = '<form method="post">
            <label for="storages-dropdown2">storage:</label><br>
            <select id="storages-dropdown2" name="storages-dropdown2">
            <option value = "" selected></option>';
        foreach ($storages as $storage) {
            if  ($storage == "") {
                
            }
            else {
                $result .= ('<option value = ' . $storage . '>' . $storage . '</option>');
            }
            
        }
        $result .= '</select>
                    </form>';
        echo $result;
    }
    static function showRowsDropdown(array $rows){
        $result = '<form method="post">
        <label for="rows-dropdown">row:</label><br>
        <select id="rows-dropdown" name="rows-dropdown">
        <option value = "" selected></option>';
    foreach ($rows as $row) {
        if  ($row == "") {
            
        }
        else {
            $result .= ('<option value = ' . $row . '>' . $row . '</option>');
        }
        
    }
    $result .= '</select>
                </form>';
    echo $result;
    }
    static function showCollumnsDropdown(array $collumns){
        $result = '<form method="post">
        <label for="collumns-dropdown">collumns:</label><br>
        <select id="collumns-dropdown" name="collumns-dropdown">
        <option value = "" selected></option>';
    foreach ($collumns as $collumn) {
        if  ($collumn == "") {
            
        }
        else {
            $result .= ('<option value = ' . $collumn . '>' . $collumn . '</option>');
        }
        
    }
    $result .= '</select>
                </form>';
    echo $result;
    }
    static function showAdd($storages,$rows,$collumns){
        echo '<br>
        <form method="post">';
        self::showStoragesDropdown2( $storages );
        self::showRowsDropdown($rows);
        self::showCollumnsDropdown($collumns);
        echo'<label for="input1">name:</label><br>
          <input type="text" id="input1" name="input1"><br>
          <label for="input2">price:</label><br>
          <input type="text" id="input2" name="input2"><br>
          <label for="input3">quantity:</label><br>
          <input type="text" id="input3" name="input3"><br>
          <label for="input4">min_quantity:</label><br>
          <input type="text" id="input4" name="input4"><br>
          <button type="submit" name="add" value="">Add</button>
          <button type="submit" name="btn-back" value="">Back</button>
        </form>';
    }
   static function add($mysqli,){
        $query = "INSERT INTO products () VALUES ()";

        $mysqli->query($query);
    }
}