
<?php 
require_once 'db.php';
$db=new Database();
if (isset($_POST['action']) && $_POST['action']=="view") {
    $output='';
    $data=$db->read();
    if ($db->totalRowCount()>0) {
        $output.='<table class="table table-striped table-sm table-bordered">

                    <thead>
                        <tr class="text-center">
                            <th>id</th>
                            <th>status</th>
                            <th>feeOnline</th>
                            <th>noOfSubject</th>
                            <th>courseID</th>
                            <th>Action</th>
                        </tr>
                        
                    </thead>
                    <tbody>';
                    foreach ($data as $row) {
                        $output.='
			<tr class="text-center text-secondry">
                            <td>'.$row['id'].'</td>
                            <td>'.$row['status'].'</td>
                            <td>'.$row['feeOnline'].'</td>
                            <td>'.$row['noOfSubject'].'</td>
                            <td>'.$row['courseID'].'</td>
                            <td>
                                <a href="" title="View Details" class="text-success infoBtn" id="'.$row['id'].'">
					<i class="fas fa-info-circle fa-lg"></i> 
				</a> 
                                <a href="" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal" id="'.$row['id'].'">
					<i class="fas fa-edit fa-lg"></i> 
				</a> 
                                <a href="" title="Delete" class="text-danger delBtn" id="'.$row['id'].'">
					<i class="fas fa-tralms-alt fa-lg"></i>
				</a> 
                            </td>
                            </tr>
                        ';
                    }
                    $output.='<tbody></table>';
                    echo $output;
    }else{
        echo '<h3 class="text-center text-secondry mt-5">:(No any data present in databse )<h3>';
    }

}

if (isset($_POST['action']) && $_POST['action']=="insert") {

    $status=$_POST['status'];
    $feeOnline=$_POST['feeOnline'];
    $noOfSubject=$_POST['noOfSubject'];
    $courseID=$_POST['courseID'];
    $db->insert($status,$feeOnline,$noOfSubject,$courseID);
}

if (isset($_POST['edit_id'])) {
    $id=$_POST['edit_id'];
    $row=$db->getUserById($id);
    echo json_encode($row);

}

if (isset($_POST['action']) && $_POST['action']=="update") {
    $id=$_POST['id'];         
    $status=$_POST['status'];         
    $feeOnline=$_POST['feeOnline'];         
    $noOfSubject=$_POST['noOfSubject'];         
    $courseID=$_POST['courseID'];
    $db->update($id,$status,$feeOnline,$noOfSubject,$courseID);
}


if (isset($_POST['del_id'])) {
    $id=$_POST['del_id'];
    $db->delete($id);

}
if (isset($_POST['info_id'])) {

    $id=$_POST['info_id'];
    $row=$db->getUserById($id);
    echo json_encode($row);
}
if (isset($_GET['export']) && $_GET['export']=="excel") {
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=coursefee.xls");
    header("Pragma: no-calms");
    header("expires:0");
    $data=$db->read();
    echo '<table border="1">';

    echo "
	<tr>
          <th>id</th>
          <th>status</th>
          <th>feeOnline</th>
          <th>noOfSubject</th>
          <th>courseID</th>
          <th>id</th>
	</tr>";
foreach ($data as $row) {
    echo '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['status'].'</td>
            <td>'.$row['feeOnline'].'</td>
            <td>'.$row['noOfSubject'].'</td>
            <td>'.$row['courseID'].'</td>
          </tr>
    ';
}

    echo '</table>
    ';
}
 ?>

