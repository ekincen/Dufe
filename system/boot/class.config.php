<?php

/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */

class Config {

    protected $_config;

    public function run() {
        date_default_timezone_set('PRC');
        $this->_config = (object) parse_ini_file(SYS_PATH . DS . 'config.ini');
        $this->_setDbConfig();
        System_Globals :: set('config', $this->_config);
    }

    protected function _setDbConfig() {
        System_Db_Adapter :: setConfig(array(
            'mysql' => array(
                $this->_config->DB_HOST,
                $this->_config->DB_USER,
                $this->_config->DB_PWD,
                $this->_config->DB_NAME,
                $this->_config->DB_TBL_PREFIX
            ),
            'redis' => array(
                $this->_config->REDIS_HOST,
                $this->_config->REDIS_PORT
            ),
            'handlersocket' => array(
                $this->_config->DB_HOST,
                $this->_config->DB_NAME,
                $this->_config->DB_TBL_PREFIX,
                $this->_config->HS_PORT,
                $this->_config->HS_RPORT
            ),
            'sphinx' => array(
                $this->_config->SPHINX_HOST,
                $this->_config->SPHINX_PORT
            ),
            'amqp' => array(
                $this->_config->AMQP_HOST,
                $this->_config->AMQP_PORT,
                $this->_config->AMQP_USER,
                $this->_config->AMQP_PWD,
                $this->_config->AMQP_VHOST
            )
        ));
    }

}

?>