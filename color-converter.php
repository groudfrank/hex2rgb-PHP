<?php

class HexSpecialCharacterException extends Exception{};
class HexCharacterCountException extends Exception{};
class HexRangeException extends Exception{};


try{

    // $color_input = "FF8DFF";
    $color_input = "F0A";
    $hex_special_char = '/[\'^.£$%&*()}{@#~?><>,|=_+¬-]/';
    $hex_range = '/[g-zG-Z]/';

     // Checks for ALL special characters stored in the input
    // (special characters listed in hex_special_char)
    // # will not be allowed as input.
    if(preg_match($hex_special_char, $color_input) == 1){
        throw new HexSpecialCharacterException();
    }

    // Check for the right amount of characters for both long
    // and short hand hexadecimal. 
    if(strlen($color_input) != 6 && strlen($color_input) != 3){
        throw new HexCharacterCountException();
    }

    // Checks if any hexadecimal characters entered are within
    // the hexadecimal range
    if(preg_match($hex_range, $color_input)){
        throw new HexRangeException();
    }

    else{

        // Convert hexidecimal to rgb
        function hex2rgb($color){

            $color = filter_var($color, FILTER_SANITIZE_STRING);
            $color = strtolower($color);
        
            $hex_red = substr($color, 0, 2);
            $rr = hexdec($hex_red);
        
            $hex_green = substr($color, 2, 2);
            $gg= hexdec($hex_green);
        
            $hex_blue = substr($color, 4, 2);
            $bb = hexdec($hex_blue);
            
            // Concatinate each channel and return as a string
            $rgb = "rgb($rr, $gg, $bb)";
            return $rgb;
        }

        // Expands shorthand hexadecimal and then uses the hex2rgb function
        if(strlen($color_input) == 3){

            # Splits hex shorthand string into an array
            $color_char_array = str_split($color_input);

            # Expands the shorthand code by in the red/green/blue
            # channel to long form(0 => 00)
            $red_chan = $color_char_array[0] . $color_char_array[0];
            $green_chan = $color_char_array[1] . $color_char_array[1];
            $blue_chan = $color_char_array[2] . $color_char_array[2];

            $hexadecimal = $red_chan . $green_chan . $blue_chan;

            hex2rgb($hexadecimal);
        }

        // This will run if longhand hexidecimal is fed to the function
        else{
            hex2rgb($color_input);
        }
    }
    
}

catch(HexSpecialCharacterException $ex){
    echo 'Only letters and numbers are allow.';
}

catch(HexCharacterCountException $ex){
    echo 'Hexadecimal color coding requires exactly 3 or 6 charachers.';
}

catch(HexRangeException $ex){
    echo 'Values entered were outside the hexadecimal color range';
}

#-----------------------------------------------------------------------------------------------

class RGBSpecialCharacterException extends Exception{};
class RGBRangeException extends Exception{}

try{

    $color_input_rgb = "(255, 141, 255)";
    $rgb_special_char = '/[\'^.£$%&*}{@#~?><>|=_+¬-]/';
    
    // Checks the range on each channel to make sure they are between 0 and 255
    function rgbInRangeCheck($rgb_val){

        $rgb_val = filter_var($rgb_val, FILTER_SANITIZE_STRING);
        $rgb_val = preg_replace("/[^0-9,]/", "", $rgb_val);
        $pass = false;

        $rgb_val_array = explode(",", $rgb_val);

        if(($rgb_val_array[0] >= 0) && ($rgb_val_array[0] <= 255)){
            $pass = true;
        }
        else{
            $pass = false;
        }

        if(($rgb_val_array[1] >= 0) && ($rgb_val_array[1] <= 255)){
            $pass = true;
        }
        else{
            $pass = false;
        }

        if(($rgb_val_array[2] >= 0) && ($rgb_val_array[2] <= 255)){
            $pass = true;
        }
        else{
            $pass = false;
        }

        return $pass;
       
    }

    // Checks for CERTAIN special characters stored in the input
    // (special characters listed in rgb_special_char)
    // 
    if(preg_match($rgb_special_char, $color_input_rgb) == 1){
        throw new RGBSpecialCharacterException();
    }

    if(rgbInRangeCheck($color_input_rgb) == false){
        throw new RGBRangeException();
    }

    // Function splits each channel, converts them to Hexadecimal,
    // concatinates them and returns the value as a string.
    function rgb2hex($color) {

        $color = filter_var($color, FILTER_SANITIZE_STRING);
        $color = preg_replace("/[^0-9,]/", "", $color);

        $rgb_array = explode(",", $color);
        
        $rr = $rgb_array[0];
        $hex_red = dechex($rr);

        $gg = $rgb_array[1];
        $hex_green = dechex($gg);

        $bb = $rgb_array[2];
        $hex_blue = dechex($bb);

        $hexadecimal = '#' . $hex_red . $hex_green . $hex_blue;
        $hexadecimal = strtoupper($hexadecimal);
        return $hexadecimal;
    }

    rgb2hex($color_input_rgb);
}

catch(RGBSpecialCharacterException $ex){
    echo 'Characters entered are incompatible with RGB color coding';
}

catch(RGBRangeException $ex){
    echo 'A number entered is out of range. Please ensure numbers entered are integers between 0 and 255';
}

?>

