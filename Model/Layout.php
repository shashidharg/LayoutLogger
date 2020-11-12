<?php
namespace ShashidharG\LayoutLogger\Model;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Layout implements ObserverInterface
{
    protected $request;
    public function __construct(
        RequestInterface $request
        ) {
            $this->request = $request;
    }
    public function execute(Observer $observer)
    {
        $layoutsDir = BP . '/var/log/layouts/';
        if (!file_exists($layoutsDir) && !mkdir($layoutsDir, 0777, true) && !is_dir($layoutsDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $layoutsDir));
        }
        $moduleName = $this->request->getModuleName();
        $controller = $this->request->getControllerName();
        $action = $this->request->getActionName();
        $time = date('Y-m-d H:i:s');
        $xml = $observer->getEvent()->getLayout()->getXmlString();
        $fileName = $moduleName . '_' . $controller . '_' . $action . ' ' . $time . '.xml';
//         $fopen = fopen($layoutsDir . $fileName, 'ab+');
//         fwrite($fopen, $xml . PHP_EOL);
//         fclose($fopen);
        return $this;
    }
}