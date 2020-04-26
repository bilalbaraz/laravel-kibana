<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;

/**
 * Class KibanaRole
 * @package Bilalbaraz\LaravelKibana\Client
 */
class KibanaRole extends KibanaClient
{
    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_ROLES);

        return $this->toArray($roles);
    }

    /**
     * @param string $roleName
     * @return array
     */
    public function getRole(string $roleName): array
    {
        $role = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_ROLES . '/' . $roleName);

        return $this->toArray($role);
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function createRole(string $roleName): bool
    {
        $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_ROLES . '/' . $roleName, 'PUT');

        return true;
    }

    /**
     * @param string $roleName
     * @param array $privileges
     * @return bool
     */
    public function updateRole(string $roleName, $privileges = []): bool
    {
        $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_ROLES . '/' . $roleName,
            'PUT',
            $privileges,
            true
        );

        return true;
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function deleteRole(string $roleName): bool
    {
        $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_ROLES . '/' . $roleName, 'DELETE');

        return true;
    }
}
