<?php

class MM_Ignition_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard {

    const IGNITION_CONFIG_PATH = '_ignition/update-config';

    /**
     * Initialize Controller Router
     *
     * @param Varien_Event_Observer $observer
     */
    public function initControllerRouters(Varien_Event_Observer $observer)
    {
        $front = $observer->getEvent()->getFront();
        $front->addRouter('_ignition', $this);
    }

    /**
    * Match the request in the form "_ignition/update-config", skip store code prefix
    *
    * @param Mage_Core_Controller_Request_Http $request
    * @inheritDoc
    */
   public function match(Zend_Controller_Request_Http $request)
   {
        /** @var MM_Ignition_Helper_Data $_helper */
        $_helper = Mage::helper('mm_ignition');
        if (!$_helper->shouldPrintIgnition()) {
            return false;
        }

        $requestPathInfo = trim($request->getPathInfo(), '/');
        if ($requestPathInfo == self::IGNITION_CONFIG_PATH && $request->isPost()) {
            $module = 'mm_ignition';
            $controller = 'config';
            $action = 'update';
            $realModule = 'MM_Ignition';

            $request->setModuleName($module);
            $request->setControllerName($controller);
            $request->setActionName($action);
            $request->setControllerModule($realModule);
            
            // set params from JSON body
            $rawBody = $request->getRawBody();
            $jsonData = json_decode($rawBody, true);
            if ($jsonData == null) {
                return false;
            }
            $request->setParams($jsonData);

            $controllerClassName = $this->_validateControllerClassName($realModule, $controller);
            if (!$controllerClassName) {
                return false;
            }

            // instantiate controller class
            $controllerInstance = Mage::getControllerInstance($controllerClassName, $request, $this->getFront()->getResponse());

            if (!$this->_validateControllerInstance($controllerInstance)) {
                return false;
            }

            if (!$controllerInstance->hasAction($action)) {
                return false;
            }
            
            // dispatch action
            $request->setDispatched(true);
            $controllerInstance->dispatch($action);

            return true;
        }
        
        return false;
   }


}