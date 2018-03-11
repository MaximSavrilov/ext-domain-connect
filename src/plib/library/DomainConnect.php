<?php
// Copyright 1999-2018. Plesk International GmbH. All rights reserved.
namespace PleskExt\DomainConnect;

class DomainConnect
{
    private $domain;
    private $urlPrefix;
    private $data;

    public function __construct(\pm_Domain $domain)
    {
        $this->domain = $domain;
        $this->urlPrefix = Dns::txtRecord("_domainconnect.{$this->domain->getName()}");
    }

    private function getData()
    {
        if (null === $this->data) {
            $client = new \Zend_Http_Client("https://{$this->urlPrefix}/v2/{$this->domain->getName()}/settings");
            $response = $client->request(\Zend_Http_Client::GET);
            $this->data = \json_decode($response->getBody());
        }
        return $this->data;
    }

    public function getSyncUx()
    {
        return $this->getData()->urlSyncUX;
    }

    public function getApplyTemplateUrl($serviceId, array $properties)
    {
        $providerId = \pm_Config::get('providerId');
        $properties = array_merge([
            'domain' => $this->domain->getName(),
            'providerName' => "Plesk",
        ], $properties);
        $properties = \http_build_query($properties);
        return "{$this->getSyncUx()}/v2/domainTemplates/providers/{$providerId}/services/{$serviceId}/apply?{$properties}";
    }

    public function enable()
    {
        $this->domain->setSetting('enabled', true);
    }

    public function disable()
    {
        $this->domain->setSetting('enabled', false);
    }

    public function isEnabled()
    {
        return $this->domain->getSetting('enabled', false);
    }
}
