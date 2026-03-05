<?php

namespace App\Repositories\Contracts;

interface PersonaRepositoryInterface
{
    public function getPersonasPaginated($perPage = 10);
}