
    jQuery(document).ready(function($) {         //wrapper
        $("#get_total_projects").on('click',function() {          //event
            var this2 = this;                  //use in callback
            $.post(wp_plugin_ajax_obj.ajax_url, {      //POST request
                _ajax_nonce: wp_plugin_ajax_obj.nonce, //nonce
                action: "wp_plugin_ajax_example",         //action
                }, function(data) {            //callback
                    this2.nextSibling.remove(); //remove current title

                    $('#project_response').html(data);
                    console.log(data);
                }
            );
        } );
    } );


