<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportSalesmanCommand
 *
 * @author rodwin
 */

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class WorkerCommand extends CConsoleCommand {

    public static $start_time;
    const TTL = 43200;//half day
    const MAX_CONSUMER = 3;//number of worker
    
    public function init() {
        WorkerCommand::$start_time = time();
        echo ' [*] start_time ',date("Y-m-d H:i:s",WorkerCommand::$start_time), "\n";
    }
    
    public function actionProcess() {

        $connection = new AMQPConnection(Yii::app()->params['rabbitmq']['host'], Yii::app()->params['rabbitmq']['port'], Yii::app()->params['rabbitmq']['username'], Yii::app()->params['rabbitmq']['password']);
        $channel = $connection->channel();

        list(,,$consumerCount) = $channel->queue_declare('noc_queue', false, true, false, false);
        
        if ($consumerCount > WorkerCommand::MAX_CONSUMER) {
            echo ' [*] max consumer reached, exiting now', "\n";
            exit;
        }

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        
        $callback = function($msg) {
            
            $data = json_decode($msg->body);
            echo " [x] Received $data->task". PHP_EOL;

            
            switch ($data->task) {
                case 'import_sku':
                    Sku::model()->processBatchUpload($data->details->batch_id, $data->details->company_id);
                    break;
                case 'import_poi':
                    Poi::model()->processBatchUpload($data->details->batch_id, $data->details->company_id);
                    break;
                default:
                    break;
            }
            
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            
            echo " [x] Done", "\n";
            // stop consuming when ttl is reached			
            if ((WorkerCommand::$start_time + WorkerCommand::TTL) < time()) {
                echo " [x] channel->basic_cancel", "\n";
                $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['consumer_tag']);
            }
        };
        
        
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('noc_queue', '', false, false, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

}

?>
