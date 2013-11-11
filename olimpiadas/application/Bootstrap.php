<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


	//equivalente a session start
    protected function _initSession()
    {
       Zend_Session::start();
    }

	//cargamos configuración de application.ini
	protected function _initConfig() 
	{
		Zend_Registry::set('config', $this->getOptions());
	}



}

