/**
 * Created by ASDAFF on 04.04.2017.
 */
$(function () {
    // Remove Search if user Resets Form or hits Escape!
    $('body, .top-menu form[role="search"] button[type="reset"]').on('click keyup', function(event) {
        console.log(event.currentTarget);
        if (event.which == 27 && $('.top-menu form[role="search"]').hasClass('active') ||
            $(event.currentTarget).attr('type') == 'reset') {
            closeSearch();
        }
    });

    function closeSearch() {
        var $form = $('.top-menu form[role="search"].active')
        $form.find('input').val('');
        $form.removeClass('active');
    }

    // Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
    $(document).on('click', '.top-menu form[role="search"]:not(.active) button[type="submit"]', function(event) {
        event.preventDefault();
        var $form = $(this).closest('form'),
            $input = $form.find('input');
        $form.addClass('active');
        $input.focus();

    });
    // ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
    // if your form is ajax remember to call `closeSearch()` to close the search container
    $(document).on('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function(event) {
        event.preventDefault();
        var $form = $(this).closest('form'),
            $input = $form.find('input');
        $('#showSearchTerm').text($input.val());
        closeSearch()
    });
});

function checkFIxed (offsetTop, element, fixedClass) {
    if($(this).scrollTop()>offsetTop){
        $(element).addClass(fixedClass);
    }
    else if ($(this).scrollTop()<offsetTop){
        $(element).removeClass(fixedClass);
    }
}

$(document).ready(function() {
    

    offset = $(".title-catalog").offset();
    checkFIxed (offset.top, ".bx-filter", "fixed")
    $(window).scroll(function(){
        checkFIxed (offset.top, ".bx-filter", "fixed")

        if($(this).scrollTop()>700){
                    $('.fixed_container').addClass('floating');
                    $('.fixedFixBlock').show();
                }
                else if ($(this).scrollTop()<700){
                    $('.fixed_container').removeClass('floating');
                    $('.fixedFixBlock').hide();
                }

    });



});
        
    