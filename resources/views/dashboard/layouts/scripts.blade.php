<!-- Jquery Core Js -->
<script src="{{ asset('dashboard/assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{ asset('dashboard/assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->

<script src="{{ asset('dashboard/assets/bundles/morrisscripts.bundle.js') }}"></script> <!-- Morris Plugin Js -->
<script src="{{ asset('dashboard/assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
<script src="{{ asset('dashboard/assets/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->
<script src="{{ asset('dashboard/assets/bundles/knob.bundle.js') }}"></script> <!-- Jquery Knob Plugin Js -->

<script src="{{ asset('dashboard/assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/pages/ecommerce.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/pages/charts/jquery-knob.min.js') }}"></script>
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
    const DeleteTitle = '{!! __('dashboard.delete_confirm') !!}';
    const DeleteContent = '{!! __('dashboard.are_you_sure_u_want_to_delete') !!}';
    const deleted_successfully = '{!! __('dashboard.deleted_successfully') !!}';
    const rtlCheck = {!! (app()->getLocale()=='ar')? 'true' :'false' !!};
    const SuccessTitle = '{!! __('dashboard.well_done') !!}';
    const ChangeTitle = '{!! __('dashboard.changed_successfully') !!}';
    const closeText = '{!! __('dashboard.closeText') !!}';
    const SomeThingWrong = '{!! __('dashboard.SomeThingWrong') !!}';
    const CancelText = '{!! __('dashboard.CancelText') !!}';
    const errors = $('.error');
    $(document).on('submit', '#form-submit', function (e) {
        event.preventDefault();
        errors.hide();
        $(document).find('input[type=submit]').addClass('disabled');
        $(document).find('.error').hide();
        $('button[type=submit]').hide();
        const formData = new FormData(this);
        const route = $(this).attr('action');
        const method = $(this).attr('method');
        const render = $(this).attr('render');
        const redirect = $(this).attr('redirect');
        const reload = $(this).attr('reload');
        const render_body = $(this).attr('render_body');
        // Does some stuff and logs the event to the console
        $.ajax({
            url: route,
            type: method,
            _method: method,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                $.alert({
                    icon: 'far fa-check-circle',
                    title:data.msg,
                    content: '',
                    backgroundDismiss: true,
                    theme: 'modern',
                    type: 'green',
                    rtl: rtlCheck,
                    typeAnimated: true,
                    closeIcon: true,
                    autoClose: 'close|5000',
                    buttons: {
                        close: {
                            title: closeText,
                        }
                    },
                });
                if (data.data && data.data.redirect) {
                    console.log(data.data.redirect);
                    window.location.replace(data.data.redirect);
                }
                if (redirect) {
                    window.location.replace(redirect);
                }
                if (reload) {
                    window.location.reload();
                }
                if (render) {
                    $(render_body).html(' ');
                    $(render_body).html(data.data);
                    $(document).find('input[type=submit]').removeClass('disabled');
                }
                $('.modal').modal('hide');
            }, error: function (data) {
                console.log(JSON.parse(data.responseText).msg);
                $(document).find('input[type=submit]').removeClass('disabled');
                if (data.status === 422) {
                    $(document).find('.error').empty(' ');
                    $(document).find('.error').html(' ');
                    $(document).find('.error').show();
                    for (const key in JSON.parse(data.responseText).errors) {
                        console.log('.error_' + key.replace(/\./g, '_'));
                        $(document).find('.error_' + key.replace(/\./g, '_')).html(JSON.parse(data.responseText).errors[key]);
                        $(document).find('#' + key).focus();
                    }
                } else {
                    $.alert({
                        title: SomeThingWrong,
                        rtl: rtlCheck,
                        content: JSON.parse(data.responseText).msg,
                        theme: 'modern',
                        type: 'red',
                        typeAnimated: true,
                        closeIcon: true,
                        autoClose: 'close|3000',
                        buttons: {
                            close: {
                                title: closeText,
                                // $.alert('action is canceled');
                            }
                        },
                    });
                }
            }
        })
    });
</script>
<script>
    const myModal = new bootstrap.Modal(document.getElementById('MainModal'));
    $('.open_modal').on('click', function (event) {
        event.preventDefault();
        const id = $(this).data('id');
        const route = $(this).data('route');
        const redirect = $(this).data('redirect');
        const redirect_id = $(this).data('redirect_id');
        const csrf_token = '{!! csrf_token() !!}';
        const userId = '{!! (auth()->check())  ? auth()->user()->id : 0 !!}';
        const requestInputs = ' @json( request()->all() )';
        // Does some stuff and logs the event to the console
        $.ajax({
            url: route,
            type: "GET",
            _method: 'GET',
            data: {
                id: id,
                redirect: redirect,
                redirect_id: redirect_id,
                csrf_token: csrf_token,
                requestInputs: requestInputs,
                userId: userId,
            },
            dataType: 'json',
            processData: true,
            contentType: false,
            success: function (data) {
                myModal.show();
                // console.log(data.data);
                $('#MainModal .modal-content').empty();
                $('#MainModal .modal-content').append(data.data);
            }, error: function (data) {
                console.log(data.data);
                $.alert({
                    title: SomeThingWrong,
                    rtl: rtlCheck,
                    content: JSON.parse(data.responseText).msg,
                    theme: 'modern',
                    type: 'red',
                    typeAnimated: true,
                    closeIcon: true,
                    autoClose: 'close|3000',
                    buttons: {
                        close: {
                            title: closeText,
                            // $.alert('action is canceled');
                        }
                    },
                });
            }
        })

    });
</script>
<script>
    const LogoutTitle = '{!! __('website.LogoutTitle') !!}';
    const LogoutContent = '{!! __('website.LogoutContent') !!}';
    const logoutConfirmation = '{!! __('website.logoutConfirmation') !!}';
    /* leave function*/
    $(document).on('click', '.logout', function () {
        const id = $(this).data('id');
        const route = $(this).data('route');
        const redirect = $(this).data('redirect');
        const Button = $(this);
        $.confirm({
            title: LogoutTitle,
            content: LogoutContent,
            rtl: rtlCheck,
            closeIcon: true,
            columnClass: 'medium',
            type: 'red',
            backgroundDismiss: true,
            buttons: {
                confirm: {
                    text: logoutConfirmation,
                    action: function () {
                        document.getElementById('logout-form').submit();
                    }
                },
                cancel: {
                    text: CancelText,
                    action: function () {
                        // $.alert('Canceled!');
                    }
                }
            }
        });
    });
</script>
