$(document).ready(function () {
  const tabs = $("#orderTabs .nav-link");

  tabs.on("click", function (e) {
    e.preventDefault();
    tabs.removeClass("active");
    $(this).addClass("active");
    $(".tab-pane").removeClass("show active");
    const targetId = $(this).attr("data-bs-target");
    const targetPane = $(targetId);
    if (targetPane.length) {
      targetPane.addClass("show active");
    }
  });
});

function openEditModal(id, judul, artikel, img) {
  $("#blogEditId").val(id);
  $("#blogEditTitle").val(judul);
  $("#blogEditContent").val(artikel);
  $("#blogEditOldImg").val(img);
}

$(document).ready(function () {
  const wrapper = $("#categories-wrapper");
  const nextBtn = $("#next-btn");
  const prevBtn = $("#prev-btn");
  const scrollAmount = 300;

  nextBtn.on("click", function () {
    if (wrapper.length) {
      wrapper.animate({ scrollLeft: "+=" + scrollAmount }, 400);
    }
  });

  prevBtn.on("click", function () {
    if (wrapper.length) {
      wrapper.animate({ scrollLeft: "-=" + scrollAmount }, 400);
    }
  });
});


document.querySelectorAll('.rating-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = btn.nextElementSibling; 
        if (form && form.style.display === 'none') {
            form.style.display = 'block';
            btn.style.display = 'none'; 
        }
    });
});