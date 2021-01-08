class CountdownTimer {
  constructor({ selector, targetDate }) {
    this.selector = selector;
    this.targetDate = targetDate;
    this.init();
  }

  init() {
    if (this.isTimerOff()) {
      this.getRefs().selector.textContent = "Время вышло";
    } else {
      setInterval(() => {
        this.renderCountdownTimer();
      }, 1000);
    }
  }

  isTimerOff() {
    return this.getTimeLeftMs() < 0 ? true : false;
  }

  getTargetDateMs() {
    const date = new Date(this.targetDate);
    return date.getTime();
  }

  getCurrentTimeMs() {
    return Date.now();
  }

  getTimeLeftMs() {
    return this.getTargetDateMs() - this.getCurrentTimeMs();
  }

  getRefs() {
    return {
      days: document.querySelector(`${this.selector} [data-value="days"]`),
      hours: document.querySelector(`${this.selector} [data-value="hours"]`),
      mins: document.querySelector(`${this.selector} [data-value="mins"]`),
      secs: document.querySelector(`${this.selector} [data-value="secs"]`),
      selector: document.querySelector(this.selector),
    };
  }

  getTimeCountdownTimer() {
    const timeLeftMs = this.getTimeLeftMs();

    const days = Math.floor(timeLeftMs / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
      (timeLeftMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const mins = Math.floor((timeLeftMs % (1000 * 60 * 60)) / (1000 * 60));
    const secs = Math.floor((timeLeftMs % (1000 * 60)) / 1000);

    return {
      days,
      hours,
      mins,
      secs,
    };
  }

  renderCountdownTimer() {
    this.getRefs().days.textContent = this.getTimeCountdownTimer().days;

    this.getRefs().hours.textContent = fullTime(
      this.getTimeCountdownTimer().hours
    );

    this.getRefs().mins.textContent = fullTime(
      this.getTimeCountdownTimer().mins
    );

    this.getRefs().secs.textContent = fullTime(
      this.getTimeCountdownTimer().secs
    );
  }
}

const fullTime = (str) => {
  return str <= 9 ? String(str).padStart(2, 0) : str;
};

new CountdownTimer({
  selector: "#timer-1",
  targetDate: new Date("Sep 18, 2017"),
});

new CountdownTimer({
  selector: "#timer-2",
  targetDate: new Date("Sep 18, 2050"),
});
