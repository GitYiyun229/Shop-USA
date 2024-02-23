const loadingHtml = '<div class="loadingio-spinner"><div class="ldio"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>';

const debounce = (mainFunction, delay) => {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
            mainFunction(...args);
        }, delay);
    };
};

$(window).on('scroll', debounce(function () {
    let load = $('.loading-scroll');
    let page = parseInt(load.attr('page')) + 1;
    let totalCurrent = parseInt(load.attr('total-current'));
    let total = parseInt(load.attr('total'));
    let limit = parseInt(load.attr('limit'));

    if (isElementInViewport($('.loading-scroll')[0]) && totalCurrent < total) {
        load.fadeIn().append(loadingHtml);
        load.attr('page', page);
        load.attr('total-current', totalCurrent + limit);

        loadMoreContent(page, limit, load);
    }
}, 300));

function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function loadMoreContent(page, limit, load) {
    $.ajax({
        url: "index.php?module=products&view=product&task=loadMore&raw=1",
        type: 'GET',
        data: { page, limit },
        dataType: 'html',
        success: function (result) {
            $(".section-more").append(result);
            load.fadeOut().html('');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            load.fadeOut().html('');
        }
    });
}

$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: false,
    asNavFor: '.slider-nav'
});

$('.slider-nav').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    margin: 1,
    dots: false,
    arrows: true,
    centerMode: false,
    focusOnSelect: true,
    vertical: true,
    verticalSwiping: true,
    prevArrow: '<button class="slick-prev"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 7.5L10 12.5L5 7.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    nextArrow: '<button class="slick-next"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 12.5L10 7.5L5 12.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    responsive: [
        {
            breakpoint: 500,
            settings: {
                vertical: false,
                verticalSwiping: false,
            }
        }
    ]
});

$('.slider-related').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    arrows: true,
    infinite: false,
    prevArrow: '<button class="slick-prev"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 21L1 11L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
    nextArrow: '<button class="slick-next"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 21L11 11L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>'
})

$(".count-down").each(function (e) {
    countdowwn($(this));
});

function countdowwn(element) {
    let e = element.attr('time-end');
    let l = new Date(e).getTime();
    let n = setInterval(function () {
        let e = new Date().getTime();
        let t = l - e;
        let a = Math.floor(t / 864e5);
        let s = Math.floor((t % 864e5) / 36e5);
        let o = Math.floor((t % 36e5) / 6e4);
        e = Math.floor((t % 6e4) / 1e3);

        element.html(`
            <span>${a}</span>
            :
            <span>${s}</span>
            :
            <span>${o}</span>
            :
            <span>${e}</span>
        `);

        if (t < 0) {
            clearInterval(n), element.html("Đã hết khuyến mại")
        };
    }, 1e3);
}

$('.p-type').click(function (e) {
    e.preventDefault();
    let data = $(this).attr('data');
    let price = $(this).attr('price-format');
    let priceOld = $(this).attr('price-old-format');
    let priceDiscount = $(this).attr('price-discount-format');

    if (data && data != '0') {
        $('.slider-nav').slick('slickGoTo', data);
    }

    $('.p-type').removeClass('active');
    $(this).addClass('active');

    $('.p-price-public').html(price);
    $('.p-price-origin').html(priceOld);
    $('.p-price-discount').html(priceDiscount);
})

$(document).ready(function(){
    if ($('.p-type').length) {
        $('.p-type.active').click()
    }
})

$('.btn-more-less').click(function() {
    $(this).toggleClass('less');
    $('.description-main').toggleClass('less');
})

$('.comment-filter').click(function (e) {
    e.preventDefault();
    let data = $(this).attr('data-filter');

    $('.comment-filter').removeClass('active');
    $(this).addClass('active');

    if (data != 0) {
        $('.item-comment').hide();
        $('.item-comment.filter-' + data).show();
    } else {
        $('.item-comment').show();
    }
})

$('.more-comment').click(function (e) {
    e.preventDefault();
})

$('.add-cart').click(function (e) {
    e.preventDefault();

    addCart();
})

$('.buy-now').click(async function (e) {
    e.preventDefault();
    let url = $(this).attr('href');

    await addCart(url);

    // location.href = url;
})

async function addCart(url = null) {
    let image = $('.slider-for .slick-active img').attr('src');
    let product = parseInt($('#product').val());

    let price = parseInt($('.p-type.active').attr('data-price'));
    let price_origin = parseInt($('.p-type.active').attr('data-price-origin'));
    let price_old = parseInt($('.p-type.active').attr('data-price-old'));
    let sub = parseInt($('.p-type.active').attr('data-sub'));

    let quantity = $('#order-quantity').val();
    let quantityMax = $('#order-quantity').attr('max');

    if (!parseInt(quantity)) {
        flashMessage(true, "Vui lòng nhập số!");
        $('#order-quantity').focus()
        return false;
    }

    if (parseInt(quantity) <= 0) {
        flashMessage(true, "Số lượng đặt sản phẩm tối thiểu là 1!");
        $('#order-quantity').focus()
        return false;
    }

    if (parseInt(quantity) > parseInt(quantityMax)) {
        flashMessage(true, "Số lượng đặt sản phẩm tối đa là " + quantityMax + "!");
        $('#order-quantity').focus()
        return false;
    }

    quantity = quantity ? parseInt(quantity) : 1;

    $.ajax({
        url: "index.php?module=products&view=cart&task=addCart&raw=1",
        type: 'POST',
        data: { product, sub, quantity, price, image, price_old, price_origin, token },
        dataType: 'JSON',
        success: function (result) {
            console.log(result)
            flashMessage(result.error, result.message);
            $('header .cart-text-quantity').text(result.total);
            if (result.newItem) {
                $('.cart-hover-body').append(`
                    <a href="${result.newItem.url}" class="cart-hover-item">
                        <img src="${result.newItem.image}" alt="${result.newItem.product_name}" class="img-fluid">
                        <div>
                            <div class="mb-1">${result.newItem.product_name}</div>
                            <div class="sub-name">${result.newItem.sub_name}</div>
                        </div>
                        <div class="item-price">
                            <span>₫</span>${result.newItem.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}
                        </div>
                    </a>
                `)
            }

            if (url) {
                location.href = url
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            return false;
        }
    });
}

$('.add-like.no-add').click(function (e) {
    e.preventDefault()
    let product_id = $('#product').val();

    $.ajax({
        url: "index.php?module=members&view=favorite&task=addFavorite&raw=1",
        type: 'POST',
        data: { product_id, token },
        dataType: 'JSON',
        success: function (result) {
            console.log(result)
            flashMessage(result.error, result.message);

            if (!result.error) {
                $('.add-like.no-add').addClass('added').removeClass('no-add');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
})
