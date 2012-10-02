<?php

return array(
    //'comport' => '/dev/cu.usbserial-FTFQSY6U',
    'comport' => 'COM1',
    'areas' => array(
        array(
            'zone' => 0,
            'speakers' => array(
                array('speaker' => 'A', 'name' => 'Lounge'),
                array('speaker' => 'B', 'name' => 'Study')
            )
        ),
        array(
            'zone' => 1,
            'speakers' => array(
                array('speaker' => 'C', 'name' => 'Outside')
            )
        ),
    ),
);
?>
