    // Add Alpine.js scroll functions
    document.addEventListener('alpine:init', () => {
        Alpine.data('themesScroll', () => ({
            scrollLeft() {
                const container = this.$refs.scrollContainer;
                container.scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            },
            scrollRight() {
                const container = this.$refs.scrollContainer;
                container.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            }
        }));
    });