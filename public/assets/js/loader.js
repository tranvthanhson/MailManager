$(window).load(function() {
    hiddenLoader();
});

function showLoader()
{
    $('#loader').fadeIn('slow');
}

function hiddenLoader()
{
    $('#loader').fadeOut('slow');
}
