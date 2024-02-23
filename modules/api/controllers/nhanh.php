<?php

/**
 * $accessToken tồn tại trong 1 năm
 */
class ApiControllersNhanh extends FSControllers
{
    private static $accessToken = "YAhvXN9bmuw9jS77MNBdaXIdK1cKnzxUrTJVEwArzljYribtVYgCpjrzPEQE4tzuKJFaJ4tQWaLaHYLQYAN0MpfKIzJEun9WoXNZOYbBig0MS51bFm0qD0hTbQ5C16tlcfEnr61GsOJQ92BqqiTVrk0m5UIAnqgsSxGlWLcFmw";
    private static $secretKey = "ZNUV9UcsvTk2s1FyWAxLoQzLhoMp6IJ8xYHonFIv2r4SMuLKlqr81sktpuA73YSHYUqHg8uSuvFWvTo4Ietlu0seXa17jdjC9c3tRILqNQUdekNcdtnmDX04TB46gM7y";
    private static $appId = "73980";
    private static $version = "2.0";
    private static $businessId = "119888";
    private static $hooksVerifyToken  = "5fc6195f3a591fdb080021c55a774347";
    public static $writeLog = 1;

    /**
     * Webhoooks
     */
    public function webhooksNhanh()
    {
        try {
            $response = file_get_contents('php://input');
            $data = json_decode($response);

            // $content = "----------\n".time()."\nResponse Origin\n$response\n----------\n\n";
            // file_put_contents(PATH_BASE . "modules/api/log/nhanh.txt", $content. PHP_EOL, FILE_APPEND);

            if ($_SERVER['REQUEST_METHOD'] != 'POST' || $data->webhooksVerifyToken != self::$hooksVerifyToken) {
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Yêu cầu không hợp lệ.'], JSON_UNESCAPED_UNICODE);
            } else {
                switch ($data->event) {
                    case "productUpdate":
                        $this->productUpdateHooks($data->data);
                        break;
                    case "orderUpdate": 
                        $this->orderUpdateHooks($data->data);
                        break;
                }           

                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Dữ liệu đã được nhận thành công.']);
            }
        } catch (Exception $e) {
            self::log("WebHooks Error", $e->getMessage());

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Dữ liệu đã được nhận thành công.']);
        }
       

        exit();
    }

    public function productUpdateHooks($data)
    {
        try {
            $log = json_encode($data); 
            $row = [
                'nhanh_id' => $data->idNhanh,
                'price' => $data->price,
                'price_old' => $data->price_old,
                'discount' => $data->price_old - $data->price,
                'edited_time' => date('Y-m-d H:i:s')
            ];
            
            if ($data->code) {
                $sub = $this->model->get_record("code = '$data->code'", "fs_products_sub", 'id, code, product_id');
        
                if ($sub) {
                    $this->model->_update($row, 'fs_products_sub', "id = $sub->id");
        
                    global $db;
                    $query = "UPDATE fs_products SET `price` = (SELECT MIN(`price`) FROM fs_products_sub WHERE `price` > 0 AND product_id = $sub->product_id LIMIT 1) WHERE id = $sub->product_id";
                    $db->query($query);
                    $db->affected_rows();
                    
                    self::log("WebHooks Success - Product", $log);
                } else {
                    $product = $this->model->get_record("code = '$data->code'", "fs_products");
        
                    if ($product) {
                        $this->model->_update($row, 'fs_products', "id = $sub->id");
                        
                        self::log("WebHooks Success - Product", $log);
                    }
                }

                // if (!$sub && !$product) {
                //     self::log("WebHooks Success - Product Not Exist", $log);
                // }
            } 
            // else {
            //     self::log("WebHooks Success - Product Not Exist", $log);
            // }           

            return;
        } catch (Exception $e) {
            self::log("WebHooks Error", $e->getMessage());
            return;
        }
    }

    public function orderUpdateHooks($data)
    {
        try {
            $log = json_encode($data); 
            $order = $this->model->get_record("nhanh_id = '$data->orderId'", "fs_order");

            if ($order) {
                self::log("WebHooks Success - Order", $log);

                switch ($data->status) {
                    case "Success":
                        $this->model->_update(["status" => 2], "fs_order", "id = $order->id");
                        break;
                    case "Shipping":
                        $this->model->_update(["status" => 1], "fs_order", "id = $order->id");
                        break;
                    case "Failed":
                        $this->model->_update(["status" => 3], "fs_order", "id = $order->id");
                        break;
                    case "Canceled":
                        $this->model->_update(["status" => 3], "fs_order", "id = $order->id");
                        break;
                    case "Aborted":
                        $this->model->_update(["status" => 3], "fs_order", "id = $order->id");
                        break;
                }
            } 
            // else {
            //     self::log("WebHooks Success - Order Not Exist", $log);
            // }

            return;
        } catch (Exception $e) {
            self::log("WebHooks Error", $e->getMessage());
            return;
        }
    }


    /**
     * Api
     */
    public static function callApi($data, $url)
    {
        $post = [
            "version" => self::$version,
            "secretKey" => self::$secretKey,
            "businessId" => self::$businessId,
            "accessToken" => self::$accessToken,
            "appId" => self::$appId
        ];

        if ($data) {
            if (is_array($data)) {
                $post["data"] = json_encode($data, JSON_UNESCAPED_UNICODE);
            }
            else {
                $post["data"] = $data;
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($post),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        self::log("Call API", http_build_query($post));

        return json_decode($response);
    }

    /**
     * Thêm đơn hàng mới
     */
    public static function addOrder($order, $orderDetail, $sscID = null)
    {
        $productList = [];

        foreach ($orderDetail as $item) {
            $productList[] = [
                "idNhanh" => $item["nhanh_id"],
                "id" => $item["id_sub"] ?: $item["product_id"],
                "quantity" => $item["count"],
                "code" => $item["code"],
                "price" => $item["price"],
                "name" => $item["product_name"],
                // "gifts" => [
                //     [
                //         "Id" => "id sản phẩm trên website",
                //         "quantity" => "Số lượng",
                //         "value" => "Giá sản phẩm quà tặng"
                //     ]
                // ]
            ];
        }

        $data = [
            "id" => $sscID ?: $order['orderID'],

            "customerName" => $order['recipients_name'],
            "customerMobile" => $order['recipients_telephone'],
            "customerEmail" => $order['recipients_email'],
            "customerAddress" => $order['recipients_address'],
            "customerCityName" => $order['province_name'],
            "customerDistrictName" => $order['district_name'],
            "customerWardLocationName" => $order['ward_name'],
            "description" => $order['recipients_comments'],

            "status" => "New",

            "carrierId" => 5,
            // "carrierServiceId" => "",
            "customerShipFee" => 30000,

            // "moneyDiscount" => "",
            // "moneyTransfer" => "",

            "paymentMethod" => "COD",
            // "paymentCode" => "",
            // "paymentGateway" => "",

            "productList" => $productList
        ];

        $url = "https://open.nhanh.vn/api/order/add";

        return self::callApi($data, $url);
    }


    /**
     * Lấy danh sách hãng vận chuyển
     */
    public static function productDetail($code)
    {
        $url = "https://open.nhanh.vn/api/product/detail";
        $data = $code;

        return self::callApi($data, $url);
    }
    
    /**
     * Lấy danh sách hãng vận chuyển
     */
    public static function shippingCarrier()
    {
        $url = "https://open.nhanh.vn/api/shipping/carrier";

        return self::callApi(null, $url);
    }

    /**
     * Tính giá ship theo địa chỉ, số sp, hãng vận chuyển
     */
    public static function shippingFee()
    {
        $url = "https://open.nhanh.vn/api/shipping/fee";
        $data = [
            "fromCityName" => "Hà Nội",
            "fromDistrictName" => "Quận Long Biên",
            "toCityName" => "Hà Nội",
            "toDistrictName" => "Quận Hai Bà Trưng",
            "productIds" => [
                "39021691" => 1,
                "39012000" => 2
            ],
            "carrierIds" => [2,5]
        ];

        return self::callApi($data, $url);
    }
    
    public static function log($title, $log)
    {
        if (self::$writeLog) { 
            $content = "----------\n".time()."\n$title\n$log\n----------\n\n";
            file_put_contents(PATH_BASE . "modules/api/log/nhanh.txt", $content. PHP_EOL, FILE_APPEND);
        }

        return;
    }
}
