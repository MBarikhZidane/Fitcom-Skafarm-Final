$(document).ready(function () {
  const sidebar = $("#sidebar");
  const mainContent = $("#mainContent");
  const toggleBtn = $("#toggleSidebar");

  toggleBtn.on("click", function () {
    if ($(window).width() <= 768) {
      sidebar.toggleClass("show");
    } else {
      sidebar.toggleClass("collapsed");
      mainContent.toggleClass("expanded");
    }
  });

  $(document).on("click", function (e) {
    if ($(window).width() <= 768) {
      if (
        !sidebar.is(e.target) &&
        sidebar.has(e.target).length === 0 &&
        !toggleBtn.is(e.target) &&
        toggleBtn.has(e.target).length === 0
      ) {
        sidebar.removeClass("show");
      }
    }
  });

  $(window).on("resize", function () {
    if ($(window).width() > 768) {
      sidebar.removeClass("show");
    } else {
      sidebar.removeClass("collapsed");
      mainContent.removeClass("expanded");
    }
  });

  let deleteCallback = null;

  window.confirmDelete = function (message, callback) {
    $("#confirmMessage").text(message);
    deleteCallback = callback;
    const modal = new bootstrap.Modal($("#confirmModal")[0]);
    modal.show();
  };

  window.showAlert = function (type, title, message) {
    const alertIcon = $("#alertIcon");
    const alertTitle = $("#alertTitle");
    const alertMessage = $("#alertMessage");
    const alertOkBtn = $("#alertOkBtn");

    alertIcon.attr("class", `alert-icon ${type}`);
    alertIcon.html(
      type === "success"
        ? '<i class="fas fa-check-circle"></i>'
        : '<i class="fas fa-times-circle"></i>'
    );

    alertTitle.text(title);
    alertMessage.text(message);
    alertOkBtn.attr(
      "class",
      `btn btn-${type === "success" ? "success" : "danger"}`
    );

    const modal = new bootstrap.Modal($("#alertModal")[0]);
    modal.show();
  };

  $("#confirmDeleteBtn").on("click", function () {
    if (deleteCallback) {
      deleteCallback();
      deleteCallback = null;
    }
    bootstrap.Modal.getInstance($("#confirmModal")[0]).hide();
  });

  $("#productImage").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const fileUpload = $(".file-upload");
      if (fileUpload.length) {
        fileUpload.html(`
          <i class="fas fa-check-circle" style="color: #22c55e; font-size: 48px; margin-bottom: 16px;"></i>
          <h6 style="color: #22c55e;">File berhasil dipilih</h6>
          <p class="text-muted">${file.name}</p>
        `);
      }
    }
  });

  window.toggleProfileDropdown = function () {
    $("#profileDropdown").toggleClass("show");
  };

  window.logout = function () {
    if (confirm("Apakah Anda yakin ingin logout?")) {
      showAlert("success", "Logout", "Logout berhasil!");
    }
  };

  $(document).on("click", function (e) {
    const dropdown = $("#profileDropdown");
    const profileBtn = $(".profile-btn");
    if (
      dropdown.length &&
      profileBtn.length &&
      !profileBtn.is(e.target) &&
      profileBtn.has(e.target).length === 0 &&
      !dropdown.is(e.target) &&
      dropdown.has(e.target).length === 0
    ) {
      dropdown.removeClass("show");
    }
  });
});
