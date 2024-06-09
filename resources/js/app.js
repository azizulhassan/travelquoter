import "@splidejs/splide/css";
import Splide from "@splidejs/splide";

document.addEventListener("livewire:navigated", () => {
    if (
        document.querySelector("#date-calculator-popup") &&
        document.querySelector("#date-calculator-popup-btn") &&
        document.querySelector("#date-calculator-popup-close-btn")
    ) {
        document
            .querySelector("#date-calculator-popup-btn")
            .addEventListener("click", function () {
                document
                    .querySelector("#date-calculator-popup")
                    .classList.toggle("hidden");
            });

        document
            .querySelector("#date-calculator-popup-close-btn")
            .addEventListener("click", function () {
                document
                    .querySelector("#date-calculator-popup")
                    .classList.toggle("hidden");
            });
    }

    if (document.querySelector(".category-blog-slider")) {
        new Splide(".category-blog-slider", {
            type: "loop",
            perPage: 4,
            gap: "20px",
            autoplay: "play",
            breakpoints: {
                440: {
                    perPage: 2,
                },
                640: {
                    perPage: 3,
                },
                768: {
                    perPage: 3,
                },
            },
        }).mount();
    }
    if (document.querySelector(".featured-blog-slider")) {
        new Splide(".featured-blog-slider", {
            direction: "ttb",
            type: "loop",
            perPage: 1,
            autoplay: "play",
            height: "350px",
            gap: "20px",
        }).mount();
    }
    if (document.querySelector(".trending-blog-slider")) {
        new Splide(".trending-blog-slider", {
            type: "loop",
            perPage: 4,
            gap: "20px",
            breakpoints: {
                440: {
                    perPage: 2,
                },
                640: {
                    perPage: 2,
                },
                800: {
                    perPage: 2,
                },
                900: {
                    perPage: 3,
                },
                1100: {
                    perPage: 4,
                },
            },
        }).mount();
    }

    // Landing Page
    if (document.querySelector(".offers-section")) {
        new Splide(".offers-section", {
            type: "loop",
            perPage: 4,
            gap: "20px",
            breakpoints: {
                440: {
                    perPage: 1,
                },
                640: {
                    perPage: 2,
                },
                768: {
                    perPage: 3,
                },
                1024: {
                    perPage: 3,
                },
            },
        }).mount();
    }

    if (document.querySelector(".daily-deals")) {
        new Splide(".daily-deals", {
            type: "loop",
            perPage: 3,
            gap: "20px",
            breakpoints: {
                640: {
                    perPage: 2,
                },
                768: {
                    perPage: 2,
                },
                1024: {
                    perPage: 2,
                },
            },
        }).mount();
    }

    if (document.querySelector(".top-offers")) {
        new Splide(".top-offers", {
            type: "loop",
            perPage: 3,
            gap: "20px",
            breakpoints: {
                640: {
                    perPage: 2,
                },
                768: {
                    perPage: 2,
                },
                1024: {
                    perPage: 2,
                },
            },
        }).mount();
    }

    if (document.querySelector(".recommended-offers")) {
        new Splide(".recommended-offers", {
            type: "loop",
            perPage: 3,
            gap: "20px",
            breakpoints: {
                640: {
                    perPage: 2,
                },
                768: {
                    perPage: 2,
                },
                1024: {
                    perPage: 2,
                },
            },
        }).mount();
    }

    if (document.querySelector(".travel-agents-section")) {
        new Splide(".travel-agents-section", {
            type: "loop",
            perPage: 4,
            gap: "20px",
            breakpoints: {
                440: {
                    perPage: 1,
                },
                640: {
                    perPage: 2,
                },
                768: {
                    perPage: 3,
                },
                1024: {
                    perPage: 3,
                },
            },
        }).mount();
    }
});