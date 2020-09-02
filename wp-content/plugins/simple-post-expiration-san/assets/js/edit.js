jQuery(document).ready(function($) {
    // PREVIOUS DATE
    var previous = $('#san_spe_expiration').val();

    // ADD DATE PICKER
    $('#san_spe_expiration').datepicker({dateFormat: 'yy-mm-dd'});

    $('#san-spe-edit-expiration, .san-spe-hide-expiration').click(function(e) {
        // PREVENTS DEFAULT EVENT FROM OCCURING
        e.preventDefault();

        var date = $('#san_spe_expiration').val();

        if( $(this).hasClass('cancel') ) {
            $('#san_spe_expiration').val(previous);
            $('#san-spe-expiration-label').text(previous);
        } else if(date) {
            $('#san-spe-expiration-label').text(date);
        }

        // SLIDES THE FIELD UP AND DOWN - HIDES OR SHOWS
        $('#san-spe-expiration-field').slideToggle();
    });
});