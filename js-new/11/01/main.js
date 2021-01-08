const colors = [
  "#FFFFFF",
  "#2196F3",
  "#4CAF50",
  "#FF9800",
  "#009688",
  "#795548",
];

const ref = {
  start: document.querySelector('[data-action="start"]'),
  stop: document.querySelector('[data-action="stop"]'),
  body: document.querySelector("body"),
};

ref.start.addEventListener("click", handleStart);
ref.stop.addEventListener("click", handleStop);

let startId;
let status = false;
let prevColorIndex = null;
let currentColorIndex = null;

const randomIntegerFromInterval = (min, max) => {
  return Math.floor(Math.random() * (max - min + 1) + min);
};

function handleStart() {
  if (status) {
    return;
  }

  status = true;
  startId = setInterval(() => {
    currentColorIndex = randomIntegerFromInterval(0, colors.length - 1);

    if (currentColorIndex === prevColorIndex) {
      memo(currentColorIndex);
    }

    ref.body.style.backgroundColor = colors[currentColorIndex];
    prevColorIndex = currentColorIndex;
  }, 1000);
}

function handleStop() {
  status = false;
  clearTimeout(startId);
}

function memo(number) {
  currentColorIndex = randomIntegerFromInterval(0, colors.length - 1);
  if (currentColorIndex === number) {
    memo(currentColorIndex);
  }
}
