<?php

include '../secure/db.php';

class Gallery
{
    private $_full_heavy_gallery_folder;
    private $_full_light_gallery_folder;
    private $_gallery_folder;
    private $_gallery_created;
    private $_db;
    private static $_instance;

    private function __construct($_gallery_folder) {
        $this->_gallery_folder = $_gallery_folder;
        $this->_full_heavy_gallery_folder = 'images/' . $_gallery_folder;
        $this->_full_light_gallery_folder = 'images/light_' . $_gallery_folder;
        $this->_gallery_created = false;
        $this->_db = DB::getInstance();
    }

    public static function getInstance($_gallery_folder) {
        if (is_null(self::$_instance)) {
            self::$_instance = new Gallery($_gallery_folder);
        }
        return self::$_instance;
    }

    private function _list_filenames() {
        $_folder_id = $this->_db->get_folder_id_by_name($this->_gallery_folder);
        $_heavy_filenames = array();
        $_light_filenames = array();
        foreach ($this->_db->get_images_by_folder_id_order_by_rank_desc($_folder_id) as $image) {
            $_heavy_filenames[] = $image['filename'] . $image['ext'];
            $_light_filenames[] = $image['filename'] . 'webp';
        }
        return [$_heavy_filenames, $_light_filenames];
    }

    private function _create_modal($_heavy_filenames, $_longdesc_prefix): void {
        $_img_name = '';
        if (array_key_exists('img', $_GET)) {
            $_img_name = $_GET['img'];
        }
        $_active_set = false;
        echo '<div class="modal modal-fullscreen carousel slide" id="carousel_modal" style="position: fixed;">';
        echo '    <div class="modal-dialog">';
        echo '        <div class="modal-content">';
        echo '            <div class="modal-body">';
        echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        echo '                    <span aria-hidden="true" style="float: right">&times;</span>';
        echo '                </button>';
        echo '                <div class="carousel-inner text-center">';
        for ($_i = 0; $_i < count($_heavy_filenames); $_i++) {
            $_active = (($_i == count($_heavy_filenames) - 1 || $_img_name == $_heavy_filenames[$_i]) && !$_active_set);
            $_active_set = ($_active || $_active_set);
            $_longdesc = $_longdesc_prefix . '?img=' . $_heavy_filenames[$_i];
            echo '<div class="carousel-item' . ($_active ? ' active"' : '"') . '><a target="_blank" href="' . $this->_full_heavy_gallery_folder . $_heavy_filenames[$_i] . '"><img loading="lazy" longdesc="' . $_longdesc . '" src="' . $this->_full_heavy_gallery_folder . $_heavy_filenames[$_i] . '"/></a></div>';
        }
        echo '                </div>';
        echo '                <a class="carousel-control-prev" href="#carousel_modal" role="button" data-slide="prev">';
        echo '                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '                    <span class="sr-only">Previous</span>';
        echo '                </a>';
        echo '                <a class="carousel-control-next" href="#carousel_modal" role="button" data-slide="next">';
        echo '                    <span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '                    <span class="sr-only">Next</span>';
        echo '                </a>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
        echo '<script>carousel_touch_slide()</script>';
    }

    public function create_gallery(): void {
        if ($this->_gallery_created) {
            return;
        }
        $this->_gallery_created = true;
        list($_heavy_filenames, $_light_filenames) = $this->_list_filenames();
        $_uri = $_SERVER['REQUEST_URI'];
        $_clean_uri = explode('?', $_uri);
        $_longdesc_prefix = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_clean_uri[0];
        $this->_create_modal($_heavy_filenames, $_longdesc_prefix);
        echo '<div id="gallery">';
        for ($_i = 0; $_i < count($_light_filenames); $_i++) {
            $_src = $this->_full_light_gallery_folder . $_light_filenames[$_i];
            $_longdesc = $_longdesc_prefix . '?img=' . $_light_filenames[$_i];
            echo '<div class="image-container">';
            echo '  <a href="#carousel_modal" data-toggle="modal" data-slide-to="' . ($_i) . '">';
            echo '      <img loading="lazy" longdesc="' . $_longdesc . '" src="' . $_src . '"/>';
            echo '  </a>';
            echo '</div>';
        }
        echo '</div>';

        if (array_key_exists('img', $_GET)) {
            echo "<script> $('#carousel_modal').modal('show');</script>";
        }
    }
}

?>