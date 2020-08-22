<?php

    // Namespace overhead
    namespace TurtlePHP\Plugin;

    /**
     * Blocking
     * 
     * Blocking plugin for TurtlePHP.
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     * @extends Base
     */
    abstract class Blocking extends Base
    {
        /**
         * _configPath
         * 
         * @access  protected
         * @var     string (default: 'config.default.inc.php')
         * @static
         */
        protected static $_configPath = 'config.default.inc.php';

        /**
         * _initiated
         * 
         * @access  protected
         * @var     bool (default: false)
         * @static
         */
        protected static $_initiated = false;

        /**
         * _blockIPAddresses
         * 
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _blockIPAddresses(): bool
        {
            $ip = IP ?? false;
            if ($ip === false) {
                return false;
            }
            $configData = static::_getConfigData();
            $addresses = $configData['ip']['addresses'];
            foreach ($addresses as $address) {
                if (strstr($ip, $address) !== false) {
                    exit(0);
                }
            }
            return false;
        }

        /**
         * _blockReferrers
         * 
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _blockReferrers(): bool
        {
            $httpReferrer = $_SERVER['HTTP_REFERER'] ?? null;
            if ($httpReferrer === null) {
                return false;
            }
            $configData = static::_getConfigData();
            $referrers = $configData['referrers'];
            foreach ($referrers as $referrer) {
                if (strstr($httpReferrer, $referrer) !== false) {
                    exit(0);
                }
            }
            return false;
        }

        /**
         * _blockUserAgents
         * 
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _blockUserAgents(): bool
        {
            $httpUserAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
            if ($httpUserAgent === null) {
                return false;
            }
            $configData = static::_getConfigData();
            $userAgents = $configData['userAgents'];
            foreach ($userAgents as $userAgent) {
                if (strstr($httpUserAgent, $userAgent) !== false) {
                    exit(0);
                }
            }
            return false;
        }

        /**
         * _checkDependencies
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _checkDependencies(): void
        {
            static::_checkConfigPluginDependency();
        }

        /**
         * init
         * 
         * @access  public
         * @static
         * @return  bool
         */
        public static function init(): bool
        {
            if (static::$_initiated === true) {
                return false;
            }
            parent::init();
            static::_blockIPAddresses();
            static::_blockReferrers();
            static::_blockUserAgents();
            return true;
        }
    }

    // Config path loading
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    \TurtlePHP\Plugin\Blocking::setConfigPath($configPath);
