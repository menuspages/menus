$('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
});

function goToMenuSection() {
    window.location.href = '#menu';
}

(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

function submitForm(e) {
    e.preventDefault();
    let fields = {};
    $(e.target).find('input').each(function (index, element) {
        fields[element.attributes.name.value] = element.value;
    });

    toggleLoading(true);
    $.ajax({
        url: '/menu-request',
        method: 'post',
        data: fields,
    }).done(function (data) {
        if(data.success){
            toggleAlert('تم ارسال طلبك بنجاح، سوف يتم التواصل معكم في اسرع وقت', 'success');
            resetMenuRequestForm();
        }else{
            toggleAlert('خطأ غير معروف، من فضلك حاول لاحقاً', 'danger');
        }
    }).fail(function (response, ) {
        if(response.responseJSON && response.responseJSON.errors){
            let errors = response.responseJSON.errors;
            let error = Object.keys(errors)[0];
            toggleAlert(errors[error], 'danger');
        }else{
            toggleAlert('خطأ غير معروف، من فضلك حاول لاحقاً', 'danger');
        }
    }).always(function () {
        toggleLoading(false);
    });
}

function toggleLoading(show) {
    if (show) {
        $('#loading-submit').show().parent().attr('disabled', true);
    } else {
        $('#loading-submit').hide().parent().attr('disabled', false);
    }

}
function toggleAlert(message, type) {
    $('.notification').toggleClass('show');
    $('.notification div.alert').removeClass(['alert-success', 'alert-danger']).addClass('alert-' + type).find('span').html(message);
    setTimeout(function () {
        $('.notification').toggleClass('show');
    }, 3000)
}

function resetMenuRequestForm(){
    $('#menu-request-form').find('input').each(function (index, element) {
        element.value = '';
    });
}
