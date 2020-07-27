<?php

    /**
     * Namespace
     * 
     */
    namespace Plugin\Blocking;

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
    \Plugin\Config::add($key, $pluginConfigData);
