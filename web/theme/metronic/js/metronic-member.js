
var handleMembers = {
    MODEL_NAME : 'staffmember',
    pjaxReload: function (){
        $.pjax.reload({container: '#memberAjax'});
        $('.modal.in').modal('hide');
    },
    
    showAlert : function(message, labelBtnCancel, labelBtnOk, functionCallBack){
        bootbox.confirm({
            message: message,
            buttons: {
                'cancel': {
                    label: labelBtnCancel,
                    className: 'btn btn-default'
                },
                'confirm': {
                    label: labelBtnOk,
                    className: 'btn btn-primary',
                }
            },
            callback: function (result) {
                if (result) {
                    if(typeof(functionCallBack)==='function')
                    {
                        functionCallBack();
                    }
                }
            }
        });
    },    
    loadOnShow: function(fnc){
        $('.modal-backdrop.fade.in').css('zIndex',1000);
        if(typeof(fnc)==='function')
        {
            fnc();
        }
        handleMembers.buttonListeners();
    },   
    handleDatePickers : function () {
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true
            });
            
            $('.modal-scrollable').removeAttr("style");
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
    },
    
    // Inside modal
    buttonListeners: function(){
        $('#buttonSave').unbind('click').click(function(event){
            event.preventDefault();
            event.stopPropagation();
            var deptMemberId = $('#modal-member').find('#staffmember-department_id').val();
            var staffMemberName = $('#modal-member').find('#staffmember-member_name').val();
            var dateHire = $('#modal-member').find('#staffmember-date_hire').val();
                
            $.ajax({
                url: '/member/create',
                data: {memberId: deptMemberId, memberName: staffMemberName, dateHire : dateHire},
                type: 'POST',
                cache: false,
                dataType: 'json'
            }).done(function(data){
                if(data.success === 1){
                    handleMembers.pjaxReload();
                }else if(data.success === 2){
                    var errors = data.errors;
                    for(var fieldName in errors){
                        var errorText = errors[fieldName];
                        $('.field-'+handleMembers.MODEL_NAME+'-'+fieldName).addClass('has-error');
                        $('.field-'+handleMembers.MODEL_NAME+'-'+fieldName).find('.help-block').eq(0).text(errorText);
                    }
                }
            });
        });
        
        $('#buttonUpdate').unbind('click').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            var deptMemberId = $('#modalUpdate').find('#staffmember-department_id').val();
            var staffMemberName = $('#modalUpdate').find('#staffmember-member_name').val();
            var dateHire = $('#modalUpdate').find('#staffmember-date_hire').val();
            var memberId = $('#modalUpdate').find('#staffmember-id').val();
            $.ajax({
                url: '/member/update',
                data: {deptMemberId: deptMemberId,
                       memberName: staffMemberName, 
                       dateHire : dateHire, memberId: memberId},
                type: 'POST',
                dataType: 'json'
             }).done(function(data){
                if(data.success === 1){
                    handleMembers.pjaxReload();
                }else if(data.success === 2){
                    var errors = data.errors;
                    for(var fieldName in errors){
                        var errorText = errors[fieldName];
                        $('.field-'+handleMembers.MODEL_NAME+'-'+fieldName).addClass('has-error');
                        $('.field-'+handleMembers.MODEL_NAME+'-'+fieldName).find('.help-block').eq(0).text(errorText);
                    }
                }
            });
        });

        $('.view_update_button').unbind('click').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            $('#modalView').modal('hide');
            $('#modalUpdate').modal('show').find('#modalContentUpdate').load('update/'+$('#hidden-member-id').val(),function(){
                handleMembers.loadOnShow(function(){
                    $('#modalUpdate').show(function(){
                        handleMembers.handleDatePickers();
                    });
                });
            });
        });
        
        // Delete in modal view
//        $('.view_del').unbind('click').on('click',function(event){
//            event.preventDefault();
//            event.stopPropagation();
//            if (confirm($(this).attr('data-confirmation'))) {
//                $.ajax({
//                    url: $(this).attr('href'),
//                    type: 'POST',
//                    dataType: 'json',
//                    data: {id : $(this).attr('data-id')}
//                }).done(function(data){
//                    if(data.success==1){
//                        handleMembers.pjaxReload();
//                    }
//                });
//            }
//        });
        
        $('.view_del_member_btn').unbind('click').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            var idm = $('#hidden-member-id').val();
            var url = 'delete/'+idm;
            handleMembers.showAlert($('#hidden-member-id').attr('message'),
                $('#hidden-member-id').attr('button-cancel'),$('#hidden-member-id').attr('button-ok'),function(){
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {id : idm}
                    }).done(function(data){
                        if(data.success === 1){
                            handleMembers.pjaxReload();
                        }
                    });
                });
        });
    },    
    registerListeners:function(){
        // Principal page
        // For Create
        $('.button_create').click(function(){
            $('#modal-member').modal('show').find('#modalContentCreateView').
                    load($(this).attr('value'), function(){
                handleMembers.loadOnShow(function(){
                    $('#modal-member').show(function(){
                        handleMembers.handleDatePickers();
                    });
                });
            });
        });
        
        // For update
        $('.custom_button').click(function(){
            $('#modalUpdate').modal('show').find('#modalContentUpdate').
                    load($(this).attr('value'),function(){
                handleMembers.loadOnShow(function(){
                    $('#modalUpdate').show(function(){
                         handleMembers.handleDatePickers();
                        //$('modal-backdrop fade in');
                    });
                });
            });
            //$('#modalView').modal('show').find('.modalContent').load($(this).attr('href'));
        });
        
        // For view
        $('.custom_button_view').click(function(){
            //$('#modalView').modal('show').find('#modalContentView').load($(this).attr('href'),function(){
            $('#modalView').modal('show').find('#modalContentView').
                    load($(this).attr('value'),function(){
                handleMembers.loadOnShow(function(){
                    $('#modalView').show();
                });
            });
        });

        // Delete each element in grid view
        $('.delete_button').unbind('click').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            var url = $(this).val();
            handleMembers.showAlert($(this).attr('data-confirmation'), 
            $(this).attr('button-cancel'), $(this).attr('button-ok'), function(){
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id : $(this).attr('data-id')}
                }).done(function(data){
                    if(data.success === 1){
                        handleMembers.pjaxReload();
                    }
                });
            });
        });
        
        // Delete selected elements
        $('#deleteMember').click(function(){
            var keys = $('#gridMembers').yiiGridView('getSelectedRows');
            if (keys.length > 0) {
                handleMembers.showAlert($(this).attr('data-confirmation'),
                $(this).attr('button-cancel'),$(this).attr('button-ok'),function(){
                    $.ajax({
                        url: '/member/deletemembers',
                        data: {keys: keys},
                        type: 'POST',
                        dataType: 'json'
                    }).done(function(data){
                        if(data.success === 1){
                            handleMembers.pjaxReload();
                        }
                    });
                });
            }
        });
    }
} // End handle members

$(document).ready(function(){
    handleMembers.registerListeners();
    handleMembers.buttonListeners();
});
$(document).on('pjax:complete', function() {
    handleMembers.registerListeners();
});