"use strict";

const timer = {
  id: null,
  startTime: null,
  isActive: null,
  deltaTime: 0,
  numberLaps: 0,
  lapTime: 0,
  deltaTimeLap: 0,

  start() {
    if (this.isActive) return;
    this.isActive = true;
    this.startTime = Date.now() - this.deltaTime;
    this.lapTime = Date.now() - this.deltaTime;
    this.id = setInterval(() => {
      const currentTime = Date.now();
      this.deltaTime = currentTime - this.startTime;
      this.deltaTimeLap = currentTime - this.lapTime;
      updateClockFace(this.deltaTime);
    }, 100);
  },

  lap() {
    if (this.isActive === true) {
      let lapCount = document.createElement("li");
      lapCount.classList.add("lap_number");
      this.numberLaps += 1;
      lapCount.textContent =
        "Lap " + this.numberLaps + ": " + formatTime(this.deltaTimeLap);
      lapsList.append(lapCount);
      this.lapTime = Date.now();
    }
  },

  pause() {
    clearInterval(this.id);
    start.textContent = "Continue";
    this.isActive = "pause";
    reset.classList.add("blue");
    lap.classList.remove("blue");
    lap.classList.add("btn-lap");
    lap.classList.remove("opacity");
  },

  continue() {
    this.isActive = false;
    this.start();
    start.textContent = "Pause";
    this.lapTime = Date.now();
    lap.classList.add("blue");
    lap.classList.remove("btn-lap");
  },

  reset() {
    if (this.isActive) {
      clearInterval(this.id);
      this.isActive = null;
      this.deltaTime = 0;
      updateClockFace(this.deltaTime);
      const arrayLaps = Array.from(lapsList.children);
      arrayLaps.forEach(lap => {
        lap.remove();
      });
      start.textContent = "Start";
      this.numberLaps = 0;
      lap.classList.remove("opacity");
      reset.classList.remove("opacity");
      lap.classList.remove("blue");
      reset.classList.remove("blue");
    }
  }
};

const start = document.querySelector(".js-start");
const lap = document.querySelector(".js-take-lap");
const reset = document.querySelector(".js-reset");
const clockFace = document.querySelector(".js-time");
const lapsList = document.querySelector(".js-laps");

start.addEventListener("click", handleStartBtnClick);
lap.addEventListener("click", timer.lap.bind(timer));
reset.addEventListener("click", timer.reset.bind(timer));

// вывод времени в html
function updateClockFace(time) {
  const formattedTime = formatTime(time);
  clockFace.textContent = formattedTime;
}

function formatTime(ms) {
  const date = new Date(ms);
  let minutes = date.getMinutes();
  minutes = minutes < 10 ? `0${date.getMinutes()}` : date.getMinutes();

  let seconds = date.getSeconds();
  seconds = seconds < 10 ? `0${date.getSeconds()}` : date.getSeconds();

  let milliseconds = String(date.getMilliseconds())[0];

  return `${minutes}:${seconds}.${milliseconds}`;
}

function handleStartBtnClick() {
  switch (timer.isActive) {
    case null:
      lap.classList.add("opacity");
      reset.classList.add("opacity");
      this.textContent = "Pause";
      lap.classList.add("blue");
      reset.classList.add("blue");
      timer.start();
      break;
    case true:
      timer.pause();
      break;
    default:
      timer.continue();
  }
}
