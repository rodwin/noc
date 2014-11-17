<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Globals
 *
 * @author rodwin
 */
use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;


class Globals {

    static function generateV4UUID() {

        try {
            // Generate a version 1 (time-based) UUID
            //$uuid1 = Uuid::uuid1();
            //echo $uuid1 . "\n"; // e4eaaaf2-d142-11e1-b3e4-080027620cdd
            // Generate a version 3 (name-based and hashed with MD5) UUID
            //$uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, 'php.net');
            //echo $uuid3 . "\n"; // 11a38b9a-b3da-360f-9353-a5a725514269
            // Generate a version 4 (random) UUID
            return Uuid::uuid4()->tostring();

            // Generate a version 5 (name-based and hashed with SHA1) UUID
            //$uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'php.net');
            //echo $uuid5 . "\n"; // c4a760a8-dbcf-5254-a0d9-6a4474bd1b62
        } catch (UnsatisfiedDependencyException $e) {
            // Some dependency was not met. Either the method cannot be called on a
            // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
            echo 'Caught exception: ' . $e->getMessage() . "\n";
            exit;
        }
    }

    static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    //put your code here
    static function getWeek($date, $rollover = 'sunday') {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $i = 1;
        $weeks = 1;

        for ($i; $i <= $elapsed; $i++) {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if ($day == strtolower($rollover))
                $weeks++;
        }

        return $weeks;
    }

    static public function getFrequency($week_no) {

        $frequency = "";

        switch ($week_no) {
            case 1://w,f1,m1
                $frequency = "'w','f1','m1'";
                break;
            case 2://w,f2,m2
                $frequency = "'w','f2','m2'";
                break;
            case 3://w,f1,m3
                $frequency = "'w','f1','m3'";
                break;
            case 4://w,f2,m4
                $frequency = "'w','f2','m4'";
                break;
            case 5://w,f1,m5
                $frequency = "'w','f1','m5'";
                break;
            case 6://w,f1,m5
                $frequency = "'w','f2','m6'";
                break;

            default:
                break;
        }

        return $frequency;
    }

    static function nice_number($n) {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n))
            return false;

        // now filter it;
        if ($n > 1000000000000)
            return round(($n / 1000000000000)) . 'T';
        else if ($n > 1000000000)
            return round(($n / 1000000000)) . 'B';
        else if ($n > 1000000)
            return round(($n / 1000000)) . 'M';
        else if ($n > 1000)
            return round(($n / 1000)) . 'K';

        return number_format($n);
    }

    public static function parseCSV($file, $head = FALSE, $first_column = FALSE, $delim = ",", $len = 9216, $max_lines = NULL) {
        if (!file_exists($file)) {
            //Debug::text('Files does not exist: ' . $file, __FILE__, __LINE__, __METHOD__, 10);
            return FALSE;
        }

        $return = false;
        $handle = fopen($file, "r");
        if ($head !== FALSE) {
            if ($first_column !== FALSE) {
                while (($header = fgetcsv($handle, $len, $delim) ) !== FALSE) {
                    if ($header[0] == $first_column) {
                        //echo "FOUND HEADER!<br>\n";
                        $found_header = TRUE;
                        break;
                    }
                }

                if ($found_header !== TRUE) {
                    return FALSE;
                }
            } else {
                $header = fgetcsv($handle, $len, $delim);
            }
        }

        $i = 1;
        while (($data = fgetcsv($handle, $len, $delim) ) !== FALSE) {
            if ($head AND isset($header)) {
                foreach ($header as $key => $heading) {
                    $row[$heading] = ( isset($data[$key]) ) ? $data[$key] : '';
                }
                $return[] = $row;
            } else {
                $return[] = $data;
            }

            if ($max_lines !== NULL AND $max_lines != '' AND $i == $max_lines) {
                break;
            }

            $i++;
        }

        fclose($handle);

        return $return;
    }

    public static function getSingleLineErrorMessage($errors = array()) {

        $err = "";
        foreach ($errors as $key => $value) {
            $err .= $value[0] . ',';
        }

        return substr($err, 0, -1);
    }

    public static function queue($data) {

        $connection = new PhpAmqpLib\Connection\AMQPConnection(Yii::app()->params['rabbitmq']['host'], Yii::app()->params['rabbitmq']['port'], Yii::app()->params['rabbitmq']['username'], Yii::app()->params['rabbitmq']['password']);
        $channel = $connection->channel();

        $channel->queue_declare('noc_queue', false, true, false, false);

        $msg = new PhpAmqpLib\Message\AMQPMessage($data, array('delivery_mode' => 2) # make message persistent
        );

        $channel->basic_publish($msg, '', 'noc_queue');

        $channel->close();
        $connection->close();
    }

    public static function pdf() {

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        return $pdf;
    }

    public static function createExcel() {

        /** Error reporting */
        error_reporting(E_ALL);

        /** Include path * */
        ini_set('include_path', 'vendor/phpoffice/phpexcel/Classes/');

        /** PHPExcel */
        include 'PHPExcel.php';

        /** PHPExcel_Writer_Excel2007 */
        include 'PHPExcel/Writer/Excel2007.php';

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        $objPHPExcel = new PHPExcel();

        return $objPHPExcel;
    }

}

?>
