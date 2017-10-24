<?php
 
require 'student_db.php';
 
// Lấy thông tin hiển thị lên để người dùng sửa
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if ($id){
    $get=new DB_student;
    $sql = "SELECT * FROM tb_sinhvien WHERE sv_id = $id";
    $get->query($sql);
    $data=$get->get_students();
}
 
// Nếu không có dữ liệu tức không tìm thấy sinh viên cần sửa
if (!$data){
   header("location: student-list.php");
}
 
// Nếu người dùng submit form
if (!empty($_POST['edit_student']))
{
    // Lay data
    $name       = isset($_POST['name']) ? $_POST['name'] : '';
    $sex        = isset($_POST['sex']) ? $_POST['sex'] : '';
    $birthday    = isset($_POST['birthday']) ? $_POST['birthday'] : '';
    $id          = isset($_POST['id']) ? $_POST['id'] : '';
     
    // Validate thong tin
    $errors = array();
    if (empty($name)){
        $errors['sv_name'] = 'Chưa nhập tên sinh vien';
    }
     
    if (empty($sex)){
        $errors['sv_sex'] = 'Chưa nhập giới tính sinh vien';
    }
     
    // Neu ko co loi thi insert
    if (!$errors){
    		$edit=new DB_student;
    		$sql = "UPDATE tb_sinhvien SET sv_name='$name', sv_sex='$sex',sv_birthday='$birthday' WHERE sv_id=$id";
    		$edit->query($sql);
        
        // Trở về trang danh sách
        header("location: student-list.php");
    }
}
 

?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Edit-student</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Edit-student</h1>
        <a href="student-list.php">Trở về</a> <br/> <br/>
        <form method="post" action="student-edit.php?id=<?php echo $data['sv_id']; ?>">
            <table width="50%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td>Name</td>
                    <td>
                        <input type="text" name="name" value="<?php echo $data['sv_name']; ?>"/>
                        <?php if (!empty($errors['sv_name'])) echo $errors['sv_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <select name="sex">
                            <option value="Nam">Nam</option>
                            <option value="Nữ" <?php if ($data['sv_sex'] == 'Nữ') echo 'selected'; ?>>Nu</option>
                        </select>
                        <?php if (!empty($errors['sv_sex'])) echo $errors['sv_sex']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td>
                        <input type="text" name="birthday" value="<?php echo $data['sv_birthday']; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $data['sv_id']; ?>"/>
                        <input type="submit" name="edit_student" value="Lưu"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>