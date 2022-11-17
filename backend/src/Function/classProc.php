<?php
//get all class
function getAllClass($db)
{
$sql = 'Select c.id, c.teacher_name, c.dob, c.gender, c.no_phone, c.position, c.qualification from class c ';
// $sql .='Inner Join students s on c.id = s.id';
$stmt = $db->prepare ($sql);
$stmt ->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//get class by id
function getClass($db, $classId)
{
$sql = 'Select c.id, c.teacher_name, c.dob, c.gender, c.no_phone, c.position, c.qualification from class c ';
// $sql .='Inner Join students s on c.id = s.id ';
$sql .= 'Where c.id = :id';
$stmt = $db->prepare ($sql);
$id = (int) $classId;
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

///////////////////////////////////////////////////////////////////////////

function createClass($db, $form_data)
{
    $sql = 'Insert into class (id, teacher_name, dob, gender, no_phone, position, qualification) ';
    $sql .= 'values (:id, :teacher_name, :dob, :gender, :no_phone, :position, :qualification)';
    $stmt = $db->prepare ($sql);
    $stmt->bindParam(':id', $form_data['id']);
    $stmt->bindParam(':teacher_name', $form_data['teacher_name']);
    $stmt->bindParam(':dob', $form_data['dob']);
    $stmt->bindParam(':gender', $form_data['gender']);
    $stmt->bindParam(':no_phone', $form_data['no_phone']);
    $stmt->bindParam(':position', $form_data['position']);
    $stmt->bindParam(':qualification', $form_data['qualification']);
    $stmt->execute();
    return $db->lastInsertID();
    //insert last number.. continue
}
///////////////////////////////////////////////////////////////////////////////

//delete product by id
function deleteClass($db,$classId) {
$sql = ' Delete from class where id = :id';
$stmt = $db->prepare($sql);
$id = (int)$classId;
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
}


////////////////////////////////////////////////////////////////////////////////

//update product by id
function updateClass($db,$form_dat,$classId,$date) {
    $sql = 'UPDATE class SET id = :id , teacher_name = :teacher_name , dob = :dob, gender = :gender, no_phone = :no_phone, position= :position ,  qualification=:qualification';
    $sql .=' WHERE id = :id';
    
    $stmt = $db->prepare ($sql);
    $id = (int)$classId;
    $mod = $date;
    
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':teacher_name', $form_dat['teacher_name']);
    $stmt->bindParam(':dob', $form_dat['dob']);
    $stmt->bindParam(':gender', $form_dat['gender']);
    $stmt->bindParam(':no_phone', $form_dat['no_phone']);
    $stmt->bindParam(':position', $form_dat['position']);
    $stmt->bindParam(':qualification', $form_dat['qualification']);
    $stmt->bindParam(':modified', $mod , PDO::PARAM_STR);
    $stmt->execute();
}