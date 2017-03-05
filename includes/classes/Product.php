<?php
class Product {

    /**
     * @param $id
     * @return array
     */
    public static function getProductInfo($id) {
        return (array)select_row_to_DB("select * from products where id = '" . (int)$id . "'");
    }

    /**
     * @return array
     */
    public static function getProductsList() {
        return (array)select_to_DB("select * from products order by name");
    }
}
