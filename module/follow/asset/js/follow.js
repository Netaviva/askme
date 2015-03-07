$(function()
{
    $("#profile-follow-button").click(function()
    {

        var follow = $("#profile-follow-button").attr('follow');


        if(follow == 1)
        {
            unFollowUser();

        }else
        {
            //alert(follow);
            followUser();
        }
        return false;
    });


    function followUser()
    {
        Linko.process.show('profile-follow-button-indicator', $('#profile-follow-indicator'));


        //alert('fsdf');
        Linko.ajax.post('follow/add',{
            refid :$("#profile-follow-button").attr('userid') ,
        }, function (data)
        {
            Linko.notify.show(data,{
                type : 'flash'

            });

            Linko.process.remove('profile-follow-button-indicator');
            //$("#profile-follow-button").removeEvent()
            $("#profile-follow-button").removeClass('btn-primary').addClass('btn-danger').text('Unfollow').click(function()
            {
                    unFollowUser();
            });

        }, 'html');

    }

    function unFollowUser()
    {
        Linko.process.show('profile-follow-button-indicator', $('#profile-follow-indicator'));

        Linko.ajax.post('follow/remove',{
            refid :$("#profile-follow-button").attr('userid') ,
        }, function (data)
        {
            //alert('hfgj');
            Linko.notify.show(data,{
                type : 'flash'
            });
            Linko.process.remove('profile-follow-button-indicator');
            //$("#profile-follow-button").();
            $("#profile-follow-button").removeClass('btn-danger').addClass('btn-primary').text('Follow').click(function()
            {
                followUser();
            });

        },'html');

    }


});
