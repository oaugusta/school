<?php

function notification($name, $day, $action) {

    $url = 'https://maker.ifttt.com/trigger/school_oa/with/key/8JLDe1G5WC651lTyEs18x';
    
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

    $url = 'https://maker.ifttt.com/trigger/lesson/with/key/lP9cV5n5XXhvK4nHIyjkk3Iug2YyAi3XOzcec6zVqS2';
    
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