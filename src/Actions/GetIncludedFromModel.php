<?php

namespace DevMurean\EloquentJsonApiSpec\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GetIncludedFromModel
{
    private Collection $included;

    public static function execute(Model $model): array
    {
        $o = new self;
        $o->included = new Collection;

        $o->crawl($model);

        return $o->result();
    }

    /**
     * Make sure each of included item is unique and sorted by type
     */
    private function result(): array
    {
        return $this->included
            ->unique(function (array $item) {
                return $item['type'] . $item['id'];
            })
            ->sortBy('type')
            ->values()
            ->all();
    }

    private function crawl(Model $model): void
    {
        /** @var array<Model|Collection> $relations */
        $relations = $model->getRelations();
        foreach ($relations as $related) {
            if ($related instanceof Model) {
                $this->build($related);
                // recrawl when deeper relationships found
                $this->crawl($related);
            }
            if ($related instanceof Collection) {
                $related->each(function (Model $item) {
                    $this->build($item);
                    $this->crawl($item);
                });
            }
        }
    }

    private function build(Model $related): void
    {
        $data = GetDataFromModel::execute($related);
        $relationships = GetRelationshipFromModel::execute($related);

        $this->included->push(
            array_merge($data, ['relationships' => $relationships])
        );
    }
}
