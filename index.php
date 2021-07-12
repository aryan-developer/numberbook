<?php
require_once "Telegram.php";
$telegram = new Telegram("****"); //توکن
define("chat_id", $telegram->ChatID());
define("type", $telegram->getUpdateType());
define("msg_id", $telegram->MessageID());
define("text", $telegram->Text());
define("data", $telegram->getData());
if (text == "/start") {
    defultMessage();
} else {
    if (isset(data["message"]["forward_from"])) {
        if ($telegram->getData()["message"]["forward_from"]["is_bot"]) {
            defultMessage2();
        } else {
            $data = json_decode(file_get_contents("https://oynay.ir/nmbrbok/?id=" . $telegram->getData()["message"]["forward_from"]["id"], true), true);
            if ($data["status"]) {
                $content = array(
                    "chat_id" => chat_id,
                    "text" => " اطلاعات یافت شد :)\n\n شماره:" . $data["phone"] . "\n ایدی: " . $data["username"],
                    "reply_to_message_id" => msg_id
                );
                $telegram->sendMessage($content);
            } else {
                $content = array(
                    "chat_id" => chat_id,
                    "text" => "اطلاعاتی پیدا نشد :(",
                    "reply_to_message_id" => msg_id
                );
                $telegram->sendMessage($content);
            }
        }
    } else {
        if (isset(data["message"]["forward_sender_name"])) {
            $content = array(
                "chat_id" => chat_id,
                "text" => "به دلیل سیاست های تلگرام نمیتوانیم بفرستیم :(",
                "reply_to_message_id" => msg_id
            );
            $telegram->sendMessage($content);
        } else {
            defultMessage();
        }
    }
}
function defultMessage()
{
    global $telegram;
    $content = array(
        "chat_id" => chat_id,
        "text" => "ی پیام از کسی که میخوای شمارشو ببینی فوروارد کن",
        "reply_to_message_id" => msg_id
    );
    $telegram->sendMessage($content);
}

function defultMessage2()
{
    global $telegram;
    $content = array(
        "chat_id" => chat_id,
        "text" => "باید از کاربر باشه نه ربات!",
        "reply_to_message_id" => msg_id
    );
    $telegram->sendMessage($content);
}
