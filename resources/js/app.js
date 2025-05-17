import './bootstrap';

window.Echo.private(`users.${id}`)
    .notification((event) => {
        $('.no-notification').remove();
        $('#push-notification').prepend(`<div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span> Post Comment : ${event.post_title}...</span>
                                        <a href="${event.link}?notify=${event.id}"><i class="fa fa-eye"></i></a>
                                    </div>`);
        let count = Number($('#count-notification').text());
        count++;
        $('#count-notification').text(count);
    });
