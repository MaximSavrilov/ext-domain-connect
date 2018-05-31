<?php
// Copyright 1999-2018. Plesk International GmbH.

class Modules_DomainConnect_ConfigDefaults extends pm_Hook_ConfigDefaults
{
    public function getDefaults()
    {
        return [
            'serviceProvider' => false,
            'dnsProvider' => true,
            'newDomainsOnly' => true,
            'providerId' => 'plesk.com',
            'providerName' => 'Plesk',
            'webServiceId' => 'web',
        ];
    }
}
