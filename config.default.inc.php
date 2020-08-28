<?php

    /**
     * Plugin Config Data
     * 
     */
    $pluginConfigData = array(
        'callback' => function(string $method, string $value, string $match): bool {
            exit(0);
        },
        'ip' => array(
            'addresses' => array()
        ),
        'pathPatterns' => array(),
        'referrers' => array(),
        'userAgents' => array()
    );

    /**
     * Storage
     * 
     */
    $key = 'TurtlePHP-BlockingPlugin';
    TurtlePHP\Plugin\Config::set($key, $pluginConfigData);
