<?php


namespace Themes\labo\src\Repository;

class TermsRepository
{

    /**
     * Récupère la liste de tous les terms du site par type ('post_tag', 'category' ou 'nav_menu' )
     * @param string $type
     * @return array|object|null
     */
    public static function getAllTagsByType(string $type): ?array
    {
        global $wpdb;
        $query = "
			SELECT name, slug
			FROM $wpdb->terms AS tags
		    INNER JOIN $wpdb->term_taxonomy AS tt
		        ON tags.term_id=tt.term_id
			WHERE tt.taxonomy='$type'";

        return $wpdb->get_results($query, ARRAY_A);
    }
}
