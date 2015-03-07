$(function(){
	$('#sidebar, #main, #leftbar').equalHeight();

    $(".button").each(function()
    {
        $(this).addClass('btn btn-primary');
    });



    setInterval(function()
    {
        $("#send-message-button").addClass('btn');

        $(".button").each(function()
        {
            $(this).addClass('btn btn-primary');
        });

    },10);
});