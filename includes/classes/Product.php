<?php

/**
 * Class Product
 */
class Product {

    /**
     * @param $product_id
     * @return array
     */
    public static function getProductInfo($product_id)
    {
        global $DB;

        return $DB->query("select * from products where id = ?d", $product_id);
    }

    /**
     * @return array
     */
    public static function getProductsList()
    {
        global $DB;

        return $DB->query("select * from products order by name");
    }
}
