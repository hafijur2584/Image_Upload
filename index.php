<?php include 'inc/header.php'; ?>

<?php
    include 'lib/config.php';
    include 'lib/Database.php';

?>
<?php
    $db = new Database();

?>

<div class="container">

    <a class="btn btn-primary" href="index.php">Home</a>
    <div class="img_form">

        <?php

            if ($_SERVER["REQUEST_METHOD"] =="POST") {
                $permitted = array('jpg', 'jpeg', 'gif', 'png');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];

                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_name_image = substr(md5(time()), 0, 10) . '.' . $file_ext;

                $uploaded_image = "img/" . $unique_name_image;

                if (empty($file_name)) {
                    echo "<span class='failed' >Please Select An Image..!</span>";
                } elseif ($file_size > 1048567) {
                    echo "<span class='failed' >Image must be less than 1 Mb..!</span>";
                } elseif (in_array($file_ext, $permitted) === false) {
                    echo "<span class='failed' >You can only upload:-" . implode(', ', $permitted) ." File". "</span>";
                } else {

                    move_uploaded_file($file_tmp, $uploaded_image);
                    $query = "INSERT INTO tbl_image(image) VALUES ('$uploaded_image')";
                    $insert = $db->insert($query);
                    if ($insert) {
                        echo "<span class='success' >Image Upload Successfully..!</span>";
                    } else {
                        echo "<span class='failed' >Image Upload Failed..!</span>";
                    }

                }
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data" >

            <table>
                <tr>
                    <td>Select Image</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Upload"></td>
                </tr>

            </table>

        </form>

        <table class="text-center table table-striped">
            <tr>
                <th width="20%">Serial</th>
                <th width="560%">Image</th>
                <th width="20%">Action</th>
            </tr>

            <?php

                if (isset($_GET['del'])){
                    $id = $_GET['del'];

                    $get_sql = "SELECT * FROM tbl_image WHERE id = '$id'";
                    $getImg = $db->delete($get_sql);
                    if ($getImg){
                    while ($imgData = $getImg->fetch_assoc()) {
                        $del_img = $imgData['image'];
                        unlink($del_img);

                        }
                    }

                    $sql ="DELETE FROM tbl_image Where id = '$id' ";
                    $delete_img = $db->delete($sql);
                if ($delete_img) {
                    echo "<span class='success' >Image Delete Successfully..!</span>";
                } else {
                    echo "<span class='failed' >Image delete Failed..!</span>";
                }
                }

            ?>

            <?php

            $sql = "SELECT * FROM tbl_image";
            $getImage = $db->select($sql);
            if ($getImage){
                $i = 0;
                while ($result = $getImage->fetch_assoc()){

                    $i++;

                    ?>





                    <tr>

                        <td><?php echo $i; ?></td>
                        <td><img src="<?php echo $result['image'] ?>" alt="" height="60px" width="70px"></td>
                        <td>
                            <a class="btn btn-primary" href="?del=<?php echo urldecode($result['id']); ?>">Delete</a>

                        </td>

                    </tr>
                <?php     }
            } ?>


        </table>


    </div>

</div>





<?php include 'inc/footer.php';?>



