/*
*
* By Khaled AlWakeel
* */


/*
* *flash notification */
$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
$('div.jconfirm').delay(3000).fadeOut(350);


$('#flash-overlay-modal').modal();


/*multi select bootstrap*/

$(function () {
    $('.selectPicker').selectpicker({
        actionsBox: true,
        liveSearch: true,
    });
    $.fn.selectpicker.Constructor.BootstrapVersion = '4';

});


/* delete function*/
$('.delete').on('click', function () {
    const id = $(this).data('id');
    const route = $(this).data('route');
    const token = $(this).data('token');
    $.confirm({
        title: 'تأكيد الحذف',
        content: 'هل أنت متأكد أنك تريد حذف هذه البيانات ؟ !',
        rtl: true,
        closeIcon: true,
        backgroundDismiss: true,
        buttons: {
            confirm: {
                text: 'تأكيد',
                action: function () {
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: token,
                            id: id
                        },
                        dataType: 'json',
                        success: function (data) {
                            $('#row_' + id).remove();
                            $.alert({
                                icon: 'far fa-check-circle',
                                title: 'تم الحذف بنجاح',
                                content: data.msg,
                                backgroundDismiss: true,
                                rtl: true,
                                theme: 'modern',
                                type: 'green',
                                typeAnimated: true,
                                closeIcon: true,
                                autoClose: 'close|3000',
                                buttons: {
                                    close: {
                                        title: 'إغلاق',
                                        // $.alert('action is canceled');
                                    }
                                },
                            });
                        }, error: function (data) {
                            if (data.status === 422) {
                                $.alert({
                                    title: 'خطأ',
                                    rtl: true,
                                    content: 'تم الحذف بنجاح',
                                    type: 'red',
                                });
                            }
                            if (data.status === 423) {

                            }
                        }
                    });
                }
            },
            cancel: {
                text: 'إلغاء',
                action: function () {
                    // $.alert('Canceled!');
                }
            }
        }
    });
});

console.log(sessionStorage.getItem("theme"));
// To Read
if (sessionStorage.getItem("theme")) {
    $('body').addClass(sessionStorage.getItem("theme"));
    if (sessionStorage.getItem("theme") == 'theme-blush') {
        // Store
        $("input[id=lighttheme]").prop('checked', true);
    } else {
        $("input[id=darktheme]").prop('checked', true);
    }
}

$("input[name='radio1']").on('change', function () {
    const radio1 = $("input[name='radio1']:checked").val();
    if (radio1 == 'light') {
        // Store
        sessionStorage.setItem("theme", "theme-blush");
        $("input[id=lighttheme]").prop('checked', true);
    } else {
        sessionStorage.setItem("theme", "theme-dark");
        $("input[id=darktheme]").prop('checked', true);
    }
})


function Modal(id, url, modal, title = null) {
    const ModalClass = $('#' + modal);
    const ModalBody = $('#' + modal + ' .modal-body');
    const ModalContent = $('#' + modal + ' .modal-content');
    ModalClass.modal('show');
    $('#' + modal + ' .modal-title').html(`<div class="text-center">${title}</div>`);
    ModalContent.html(`<div class="modal-content"><div class="modal-body"><div class="text-center"><em class="fas fa-5x fa-spinner fa-pulse"></em></div></div></div>`);
    $.ajax({
        method: "GET",
        url: url,
        data: {
            id: id,
        },
        processData: true,
        success: function (data) {
            console.log(data);
            ModalContent.empty('');
            ModalContent.html(data.data);
        }, error: function (data) {

        },
    });
}
