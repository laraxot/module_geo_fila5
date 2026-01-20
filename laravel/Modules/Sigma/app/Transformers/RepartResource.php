<?php

declare(strict_types=1);

namespace Modules\Sigma\Transformers;

/*
 * https://medium.com/@dinotedesco/using-laravel-5-5-resources-to-create-your-own-json-api-formatted-api-2c6af5e4d0e8
 * https://jsonapi.org/
 **/
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use JsonSerializable;

class RepartResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    #[\Override]
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        /*
         * return [
         * 'type'          => $this->post_type,
         * 'id'            => (string)$this->id,
         * 'attributes'    => $attributes,
         * 'links'         => [
         * //'self' => route('articles.show', ['article' => $this->id]),
         * ],
         * ];
         */
        return parent::toArray($request);
    }
}
