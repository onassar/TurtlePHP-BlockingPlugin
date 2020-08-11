<?php

    /**
     * Plugin Config Data
     * 
     */
    $config = array(
        'ip' => array(
            'addresses' => array()
        ),
        'referrers' => array(),
        'userAgents' => array()
    );

    /**
     * Storage
     * 
     */
    $key = 'TurtlePHP-BlockingPlugin';
    TurtlePHP\Plugin\Config::set($key, $pluginConfigData);
