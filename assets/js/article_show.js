import '../css/article_show.scss';
import $ from 'jquery';

$('.js-like-article').tooltip();

$('.js-like-article').on('click', function(e) {
    e.preventDefault();

    var $link = $(e.currentTarget);
    $link.toggleClass('fa-heart-o').toggleClass('fa-heart');

    $.ajax({
        method: 'POST',
        url: $link.attr('href')
    }).done(function(data) {
        $('.js-like-article-count').html(data.hearts);
    })
});
