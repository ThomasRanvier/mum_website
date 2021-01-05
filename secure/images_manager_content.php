<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Images manager</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 1650px;
        }
        #sortable li {
            float: left;
            width: 200px;
            height: 220px;
            text-align: center;
            cursor: pointer;
        }
        #sortable li img {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $('#sortable').sortable({
                update: function(event, ui) {
                    var productOrder = $(this).sortable('toArray').toString();
                    $("#order").val(productOrder);
                }
            });
        });
    </script>
</head>
<body>
    <h1>
        Images manager
    </h1>

    <?php
    // Allow for long executing time
    set_time_limit(0);

    include '../secure/db.php';
    $db = DB::getInstance();

    include '../secure/imageOptimizer.php';
    $image_optimizer = ImageOptimizer::getInstance();

    // Selected folder in select form
    if (isset($_POST['select_folder'])) {
        list($selected_folder_id, $selected_folder) = explode("-", $_POST['select_folder']);
        if (isset($_POST['images_order'])) {
            if ($_POST['images_order'] != '') {
                // If images order is set and not empty (only happens if a change have manually occured), then set ranks
                $image_ids = explode(',', $_POST['images_order']);
                $highest_rank = count($image_ids);
                foreach ($image_ids as $image_id) {
                    $db->set_image_rank($image_id, $highest_rank);
                    $highest_rank--;
                }
            }
        }
    } else {
        $selected_folder_id = 1;
        $selected_folder = $db->get_folder_by_id(1);
    }

    // On file upload
    $highest_rank = $db->get_highest_rank_by_folder_id($selected_folder_id);
    if (isset($_FILES['upload'])) {
        $total = count($_FILES['upload']['name']);
        for ($i = 0; $i < $total; $i++) {
            $tmp_file_path = $_FILES['upload']['tmp_name'][$i];
            if ($tmp_file_path != "") {
                $filename_with_ext = $_FILES['upload']['name'][$i];
                $exploding = explode('.', $filename_with_ext);
                $ext = end($exploding);
                $filename_without_ext = substr($filename_with_ext, 0, -strlen($ext));
                $highest_rank++;
                // Check if filename + ext + folder_id already exists in base, if so just update the rank and don't upload file again
                $image_id = $db->get_image_id_by_values($filename_without_ext, $ext, $selected_folder_id);
                if (isset($image_id)) {
                    // Update already uploaded image
                    $db->set_image_rank($image_id, $highest_rank);
                } else {
                    // Add new image
                    if ($db->insert_into_images($filename_without_ext, $ext, $selected_folder_id, $highest_rank)) {
                        $new_file_path = "images/" . $selected_folder . $filename_with_ext;
                        // Upload file
                        move_uploaded_file($tmp_file_path, $new_file_path);
                        // Optimize file
                        $image_optimizer->optimize_image($new_file_path, $selected_folder, $filename_without_ext);
                    } else {
                        echo 'image ' . $filename_without_ext . ';' . $ext . ';' . $selected_folder_id . ';' . $highest_rank . ' could not be inserted to db<br/>';
                    }
                }
            }
        }
    }

    // Image deletion
    if (isset($_POST['images_delete'])) {
        foreach ($_POST['images_delete'] as $image_id) {
            $image = $db->get_image_by_id($image_id);
            $folder = $db->get_folder_by_id($image['id_folder']);
            $path = $folder . $image['filename'];
            $heavy_path = 'images/' . $path . $image['ext'];
            $light_path = 'images/light_' . $path . 'webp';
            unlink($heavy_path);
            unlink($light_path);
            $db->delete_image_by_id($image_id);
        }
    }
    ?>

    <form action="images_manager.php" method="post" enctype="multipart/form-data">
        Sélectionnez un dossier :
        <select name="select_folder">
            <?php
            foreach ($db->get_all_folders() as $row) {
                echo '<option ' . ($row['id'] == $selected_folder_id ? 'selected="selected"' : '') .
                    'value="' . $row['id'] . '-' . $row['foldername'] . '">' . $row['foldername'] . '</option>';
            }
            ?>
        </select>
        <br/>
        Select files:
        <input type="file" id="files" name="upload[]" multiple/><br><br>
        <button type="submit">Valider le choix de dossier</button>
    </form>
    <br/>
    <br/>


    <form action="images_manager.php" method="post" enctype="multipart/form-data">
        <ul id="sortable">
        <?php
        $loaded_images = false;
        foreach ($db->get_images_by_folder_id_order_by_rank_desc($selected_folder_id) as $image) {
            echo '<li class="ui-state-default" id="' . $image['id'] . '"><input type="checkbox" name="images_delete[]" value="' . $image['id'] . '"><br/><img src="images/light_' . $selected_folder . $image['filename'] . 'webp"></li>';
            $loaded_images = true;
        }
        ?>
        </ul>
        <?php
        if ($loaded_images) {
        ?>
            <br/>
            <input type="hidden" name="select_folder" value="<?php echo $selected_folder_id . '-' . $selected_folder; ?>">
            <button type="submit">Supprimer les images sélectionnées</button>
        <?php
        }
        ?>
    </form>
    <?php
    if ($loaded_images) {
    ?>
        <br/>
        <form action="images_manager.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="order" name="images_order">
            <input type="hidden" name="select_folder" value="<?php echo $selected_folder_id . '-' . $selected_folder; ?>">
            <button type="submit">Valider le nouvel ordre</button>
        </form>
    <?php
    }
    ?>
</body>
</html>
