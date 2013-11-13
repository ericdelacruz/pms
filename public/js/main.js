var application = {
        process : function() {
            $('#processAddStepButton').undelegate('#processAddStepButton', 'click').delegate($('.processAddStep'), 'click', function() {
                var strStep = $.trim($('#processStepName').val());
                var strDetails = $.trim($('#processDetails').val());

                if ('' === strStep || '' === strDetails) {
                    alert('All fields are required');
                    return false;
                }

                var intSize = $('#processSteps tbody tr').size();
                var objNode = $('#processStepRow');

                //assign values
                objNode.find('.processStepsRow1').html(strStep);
                objNode.find('.processStepsRow2').html(strDetails);

                //assign hidden values
                objNode.find('.processStepNameValue').val(strStep).attr('name', 'step[' +intSize+ '][steps]');
                objNode.find('.processDetailsValue').val(strDetails).attr('name', 'step[' +intSize+ '][details]');

                //append table row
                $('#processSteps').find('tbody').append(objNode.find('tbody').html());

                bindSaveLink();
                bindEditLink();
                bindRemoveLink();
            });

            function bindRemoveLink() {
                $('.processRemoveStep').undelegate('.processRemoveStep', 'click').delegate($('#processWrapper'), 'click', function(){
                    $(this).parents('tr').remove();
                });
            }

            function bindEditLink() {
                $('.processEditStep').undelegate('.processEditStep', 'click').delegate($('#processWrapper'), 'click', function(){
                    $(this).parents('tr').find('.processStepsRow1').html('<input type="text" />');
                    $(this).parents('tr').find('.processStepsRow2').html('<input type="text" style="width: 100px;"/>');

                    //assign values
                    $(this).parents('tr').find('.processStepsRow1 input').val($(this).parents('tr').find('.processStepNameValue').val());
                    $(this).parents('tr').find('.processStepsRow2 input').val($(this).parents('tr').find('.processDetailsValue').val());

                    //show save link and hide edit link
                    $(this).addClass('hide');
                    $(this).parent().find('.processSaveStep').removeClass('hide');
                });
            }

            function bindSaveLink() {
                $('.processSaveStep').undelegate('.processSaveStep', 'click').delegate($('#processWrapper'), 'click', function(){
                    //mark as active
                    $('.processSaveStep').removeClass('activeSaveLink');
                    $(this).addClass('activeSaveLink');

                    var objNode = $('.activeSaveLink');

                    var strStep = $.trim(objNode.parents('tr').find('.processStepsRow1 input').val());
                    var strDetails = objNode.parents('tr').find('.processStepsRow2 input').val();

                    objNode.parents('tr').find('.processStepsRow1').html(strStep);
                    objNode.parents('tr').find('.processStepsRow2').html(strDetails);

                    //hidden links
                    objNode.parents('tr').find('.processStepNameValue').val(strStep);
                    objNode.parents('tr').find('.processDetailsValue').val(strDetails);

                    bindEditLink();
                    bindRemoveLink();

                    objNode.addClass('hide');
                    objNode.parent().find('.processEditStep').removeClass('hide');
                });
            }

            bindSaveLink();
            bindEditLink();
            bindRemoveLink();
        },
        processResource : function() {
            $('#stepResource').undelegate('#stepResource', 'change').delegate($('#processResourceWrapper'), 'change', function(){
                var strResource = $('#stepResource :selected').val();

                if (strResource !== 0) {
                    $.ajax({
                        url: '/user/getUserByResourceAjax/' + strResource,
                        dataType: 'json'
                    }).done(function(data){
                        var arrUsers = data.users;
                        if (arrUsers.length > 0 && arrUsers != 'null') {
                            $('#stepUser').html('<option>Choose Name</option>');
                            $.each(arrUsers, function(index) {
                                var strOption = '<option value="'+ arrUsers[index].user_id + '">'+arrUsers[index].firstName + ' ' + arrUsers[index].lastName +'</option>';
                                $('#stepUser').append(strOption);
                            });
                        } else {
                            $('#stepUser').html('<option>Choose Name</option>');
                        }
                    });
                } else {
                    $('#stepUser').html('<option></option>');
                }
            });

            $('#addStepResource').undelegate('#addStepResource', 'click').delegate($('#processResourceWrapper'), 'click', function(){
                var strResource = $('#stepResource :selected').val();
                var strDays = $('#addResourceDays').val();

                if (strDays === '' || strResource === 0) {
                    alert('Fill up required fields');
                    return false;
                }
            });
        }
};

$(document).ready(function(){

    //for process
    if ($('#processWrapper').length > 0) {
        application.process();
    }

    //for process resource list
    if ($('#processResourceWrapper').length > 0) {
        application.processResource();
    }
});