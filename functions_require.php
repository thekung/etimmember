<?php

/**
 * Generate password string
 * @since 1.0
 * @version 1.0
 * @return string
 */
if ( !function_exists('generateStrongPassword')) {
    function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?+';

        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if(!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
}

if(!function_exists('genLowerString')) {
    function genLowerString($numpass)
    {
        # สร้างรหัสแบบสุ่มจำนวนหลักตามค่า parameter ที่ส่งมา
        $allow = "abcdefghijkmnpqrstuvwxyz";
        srand((double)microtime()*1000000);
        $password = '';
        for($i=0; $i<$numpass; $i++) {
            $password .= $allow[rand()%strlen($allow)];
        }
        return $password;
    }
}

if(!function_exists('genUpperString')){
    function genUpperString($numpass)
    {
        # สร้างรหัสแบบสุ่มจำนวนหลักตามค่า parameter ที่ส่งมา
        $allow = "ABCDEFGHIJKMNPQRSTUVWXYZ";
        srand((double)microtime()*1000000);
        $password = '';
        for($i=0; $i<$numpass; $i++) {
            $password .= $allow[rand()%strlen($allow)];
        }
        return $password;
    }
}

if(!function_exists('genNumber')) {
    function genNumber($numpass){
        # สร้างตัวเลขแบบสุ่มจำนวนหลักตามค่า parameter ที่ส่งมา
        $allow = "1234567890";
        srand((double)microtime()*1000000);
        $xval = '';
        for($i=0; $i<$numpass; $i++) {
            $xval .= $allow[rand()%strlen($allow)];
        }
        return $xval;
    }
}

/**
 * Show debug information
 * @var String,Array,Object,Number
 * @since 1.0
 * @version 1.0
 */
if( !function_exists('show')) {
    function show($txt='', $small=false) {
        echo get_show($txt, $small);
    }
}

/**
 * Return debug information
 * @var String,Array,Object,Number
 * @since 1.0
 * @version 1.0
 * @return String output
 */
if( !function_exists('get_show')) {
    function get_show($txt='', $small=false) {
        $return = '';
        if($small) { $return .= '<span style="font-size:70%;">';}
        # สั่งแสดงผลค่าพารามิเตอร์ที่ส่งเข้ามา โดยถ้าค่าที่ส่งมาเป็น array จะแสดง tag pre เอาไว้ให้แสดง array
        if(is_array($txt)){
            $return .=  "<pre>";
            $return .=  print_r($txt, true);
            $return .=  "</pre>";
        } elseif (is_object($txt)) {
            $return .=  "<pre>";
            $return .=  var_export($txt, true);
            $return .=  "</pre>";
        } elseif(is_null($txt)) {
            $return .=  '<pre>NULL</pre>';
        } elseif(is_bool($txt)) {
            $return .=  "<pre>";
            $return .=  ($txt)?'true':'false';
            $return .=  '</pre>';
        } else {
            $return .=  "<pre>";
            $return .=  $txt.'</pre>';
        }
        if($small) { $return .=  '</span>';}
        return $return;
    }
}

/**
 * Display array information with key and value
 * @var ARRAY
 * @since 1.0
 * @version 1.0
 */
if( !function_exists('showarray')) {
    function showarray($arr)
    {
        echo '$arr = array(<br>'.PHP_EOL;
        foreach($arr as $k=>$o) {
            echo "\t'$k' => \$$k,<br>".PHP_EOL;
        }
        echo ');'.PHP_EOL;
    }
}

/**
 * Save debug log
 * @var String
 * @since 1.0
 * @version 1.0
 */
if( !function_exists('save_log')) {
    function save_log($log='', $filename=null, $json=false)
    {
        global $g_path;
        if($json) {
            $filename = (empty($filename)) ? 'log.json' : $filename;
            $fp = fopen(ABSPATH . $filename, 'w');
            fwrite($fp, $log);
            fclose($fp);
        } else {
            $filename = (empty($filename)) ? 'log.sql' : $filename;
            $fp = fopen(ABSPATH . $filename, 'a+');
            if(is_string($log)) {
                fwrite($fp, $log.PHP_EOL);
            } else if(is_array($log)) {
                $log = print_r($log, true);
                fwrite($fp, $log.PHP_EOL);
            } else if(is_object($log)) {
                $log = var_export($log, true);
                fwrite($fp, $log.PHP_EOL);
            }
            fclose($fp);
        }
    }
}

/**
 * Display javascript debug console from php code
 * @var String
 * @since 1.0
 * @version 1.0
 */
if( ! function_exists('debug') ) {
    function debug($str) {
        echo '<script type="text/javascript">'.PHP_EOL;
        echo 'console.log(\''.get_show($str).'\');'.PHP_EOL;
        echo '</script>'.PHP_EOL;
    }
}

/*
# สร้าง hash สำหรับใช้กับรหัสผ่าน
function generateHash($password) {
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return crypt($password, $salt);
    }
}
*/
# encrypt password
if( ! function_exists('my_crypt') ) {
    function my_crypt($password) {
        return crypt($password, SITE_SALT);
        /*
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            return crypt($password, SITE_SALT);
        } else {
            return hash("sha256", $password . SITE_SALT);
        }
        */
    }
}

if( ! function_exists('my_salt') ) {
    function my_salt() {
        #return '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 21).'$';
        return '$'.rand(0,9).genLowerString(1).'$'.genNumber(2).'$'.genUpperString(1).generateStrongPassword(21).'$';
    }
}

/**
 * Private helper function for checked, selected, and disabled.
 *
 * Compares the first two arguments and if identical marks as $type
 *
 * @since 2.8.0
 * @access private
 *
 * @param mixed  $helper  One of the values to compare
 * @param mixed  $current (true) The other value to compare if not just true
 * @param bool   $echo    Whether to echo or just return the string
 * @param string $type    The type of checked|selected|disabled we are doing
 * @param boolean $onlytype  Tel the function is return only type true|false
 * @return string html attribute or empty string
 */
if( ! function_exists('__checked_selected_helper') ) {
    function __checked_selected_helper( $helper, $current, $echo, $type, $onlytype=false ) {
        if ( (string) $helper === (string) $current )
            $result = ($onlytype) ? "$type" : " $type='$type'";
        else
            $result = '';

        if ( $echo )
            echo $result;

        return $result;
    }
}

/**
 * Outputs the html checked attribute.
 *
 * Compares the first two arguments and if identical marks as checked
 *
 * @since 1.0.0
 *
 * @param mixed $checked One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool  $echo    Whether to echo or just return the string
 * @return string html attribute or empty string
 */
if( ! function_exists('checked') ) {
    function checked( $checked, $current = true, $echo = true, $onlytype=false ) {
        return __checked_selected_helper( $checked, $current, $echo, 'checked', $onlytype );
    }
}
/**
 * Outputs the html selected attribute.
 *
 * Compares the first two arguments and if identical marks as selected
 *
 * @since 1.0.0
 *
 * @param mixed $selected One of the values to compare
 * @param mixed $current  (true) The other value to compare if not just true
 * @param bool  $echo     Whether to echo or just return the string
 * @return string html attribute or empty string
 */
if( ! function_exists('selected') ) {
    function selected( $selected, $current = true, $echo = true, $onlytype=false ) {
        return __checked_selected_helper( $selected, $current, $echo, 'selected', $onlytype );
    }
}

/**
 * Outputs the html disabled attribute.
 *
 * Compares the first two arguments and if identical marks as disabled
 *
 * @since 3.0.0
 *
 * @param mixed $disabled One of the values to compare
 * @param mixed $current  (true) The other value to compare if not just true
 * @param bool  $echo     Whether to echo or just return the string
 * @return string html attribute or empty string
 */
if( ! function_exists('disabled') ) {
    function disabled( $disabled, $current = true, $echo = true , $onlytype=false) {
        return __checked_selected_helper( $disabled, $current, $echo, 'disabled', $onlytype );
    }
}

if( ! function_exists('thai_date') ) {
    function thai_date($date=null) {
        if(empty($date)) {
            $date = date('Y-m-d');
        }
        $a = explode('-', $date);
        $thaimonth = array("", "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

        return sprintf("%d %s %d", $a[2], $thaimonth[abs($a[1])], $a[0]+543);
    }
}

/*
#Function definition
# $time_elapsed = timeAgo($time_ago); //The argument $time_ago is in timestamp (Y-m-d H:i:s)format.
*/
if(!function_exists('timeAgo')) {
    function timeAgo($time_ago) {
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60) {
            if($minutes==1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24) {
            if($hours==1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7) {
            if($days==1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3) {
            if($weeks==1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12) {
            if($months==1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if($years==1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}
