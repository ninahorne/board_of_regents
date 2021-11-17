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
                "tags"
            ]
        ]);
        $index->clearObjects()->wait();

        $paged = 1;
        $count = 0;


        $posts_response = new WP_Query([
            'posts_per_page' => 1000,
            'paged' => $paged,
            'post_type' => 'faq',
            'orderby' => 'post_date',
            'order' => 'ASC'
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
            $post_date = $post->post_date;

            foreach ($post_metas as $meta) {

                $key = $meta->meta_key;
                $substring = substr($key, 0, 1);
                $record['objectID'] = $post->ID;
                $record['post_date'] = $post->post_date;

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
                    } else if ($key == 'tags') {
                        $value = [];
                        if (strpos($meta->meta_value, 'Credits')) {
                            array_push($value, 'Credits');
                        }
                        if (strpos($meta->meta_value, 'Benefits of DE')) {
                            array_push($value, 'Benefits of DE');
                        }
                        if (strpos($meta->meta_value, 'Dual Enrollment Basics')) {
                            array_push($value, 'Dual Enrollment Basics');
                        }
                        if (strpos($meta->meta_value, 'Eligibility')) {
                            array_push($value, 'Eligibility');
                        }
                        if (strpos($meta->meta_value, 'Applications')) {
                            array_push($value, 'Applications');
                        }
                        if (strpos($meta->meta_value, 'Grades/GPA')) {
                            array_push($value, 'Grades/GPA');
                        }
                        if (strpos($meta->meta_value, 'Cost')) {
                            array_push($value, 'Cost');
                        }
                        if (strpos($meta->meta_value, 'TOPS')) {
                            array_push($value, 'TOPS');
                        }
                        if (strpos($meta->meta_value, 'College Admissions')) {
                            array_push($value, 'College Admissions');
                        }

                        $record['tags'] = $value;
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
    public function index_generic_page_search($args, $assoc_args)
    {
        global $algolia;
        $index = $algolia->initIndex('generic-page-search');

        $index->clearObjects()->wait();

        $paged = 1;
        $count = 0;


        $fields_response = new WP_Query([
            'posts_per_page' => 1000,
            'paged' => $paged,
            'post_type' => 'course'
        ]);

        if (!$fields_response->have_posts()) {
            return;
        }

        $records = [];

        $fields = $fields_response->posts;

        foreach ($fields as $post) {
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

                $value = $meta->meta_value;

                if ($key == "career_cluster") {
                    $record['title'] = $value;
                }
                if ($key == 'details') {
                    $record['details'] = str_replace('&nbsp;', ' ', $value);;
                }
                if ($key == 'url-params') {
                    $record['url_params'] = './index.php/fields-of-study?field=' . $value;
                }
            }

            $index->saveObject($record);
            $count++;
        }

        $faqs_response = new WP_Query([
            'posts_per_page' => 1000,
            'paged' => $paged,
            'post_type' => 'faq'
        ]);

        if (!$fields_response->have_posts()) {
            return;
        }


        $faqs = $faqs_response->posts;

        foreach ($faqs as $post) {
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

                $value = $meta->meta_value;

                if ($key == "what_is_the_faq") {
                    $record['title'] = $value;
                    $record['url_params'] = './index.php/faqs?question=' . urlencode($value);
                }
                if ($key == 'what_is_the_answer') {
                    $record['details'] = str_replace('&nbsp;', ' ', $value);
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


        $college_links_response = new WP_Query([
            'posts_per_page' => 1000,
            'post_type' => 'college_link'
        ]);

        if (!$college_links_response->have_posts()) {
            WP_CLI::line("no college links");

            return;
        }


        $links = $college_links_response->posts;

        foreach ($links as $post) {
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

                $value = $meta->meta_value;

                if ($key == "campus") {
                    $record['title'] = $value;
                    $record['url_params'] = './index.php/contact?college=' . $value;
                }


                if ($key == 'notes') {
                    $record['details'] = $value;
                }
                
            }

            $index->saveObject($record);
            $count++;
        }

        WP_CLI::success("$count generic search fields indexed in Algolia");
    }
}

WP_CLI::add_command('algolia', 'Algolia_Command');
