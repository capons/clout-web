$(document).ready(function main() {

//    variables that probably won't change
     var content_column_height = parseInt($('.content-customer-column').first().css('height'));

    // Grand Parent (1st level) sortable columns
    $("#sortable-overlay").sortable({
        axis: "x",
        handle: ".handle",
        containment: "parent",
        activate: function() {
            console.log('sorting activated: section');
        },
        beforeStop: function() {
            console.log('sorting stopped: section');
        }
    });

    // Parent (2nd level) sortable columns (currently only inside spending )
    $('.sortable').sortable({
        axis: "x",
        handle: ".subhandle",
        containment: "parent",
        activate: function() {
            console.log('sorting activated: subsection');
        },
        beforeStop: function() {
            console.log('sorting stopped: subsection');
        }
    });

    // Children (3rd level) sortable content-columns
    $('.section-content, .subsection-content').sortable({
        axis: "x",
        handle: ".content-column-header",
        containment: "parent",
        activate: function contentColumnSortingActivate(event, ui) {
            // triggered when content-columns are dragged
            console.log('sorting activated: content-column');
        },
        beforeStop: function contentColumnSortingBeforeStop(event, ui) {
            // triggered immediately before content-columns (being dragged) are dropped into place
            console.log('sorting stopped: content-column');
        }
    });

    // handle class also toggles section and label
    $(".collapse").click(function handleClassClickHandler() {

        //animation speeds in milliseconds
        var section_speed = label_speed = 200;

        // determine if its collapse-label or section-header
        var isSectionHeader = $(this).hasClass('section-header');
        var isCollapseLabel = $(this).hasClass('collapse-label');
        var isSubSectionHeader = $(this).hasClass('subsection-header')

        // label isnt displayed, lets collapse section and reveal label
        if (isSectionHeader || isSubSectionHeader) {
            var $section_header = $(this);
            var $section_color_rgb = $section_header.css('background-color');
            var $section = $section_header.parent();
            var $collapse_label = $section.prev();
            var $closed_arrow = $section.prev().children().first();
            var $closed_arrowB = $section.prev().children().last();
            var $label_text = $section.prev().children().last().children().first();

            // dynamically style each collapse label
            $collapse_label.css({'height': content_column_height + 50});
            $closed_arrowB.css('background', $section_color_rgb);
           // $closed_arrowB.css('position', 'relative');
            $closed_arrowB.css({'margin-top': content_column_height - 25});
            // $label_text.css('color', $section_color_rgb);
            $closed_arrow.css('background', $section_color_rgb);
            $collapse_label.css('background', $section_color_rgb);
            $collapse_label.css('border-top', '2px solid ' + $section_color_rgb);
            $collapse_label.css('border-right', '2px solid ' + $section_color_rgb);
            $collapse_label.css('border-bottom', '2px solid ' + $section_color_rgb);
            $collapse_label.css('border-left', '2px solid ' + $section_color_rgb);
            // open vertical collapse label, close section contents
            $section.animate({width: 'toggle'}, section_speed);
            $collapse_label.animate({width: 'toggle'}, label_speed);
        }

        // label isnt displayed, lets collapse section and reveal label
        if (isCollapseLabel) {
            $collapse_label = $(this);
            $section = $collapse_label.next();
            $section_header = $section.children().first();
            // open section contents, close vertical collapse label
            $section.animate({width: 'toggle'}, section_speed);
            $collapse_label.animate({width: 'toggle'}, label_speed);
        }
    });
    
    // first we hide them
    $('.simple-sort').toggle();

    // end of main/ready fn
});

/* Checkbox (1st column, 1st content-column) Header, toggle all */
$(document).on('click', '#check-all-customers+label', function () {
    // var $all_checkboxes = $("#check-all-customers");
    if ($('#check-all-customers').prop('checked') == false) {
        $('.customer-checkbox').prop('checked', true);
    } else {
        $('.customer-checkbox').prop('checked', false);
    }
});

/* Content-Column-Header hover (dynamic border color based on section) */
$('.header-hover').hover(function handlerIn(e) {
    // TODO: Make work for subsections ('parents' between grandparent && children)
    var nearest_section_header = $(this).parent().parent().parent().parent();
    var border_color = nearest_section_header.css("background-color");
    //    console.log(nearest_section_header, border_color);
    $(this).css('border-left', (e.type === "mouseenter") ? "2px solid " + border_color : "2px solid " + 'transparent');
});

// // Filter By Store Location(s) dropdown / Far Left Menu
// $('#filterBy .tag').click(function openFilterByDropDown(e) {
//     $('#filterBy .menu').toggleClass('flex-menu');
// });

// // Far Right Menu
// $('#viewBy .tag').click(function openViewByDropDown(e) {
//     $('#viewBy .menu').toggleClass('flex-menu');
// });

//// Viewing
//$( "input[name$='viewByRadio']" ).change(function(e) {
//    var $target_text = e.target.nextElementSibling.innerText;
//    var down_arrow = '<img src="icons/arrow_down.png" class="dropdown-icon">';
//    $('#viewBy .menu').toggleClass('flex-menu');
//    $('#viewBy .tag').html($target_text + down_arrow);
//});

/* Request Modal*/
$('.premium-content-data > span').click(function (e) {
    // capture column header of requested content
    var requested = $(this).parent().prev().first().text().trim();
    $('#requested-feature').openModal({
        in_duration: 250,
        out_duration: 250
    });
});


/* Simple Sort Arrows */
$('.content-column-header > .flex > span').click(function(e) {
    
    // make sure no other headers are darker
    $('.content-column-header').each(function(i, el) {
        if ($(el).hasClass('selected-header')) {
            $(el).removeClass('selected-header');            
        }
    });
    
    // darken the clicked header
    $(e.target).closest('.content-column-header').addClass('selected-header');
    
    
    if ($(e.target).closest('.content-column-header').children().first().is(':visible')) {
        
        $(e.target).closest('.content-column-header').children().first().toggleClass('rotate');
    
    } else {
        //close all other arrows
        $('.content-column-header').each(function(i, el) {
            
            $(el).children().first().hide();
            
        });
        
        // reveal the arrow
        $(e.target).closest('.content-column-header').children().first().toggle();
    }
    
});


var dd_men1 = '<div class="dd_men" style="position: absolute; background-color: white; flex-direction: column; border: 2px solid grey; padding:10px; z-index: 100; transform: translate(-22px, 32px); font-family: Roboto; font-weight: 500;">'+
                                    '<input style="display:flex" name="ResStatus" type="radio" id="all-countries" />'+
                                    '<label style="display:flex" for="">Show Pending</label>'+
                                    '<input style="display:flex" name="ResStatus" type="radio" id="choose-country" />'+
                                    '<label style="display:flex" for="">Show Approved</label>'+
                                   ' <input style="display:flex" name="ResStatus" type="radio" id="all-countries" />'+
                                    '<label style="display:flex" for="">Show Cancelled</label>'+
                                    '<input style="display:flex" name="ResStatus" type="radio" id="choose-country" checked="checked" />'+
                                   ' <label style="display:flex" for="choose-country">Show All</label>'+
                                   ' </div>';

var dd_men2 = ' <div class="dd_men" style="position: absolute; background-color: white; flex-direction: column; border: 2px solid grey; padding:10px; z-index: 100; transform: translate(-22px, 32px); font-family: Roboto; font-weight: 500; ">'+
                    '<input type="checkbox" class="filled-in" id="data-dropdown-menu" />'+
                    '<label for="data-dropdown-menu">Show checkins between:</label><br/>'+
                    '<div style="display:flex; flex: 1; flex-direction: row; align-items: center; justify-content: center">'+
                        '<div class="spacer"></div> <div class="spacer"></div>'+
                        '<input type="text" style="width: 50px; height: 25px; border: 1px solid black" value=" 05/21/16" /> '+
                        
                        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                        
                        '<div style="font-weight: 900; transform: scale(2.5);">-</div>'+
                        
                        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                        
                        '<input type="text" style="width: 50px; height: 25px; border: 1px solid black" value=" 05/27/16" /> '+
                    '</div>'+                    
                '</div>';


$('.header-hover').click(function(e) {
    $(e.target).closest('.dd_men').toggle();    
});