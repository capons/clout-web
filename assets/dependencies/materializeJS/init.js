(function($) {
        $(function() {

                $('.button-collapse').sideNav();
                $('.parallax').parallax();
                $('.modal-trigger').leanModal({dismissible: true});
                    //        $('.carousel').carousel();
                $('.slider').slider({full_width: true});
                $('ul.tabs').tabs();
                    //        $('.slider').slider('pause');

                    // only necessary if content added dynamically.
                    //        $('.collapsible').collapsible({
                    //            accordion: false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
                    //        });

                }); // end of document ready
        })(jQuery); // end of jQuery name space
