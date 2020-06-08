<?php

    // namespace
    namespace Plugin;

    // dependency check
    if (class_exists('\\Plugin\\Config') === false) {
        throw new \Exception(
            '*Config* class required. Please see ' .
            'https://github.com/onassar/TurtlePHP-ConfigPlugin'
        );
    }

    /**
     * Blocking
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Blocking
    {
        /**
         * _configPath
         *
         * @access  protected
         * @var     string
         * @static
         */
        protected static $_configPath = 'config.default.inc.php';

        /**
         * _initiated
         *
         * @access  protected
         * @var     bool
         * @static
         */
        protected static $_initiated = false;

        /**
         * _blockIPAddresses
         * 
         * @access  protected
         * @static
         * @param   array $addresses
         * @return  void
         */
        protected static function _blockIPAddresses(array $addresses)
        {
            foreach ($addresses as $address) {
                if (strstr(IP, $address) !== false) {
                    exit(0);
                }
            }
        }

        /**
         * _blockReferrers
         * 
         * @access  protected
         * @static
         * @param   array $referrers
         * @return  void
         */
        protected static function _blockReferrers(array $referrers)
        {
            if (isset($_SERVER['HTTP_REFERER']) === true) {
                foreach ($referrers as $referrer) {
                    if (strstr($_SERVER['HTTP_REFERER'], $referrer) !== false) {
                        exit(0);
                    }
                }
            }
        }

        /**
         * _blockUserAgents
         * 
         * @access  protected
         * @static
         * @param   array $userAgents
         * @return  void
         */
        protected static function _blockUserAgents(array $userAgents)
        {
            if (isset($_SERVER['HTTP_USER_AGENT']) === true) {
                foreach ($userAgents as $userAgent) {
                    if (strstr($_SERVER['HTTP_USER_AGENT'], $userAgent) !== false) {
                        exit(0);
                    }
                }
            }
        }

        /**
         * init
         * 
         * @access  public
         * @static
         * @return  void
         */
        public static function init()
        {
            if (self::$_initiated === false) {
                self::$_initiated = true;
                require_once self::$_configPath;
                $config = \Plugin\Config::retrieve('TurtlePHP-BlockingPlugin');
                self::_blockIPAddresses($config['ip']['addresses']);
                self::_blockReferrers($config['referrers']);
                self::_blockUserAgents($config['userAgents']);
            }
        }

        /**
         * setConfigPath
         * 
         * @access  public
         * @param   string $path
         * @return  void
         */
        public static function setConfigPath($path)
        {
            self::$_configPath = $path;
        }
    }

    // Config
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    if (is_file($configPath) === true) {
        Blocking::setConfigPath($configPath);
    }
