<?php

namespace Modules\SysAdmin\Core\Contracts;

interface RepositoryInterface
{
    public function all(array $columns = ['*']);

    public function find(int|string $id, array $columns = ['*']);

    public function findOrFail(int|string $id, array $columns = ['*']);

    public function create(array $attributes);

    public function update(array $attributes, int|string $id);

    public function delete(int|string $id): bool;
}
