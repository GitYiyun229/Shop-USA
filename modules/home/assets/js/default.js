const loadingHtml =
  '<div class="loadingio-spinner"><div class="ldio"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>';

$(".section-user-btn").hover(function () {
  let id = $(this).attr("data-hover");
  if ($(`#${id}`).css("display") !== "block") {
    $(".section-user-tab").fadeOut();
    $(`#${id}`).fadeIn();

    $(".section-user-btn").removeClass("active");
    $(this).addClass("active");
  }
});

$(".owl-flashsale").owlCarousel({
  center: true,
  items: 1,
  loop: false,
  margin: 15,
  nav: true,
  dots: false,
  autoplayHoverPause: true,
});

$("#owl-tiktok").owlCarousel({
  center: false,
  items: 1,
  loop: false,
  margin: 15,
  nav: true,
  dots: true,
  autoWidth: true,
  lazyLoad: true,
});

const debounce = (mainFunction, delay) => {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      mainFunction(...args);
    }, delay);
  };
};

$(window).on(
  "scroll",
  debounce(function () {
    let load = $(".loading-scroll");
    let page = parseInt(load.attr("page")) + 1;
    let totalCurrent = parseInt(load.attr("total-current"));
    let total = parseInt(load.attr("total"));
    let limit = parseInt(load.attr("limit"));

    if (isElementInViewport($(".loading-scroll")[0]) && totalCurrent < total) {
      load.fadeIn().append(loadingHtml);
      load.attr("page", page);
      load.attr("total-current", totalCurrent + limit);

      loadMoreContent(page, limit, load);
    }
  }, 300)
);

function isElementInViewport(el) {
  var rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

function loadMoreContent(page, limit, load) {
  $.ajax({
    url: "index.php?module=home&view=home&task=loadMore&raw=1",
    type: "GET",
    data: { page, limit },
    dataType: "html",
    success: function (result) {
      $(".section-product .products").append(result);
      load.fadeOut().html("");
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      load.fadeOut().html("");
    },
  });
}
$(document).ready(function () {
    $(".slider-flashsale").slick({
      slidesToShow: 6,
      rows: 2,
      slidesToScroll: 6,
      arrows: true,
      infinite: true,
      speed: 300,
      prevArrow:
        '<button class="slick-prev"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 21L1 11L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
      nextArrow:
        '<button class="slick-next"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 21L11 11L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
    });
})

const coutDown = (day, hour, minute, second) => {
  setInterval(() => {
    var d = new Date();
    let hours = hour - 1 - d.getHours();
    let min = minute - d.getMinutes();
    if ((min + "").length == 1) {
      min = "0" + min;
    }
    let sec = second - d.getSeconds();
    if ((sec + "").length == 1) {
      sec = "0" + sec;
    }
    $("#the-FlashSale-countdown #demo163").html(
      "<span class='fw-bold number_'>" +
        day +
        "</span>:" +
        "<span class='fw-bold number_'>" +
        hours +
        "</span>:" +
        "<span class='fw-bold number_'>" +
        min +
        "</span>:" +
        "<span class='fw-bold number_'>" +
        sec +
        "</span>"
    );
  }, 1000);
};

var countdownElement = document.getElementById("the-FlashSale-countdown");

if (countdownElement) {
  var timeDayValue = countdownElement.getAttribute("data-day");
  coutDown(timeDayValue, 24, 60, 60); // Sử dụng giờ mặc định là 24, bạn có thể cập nhật nếu cần thiết
}

