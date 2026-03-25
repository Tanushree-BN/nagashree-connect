document.addEventListener("DOMContentLoaded", function () {
  var admissionWhatsappPhone = "919901181966";
  var pendingAdmissionWhatsappUrl = "";

  if (window.lucide) {
    window.lucide.createIcons();
  }

  var admissionPopup = document.getElementById("admission-popup");
  var admissionPopupClose = document.getElementById("admission-popup-close");
  if (admissionPopup) {
    var isClosingAdmissionPopup = false;

    var openAdmissionPopup = function () {
      admissionPopup.classList.remove("hidden");
      admissionPopup.classList.add("flex");
      requestAnimationFrame(function () {
        admissionPopup.classList.add("popup-visible");
      });
    };

    var hasShownAdmissionPopup = sessionStorage.getItem("admissionPopupShown");
    if (!hasShownAdmissionPopup) {
      setTimeout(function () {
        openAdmissionPopup();
        sessionStorage.setItem("admissionPopupShown", "1");
      }, 250);
    }

    var closeAdmissionPopup = function () {
      if (isClosingAdmissionPopup) return;
      isClosingAdmissionPopup = true;
      admissionPopup.classList.remove("popup-visible");

      setTimeout(function () {
        admissionPopup.classList.add("hidden");
        admissionPopup.classList.remove("flex");
        isClosingAdmissionPopup = false;
      }, 230);
    };

    if (admissionPopupClose) {
      admissionPopupClose.addEventListener("click", closeAdmissionPopup);
    }

    admissionPopup.addEventListener("click", function (event) {
      if (event.target === admissionPopup) {
        closeAdmissionPopup();
      }
    });
  }

  var header = document.getElementById("site-header");
  if (header) {
    var handleScroll = function () {
      if (window.scrollY > 20) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    };
    handleScroll();
    window.addEventListener("scroll", handleScroll);
  }

  var mobileToggle = document.getElementById("mobile-menu-toggle");
  var mobileMenu = document.getElementById("mobile-menu");
  var menuOpenIcon = document.getElementById("menu-open-icon");
  var menuCloseIcon = document.getElementById("menu-close-icon");
  if (mobileToggle && mobileMenu && menuOpenIcon && menuCloseIcon) {
    mobileToggle.addEventListener("click", function () {
      mobileMenu.classList.toggle("hidden");
      menuOpenIcon.classList.toggle("hidden");
      menuCloseIcon.classList.toggle("hidden");
    });
  }

  var adminMenuToggle = document.getElementById("admin-menu-toggle");
  var adminMenuPanel = document.getElementById("admin-menu-panel");
  if (adminMenuToggle && adminMenuPanel) {
    adminMenuToggle.addEventListener("click", function () {
      adminMenuPanel.classList.toggle("hidden");
    });
  }

  document.querySelectorAll("[data-stat]").forEach(function (element) {
    var targetValue = Number(element.getAttribute("data-stat")) || 0;
    var suffix = element.getAttribute("data-suffix") || "";
    var hasAnimated = false;
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting || hasAnimated) return;
          hasAnimated = true;
          var duration = 2000;
          var startTime = performance.now();
          var animate = function (now) {
            var progress = Math.min((now - startTime) / duration, 1);
            var value = Math.floor(progress * targetValue);
            element.textContent = String(value) + suffix;
            if (progress < 1) requestAnimationFrame(animate);
          };
          requestAnimationFrame(animate);
        });
      },
      { threshold: 0.5 },
    );
    observer.observe(element);
  });

  var contactForm = document.getElementById("contact-form");
  if (contactForm) {
    contactForm.addEventListener("submit", async function (event) {
      event.preventDefault();
      var formData = new FormData(contactForm);
      formData.append("action", "create_message");
      var response = await fetch(window.appUrl("/api/update-data.php"), {
        method: "POST",
        body: formData,
      });
      var data = await response.json();
      var successBox = document.getElementById("contact-success");
      var errorBox = document.getElementById("contact-error");
      if (data.success) {
        if (errorBox) {
          errorBox.classList.add("hidden");
          errorBox.classList.remove("flex");
        }
        if (successBox) {
          successBox.classList.remove("hidden");
          successBox.classList.add("flex");
        }
        contactForm.reset();
        setTimeout(function () {
          if (successBox) {
            successBox.classList.add("hidden");
            successBox.classList.remove("flex");
          }
        }, 5000);
      } else if (errorBox) {
        var errorText = errorBox.querySelector("span");
        if (errorText && data.message) {
          errorText.textContent = data.message;
        }
        errorBox.classList.remove("hidden");
        errorBox.classList.add("flex");
      }
    });
  }

  var admissionForm = document.getElementById("admission-form");
  var admissionOpenButton = document.getElementById("admission-open-btn");
  var admissionCancelButton = document.getElementById("admission-cancel-btn");
  var admissionSubmitAnotherButton = document.getElementById(
    "admission-submit-another-btn",
  );
  var admissionWhatsappSendButton = document.getElementById(
    "admission-whatsapp-send-btn",
  );

  if (admissionWhatsappSendButton) {
    admissionWhatsappSendButton.addEventListener("click", function () {
      if (!pendingAdmissionWhatsappUrl) return;
      window.location.href = pendingAdmissionWhatsappUrl;
    });
  }

  if (admissionSubmitAnotherButton && admissionForm) {
    admissionSubmitAnotherButton.addEventListener("click", function () {
      var successBox = document.getElementById("admission-success");
      var errorBox = document.getElementById("admission-error");
      if (successBox) {
        successBox.classList.add("hidden");
        successBox.classList.remove("block");
      }
      if (errorBox) {
        errorBox.classList.add("hidden");
        errorBox.classList.remove("flex");
      }
      pendingAdmissionWhatsappUrl = "";
      admissionForm.hidden = false;
      admissionForm.classList.remove("hidden");
      var firstInput = admissionForm.querySelector("input, select, textarea");
      if (firstInput) firstInput.focus();
      admissionForm.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  }

  if (admissionOpenButton && admissionForm) {
    admissionOpenButton.addEventListener("click", function () {
      admissionForm.hidden = false;
      admissionForm.classList.remove("hidden");
      var firstInput = admissionForm.querySelector("input, select, textarea");
      if (firstInput) firstInput.focus();
      admissionForm.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  }

  if (admissionCancelButton && admissionForm) {
    admissionCancelButton.addEventListener("click", function () {
      admissionForm.reset();
      admissionForm.hidden = true;
      admissionForm.classList.add("hidden");

      var successBox = document.getElementById("admission-success");
      var errorBox = document.getElementById("admission-error");
      if (successBox) {
        successBox.classList.add("hidden");
        successBox.classList.remove("flex");
        successBox.classList.remove("block");
      }
      if (errorBox) {
        errorBox.classList.add("hidden");
        errorBox.classList.remove("flex");
      }
    });
  }

  if (admissionForm) {
    admissionForm.addEventListener("submit", async function (event) {
      event.preventDefault();
      var formData = new FormData(admissionForm);
      var whatsappMessageLines = [
        "New Admission Enquiry - Nagashree English School",
        "",
        "Student Name: " + (formData.get("studentName") || ""),
        "Father's Name: " + (formData.get("parentName") || ""),
        "Mother's Name: " + (formData.get("motherName") || "N/A"),
        "DOB: " + (formData.get("dob") || ""),
        "Gender: " + (formData.get("gender") || ""),
        "Class Applying: " + (formData.get("classApplying") || ""),
        "Father's Phone: " + (formData.get("phone") || ""),
        "Mother's Phone: " + (formData.get("motherPhone") || "N/A"),
        "Email: " + (formData.get("email") || "N/A"),
        "Address: " + (formData.get("address") || ""),
        "Previous School: " + (formData.get("previousSchool") || "N/A"),
      ];

      formData.append("action", "create_admission");
      var response = await fetch(window.appUrl("/api/update-data.php"), {
        method: "POST",
        body: formData,
      });
      var data = await response.json();
      var successBox = document.getElementById("admission-success");
      var errorBox = document.getElementById("admission-error");
      if (data.success) {
        if (errorBox) {
          errorBox.classList.add("hidden");
          errorBox.classList.remove("flex");
        }
        if (successBox) {
          successBox.classList.remove("hidden");
          successBox.classList.add("block");
          var successText = successBox.querySelector("span");
          if (successText) {
            successText.textContent =
              "Form submitted successfully. We will contact you soon.";
          }
        }

        pendingAdmissionWhatsappUrl =
          "https://wa.me/" +
          admissionWhatsappPhone +
          "?text=" +
          encodeURIComponent(whatsappMessageLines.join("\n"));

        admissionForm.hidden = true;
        admissionForm.classList.add("hidden");
        admissionForm.reset();

        if (successBox) {
          setTimeout(function () {
            successBox.scrollIntoView({ behavior: "smooth", block: "start" });
          }, 80);
        }
      } else if (errorBox) {
        var errorText = errorBox.querySelector("span");
        if (errorText && data.message) {
          errorText.textContent = data.message;
        }
        errorBox.classList.remove("hidden");
        errorBox.classList.add("flex");
      }
    });
  }

  var videoTrigger = document.getElementById("video-trigger");
  if (videoTrigger) {
    videoTrigger.addEventListener("click", function () {
      var container = document.getElementById("school-video-container");
      if (!container) return;
      container.innerHTML =
        '<video src="' +
        window.appUrl("/assets/images/vedio.mp4") +
        '" class="w-full h-full object-cover" autoplay controls title="Nagashree English School video"></video>';
    });
  }

  var galleryFilters = document.querySelectorAll("[data-gallery-filter]");
  var galleryItems = document.querySelectorAll("[data-gallery-item]");
  galleryFilters.forEach(function (button) {
    button.addEventListener("click", function () {
      var category = button.getAttribute("data-gallery-filter");
      galleryFilters.forEach(function (b) {
        b.classList.remove("bg-secondary", "text-secondary-foreground");
        b.classList.add("bg-muted", "text-muted-foreground");
      });
      button.classList.add("bg-secondary", "text-secondary-foreground");
      button.classList.remove("bg-muted", "text-muted-foreground");
      galleryItems.forEach(function (item) {
        var itemCategory = item.getAttribute("data-gallery-item");
        if (category === "all" || itemCategory === category)
          item.classList.remove("hidden");
        else item.classList.add("hidden");
      });
    });
  });

  var lightbox = document.getElementById("gallery-lightbox");
  var lightboxImage = document.getElementById("gallery-lightbox-image");
  var lightboxTitle = document.getElementById("gallery-lightbox-title");
  var lightboxClose = document.getElementById("gallery-lightbox-close");
  document.querySelectorAll("[data-lightbox-src]").forEach(function (item) {
    item.addEventListener("click", function () {
      if (!lightbox || !lightboxImage || !lightboxTitle) return;
      var src = item.getAttribute("data-lightbox-src") || "";
      var alt = item.getAttribute("data-lightbox-alt") || "";
      var title = item.getAttribute("data-lightbox-title") || "";
      lightboxImage.setAttribute("src", src);
      lightboxImage.setAttribute("alt", alt);
      lightboxTitle.textContent = title;
      lightbox.classList.remove("hidden");
      lightbox.classList.add("flex");
    });
  });
  if (lightbox && lightboxClose) {
    var closeLightbox = function () {
      lightbox.classList.add("hidden");
      lightbox.classList.remove("flex");
    };
    lightboxClose.addEventListener("click", closeLightbox);
    lightbox.addEventListener("click", function (event) {
      if (event.target === lightbox) closeLightbox();
    });
  }

  document.querySelectorAll("[data-facility-open]").forEach(function (button) {
    button.addEventListener("click", function () {
      var id = button.getAttribute("data-facility-open");
      var modal = document.getElementById("facility-modal-" + id);
      if (modal) {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
      }
    });
  });
  document.querySelectorAll("[data-facility-close]").forEach(function (button) {
    button.addEventListener("click", function () {
      var id = button.getAttribute("data-facility-close");
      var modal = document.getElementById("facility-modal-" + id);
      if (modal) {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
      }
    });
  });
  document
    .querySelectorAll(".facility-modal-overlay")
    .forEach(function (overlay) {
      overlay.addEventListener("click", function (event) {
        if (event.target === overlay) {
          overlay.classList.add("hidden");
          overlay.classList.remove("flex");
        }
      });
    });
});
