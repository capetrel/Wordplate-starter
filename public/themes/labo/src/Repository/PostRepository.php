<?php


namespace Themes\labo\src\Repository;

use Timber\PostQuery;

class PostRepository
{

    public static function getPage(string $name)
    {
        return new PostQuery([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'pagename'       => $name,
        ]);
    }

    public static function lastAllOneCategory(string $categorySlug, int $quantity = 4): PostQuery
    {
        return new PostQuery([
            'post_type'      => 'post',
            'posts_per_page' => $quantity,
            'post_status'    => 'publish',
            'category_name'  => $categorySlug,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ]);
    }

    public static function paginatedPostInCategoryWithTag(int $paged, string $categorySlug, int $quantity = 4, string $tags = null, array $dates = null): PostQuery
    {
        if ($tags === 'all') {
            $tags = null;
        }
        $query =  [
            'post_type'      => 'post',
            'posts_per_page' => $quantity,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'category_name'  => $categorySlug,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ];
        if (!is_null($dates) && $dates[0] !== 'undefined') {
            $meta_query = [
                'date_query' => [
                    [
                        'after' => $dates[0],
                        'before' => $dates[1],
                        'inclusive' => 'false',
                    ]
                ]
            ];
            $query = array_merge($query, $meta_query);
        }

        if (!is_null($tags)) {
            if (is_array($tags)) {
                $relation = [
                    'tag_slug__in' => $tags
                ];
            } else {
                $relation = [
                    'tag' => $tags
                ];
            }
            return new PostQuery(array_merge($query, $relation));
        } else {
            return new PostQuery($query);
        }
    }

    public static function lastRelatedByCategory(string $categorySlug, int $quantity = 4): PostQuery
    {
        return new PostQuery([
            'post_type'      => 'post',
            'posts_per_page' => $quantity,
            'post_status'    => 'publish',
            'category_name'  => $categorySlug,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ]);
    }

    /**
     * @param array|string $tags
     * @param int $quantity
     *
     * @return PostQuery
     */
    public static function lastRelatedByTags($tags, $quantity = 4): PostQuery
    {
        $query = [
            'post_type'      => 'post',
            'posts_per_page' => $quantity,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        if (is_array($tags)) {
            $relation = [
                'tag_slug__in' => $tags
            ];
        } else {
            $relation = [
                'tag' => $tags
            ];
        }
        return new PostQuery(array_merge($query, $relation));
    }

    /**
     * Récupère des articles filtrés
     *
     * @param int $paged nombre d'articles par page
     * @param string $categorySlug slug de la categorie de l'article
     * @param string $by type de filtre, date, titre...
     * @param string $order ordre alphabetique ou inverse
     * @param int $perPage articles par page
     *
     * @return PostQuery
     */
    public static function getFilteredPosts(int $paged, string $categorySlug, string $by = 'date', string $order = 'ASC', int $perPage = 4): PostQuery
    {
        return new PostQuery([
            'post_type'      => 'post',
            'posts_per_page' => $perPage,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'category_name'  => $categorySlug,
            'orderby'        => $by,
            'order'          => $order
        ]);
    }
}
