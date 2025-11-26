
document.addEventListener("DOMContentLoaded", () => {

let slideIndex = 1;
const mainSlide = document.getElementById("mainSlide");
const prevSlide = document.getElementById("prevSlide");
const nextSlide = document.getElementById("nextSlide");
const prevButton = document.getElementById("prevButton");
const nextButton = document.getElementById("nextButton");

prevButton.addEventListener("click", () => {
    moveSlide(-1);
    }
);

nextButton.addEventListener("click", () => {
    moveSlide(1);
    }
);

const showSlide = () => {
  if (slideIndex > 3) {
    slideIndex = 1;
  }
  if (slideIndex < 1) {
    slideIndex = 3;
  }

  mainSlide.src = `../images/${slideIndex}.jpeg`;
  prevSlide.src = `../images/${slideIndex === 1 ? 3 : slideIndex - 1}.jpeg`;
  nextSlide.src = `../images/${slideIndex === 3 ? 1 : slideIndex + 1}.jpeg`;
};

const moveSlide = (moveStep) => {
  slideIndex += moveStep;
  showSlide();
};


showSlide();
setInterval(() => {
  moveSlide(1);
}, 3000);

});