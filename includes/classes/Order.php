<?php
class Order
{

    /**
     * Новый заказ
     * @param $data
     * @return int
     */
    public static function createOrder($data)
    {
        global $DB;

        $order_info = array(
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_address' => $data['customer_address'],
        );
        $order_id = $DB->query("insert into orders (?#) values (?a)", array_keys($order_info), array_values($order_info));

        foreach ($data['products'] as $product_id => $product_quantity) {
            $product_info = Product::getProductInfo($product_id);
            $order_product = array(
                'order_id' => $order_id,
                'product_id' => $product_info['id'],
                'product_name' => $product_info['name'],
                'product_price' => $product_info['price'],
                'product_quantity' => $product_quantity,
            );
            $DB->query("insert into orders_products (?#) values (?a)", array_keys($order_product), array_values($order_product));
        }

        self::updateOrderTotalSum($order_id);
        self::updateOrderStatusHistory($order_id, 0, $data['comments']);

        return $order_id;
    }

    /**
     * Обновление заказа
     * @param $data
     * @param $order_id
     * @return bool
     */
    public static function updateOrder($data, $order_id)
    {
        global $DB;

        $order_info = array(
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_address' => $data['customer_address'],
            'last_modified' => date('Y-m-d H:i:s')
        );
        $result = $DB->query("update orders set ?a where id = ?d", $order_info, $order_id);

        foreach ($data['products'] as $order_product_id => $product_data) {
            $product_price = (float)$product_data['price'];
            $product_quantity = (int)$product_data['quantity'];
            $order_product = array(
                'product_price' => $product_price,
                'product_quantity' => $product_quantity,
            );
            $DB->query("update orders_products set ?a where id = ?d", $order_product, $order_product_id);
        }

        self::updateOrderTotalSum($order_id);

        $order_status = self::getOrderStatus($order_id);
        if ($order_status['status_id'] != $data['order_status_id'] || !empty($data['comments']))
            self::updateOrderStatusHistory($order_id, $data['order_status_id'], $data['comments']);

        return $result;
    }

    /**
     * Обновление итоговой суммы заказа
     * @param $order_id
     * @return bool
     */
    public static function updateOrderTotalSum($order_id)
    {
        global $DB;

        $order_total_sum = select_cell_to_DB("select sum(product_price * product_quantity) 
                                                from orders_products 
                                                where order_id = '" . (int)$order_id . "'");

        return $DB->query("update orders set total_sum = ? where id = ?d", $order_total_sum, $order_id);
    }

    /**
     * Добавление записи в историяю заказа
     * @param $order_id
     * @param int $order_status_id
     * @param string $comments
     * @return mixed
     */
    public static function updateOrderStatusHistory($order_id, $order_status_id = 0, $comments = '')
    {
        global $DB;

        if (!$order_status_id)
            $order_status_id = self::getOrderDefaultStatus();

        $history_info = array(
            'order_id' => $order_id,
            'order_status_id' => $order_status_id,
            'comments' => $comments
        );

        return $DB->query("insert into orders_statuses_history (?#) values (?a)", array_keys($history_info), array_values($history_info));
    }

    /**
     * Получение id статуса заказа, выставляемого по умолчанию
     * @return bool
     */
    public static function getOrderDefaultStatus()
    {
        global $DB;

        if (!($default_order_status_id = $DB->selectCell("select id from orders_statuses where is_default = 1")))
            $default_order_status_id = $DB->celectCell("select id from orders_statuses order by sort_order limit 1");

        return $default_order_status_id;
    }

    /**
     * Список статусов заказов с id статуса в качестве ключа
     * @return array
     */
    public static function getOrdersStatusesList()
    {
        global $DB;

        $order_statuses = array();
        $statuses = $DB->query("select id, name from orders_statuses order by sort_order, name");

        return array_column($statuses, 'name', 'id');
    }

    /**
     * Инофрмация о заказе
     * @param $order_id
     * @return array
     */
    public static function getOrderInfo($order_id)
    {
        global $DB;

        if ($order = $DB->query("select * from orders where id = ?d", $order_id)) {
            $order['products'] = self::getOrderProducts($order_id);
            $order['history'] = self::getOrderStatusHistory($order_id);
            $order['status'] = self::getOrderStatus($order_id);
        }

        return $order;
    }

    /**
     * Список товаров в заказе
     * @param $order_id
     * @return array
     */
    public static function getOrderProducts($order_id)
    {
        global $DB;

        return $DB->query("select * from orders_products where order_id = ?d", $order_id);
    }

    /**
     * История изменения статуса заказа
     * @param $order_id
     * @return mixed
     */
    public static function getOrderStatusHistory($order_id)
    {
        global $DB;

        return $DB->query("select osh.*, os.name as status 
                             from orders_statuses_history osh 
                                 left join orders_statuses os on os.id = osh.order_status_id
                             where osh.order_id = ?d order by osh.date_added desc", $order_id);
    }

    /**
     * Текущий статус заказа
     * @param $order_id
     * @return mixed
     */
    public static function getOrderStatus($order_id)
    {
        global $DB;

        return $DB->selectRow("select os.id as status_id, os.name as status_name 
                                  from orders_statuses_history osh 
                                      left join orders_statuses os on os.id = osh.order_status_id
                                  where osh.order_id = ?d order by osh.date_added desc limit 1", $order_id);
    }

    /**
     * Список заказов и их статусов
     * @return array
     */
    public static function getOrdersList()
    {
        global $DB;

        $orders = $DB->query("select * from orders order by date_added desc");
        foreach ($orders as $k => $order) {
            $order_status = self::getOrderStatus($order['id']);
            $orders[$k]['status'] = $order_status['status_name'];
        }

        return $orders;
    }
}
