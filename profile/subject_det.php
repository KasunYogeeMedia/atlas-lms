<?php
require_once '../dashboard/dbconfig4.php';
include '../dashboard/conn.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level = $_POST['level'];
    $stmt = $DB_con->prepare('SELECT * FROM lmssubject where class="' . $level . '"');

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $name = array();
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo json_encode($row['name']);
        }
    }
}