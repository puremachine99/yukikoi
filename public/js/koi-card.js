// ============================== CONFIGURATIONS ===============================
const CONFIG = {
    csrfToken: document.querySelector('meta[name="csrf-token"]').content,
    routes: {
        toggleLike: "/koi/{id}/like",
        toggleWishlist: "/wishlist/toggle",
    },
};

// ============================== TIMER FUNCTIONALITY ===============================
$(document).ready(function () {
    function updateCountdown() {
        $("[data-end-time]").each(function () {
            const $wrapper = $(this);
            const koiId = $wrapper.data("koi-id");
            const endTime = new Date($wrapper.data("end-time")).getTime();
            const $countdownElement = $(`#countdown-${koiId}`);

            if (!$countdownElement.length) return;

            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                );
                const minutes = Math.floor(
                    (distance % (1000 * 60 * 60)) / (1000 * 60)
                );
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $countdownElement.text(
                    `${days}Hr ${hours}:${minutes}:${seconds}`
                );

                if (distance <= 60 * 60 * 1000) {
                    $wrapper
                        .removeClass("bg-yellow-500 text-black")
                        .addClass("bg-red-500 text-white");
                } else {
                    $wrapper
                        .removeClass("bg-red-500 text-white")
                        .addClass("bg-yellow-500 text-black");
                }
            } else {
                $countdownElement.text("Lelang Berakhir");
                $wrapper
                    .removeClass("bg-yellow-500 bg-red-500")
                    .addClass("bg-gray-500 text-white");
            }
        });

        // Recursive update setiap detik
        setTimeout(updateCountdown, 1000);
    }

    // Jalankan pertama kali saat halaman dimuat
    updateCountdown();
});

// ============================== NAVIGATION FUNCTIONALITY ===============================
$(".card-navigate").click(function (event) {
    if (!$(event.target).closest(".koi-action").length) {
        window.location.href = $(this).data("url");
    }
});

// ============================== LIKE FUNCTIONALITY ===============================
function toggleLike(koiId) {
    const likeIcon = $(`#like-icon-${koiId}`);
    const likesCountElement = $(`#likes-count-${koiId}`);
    const isLiked = likeIcon.hasClass("text-red-600");
    let currentLikes = parseInt(likesCountElement.text(), 10) || 0; // Default ke 0 jika NaN

    likeIcon.toggleClass("text-red-600");
    likesCountElement.text(isLiked ? currentLikes - 1 : currentLikes + 1);

    $.post(CONFIG.routes.toggleLike.replace("{id}", koiId), {
        _token: CONFIG.csrfToken,
    }).fail(() => {
        likeIcon.toggleClass("text-red-600");
        likesCountElement.text(currentLikes); // Kembalikan ke nilai sebelumnya jika gagal
    });
}

// ============================== WISHLIST FUNCTIONALITY ===============================
function toggleWishlist(koiId) {
    const wishlistIcon = $(`#wishlist-icon-${koiId}`);
    const isWishlisted = wishlistIcon.hasClass("text-yellow-500");

    wishlistIcon.toggleClass("text-yellow-500");

    $.post(CONFIG.routes.toggleWishlist, {
        _token: CONFIG.csrfToken,
        koi_id: koiId,
    }).fail(() => {
        wishlistIcon.toggleClass("text-yellow-500");
    });
}
