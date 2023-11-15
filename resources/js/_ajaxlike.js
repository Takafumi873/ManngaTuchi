$(function () {
    // Likeの処理
    let like = $('.like-toggle');
    let likeComicId;
    like.on('click', function () {
      let $this = $(this);
      likeComicId = $this.data('comic-id');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url: '/posts/like',
        method: 'POST',
        data: {
          'comic_id': likeComicId
        },
      })
      .done(function (data) {
        console.log('like success');
        $this.toggleClass('liked');
        $this.next('.like-counter').html(data.comic_likes_count);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('like fail');
        console.log(jqXHR.responseText);
      });
    });

    // Reserveの処理
    let reserve = $('.reserve-toggle');
    let reserveComicId;
    reserve.on('click', function () {
      let $this = $(this);
      reserveComicId = $this.data('comic-id');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url: '/posts/reserve',
        method: 'POST',
        data: {
          'comic_id': reserveComicId
        },
      })
      .done(function (data) {
        console.log('reserve success');
        $this.toggleClass('reserved');
        $this.next('.reserve-counter').html(data.comic_reserves_count);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('reserve fail');
        console.log(jqXHR.responseText);
      });
    });
});
