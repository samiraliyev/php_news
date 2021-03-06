<?php include("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include("menu.php"); ?>
            <?php ob_start();
            $edit_title = "New flatpages add";
            if ($_GET['edit']) {
                $edit_title = "Edit flatpage";
            }
            if(isset($_POST['change'])) {
                if ($_FILES['picture']['size'] == 0) {
                    $uploadOk = 0;
                }
                else {
                    $target_dir = "../uploads/flatpage/";
                    $save_target = "uploads/flatpage/";
                    $token = generateRandomString();
                    $target_file = $target_dir . $token . basename($_FILES["picture"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["picture"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $handle_error = "File is not an image.";
                        $uploadOk = 0;
                    }

//                    // Check if file already exists
//                    if (file_exists($target_file)) {
//                        $handle_error = "Sorry, file already exists.";
//                        $uploadOk = 0;
//                    }
                    // Check file size
                    if ($_FILES["picture"]["size"] > 50000000) {
                        $handle_error = "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    ) {
                        $handle_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error


                }
                if ($uploadOk == 0) {
                    if ($_POST['id']) {
                        $flat_id = (int) $_POST['id'];
                        $url = $_POST['url'];
                        $name = check_input($_POST['name']);
                        $title = check_input($_POST['title']);
                        $sub_title = check_input($_POST['sub_title']);
                        $text = stripslashes($_POST["text"]);

                        $update_flat = "UPDATE `flatpage` SET `url`='".$url."' , `title`='".$title."' , `name`='".$name."' , `content`='".$text."' WHERE `id`=".$flat_id."";

                        if ($mysqli->query($update_flat)) {
                            get_flat_list();
                        } else {
                            $handle_error = "Error: $mysqli->error";
                        }

                    }
                }

                else {
                    global $target_file;
                    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                        // If Succesfuly image upload then
                        global $user;
                        if ($_POST['id']) {
                            $post_id = (int) $_POST['id'];
                            $title = check_input($_POST['title']);
                            $sub_title = check_input($_POST['sub_title']);
                            $full_image_path = $save_target . basename($_FILES["picture"]["name"]);
                            $time = get_valid_datetime($_POST['date']);
                            $author = (int) $user['id'];
                            $text = check_input($_POST['text']);
//                            if ($_FILES['picture']){
//                                $handle_error = "var";
//                            }
//                            else {
//                                $handle_error = "yoxdu";
//                            }
//                            $update_post = "UPDATE `article` SET `title`='".$title."' , `image`='".$full_image_path."' , `sub_title`='".$sub_title."' , `author_id`='".$author."' , `publish_date`=FROM_UNIXTIME(" . $time . "), `text`='".$text."' WHERE `id`=".$post_id."";
//                            if ($mysqli->query($update_post)) {
//                                $handle_error = "Successfuly created post";
//                            } else {
//                                $handle_error = "Error: $mysqli->error";
//                            }
                        }
                        else {
                            if (check_url($_POST['url'])) {
                                global $save_target, $token;
                                $url = $_POST['url'];
                                $name = check_input($_POST['name']);
                                $title = check_input($_POST['title']);
                                $sub_title = check_input($_POST['sub_title']);
                                $full_image_path = $save_target . $token . basename($_FILES["picture"]["name"]);
                                $text = stripslashes($_POST["text"]);

                                $create_flat = "INSERT INTO `flatpage` (`url`, `name`,`title`,`image`,`sub_title`, `content`) VALUES ('" . $url . "','" . $name . "','" . $title . "','" . $full_image_path . "','" . $sub_title . "','" . $text . "')";

                                if ($mysqli->query($create_flat)) {
                                    get_flat_list();
                                } else {
                                    $handle_error = "Error: $mysqli->error";
                                }
                            }
                            else {
                                $handle_error = "Please append slash url row";
                            }
                        }
                    } else {

                        $handle_error = "Sorry, there was an error uploading your file.";
                    }
                }


//                if ($id) {
//                    $edit_query = "UPDATE `header` SET `name`='".$name."' , `text`='".$text."' WHERE `id`=".$id."";
//                    $mysqli->query($edit_query);
//                    get_list();
//                }
//                else {
//                    $edit_query = "INSERT INTO `header`(`name`,`text`) VALUES ('".$name."','".$text."')";
//                    $res = $mysqli->query($edit_query);
//                    get_list();
//                }


            }
            function check_input($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = strip_tags($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            function generateRandomString($length = 10) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            function check_url($url) {
                if(strpos($url, '/') !== false) {
                    return true;
                }
                else {
                    return false;
                }
            }
            function get_valid_datetime($var) {
                if ($var) {
                    $final = (string) strtotime($var);
                    var_dump($final);
                    return $final;
                }
                else {
                    $currentDate = date("Y-m-d");
                    $currentTime = date("H:i:s");
                    $final = (string) strtotime($currentDate . $currentTime);
                    var_dump($final);
                    return $final;
                }
            }
            function get_flat_list() {
                return header("Location: flatpage_list.php");
            }
            ?>

            <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
                <h1><?php echo $edit_title ?></h1>
                <p><span class="text-success"><?php echo $handle_error; ?></span></p>
                <form action=""  method="post" class="form-group" enctype="multipart/form-data">
                    <?php
                    if ($_GET['edit']) {
                        $get_head = "SELECT * FROM `flatpage` WHERE `id`=" . $_GET['edit'] . "";
                        $result = $mysqli->query($get_head);
                        foreach ($result as $key) {
                            echo '<input type="hidden" name="id" value="'.$_GET['edit'].'">
                                  <div class="form-group">
                                        <label for="exampleInputEmail1">Base url</label>
                                        <input type="text" name="url" value="'.$key['url'].'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                                        <small id="emailHelp" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" name="name" value="'.$key['name'].'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                                        <small id="emailHelp" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" name="title" value="'.$key['title'].'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                                        <small id="emailHelp" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Sub title</label>
                                        <input type="text" name="sub_title" value="'.$key['sub_title'].'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                                        <small id="emailHelp" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Cover picture</label>
                                        <input type="file" name="picture"  class="form-control" >
                                        <small id="emailHelp" class="form-text text-muted">Current cover_picture : <a href="'.$key['image'].'">'.$key['image'].'</a></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Text</label>
                                        <textarea name="text" id="ckeditor" class="form-control" cols="30" rows="10">'.$key['content'].'</textarea>
                                        <small id="emailHelp" class="form-text text-muted"></small>
                                    </div>
                                     <script >
                                    CKEDITOR.replace( "ckeditor");</script>
                                  ';
                        };
                    }
                    else {
                        echo '
                    <div class="form-group">
                        <label for="exampleInputEmail1">Base Url</label>
                        <input type="text" name="url" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        <small id="emailHelp" class="form-text text-muted">Example: \'/about/contact/\'. Make sure to have leading and trailing slashes.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="title"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sub Title</label>
                        <input type="text" name="sub_title"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cover picture</label>
                        <input type="file" name="picture"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Content</label>
                        <textarea name="text" id="ckeditor" class="form-control" cols="30" rows="10"></textarea>
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <script >
                    CKEDITOR.replace( "ckeditor");</script>
                    ';
                    }
                    ?>



                    <input type="submit" name="change" class="btn btn-success">
                </form>


            </main>

        </div>
    </div>
<?php include("footer.php"); ?>