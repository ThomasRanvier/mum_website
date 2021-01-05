<?php


class DB
{
    private $_pdo;
    private static $_instance;

    private function __construct($_host, $_db, $_user, $_pass) {
        $_dsn = "mysql:host=$_host;dbname=$_db";
        $this->_pdo= new PDO($_dsn, $_user, $_pass);
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            $_json = file_get_contents('../secure/db_credentials.json');
            $_data = json_decode($_json, true);
            self::$_instance = new DB($_data['host'], $_data['db'], $_data['user'], $_data['pass']);
        }
        return self::$_instance;
    }

    public function get_folder_by_id($_id) {
        $_row = $this->_pdo->query('SELECT foldername FROM folders WHERE id=' . $_id)->fetch();
        return $_row['foldername'];
    }

    public function get_folder_id_by_name($_foldername) {
        $_row = $this->_pdo->query("SELECT id FROM folders WHERE foldername='" . $_foldername . "'")->fetch();
        return $_row['id'];
    }

    public function get_highest_rank_by_folder_id($_id) {
        $_row = $this->_pdo->query('SELECT MAX(rank) FROM images WHERE id_folder=' . $_id)->fetch();
        return $_row['MAX(rank)'];
    }

    public function insert_into_images($_filename, $_ext, $_folder_id, $_rank) {
        $_sql = 'INSERT INTO images (filename, ext, id_folder, rank) VALUES (?, ?, ?, ?)';
        $_stmt= $this->_pdo->prepare($_sql);
        return $_stmt->execute([$_filename, $_ext, $_folder_id, $_rank]);
    }

    public function get_all_folders() {
        $_stmt = $this->_pdo->query('SELECT * FROM folders');
        return $_stmt->fetchAll();
    }

    public function get_images_by_folder_id_order_by_rank_desc($_id) {
        $_stmt = $this->_pdo->query('SELECT * FROM images WHERE id_folder=' . $_id . ' ORDER BY rank DESC');
        return $_stmt->fetchAll();
    }

    public function set_image_rank($_image_id, $_rank) {
        $_sql = 'UPDATE images SET rank=' . $_rank . ' WHERE id=' . $_image_id;
        $this->_pdo->prepare($_sql)->execute();
    }

    public function get_image_id_by_values($_filename, $_ext, $_id_folder) {
        $_row = $this->_pdo->query("SELECT id FROM images WHERE filename='" . $_filename .
            "' AND ext='" . $_ext . "' AND id_folder=" . $_id_folder)->fetch();
        return $_row['id'];
    }

    public function get_image_by_id($_id) {
        $_row = $this->_pdo->query('SELECT * FROM images WHERE id=' . $_id)->fetch();
        return $_row;
    }

    public function delete_image_by_id($_id) {
        $_sql = 'DELETE FROM images WHERE id=' . $_id;
        $this->_pdo->prepare($_sql)->execute();
    }
}