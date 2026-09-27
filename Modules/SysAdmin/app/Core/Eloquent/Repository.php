<?php

namespace Modules\SysAdmin\Core\Eloquent;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\SysAdmin\Core\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected Model $modelInstance;

    /** @deprecated Prefer getModel(); retained for existing repositories. */
    protected Model $model;

    protected ?Builder $queryBuilder = null;

    abstract public function model();

    public function __construct()
    {
        $model = app($this->model());

        if (! $model instanceof Model) {
            throw new InvalidArgumentException('Repository model must be an Eloquent model.');
        }

        $this->modelInstance = $model;
        $this->model = $model;

        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    public function getModel(): Model
    {
        return $this->modelInstance;
    }

    public function resetModel(): static
    {
        $this->queryBuilder = null;

        return $this;
    }

    public function pushCriteria(mixed $criteria): static
    {
        return $this;
    }

    public function scopeQuery(Closure $scope): static
    {
        $query = $scope($this->query());
        $this->queryBuilder = $query instanceof Builder ? $query : $this->query();

        return $this;
    }

    public function with(array|string $relations): static
    {
        $this->queryBuilder = $this->query()->with($relations);

        return $this;
    }

    public function all(array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->get($columns));
    }

    public function get(array $columns = ['*'])
    {
        return $this->all($columns);
    }

    public function first(array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->first($columns));
    }

    public function paginate(int $perPage = 15, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->paginate($perPage, $columns));
    }

    public function find(int|string $id, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->find($id, $columns));
    }

    public function findOrFail(int|string $id, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->findOrFail($id, $columns));
    }

    public function findWhere(array $where, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $this->applyWhere($query, $where)->get($columns));
    }

    public function findOneWhere(array $where, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $this->applyWhere($query, $where)->first($columns));
    }

    public function findByField(string $field, mixed $value = null, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->where($field, $value)->get($columns));
    }

    public function findOneByField(string $field, mixed $value = null, array $columns = ['*'])
    {
        return $this->consume(fn (Builder $query) => $query->where($field, $value)->first($columns));
    }

    public function create(array $attributes)
    {
        return $this->modelInstance->newQuery()->create($attributes);
    }

    public function update(array $attributes, int|string $id)
    {
        $model = $this->modelInstance->newQuery()->findOrFail($id);
        $model->update($attributes);

        return $model->refresh();
    }

    public function delete(int|string $id): bool
    {
        return (bool) $this->modelInstance->newQuery()->findOrFail($id)->delete();
    }

    public function deleteWhere(array $where): int
    {
        return $this->applyWhere($this->modelInstance->newQuery(), $where)->delete();
    }

    public function count(array $where = [], string $column = '*'): int
    {
        return $this->consume(fn (Builder $query) => $this->applyWhere($query, $where)->count($column));
    }

    public function sum(string $column): int|float
    {
        return $this->consume(fn (Builder $query) => $query->sum($column));
    }

    public function avg(string $column): int|float|null
    {
        return $this->consume(fn (Builder $query) => $query->avg($column));
    }

    public function select(array|string ...$columns): Builder
    {
        $columns = count($columns) === 1 && is_array($columns[0]) ? $columns[0] : $columns;

        return $this->query()->select($columns);
    }

    public function where(...$arguments): Builder
    {
        return $this->query()->where(...$arguments);
    }

    public function __call(string $method, array $arguments): mixed
    {
        return $this->query()->{$method}(...$arguments);
    }

    protected function query(): Builder
    {
        return $this->queryBuilder ??= $this->modelInstance->newQuery();
    }

    protected function consume(Closure $callback): mixed
    {
        try {
            return $callback($this->query());
        } finally {
            $this->resetModel();
        }
    }

    protected function applyWhere(Builder $query, array $where): Builder
    {
        foreach ($where as $field => $value) {
            is_int($field) && is_array($value)
                ? $query->where(...$value)
                : $query->where($field, $value);
        }

        return $query;
    }
}
