<div class="container">
    <div class="faq-preview__wrapper background__orange-gradient">
        <p class="faq-preview__small-header">
            How else can we help?
        </p>
        <h1>Frequently Asked Questions</h1>
        <?php
        global $wpdb;

        $pagename = get_query_var('pagename');


        $result = $wpdb->get_results("
            SELECT * 
            FROM  $wpdb->posts
                WHERE post_type = 'faq'
        
        ");
        $first_three_student_faqs = [];

        function get_object_from_meta_rows($array, $id)
        {
            $newObj = new stdClass();

            foreach ($array as $item) {
                $item_id = $item->post_id;
                if ($id === $item_id) {
                    $key = $item->meta_key;
                    $value = $item->meta_value;
                        $newObj->ID = $id;

                    if ($key == 'what_is_the_faq') {
                        $newObj->question = $value;
                    }

                    if ($key == 'what_is_the_answer') {
                        $formattedString = $value;
                        $formattedString = str_replace('&nbsp;', '<br /><br />', $formattedString);
                        $newObj->answer = $formattedString;
                    } 

                    if($key == 'Details'){
                        $formattedString = $value;
                        $newObj->details = $value;
                    }
                }
            }
            return $newObj;
        }
        $count = 0;
        foreach ($result as $faq) {
            $faq_id = $faq->ID;

            $faq_result = $wpdb->get_results("
            SELECT * 
            FROM  $wpdb->postmeta
                WHERE post_id = $faq_id             
            ");
            foreach ($faq_result as $faq_item) {
                $key = $faq_item->meta_key;
                $value = $faq_item->meta_value;
                $id = $faq_item->post_id;

                // TODO make sure there are no repeats here

                if (count($first_three_student_faqs) < 4) {
                    $obj = get_object_from_meta_rows($faq_result, $id);
                    $objectExists = array_filter(
                        $first_three_student_faqs,
                        function ($e) use (&$obj) {
                            return $e->ID == $obj->ID;
                        }
                    );
                    if ($obj->details == 1 && !$objectExists) {
                        $count++;
                        $obj->count = $count;
                        array_push($first_three_student_faqs, $obj);
                    }
                }
            }
        }

        foreach ($first_three_student_faqs as $faq) {
            echo "<div class='faq-preview__faq'>
                    <h3 onclick='toggleFaq(\"FAQ-" . strval($faq->count) . "\")' class='faq-preview__question'>" . $faq->question . "</h3> 
                    <div id='FAQ-" . strval($faq->count) . "' class='faq-preview__answer'>
                        <p>" . $faq->answer . "</p>
                    </div>
                    
                </div>";
        }


        ?>
        <a href="./faqs" class="btn faq-preview__view-all"><i class="fas fa-share"></i>&nbsp;&nbsp;View all FAQs</a>

    </div>
</div>

<script>
    function toggleFaq(id) {
        const section = document.getElementById(id);
        section.classList.toggle('faq-preview__answer--open');
    }
</script>