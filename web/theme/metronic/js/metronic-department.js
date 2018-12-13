
var handleDpto = {
    MODEL_NAME : 'department',
    pjaxReload: function (){
        $.pjax.reload({container: '#departmentAjax', timeout: 2000});
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
        if(typeof(fnc)==='function')
        {
            fnc();
        }
        handleDpto.buttonListeners();
    },
    buttonListeners : function(){

        $('#buttonSave').unbind('click').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            var dpto = $('#modal-department').find('#department-name').val();
            $.ajax({
                url: '/department/create',
                data: {dpto: dpto},
                type: 'POST',
                dataType: 'json',
            }).done(function(data){
                if(data.success === 1){
                    handleDpto.pjaxReload();
                }else if(data.success === 2){
                    var errors = data.errors;
                        for(var fieldName in errors){
                            var errorText = errors[fieldName];
                            $('.field-'+handleDpto.MODEL_NAME+'-'+fieldName).addClass('has-error');
                            $('.field-'+handleDpto.MODEL_NAME+'-'+fieldName).find('.help-block').eq(0).text(errorText);
                        }
                }
            });
        });
        
        $('#buttonUpdate').click(function(e){
            //var dptoId = $('#department-id').val();
            var dptoId = $('#modalUpdate').find('#department-id').val();
            var dpto = $('#modalUpdate').find('#department-name').val();
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                url: '/department/update',
                data: {dptoId: dptoId, dpto: dpto},
                type: 'POST',
                dataType: 'json',
            }).done(function(data){
                if(data.success === 1){
                    handleDpto.pjaxReload();
                }else if(data.success === 2){
                    var errors = data.errors;
                    for(var fieldName in errors){
                        var errorText = errors[fieldName];
                        $('.field-'+handleDpto.MODEL_NAME+'-'+fieldName).addClass('has-error');
                        $('.field-'+handleDpto.MODEL_NAME+'-'+fieldName).find('.help-block').eq(0).text(errorText);
                    }
                }
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
//                 }).done(function(data){
//                     if(data.success == 1){
//                         handleDpto.pjaxReload();
//                     }
//                 });
//            }
//        });
        
        // Delete in modal view - btn red
        $('.view_del_btn').unbind('click').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            
            handleDpto.showAlert($('#hidden-department-id').attr('message'),
            $('#hidden-department-id').attr('button-cancel'),$('#hidden-department-id').attr('button-ok'),function(){
                $.ajax({
                    url: "/department/delete/"+$('#hidden-department-id').val(),
                    type: 'POST',
                    dataType: 'json',
                    data: {id : $(this).attr('data-id')}
                }).done(function(data){
                    if(data.success === 1){
                        handleDpto.pjaxReload();
                    }
                });
            });
        });

        $('.view_update_button').unbind('click').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            $('.modal.in').modal('hide');
            $('#modalUpdate').modal('show').find('#modalContentUpdate').load('update/'+$('#hidden-department-id').val(),function(){
                handleDpto.loadOnShow(function(){
                    $('#modalUpdate').show();
                });
            });
        });
    },
    listenerEvents: function(){
        $('form#form-dpto-create').find('#department-name').keypress(function(evt){ 
//            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
            if ((evt.keyCode === 13)) {
                $("#buttonSave").trigger( "click" );
                return false;
            }
        });
        
        $('form#form-dpto-update').find('#department-name').keypress(function(evt){ 
//            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
            if ((evt.keyCode == 13)) {
                $("#buttonUpdate").trigger( "click" );
                return false;
            }
        });
    },
    registerListeners:function(){
        // Delete in grid view
        $('.delete_button').click(function(){
            var url = $(this).val();
            handleDpto.showAlert($(this).attr('message'),
            $(this).attr('button-cancel'),$(this).attr('button-ok'),function(){
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id : $(this).attr('data-id')},
                }).done(function(data){
                    if(data.success === 1){
                        handleDpto.pjaxReload();
                    }
                });
            });
        });
        
        $('#deleteDpto').click(function(){
            var keys = $('#gridDepartment').yiiGridView('getSelectedRows');
            if(keys.length > 0){
                handleDpto.showAlert($(this).attr('data-confirmation'),
                $(this).attr('button-cancel'),$(this).attr('button-ok'),function(){
                    $.ajax({
                        url: '/department/deleteall',
                        data: {keys: keys},
                        type: 'POST',
                        dataType: 'json',
                    }).done(function(data){
                        if(data.success === 1){
                            handleDpto.pjaxReload();
                        }
                    });
                });
            }
        });
        
        // For update
        $('.custom_button').click(function(){
            $('#modalUpdate').modal('show').find('#modalContentUpdate')
                    .load($(this).attr('value'),function(){
                handleDpto.loadOnShow(function(){
                    $('#modalUpdate').show();
                });
                handleDpto.listenerEvents();
            });
        });
        
        // For view
        $('.custom_button_view').click(function(){
            $('#modalView').modal('show').find('#modalContentView')
                    .load($(this).attr('value'),function(){
                handleDpto.loadOnShow(function(){
                    $('#modalView').show();
                handleDpto.listenerEvents();
                });
            });
        });

        // For Create
        $('.button_create').click(function(){
            $('#modal-department').modal('show').find('#modalContentCreateView')
                    .load($(this).attr('value'), function(){
                handleDpto.loadOnShow(function(){
                    $('#modal-department').show();
                });
                handleDpto.listenerEvents();
            });
        });
    }
};
$(document).ready(function(){
    $('div.department-create').toggleClass('col-md-6');
    handleDpto.registerListeners();
    handleDpto.buttonListeners();

});
$(document).on('pjax:complete', function() {
    handleDpto.registerListeners();
});