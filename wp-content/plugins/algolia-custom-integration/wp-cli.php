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

        do {
            $posts = new WP_Query([
                'posts_per_page' => 100,
                'paged' => $paged,
                'post_type' => 'college_link'
            ]);

            if (!$posts->have_posts()) {
                break;
            }

            $records = [];

            foreach ($posts->posts as $post) {
                if ($assoc_args['verbose']) {
                    WP_CLI::line('Serializing [' . $post->post_title . ']');
                }
                $record = (array) apply_filters('post_to_record', $post);

                if (!isset($record['objectID'])) {
                    $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
                }

                $records[] = $record;
                $count++;
            }

            if ($assoc_args['verbose']) {
                WP_CLI::line('Sending batch');
            }

            $index->saveObjects($records);

            $paged++;
        } while (true);

        WP_CLI::success("$count posts indexed in Algolia");
    }
}

WP_CLI::add_command('algolia', 'Algolia_Command');
