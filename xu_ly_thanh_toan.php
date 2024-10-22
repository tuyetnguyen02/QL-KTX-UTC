<?php
header('Content-type: text/html; charset=utf-8');
$total_price = $_GET['total_price'];
$url_update = "https://localhost/Code_Tuyet/Dormitory/action/capnhat_thanhtoan.php?";
if(isset($_GET['contract_id'])){
    $contract_id = $_GET['contract_id'];
    $url_update .= "contract_id=". $contract_id."&";
}
if(isset($_GET['register_vesinh_id'])){
    $register_vesinh_id = $_GET['register_vesinh_id'];
    $url_update .= "register_vesinh_id=". $register_vesinh_id."&";
}
if(isset($_GET['register_xemay_id'])){
    $register_xemay_id = $_GET['register_xemay_id'];
    $url_update .= "register_xemay_id=". $register_xemay_id."&";
}
if(isset($_GET['register_xedap_id'])){
    $register_xedap_id = $_GET['register_xedap_id'];
    $url_update .= "register_xedap_id=". $register_xedap_id."&";
}
// thanh toán bill điện nước riêng biệt
if(isset($_GET['bill_id'])){
    $bill_id = $_GET['bill_id'];
    $url_update .= "bill_id=". $bill_id."&";
}
// echo $bill_id;


// sửa đường linh lấy id contract và register_service


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );

    // 26-05 phát hiện lỗi time 5->20 lỗi do phía máy chủ momo
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}


$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua ATM MoMo";
$amount = $total_price;      //"10000";
$orderId = time() ."";
$redirectUrl = substr($url_update, 0, -1)."&price=".$total_price;
// "https://localhost/Code_Tuyet/Dormitory/thong_tin_ca_nhan.php";
$ipnUrl = substr($url_update, 0, -1)."&price=".$total_price;
$extraData = "";

    $requestId = time() . "";
    $requestType = "payWithATM";
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    header('Location: ' . $jsonResult['payUrl']);
