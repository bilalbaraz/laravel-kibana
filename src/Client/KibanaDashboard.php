<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;

/**
 * Class KibanaDashboard
 * @package Bilalbaraz\LaravelKibana\Client
 */
class KibanaDashboard extends KibanaClient
{
    /**
     * @param string $dashboardId
     * @return array
     */
    public function exportDashboard(string $dashboardId): array
    {
        $dashboard = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::EXPORT_DASHBOARD . '?dashboard=' . $dashboardId);

        return $this->toArray($dashboard);
    }

    /**
     * @param array $body
     * @return array
     */
    public function importDashboard(array $body = []): array
    {
        $dashboard = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::IMPORT_DASHBOARD,
            'POST',
            $body,
            true
        );

        return $this->toArray($dashboard);
    }
}
