<?php
 $servername = "localhost";
 $username = "root";
 $password = null;
 $database = "storage";
 $mysqli = new mysqli($servername, $username, $password, $database);
require_once"tools.php";
//tools::showCreateDatabaseButton();
$storages = tools::getStorages();
tools::showStoragesDropdown( $storages );
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['storages-dropdown'])) {
        $selected_option = $_POST['storages-dropdown'];
        $asd = tools::getByStore($mysqli, $selected_option);
        echo "<br>";
        tools::showCity($asd);
    } else {
        echo "<p>No option selected</p>";
    }
}