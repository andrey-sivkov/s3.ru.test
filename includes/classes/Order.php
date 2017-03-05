<?php
class Order {

    /**
     * @param $data
     */
    public static function createOrder($data) {
        $order_info = array(
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
        );
        $order_id = insert_to_DB('orders', $order_info);

        foreach ($data['products'] as $product_id => $product_quantity) {
            $product_info = Product::getProductInfo($product_id);
            $order_product = array(
                'order_id' => $order_id,
                'product_id' => $product_info['id'],
                'product_name' => $product_info['name'],
                'product_price' => $product_info['price'],
                'product_quantity' => $product_quantity,
            );
            insert_to_DB('orders_products', $order_product);
        }

        self::updateOrderTotalSum($order_id);
        self::updateOrderStatusHistory($order_id, 0, $data['comments']);
    }

    /**
     * @param $data
     * @param $order_id
     */
    public static function updateOrder($data, $order_id) {
        $order_status_id = $data['order_status_id'];
        $order_info = array(
            //'customer_name' => $data['customer_name'],
            //'customer_email' => $data['customer_email'],
            'customer_address' => $data['customer_address'],
            'last_modified' => date('Y-m-d H:i:s')
        );
        update_to_DB('orders', $order_info, array('id' => $order_id));

        foreach ($data['products'] as $order_product_id => $product_quantity) {
            $order_product = array(
                'product_quantity' => $product_quantity,
            );
            update_to_DB('orders_products', $order_product, array('id' => $order_product_id));
        }

        self::updateOrderTotalSum($order_id);
        self::updateOrderStatusHistory($order_id, $order_status_id, $data['comments']);
    }

    /**
     * @param $order_id
     * @return bool
     */
    public static function updateOrderTotalSum($order_id) {
        $order_total_sum = select_cell_to_DB("select sum(product_price * product_quantity) 
                                                from orders_products 
                                                where order_id = '" . (int)$order_id . "'");

        return update_to_DB('orders', array('total_sum' => $order_total_sum), array('id' => $order_id));
    }

    /**
     * @param $order_id
     * @param int $order_status_id
     * @param string $comments
     * @return mixed
     */
    public static function updateOrderStatusHistory($order_id, $order_status_id = 0, $comments = '') {
        if (!$order_status_id) $order_status_id = self::getOrderDefaultStatus();

        $history_info = array(
            'order_id' => $order_id,
            'order_status_id' => $order_status_id,
            'comments' => $comments
        );

        return insert_to_DB('orders_statuses_history', $history_info);
    }

    /**
     * @return bool
     */
    public static function getOrderDefaultStatus() {
        if (!$default_order_status_id = select_cell_to_DB("select id from orders_statuses where is_default = '1'"))
            $default_order_status_id = select_cell_to_DB("select id from orders_statuses order by sort_order limit 1");

        return $default_order_status_id;
    }

    /**
     * @return array
     */
    public static function getOrdersStatusesList() {
        $order_statuses = array();
        $statuses = (array)select_to_DB("select * from orders_statuses order by sort_order, name");
        foreach ($statuses as $status) {
            $order_statuses[$status['id']] = $status['name'];
        }

        return $order_statuses;
    }

    /**
     * @param $order_id
     * @return array
     */
    public static function getOrderInfo($order_id) {
        if ($order = select_cell_to_DB("select * from orders where id = '" . (int)$order_id . "'")) {
            $order['products'] = self::getOrderProducts($order_id);
            $order['history'] = self::getOrderStatusHistory($order_id);
        }
        return $order;
    }

    /**
     * @param $order_id
     * @return array
     */
    public static function getOrderProducts($order_id) {
        return (array)select_cell_to_DB("select * from orders_products where order_id = '" . (int)$order_id . "'");
    }

    /**
     * @param $order_id
     * @return mixed
     */
    public static function getOrderStatusHistory($order_id) {
        return select_to_DB("select osh.*, os.name as status 
                                from orders_statuses_history osh 
                                   left join orders_statuses os on os.id = osh.order_status_id
                                where osh.order_id = '" . (int)$order_id . "'
                                order by date_aded desc");
    }

    /**
     * @return array
     */
    public static function getOrdersList() {
        return (array)select_to_DB("select * from orders order by date_added desc");
    }
}
