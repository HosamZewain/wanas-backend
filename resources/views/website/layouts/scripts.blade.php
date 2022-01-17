
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js"></script>
<script src="{!! asset('website/assets/js/jquery.waterwheelCarousel.min.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{!! asset('website/assets/js/scripts.js') !!}"></script>
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
        $(document).find('button[type=submit]').addClass('disabled');
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
                $.dialog({
                    icon: 'fas fa-envelope-open-text',
                    title: data.msg,
                    content: '',
                    backgroundDismiss: true,
                    theme: 'modern',
                    type: 'green',
                    rtl: rtlCheck,
                    typeAnimated: true,
                    closeIcon: true,
                    autoClose: 'close|5000',
                });
                if (data.data && data.data.redirect) {
                   // console.log(data.data.redirect);
                    window.location.replace(data.data.redirect);
                }
                if (redirect) {
                    window.location.replace(redirect);
                }
                if (reload) {
                    setTimeout(window.location.reload(), 5000)
                }
                if (render) {
                    $(render_body).html(' ');
                    $(render_body).html(data.data);
                    $(document).find('button[type=submit]').removeClass('disabled');


                }
                $('.modal').modal('hide');
            }, error: function (data) {
                console.log(JSON.parse(data.responseText).msg);
                $(document).find('button[type=submit]').removeClass('disabled');
                if (data.status === 422) {
                    $(document).find('button[type=submit]').show();
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
