<?php

add_action("rest_api_init", function () {

  register_rest_route(
        "abacies/v1"
      , "/pages/(?P<id>\d+)/contentElementor"
      , [
          "methods" => "GET",
          "callback" => function (\WP_REST_Request $req) {

              $contentElementor = "";

              if (class_exists("\\Elementor\\Plugin")) {
                  $post_ID = $req->get_param("id");

                  $pluginElementor = \Elementor\Plugin::instance();
                  $contentElementor = $pluginElementor->frontend->get_builder_content_for_display($post_ID);
              }


              return $contentElementor;

          },
      ]
  );


});