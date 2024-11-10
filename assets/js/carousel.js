document.addEventListener('DOMContentLoaded', function () {
    const carousels = document.querySelectorAll('.carousel');

    carousels.forEach(carousel => {
        let index = 0;
        const images = carousel.querySelectorAll('img');
        const totalImages = images.length;

        carousel.querySelector('.next').addEventListener('click', () => {
            index = (index + 1) % totalImages;
            updateCarousel();
        });

        carousel.querySelector('.prev').addEventListener('click', () => {
            index = (index - 1 + totalImages) % totalImages;
            updateCarousel();
        });

        function updateCarousel() {
            images.forEach((img, i) => {
                img.style.transform = `translateX(-${index * 100}%)`;
            });
        }
    });
});
