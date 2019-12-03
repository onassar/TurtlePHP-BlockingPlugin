<?php

    /**
     * Namespace
     * 
     */
    namespace Plugin\Blocking;

    /**
     * Config settings
     * 
     */
    $config = array(
        'ip' => array(
            'addresses' => array()
        ),
        'referers' => array(),
        'userAgents' => array()
    );

    /**
     * Config storage
     * 
     */

    // Store
    \Plugin\Config::add(
        'TurtlePHP-BlockingPlugin',
        $config
    );
