<?php

class ApiControllersSsc extends FSControllers
{
    private static $email = "lehaivu01@gmail.com";
    private static $password = "huongnui5678@vulevu";
    public static $writeLog = 1;

    public function webhooksSKU()
    {
        try {
            $response = file_get_contents('php://input');
            $data = json_decode($response);

            // $content = "----------\n" . time() . "\nResponse Origin\n$response\n----------\n\n";
            // file_put_contents(PATH_BASE . "modules/api/log/ssc.txt", $content . PHP_EOL, FILE_APPEND);

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Yêu cầu không hợp lệ.'], JSON_UNESCAPED_UNICODE);
                exit();
            } else {
                if ($data->warehouse_code == 'LV-LB') {
                    $record = $this->model->get_record("code = '$data->customer_goods_barcode'", "fs_products_sub");

                    if ($record) {
                        $this->model->_update(["quantity" => $data->available], "fs_products_sub", "id = $record->id");

                        global $db;
                        $query = "UPDATE fs_products SET `quantity` = (SELECT SUM(`quantity`) FROM fs_products_sub WHERE product_id = $record->product_id) WHERE id = $record->product_id";
                        $db->query($query);
                        $db->affected_rows();
                    } else {
                        $record = $this->model->get_record("code = '$data->customer_goods_barcode'", "fs_products");
                        if ($record) {
                            $this->model->_update(["quantity" => $data->available], "fs_products", "id = $record->id");
                        }
                    }
                    self::log("WebHooks SKU Success", $response);
                }           

                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Dữ liệu đã được nhận thành công.']);
                exit();
            }
        } catch (Exception $e) {
            self::log("WebHooks SKU Error", $e->getMessage());

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Dữ liệu đã được nhận thành công.']);
            exit();
        }
    }

    public function webhooksOrder()
    {
        try {
            $response = file_get_contents('php://input');
            $data = json_decode($response);

            // $content = "----------\n" . time() . "\nResponse Origin\n$response\n----------\n\n";
            // file_put_contents(PATH_BASE . "modules/api/log/ssc.txt", $content . PHP_EOL, FILE_APPEND);

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Yêu cầu không hợp lệ.'], JSON_UNESCAPED_UNICODE);
                exit();
            } else {                
                $order = $this->model->get_record("ssc_id = '$data->tracking_id'", "fs_order");
                if ($order) {
                    switch ($data->delivery_state) {
                        case 200:
                        case 225:
                        case 250:
                        case 275:
                            $this->model->_update(["status" => 1], "fs_order", "id = $order->id");
                            break;
                        case 400:
                        case 401:
                            $this->model->_update(["status" => 2], "fs_order", "id = $order->id");
                            break;
                        case 700:
                            $this->updatePromotionDiscount($order->id);
                            $this->model->_update(["status" => 3], "fs_order", "id = $order->id");
                            break;
                    }
                    self::log("WebHooks Order Success", $response);
                }

                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Dữ liệu đã được nhận thành công.']);
                exit();
            }
        } catch (Exception $e) {
            self::log("WebHooks Order Error", $e->getMessage());

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Dữ liệu đã được nhận thành công.']);
            exit();
        }
    }

    public static function getAvailable($code)
    {
        $token = self::getToken();
        if (!$token->token) {
            return $token;
        } else {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ssc.eco/frontend/goods/get-available?barcode=$code",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $token->token",
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            return json_decode($response);
        }
    }

    public static function getComboAvailable($code)
    {
        $token = self::getToken();
        if (!$token->token) {
            return $token;
        } else {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ssc.eco/frontend/combo/get-available?barcode=$code",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $token->token",
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            return json_decode($response);
        }
    }

    public static function getToken()
    {
        $post = [
            "email" => self::$email,
            "password" => self::$password
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ssc.eco/auth/get-token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        // self::log("getToken", "POST\n" . json_encode($post). "\nRESPONSE\n". $response);

        return json_decode($response);
    }

    public static function createOrder($order, $orderDetail)
    {
        $token = self::getToken();
        if (!$token->token) {
            return $token;
        } else {
            $goodsItems = [];
            foreach ($orderDetail as $item) {
                $goodsItems[] = [
                    "barcode" => $item['code'],
                    "quantity" => $item["count"]
                ];
            }

            $post = [
                "warehouse_code" => "LV-LB",
                // "pos_code" => null,
                "goods_data" => [
                    [
                        "customer_order_id" => $order["orderID"],
                        "receiver_name" => $order['recipients_name'],
                        "receiver_phone_number" => $order['recipients_telephone'],
                        "city_name" => $order['province_name'],
                        "county_name" => $order['district_name'],
                        "ward_name" => $order['ward_name'],
                        "address" => $order['recipients_address'],
                        "goodsItems" => $goodsItems,
                        "receiver_pay_for_delivery_cost" => 0,
                        "cash_on_delivery" => $order['total_end'],
                        "note" => $order['recipients_comments'],
                        // "custom_sender_name" => "", 
                        "tvc" => 2,
                        "delivery_partial" => 0,
                        "delivery_check_goods" => 0,
                        "delivery_return_required" => 0
                    ]
                ]
            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.ssc.eco/frontend/goodsIssue/create-api/create',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($post),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer $token->token"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            self::log("createOrder", "POST\n" . json_encode($post). "\nRESPONSE\n". $response);

            return json_decode($response);
        }
    }

    public static function log($title, $log)
    {
        if (self::$writeLog) { 
            $content = "----------\n".time()."\n$title\n$log\n----------\n\n";
            file_put_contents(PATH_BASE . "modules/api/log/ssc.txt", $content. PHP_EOL, FILE_APPEND);
        }

        return;
    }

    public function updatePromotionDiscount($id)
    {
        $orderDetail = $this->model->get_records("order_id = $id", "fs_order_items");

        foreach ($orderDetail as $item) {
            if ($item->promotion_discount_id) {
                $this->model->_update(['sold' => "sold - $item->promotion_discount_quantity"], 'fs_promotion_discount_detail', "promotion_id = " . $item->promotion_discount_id . " AND product_id = " . $item->product_id);
            }
        }
    }
}
