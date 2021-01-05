<?php


class ImageOptimizer
{
    private $_max_width;
    private $_max_height;
    private $_quality;
    private $_dest_ext;
    private static $_instance;

    private function __construct($_max_width=(.5*.9*1920), $_max_height=(.9*1080), $_quality=70, $_dest_ext='webp') {
        $this->_max_width = (int)$_max_width;
        $this->_max_height = (int)$_max_height;
        $this->_quality = $_quality;
        $this->_dest_ext = $_dest_ext;
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new ImageOptimizer();
        }
        return self::$_instance;
    }

    private function _load_img($_source) {
        $_exploding = explode('.', $_source);
        $_ext = end($_exploding);
        switch($_ext){
            case 'png':
                $_src = imagecreatefrompng($_source);
                break;
            case 'jpeg':
            case 'jpg':
                $_src = imagecreatefromjpeg($_source);
                break;
            case 'gif':
                $_src = imagecreatefromgif($_source);
                break;
            case 'webp':
                $_src = imagecreatefromwebp($_source);
                break;
            default:
                $_src = imagecreatefromjpeg($_source);
                break;
        }
        return $_src;
    }

    private function _write_img($_src, $_destination) {
        $_exploding = explode('.', $_destination);
        $_ext = end($_exploding);
        switch($_ext){
            case 'jpeg':
            case 'jpg':
                imagejpeg($_src, $_destination, $this->_quality);
                break;
            case 'webp':
                imagewebp($_src, $_destination, $this->_quality);
                break;
            default:
                imagewebp($_src, $_destination, $this->_quality);
                break;
        }
        imagedestroy($_src);
    }

    private function _resize_and_compress($_source, $_destination) {
        list($_width, $_height) = getimagesize($_source);
        $_r = $_width / $_height;
        if ($this->_max_width / $this->_max_height > $_r) {
            $_new_width = $this->_max_height * $_r;
            $_new_height = $this->_max_height;
        } else {
            $_new_height = $this->_max_width / $_r;
            $_new_width = $this->_max_width;
        }

        $_src = $this->_load_img($_source);

        $_dst = imagecreatetruecolor($_new_width, $_new_height);
        imagecopyresampled($_dst, $_src, 0, 0, 0, 0, $_new_width, $_new_height, $_width, $_height);

        $this->_write_img($_dst, $_destination);
    }

    public function optimize_image($_source, $_folder, $_filename_without_ext) {
        $_destination = 'images/light_' . $_folder . $_filename_without_ext . $this->_dest_ext;
        $this->_resize_and_compress($_source, $_destination);
    }
}