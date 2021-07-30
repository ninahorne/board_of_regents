<?php

if (!(defined('WP_CLI') && WP_CLI)) {
    return;
}

class Algolia_Command
{
    public function index_useful_college_links($args, $assoc_args)
    {
        global $algolia;
        $index = $algolia->initIndex('useful-college-links');

        $index->clearObjects()->wait();

        $paged = 1;
        $count = 0;


        $posts_response = new WP_Query([
            'posts_per_page' => 1000,
            'paged' => $paged,
            'post_type' => 'college_link'
        ]);

        if (!$posts_response->have_posts()) {
            return;
        }

        $records = [];
     
        $posts = $posts_response->posts;

        foreach ($posts as $post) {
            global $wpdb;

            $querystr = "
                    SELECT *
                    FROM $wpdb->postmeta 
                    WHERE post_id LIKE $post->ID 
                ";
            $post_metas = $wpdb->get_results($querystr, OBJECT);


            foreach ($post_metas as $meta) {

                $key = $meta->meta_key;
                $substring = substr($key, 0, 1);
                $record['objectID'] = implode('#', [$post->post_type, $post->ID]);

                if ($substring != "_") {
                    if ($assoc_args['verbose']) {

                        WP_CLI::line('writing ' . $key . '=' . $meta->meta_value . ' for ' . $post->ID);
                    }
                    $record[$meta->meta_key] = $meta->meta_value;
                }
            }

            $index->saveObject($record);
        }

        if ($assoc_args['verbose']) {
            WP_CLI::line('Sending batch');
        }
        if ($assoc_args['verbose']) {
            WP_CLI::line('record length [' . count($records) . ']');
        }
        $index->saveObjects($records);

        $paged++;


        WP_CLI::success("$count college links indexed in Algolia");
    }
}

WP_CLI::add_command('algolia', 'Algolia_Command');
