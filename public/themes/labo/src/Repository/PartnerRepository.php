<?php


namespace Themes\labo\src\Repository;

use Timber\PostQuery;

class PartnerRepository
{

    public static function lastAll(): PostQuery
    {
        return new PostQuery([
            'post_type'     => 'partners',
            'post_status'   => 'publish',
            'orderby'       => 'partner_weight',
            'order'         => 'DESC'
        ]);
    }

    public static function orderByWeight(int $quantity = 4): PostQuery
    {
        return new PostQuery([
            'posts_per_page' => $quantity,
            'post_type'     => 'partners',
            'post_status'   => 'publish',
            'order'         => 'ASC',
            'orderby'       => 'meta_value',
            'meta_key'      => 'partner_weight'
        ]);
    }
}
