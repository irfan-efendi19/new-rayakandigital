(function () {
    'use strict';

    /* ==================== COVER ==================== */
    var cover = document.getElementById('cover');
    var openBtn = document.getElementById('openBtn');
    var main = document.getElementById('main');

    if (openBtn && cover && main) {
        openBtn.addEventListener('click', function () {
            cover.classList.add('opened');
            main.classList.add('visible');
            document.body.style.overflow = 'auto';
            if (audio) {
                audio.play().catch(function () {});
            }
            setTimeout(function () {
                cover.style.display = 'none';
            }, 800);
        });
    }

    /* ==================== MUSIC PLAYER ==================== */
    var audio = document.getElementById('bgAudio');
    var musicBtn = document.getElementById('musicToggle');
    var isPlaying = false;

    if (audio && musicBtn) {
        musicBtn.addEventListener('click', function () {
            if (isPlaying) {
                audio.pause();
                musicBtn.classList.remove('playing');
            } else {
                audio.play().then(function () {
                    musicBtn.classList.add('playing');
                }).catch(function () {});
            }
            isPlaying = !isPlaying;
        });

        audio.addEventListener('ended', function () {
            isPlaying = false;
            musicBtn.classList.remove('playing');
        });
    }

    /* ==================== COUNTDOWN ==================== */
    var countdownEl = document.getElementById('countdown');

    if (countdownEl) {
        var targetYear = parseInt(countdownEl.dataset.year);
        var targetMonth = parseInt(countdownEl.dataset.month) - 1;
        var targetDay = parseInt(countdownEl.dataset.day);
        var targetDate = new Date(targetYear, targetMonth, targetDay);
        var targetHour = parseInt(countdownEl.dataset.hour || '0');
        var targetMin = parseInt(countdownEl.dataset.minute || '0');
        targetDate.setHours(targetHour, targetMin, 0, 0);

        function updateCountdown() {
            var now = new Date();
            var diff = targetDate - now;

            if (diff <= 0) {
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-minutes').textContent = '00';
                document.getElementById('cd-seconds').textContent = '00';
                return;
            }

            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('cd-days').textContent = String(days).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    /* ==================== GIFT TOGGLE ==================== */
    var giftBtn = document.getElementById('giftToggleBtn');
    var giftContent = document.getElementById('giftContent');

    if (giftBtn && giftContent) {
        giftBtn.addEventListener('click', function () {
            giftContent.classList.toggle('open');
            giftBtn.textContent = giftContent.classList.contains('open')
                ? 'Tutup Kado Digital'
                : 'Kirim Kado Digital';
        });
    }

    /* ==================== COPY TO CLIPBOARD ==================== */
    document.addEventListener('click', function (e) {
        var copyBtn = e.target.closest('.btn-copy');
        if (copyBtn) {
            var text = copyBtn.dataset.copy;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function () {
                    var original = copyBtn.textContent;
                    copyBtn.textContent = 'Disalin!';
                    setTimeout(function () {
                        copyBtn.textContent = original;
                    }, 2000);
                });
            } else {
                var input = document.createElement('input');
                input.value = text;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                var original = copyBtn.textContent;
                copyBtn.textContent = 'Disalin!';
                setTimeout(function () {
                    copyBtn.textContent = original;
                }, 2000);
            }
        }
    });

    /* ==================== RSVP FORM (AJAX) ==================== */
    var rsvpForm = document.getElementById('rsvpForm');
    if (rsvpForm) {
        rsvpForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var form = e.target;
            var formData = new FormData(form);
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    form.innerHTML = '<div class="success-msg">Terima kasih! Konfirmasi kehadiran Anda telah diterima.</div>';
                } else {
                    alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            })
            .catch(function () {
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }

    /* ==================== WISH FORM (AJAX) ==================== */
    var wishForm = document.getElementById('wishForm');
    if (wishForm) {
        wishForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var form = e.target;
            var formData = new FormData(form);
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    var wishList = document.getElementById('wishList');
                    var empty = wishList.querySelector('.wish-empty');
                    if (empty) empty.remove();

                    var item = document.createElement('div');
                    item.className = 'wish-item';
                    item.innerHTML = '<h4>' + escapeHtml(data.wish.guest_name) + '</h4>'
                        + '<p>' + escapeHtml(data.wish.message) + '</p>'
                        + '<small>Baru saja</small>';
                    wishList.insertBefore(item, wishList.firstChild);
                    form.reset();
                } else {
                    alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            })
            .catch(function () {
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }

    function loadWishPage(url) {
        var wishContainer = document.getElementById("wishContainer");
        if (!wishContainer) return;

        wishContainer.classList.add("loading");
        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(function (res) {
                return res.text();
            })
            .then(function (html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, "text/html");
                var newContainer = doc.getElementById("wishContainer");
                if (newContainer) {
                    wishContainer.innerHTML = newContainer.innerHTML;
                    if (window.history && window.history.pushState) {
                        window.history.pushState(null, "", url);
                    }
                }
            })
            .catch(function () {
                console.warn("Gagal memuat halaman wishbook.");
            })
            .finally(function () {
                wishContainer.classList.remove("loading");
            });
    }

    var wishContainer = document.getElementById("wishContainer");
    if (wishContainer) {
        wishContainer.addEventListener("click", function (e) {
            var pageLink = e.target.closest("a.page-link");
            if (!pageLink || !pageLink.closest(".wish-pagination")) {
                return;
            }
            e.preventDefault();
            e.stopPropagation();
            loadWishPage(pageLink.href);
        });
    }

    /* ==================== LIGHTBOX ==================== */
    var lightbox = document.getElementById('lightbox');
    var lightboxImg = document.getElementById('lightboxImg');
    var lightboxClose = document.getElementById('lightboxClose');

    if (lightbox && lightboxImg) {
        document.addEventListener('click', function (e) {
            var item = e.target.closest('.gallery-item img');
            if (item) {
                lightbox.classList.add('active');
                lightboxImg.src = item.src;
                document.body.style.overflow = 'hidden';
            }
        });

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (lightboxClose) {
            lightboxClose.addEventListener('click', closeLightbox);
        }

        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    }

    /* ==================== SCROLL ANIMATIONS (Intersection Observer) ==================== */
    if (window.IntersectionObserver) {
        var sections = document.querySelectorAll('.section');
        sections.forEach(function (section) {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        sections.forEach(function (section) {
            observer.observe(section);
        });
    } else {
        sections.forEach(function (section) {
            section.style.opacity = '1';
            section.style.transform = 'none';
        });
    }

    /* ==================== FLOATING LEAVES ==================== */
    var body = document.body;
    function createLeaf() {
        var leaf = document.createElement('div');
        leaf.style.cssText =
            'position:fixed;z-index:0;pointer-events:none;' +
            'width:' + (10 + Math.random() * 16) + 'px;' +
            'height:' + (6 + Math.random() * 10) + 'px;' +
            'background:rgba(139,157,131,' + (0.1 + Math.random() * 0.15) + ');' +
            'border-radius:0 50% 50% 50%;' +
            'left:' + (Math.random() * 110 - 5) + '%;' +
            'top:-20px;' +
            'transform:rotate(' + (Math.random() * 360) + 'deg);' +
            'animation:leafFall ' + (8 + Math.random() * 12) + 's linear forwards;';
        body.appendChild(leaf);
        setTimeout(function () { leaf.remove(); }, 20000);
    }

    var style = document.createElement('style');
    style.textContent =
        '@keyframes leafFall{' +
        '0%{top:-20px;transform:rotate(0deg) translateX(0);opacity:0;}' +
        '10%{opacity:1;}' +
        '90%{opacity:0.6;}' +
        '100%{top:110vh;transform:rotate(720deg) translateX(80px);opacity:0;}' +
        '}';
    document.head.appendChild(style);

    setInterval(createLeaf, 2000);

    /* ==================== HELPER ==================== */
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

})();
