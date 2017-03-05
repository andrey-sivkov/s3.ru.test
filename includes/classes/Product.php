<?php
    class Product {
        function __construct() {
        }

        function __destruct() {
        }

        function Product($id) {
            return select_cell_to_DB("select * from products where id = '" . (int)$id . "'");
        }
    }
