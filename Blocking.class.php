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
                    $method = 'ipAddresses';
                    static::_handleBlock($method, $ip, $address);
                }
            }
            return false;
        }

        /**
         * _blockPaths
         * 
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _blockPaths(): bool
        {
            $requestURI = static::_getRequestURI() ?? null;
            if ($requestURI === null) {
                return false;
            }
            $configData = static::_getConfigData();
            $patterns = $configData['pathPatterns'];
            foreach ($patterns as $pattern) {
                $pattern = static::_getBlockingPathPattern($pattern);
                if (preg_match($pattern, $requestURI) === 1) {
                    $method = 'paths';
                    static::_handleBlock($method, $requestURI, $pattern);
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
                    $method = 'referrers';
                    static::_handleBlock($method, $httpReferrer, $referrer);
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
                    $method = 'userAgents';
                    static::_handleBlock($method, $httpUserAgent, $userAgent);
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
         * _getBlockingPathPattern
         * 
         * @access  protected
         * @static
         * @param   string $pathPattern
         * @return  string
         */
        protected static function _getBlockingPathPattern(string $pathPattern): string
        {
            $pathPattern = str_replace('/', '\/', $pathPattern);
            $pattern = '/' . ($pathPattern) . '/';
            $pattern .= 'i';
            return $pattern;
        }

        /**
         * _getRequestURI
         * 
         * @access  protected
         * @static
         * @return  null|string
         */
        protected static function _getRequestURI(): ?string
        {
            $path = $_SERVER['REQUEST_URI'] ?? null;
            return $path;
        }

        /**
         * _handleBlock
         * 
         * @access  protected
         * @static
         * @param   string $method
         * @param   string $value
         * @param   string $match
         * @return  void
         */
        protected static function _handleBlock(string $method, string $value, string $match): void
        {
            $configData = static::_getConfigData();
            $callback = $configData['callback'];
            $args = array($method, $value, $match);
            call_user_func_array($callback, $args);
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
            static::_blockPaths();
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
