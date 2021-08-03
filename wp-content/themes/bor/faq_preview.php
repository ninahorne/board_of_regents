<div class="container">
    <div class="faq-preview__wrapper background__orange-gradient">
        <p class="faq-preview__small-header">
            How else can we help?
        </p>
        <h1>Frequently Asked Questions</h1>
        <?php
        global $wpdb;

        $pagename = get_query_var('pagename');
        // echo $pagename;


        $result = $wpdb->get_results("
            SELECT * 
            FROM  $wpdb->posts
                WHERE post_type = 'faq'
        
        ");
        $first_three_student_faqs = [];

        function get_object_from_meta_rows($array, $id)
        {
            $newObj = new stdClass();

            foreach($array as $item) {
                $id = $item->post_id;
                if($id === $id) {
                    $key = $item->meta_key;
                    $value = $item->meta_value;
                  
                    if($key == 'what_is_the_faq') {
                        $newObj->question = $value;
                    }

                    if($key == 'what_is_the_answer') {
                        $formattedString = $value;
                        while(strpos($formattedString, '&nbsp;')) {
                            $formattedString = str_replace('&nbsp;', '<br /><br />', $formattedString);
                        }
                        $newObj->answer = $formattedString;
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
                $id= $faq_item->post_id;
                
      
                if (count($first_three_student_faqs) < 4) {
                    if ($key == 'who_is_the_faq_for' && strpos(strtolower($value), $pagename)) {
                        $obj = get_object_from_meta_rows($faq_result, $id);
                        $count++;
                        $obj->count=$count;
                        
                        array_push($first_three_student_faqs,$obj);
                    }
                }
            }
        }

        // echo count($first_three_student_faqs);
        foreach ($first_three_student_faqs as $faq) {
            echo '<div class="faq-preview__faq">
                    <h3 onclick="toggleFaq(\'FAQ-'.strval($faq->count).'\')" class="faq-preview__question">' . $faq->question . '</h3> 
                    <div id="FAQ-'.strval($faq->count).'" class="faq-preview__answer">
                        <p  innerHTML="' . $faq->answer . '"</p>
                    </div>
                    
                </div>';
        }

        
        ?>
        <a href="./faqs" class="btn faq-preview__view-all"><i class="fas fa-share"></i>&nbsp;&nbsp;View all FAQs</a>
        <div class="row">
            <div class="col-md-6">
                <div class="flex-vertical-center">
                    <h1 class="text-left mb-2">Ask a Question</h1>
                    <p class="arvo-regular mb-1">Board of Regents</p>
                    <p class="arvo-regular subtitle mb-2">Dual enrollment questions related to the postsecondary institution.</p>
                    <p class="rubik-medium color__dark-blue mb-1"><a class="unformatted" href="mailto:dualenrollment@laregents.edu">dualenrollment@laregents.edu</a></p>
                    <p class="rubik-medium color__dark-blue mb-3"><a href="tel:2253424253" class="unformatted">225.342.4253</a></p>
                    <div class="dotted-line__dark-gray mb-3"></div>
                    <p class="arvo-regular mb-1">Department of Education</p>
                    <p class="arvo-regular subtitle mb-2">Dual enrollment questions related to the high school or school district.</p>
                    <p class="rubik-medium color__dark-blue mb-1"><a class="unformatted" href="mailto:highschoolacademics@la.gov">highschoolacademics@la.gov</a></p>
                    <p class="rubik-medium color__dark-blue mb-2"><a href="tel:8774532742" class="unformatted">877.453.2742</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="background__orange-brush-stroke background__brush-stroke--large">
                    <img class="m-1 " src="<?php echo get_template_directory_uri(); ?>/images/contact.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFaq(id) {
        const section = document.getElementById(id);
        section.classList.toggle('faq-preview__answer--open');
    }
</script>