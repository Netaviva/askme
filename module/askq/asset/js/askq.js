/*
 *Javascript code for Askq system
 *Author : LinkoDev
 */
$Askq = {};

$Askq.init = function()
{

}

$Askq.submitQuestion = function()
{
    var userid = $("#ask-question-form").attr('userid');
    //alert(userid)
    var text = $("#question-content-input").val();

    if(text == '')
    {
        //alert('message is empty');
        Linko.notify.show(Linko.translate.get('askq.error_question_asked'));
        return false;
    }
    Linko.process.show('question-post-indicator', $("#question-post-indicator-container"));
    $("#ask-question-form-container textarea").css('opacity', '0.5');
    Linko.ajax.post( 'askq/submitQuestion', {userid: userid, data: $("#ask-question-form").serialize()},function(data)
    {
        Linko.process.remove('question-post-indicator');
        //$("#ask-question-form-container").prepend(data);
        $("#ask-question-form-container textarea").val('').css('opacity', '1.0');
        Linko.notify.show(Linko.translate.get('askq.success_question_asked'));
    },'html')
}

$Askq.getAnswerWindow = function (elem)
{
    var id = $(elem).attr('question_id');
    var c = "<textarea class='modal-answer-textarea' rows='5' name='text' ></textarea> ";
    c +="<input type='hidden' name='question_id' value='"+id+"'>";

    //alert(id);
    Linko.modal.show(c, {dataType:'html' , method : 'POST',type:'form',action:'askq/answer',title:'Answer Question',submit:'answer',success:function(data)
    {
        //alert(data);
        Linko.notify.show(Linko.translate.get('askq.success_question_answered'));
        //alert(data);
        $("#question-item-"+id).slideUp();

       // alert('this is done');

    },autoCloseInterval:1});


};

$(function()
{
    $("#ask-question-form").submit(function()
    {
        $Askq.submitQuestion();
        return false;
    });

    $('.question-answer-button').each(function()
    {
        $(this).click(function()
        {
            //alert($(this).attr('question_id'));

            $Askq.getAnswerWindow(this);
            return false;
        })
    })


})