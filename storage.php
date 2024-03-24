<?php
 $servername = "localhost";
 $username = "root";
 $password = null;
 $database = "storage";
 $mysqli = new mysqli($servername, $username, $password, $database);
 include 'html-head.php';
require_once "tools.php";
//tools::showCreateDatabaseButton();
$storages = tools::getStorages();
$rows = tools::getRows();
$collumns = tools::getCollumns();
$file = "products.csv";
tools::showStoragesDropdown( $storages );
tools::showSearch();
tools::showStockButton();
tools::showAddButton();
if (isset($_POST['storages-dropdown'])) {
    $store = $_POST['storages-dropdown'];
    $products = tools::getByStore($mysqli, $store);
    echo "<br>";
    tools::showProducts($products);
}
if (isset($_POST["reset"])) {
    $data = tools::getCsvData($file);
    tools::resetDatabase($mysqli, $data, true);
}
if (isset($_POST['submitButton'])) {
    $name = $_POST['inputField'];
    $search = tools::Search($mysqli, $name);
    tools::searchResult($search);
}
if (isset($_POST['btn-delete'])) {
    $name = $_POST['btn-delete'];
    tools::delete($mysqli,$name);
    $name2='';
    $search = tools::Search($mysqli, $name2);
    tools::searchResult($search);
}
if(isset($_POST['btn-edit'])) {
    $name = $_POST['btn-edit'];
    tools::showEdit($mysqli,$name);
}
if(isset($_POST['edit'])) {
    $nameOG = $_POST['edit'];
    $name = $_POST['input1'];
    $price = $_POST['input2'];
    $quantity= $_POST['input3'];
    tools::edit($mysqli,$nameOG,$name,$price,$quantity);
    $search = tools::Search($mysqli, $nameOG);
    tools::searchResult($search);
}
if(isset($_POST['btn-more'])) {
    $name = $_POST['btn-more'];
    $more = tools::more($mysqli,$name);
    tools::showMore($mysqli,$name,$more);
}
if(isset($_POST['btn-back'])) {
    $name2='';
    $search = tools::Search($mysqli, $name2);
    tools::searchResult($search);
}
if(isset($_POST['btn-lowstock'])) {
    $stock = tools::getLowStock($mysqli);
    tools::showStock($stock);
}
if(isset($_POST['btn-add'])) {
    tools::showAdd($storages,$rows,$collumns);
}
if(isset($_POST['add'])) {
    $name = $_POST['storages-dropdown2'];
    $row = $_POST['rows-dropdown'];
    $collumn = $_POST['collumns-dropdown'];
    $shelf = "$row$shelf";
    echo $shelf;
}