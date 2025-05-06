<?php

namespace People\View\Composers;
use Roots\Acorn\View\Composer;
use WP_Query;

class People extends Composer
{
    use PostsTrait;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.builder.people',
    ];

    public function with()
    {
        $this->fetchPerson();
        return [
            'teams' => $this->getGroups(),
            'peoples' => $this->peoples,
            'query' => $this->query, // Need to pass the query to the template for the pagination
        ];
    }

    public function getGroups()
    {
        $groups = get_categories([
            'taxonomy' => 'group',
            'hide_empty' => false,
        ]);

        return $groups;
    }

    private function fetchPerson()
    {
        global $post;

        $args = array(
            'post_type'=> 'person',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'paged' => get_query_var('paged') ?: 1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );

        $this->query = new WP_Query($args);
        if ($this->query->have_posts()) {
            while ($this->query->have_posts()) {
                $this->query->the_post();
                $fields['ID'] = get_the_ID();
                $fields['slug'] = $post->post_name;
                $fields['title'] = get_the_title();
                $fields['position'] = get_field('position');
                $fields['descriptions'] = get_field('descriptions');
                $fields['photo'] = get_field('photo');
                $fields['teams'] = implode(' ', wp_get_post_terms($post->ID, 'group', array('fields' => 'slugs')));
                $this->peoples[] = $fields;
            }
            wp_reset_postdata();
        }
    }

    /**
     * Allows you to get variables that would already be present in the partial
     * @todo-wp_template Migrate this method to a parent class
     * @param $key
     * @return mixed
     */
    public function getPartialData($key)
    {
        return $this->view->getData()[$key];
    }
}