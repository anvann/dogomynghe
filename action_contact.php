<?php
session_start();

include "includes/mysqli_connect.php";

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/OAuth.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/POP3.php";
require "PHPMailer/src/SMTP.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = '';

//Gui Mail
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = array();
    if (!empty($_POST['name'])){
        $name = $_POST['name'];
    }else{
        $errors[] = "Vui lòng hãy điền họ tên của bạn!";
    }
    if (!empty($_POST['phone'])){
        $phone = $_POST['phone'];
    }else{
        $errors[] = "Vui lòng hãy điền số điện thoại của bạn!";
    }if (!empty($_POST['email'])){
        $email = $_POST['email'];
    }else{
        $errors[] = "Vui lòng hãy điền địa chỉ email của bạn!";
    }
    if (!empty($_POST['address'])){
        $address = $_POST['address'];
    }else{
        $errors[] = "Vui lòng hãy điền địa chỉ giao hàng đến cho bạn!";
    }
    $content = $_POST['msg'];
    //gui mail
    if (empty($errors)) {
        $mail = new PHPMailer(true);

        try {
            //Server settings google go port gmail google piavietnam them ob_start

            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                    // mail server gooogle go port gmail google piavietnam
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'dungcon1904@gmail.com';                     //mail minh
            $mail->Password = 'ygbchbdmoqpyfrmj';                               //mat khau ung dung
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587;                                    // port gmail google piavietnam
            $mail->CharSet = 'UTF-8';
            //Recipients
            $mail->setFrom($email, $name); //gui tu
            $mail->addAddress('dungcon1904@gmail.com', 'THANH TÙNG-STORE');     // gui den

            //lay noi dung mail gui di
            $mailHTML .= '
                    <p>
                        <b>Họ & Tên: </b> ' . $name . '<br>
                        <b>Số điện thoại: </b> ' . $phone . '<br>
                        <b>Địa chỉ giao hàng: </b> ' . $address . '<br>
                        <b>Email: </b> ' . $email . '<br>
                        <b>Nội dung từ khách hàng: </b>' . $content . '<br>
                    </p> ';
            // Content
            $mail->isHTML(true);                                  // Định dang email thành HTML
            $mail->Subject = 'Liên hệ từ khách hàng';
            $mail->Body = $mailHTML;

            $mail->send();
            //gui mail xong thi xoa session cart
            header('Location:index.php', true, 302);
        } catch (Exception $e) {
            echo "Lỗi!Mail đã không được gửi do lỗi: {$mail->ErrorInfo}";
        }
    }else {
        foreach ($errors as $error){
            $msg .= $error . "<br/>";
            header('Location: index.php?msg='.$msg.'');
        }
    }
}
?>
