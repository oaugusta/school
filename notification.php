<?php

function notification($name, $day, $action) {
    //this function sends a system notification
    $url = ''; //your ifttt maker (webhooks) trigger url goes here
    
    switch ($day) {
            case 1:
                $dfn = "v pondělí";
                break;
            case 2:
                $dfn = "v úterý";
                break;
            case 3:
                $dfn = "ve středu";
                break;
            case 4:
                $dfn = "ve čtvrtek";
                break;
            case 5:
                $dfn = "v pátek";
                break;
        }
    
    $data = array('value1' => $name, 'value2' => $dfn, 'value3' => $action);
    
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { echo "Sending the notification failed!"; }
    
}


function reminder($subject, $content, $meeting) {
    //this function sends the lesson reminder
    $url = ''; //your ifttt maker (webhooks) trigger url goes here
    
    $data = array('value1' => $subject, 'value2' => $content, 'value3' => $meeting);
    
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { echo "Sending the reminder failed!"; }
    
}

?>
