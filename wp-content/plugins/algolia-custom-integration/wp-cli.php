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
                $record['objectID'] = $post->ID;

                if ($substring != "_") {
                    if ($assoc_args['verbose']) {

                        WP_CLI::line('writing ' . $key . '=' . $meta->meta_value . ' for ' . $post->ID);
                    }
                    $record[$meta->meta_key] = $meta->meta_value;
                }
            }

            $index->saveObject($record);
            $count++;
        }

        if ($assoc_args['verbose']) {
            WP_CLI::line('Sending batch');
        }
        if ($assoc_args['verbose']) {
            WP_CLI::line('record length [' . count($records) . ']');
        }

        $paged++;


        WP_CLI::success("$count college links indexed in Algolia");
    }

    public function index_faqs($args, $assoc_args)
    {
        global $algolia;
        $index = $algolia->initIndex('faqs');
        $index->setSettings([
            'attributesForFaceting' => [
                "categories"
            ]
        ]);
        $index->clearObjects()->wait();

        $paged = 1;
        $count = 0;


        $posts_response = new WP_Query([
            'posts_per_page' => 1000,
            'paged' => $paged,
            'post_type' => 'faq'
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
                $record['objectID'] = $post->ID;

                if ($substring != "_") {
                    if ($assoc_args['verbose']) {

                        WP_CLI::line('writing ' . $key . '=' . $meta->meta_value . ' for ' . $post->ID);
                    }
                    if ($meta->meta_key == 'who_is_the_faq_for') {
                        $value = [];
                        if (strpos($meta->meta_value, 'Students')) {
                            array_push($value, 'Students');
                        }
                        if (strpos($meta->meta_value, 'Families')) {
                            array_push($value, 'Families');
                        }
                        if (strpos($meta->meta_value, 'Counselors')) {
                            array_push($value, 'Counselors');
                        }

                        $record['categories'] = $value;
                    } else {
                        $record[$meta->meta_key] = $meta->meta_value;
                    }
                }
            }

            $index->saveObject($record);
            $count++;
        }

        if ($assoc_args['verbose']) {
            WP_CLI::line('Sending batch');
        }
        if ($assoc_args['verbose']) {
            WP_CLI::line('record length [' . count($records) . ']');
        }
        $index->saveObjects($records);

        $paged++;


        WP_CLI::success("$count FAQs indexed in Algolia");
    }

    public function index_fields_of_study($args, $assoc_args)
    {
        global $algolia;
        $index = $algolia->initIndex('fields-of-study');

        $index->clearObjects()->wait();

        $paged = 1;
        $count = 0;


        $posts_response = new WP_Query([
            'posts_per_page' => 1000,
            'paged' => $paged,
            'post_type' => 'course'
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
                $record['objectID'] = $post->ID;

                if ($substring != "_") {
                    if ($assoc_args['verbose']) {

                        WP_CLI::line('writing ' . $key . '=' . $meta->meta_value . ' for ' . $post->ID);
                    }

                    $record[$meta->meta_key] = $meta->meta_value;
                }
            }

            $index->saveObject($record);
            $count++;
        }

        if ($assoc_args['verbose']) {
            WP_CLI::line('Sending batch');
        }
        if ($assoc_args['verbose']) {
            WP_CLI::line('record length [' . count($records) . ']');
        }

        $paged++;


        WP_CLI::success("$count fields of study indexed in Algolia");
    }
}

WP_CLI::add_command('algolia', 'Algolia_Command');
