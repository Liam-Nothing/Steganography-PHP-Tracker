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

function get_ip()
{

    $the_ip1 = null;
    $the_ip2 = null;
    $the_ip3 = null;

    if (function_exists('apache_request_headers'))
        $headers = apache_request_headers();
    else
        $headers = $_SERVER;

    if (array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE))
        $the_ip1 = $headers['X-Forwarded-For'];
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE))
        $the_ip2 = $headers['HTTP_X_FORWARDED_FOR'];

    $the_ip3 = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

    return array(
        'X-Forwarded-For' => $the_ip1,
        'HTTP_X_FORWARDED_FOR' => $the_ip2,
        'REMOTE_ADDR' => $the_ip3
    );
}


function create_image($img, $str)
{

    $msg = $str;
    $src = $img;

    $msg .= '|'; //EOF sign, decided to use the pipe symbol to show our decrypter the end of the message
    $msgBin = toBin($msg); //Convert our message to binary
    $msgLength = strlen($msgBin); //Get message length
    $img = imagecreatefromjpeg($src); //returns an image identifier
    list($width, $height, $type, $attr) = getimagesize($src); //get image size

    if ($msgLength > ($width * $height)) { //The image has more bits than there are pixels in our image
        return imagecreatefromjpeg($src);
    }

    $pixelX = 0; //Coordinates of our pixel that we want to edit
    $pixelY = 0; //^

    for ($x = 0; $x < $msgLength; $x++) { //Encrypt message bit by bit (literally)

        //if($pixelX === $width+1){
        if ($pixelX === $width) { //If this is true, we've reached the end of the row of pixels, start on next row
            $pixelY++;
            $pixelX = 0;
        }

        if ($pixelY === $height && $pixelX === $width) { //Check if we reached the end of our file
            return imagecreatefromjpeg($src);
        }

        $rgb = imagecolorat($img, $pixelX, $pixelY); //Color of the pixel at the x and y positions
        $r = ($rgb >> 16) & 0xFF; //returns red value for example int(119)
        $g = ($rgb >> 8) & 0xFF; //^^ but green
        $b = $rgb & 0xFF; //^^ but blue

        $newR = $r; //we dont change the red or green color, only the lsb of blue
        $newG = $g; //^
        $newB = toBin($b); //Convert our blue to binary
        $newB[strlen($newB) - 1] = $msgBin[$x]; //Change least significant bit with the bit from out message
        $newB = toString($newB); //Convert our blue back to an integer value (even though its called tostring its actually toHex)

        $new_color = imagecolorallocate($img, $newR, $newG, $newB); //swap pixel with new pixel that has its blue lsb changed (looks the same)
        imagesetpixel($img, $pixelX, $pixelY, $new_color); //Set the color at the x and y positions
        $pixelX++; //next pixel (horizontally)

    }

    return $img;
}

function is_clean($string)
{
    return !preg_match("/[^a-z\d_-]/i", $string);
}

if (isset($_GET['file'])) {
    $file = htmlspecialchars($_GET['file']);
    $path = "../img_pure/" . $file;
    $date_now = date("d/m/Y H:i:s");

    $user_data = [
        "date" => $date_now,
        "HTTP_USER_AGENT" => htmlspecialchars($_SERVER['HTTP_USER_AGENT']),
        "HTTP_ACCEPT_LANGUAGE" => htmlspecialchars($_SERVER['HTTP_ACCEPT_LANGUAGE']),
        "ip" => get_ip()
    ];

    if (is_clean($file)) {
        if (file_exists($path . ".jpg")) {
            $img = create_image($path . ".jpg", json_encode($user_data));
            header('Content-Type: image/png');
            imagepng($img);
            imagedestroy($img);
        } else {
            header("Location: ../404.html");
        }
    } else {
        header("Location: ../404.html#");
    }
} else {
    header("Location: ../404.html#");
}
