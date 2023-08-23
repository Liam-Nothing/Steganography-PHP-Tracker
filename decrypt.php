<?php

//Convert string to binary
function toBin($str)
{
    $str = (string)$str;
    $l = strlen($str);
    $result = '';
    while ($l--) {
        $result = str_pad(decbin(ord($str[$l])), 8, "0", STR_PAD_LEFT) . $result;
    }
    return $result;
}

//Convert binary to string
function toString($str)
{
    $text_array = explode("\r\n", chunk_split($str, 8));
    $newstring = '';
    for ($n = 0; $n < count($text_array) - 1; $n++) {
        $newstring .= chr(base_convert($text_array[$n], 2, 10));
    }
    return $newstring;
}


function decryptSteno($src) {

    $img = imagecreatefrompng($src);

    $real_message = '';
    $count = 0;
    $pixelX = 0;
    $pixelY = 0;

    list($width, $height, $type, $attr) = getimagesize($src);

    while ($pixelY < $height) {
        $rgb = imagecolorat($img, $pixelX, $pixelY);
        $b = $rgb & 0xFF;
        $blue = toBin($b);

        $real_message .= $blue[strlen($blue) - 1];
        $count++;

        if ($count === 8) {
            if (toString(substr($real_message, -8)) === '|') {
                $real_message = toString(substr($real_message, 0, -8));

                return [
                    "type" => "success",
                    "message" => "Success decrypting.",
                    "content" => json_decode($real_message)
                ];
            }
            $count = 0;
        }

        $pixelX++;

        if ($pixelX === $width) {
            $pixelY++;
            $pixelX = 0;
        }

        if ($pixelY === $height && $pixelX === $width) {
            return [
                "type" => "error",
                "message" => "Max Reached"
            ];
        }
    }

    return [
        "type" => "error",
        "message" => "Decryption failed"
    ];
}

$return_data = [
    "type" => null,
    "message" => null
];

if (isset($_FILES['image_with_data'])) {
    $return_data = decryptSteno($_FILES['image_with_data']['tmp_name']);
} else {
    $return_data["type"] = "error";
    $return_data["message"] = "Enter a file please.";
}

header('Content-Type: application/json');
echo json_encode($return_data);
