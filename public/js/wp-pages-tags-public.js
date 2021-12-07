(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  let timeout;
  $("document").ready(function () {
    tags_add_remove();
    initials_tags();
  });

  function initials_tags() {
    var $input = $("input[name=tags]")
      .tagify({
        whitelist: [{ id: 1, value: "some string" }],
      })
      .on("add", function (e, tagName) {
        // console.log("JQEURY EVENT: ", "added", tagName);
      })
      .on("invalid", function (e, tagName) {
        // console.log("JQEURY EVENT: ", "invalid", e, " ", tagName);
      });

    // get the Tagify instance assigned for this jQuery input object
    // so its methods could be accessed
    var jqTagify = $input.data("tagify");
  }

  function tags_add_remove() {
    if ($("#wp-post-tags-id").length) {
      $("#wp-post-tags-id .tags-area").on("change", function () {
        console.log($(this).val());
        let data = $(this).val();
        let title = $(this).data("title");
        let secret = $("input[name=wppt_secret_key]").val();
        let page_id = $("input[name=page_id]").val();

        clearTimeout(timeout);
        timeout = setTimeout(function () {
          $(this).prop("disabled", true);
          $("tags.tagify").css("opacity", "0.5");
          jQuery.ajax({
            type: "post",
            dataType: "json",
            url: wppt_script.ajaxurl,
            data: {
              action: "wppt_ajax",
              data: data,
              nonce: secret,
              pageid: page_id,
              meta_title: title,
            },
            success: function (response) {
              $(this).prop("disabled", false);
              $("tags.tagify").css("opacity", "1");
              console.log(response);
            },
            error: function (xhr, status, error) {
              var err = eval("(" + xhr.responseText + ")");
              alert(err.data);
            },
          });
        }, 1000);
      });
    }
  }
})(jQuery);
