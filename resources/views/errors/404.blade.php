@extends('layout.app')

@section('page.title', 'الصفحة غير موجودة')
@section('content')
 <main class="error-page">
  <div class="container_b">
    <div class="eyes">
      <div class="eye">
        <div class="eye__pupil eye__pupil--left"></div>
      </div>
      <div class="eye">
        <div class="eye__pupil eye__pupil--right"></div>
      </div>
    </div>

    <div class="error-page__heading">
      <h1 class="error-page__heading-title">الصفحة التي طلبتها غير موجدة</h1>
      <p class="error-page__heading-desciption">404 خطأ</p>
    </div>

    <a class="error-page__button" href="{{route('home')}}" aria-label="back to home" title="back to home">عودة إلى الرئيسية</a>
  </div>
</div>

</main>
@endsection
@section('extraJs')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Fira+Sans:wght@200;500&display=swap");


:root {
  --primary-color: #0F5089;
  --eye-pupil-color: #050505;
  --bg-color: #fff;
  --text-color: #000;
  --fs-heading: 36px;
  --fs-text: 26px;
  --fs-button: 18px;
  --fs-icon: 30px;
  --pupil-size: 30px;
  --eye-size: 80px;
  --button-padding: 15px 30px;
}
@media only screen and (max-width: 567px) {
  :root {
    --fs-heading: 30px;
    --fs-text: 22px;
    --fs-button: 16px;
    --fs-icon: 24px;
    --button-padding: 12px 24px;
  }
}

body {

  font-family: "Fira Sans", sans-serif;
}

.container_b {
    display: flex;
    flex-direction: column;
    align-items: center;
    row-gap: 30px;
    text-align: center;
    min-height: 80vh;
    margin-top: 150px;
}

.error-page {
  margin: auto;
}
.error-page__heading-title {
  text-transform: capitalize;
  font-size: var(--fs-heading);
  font-weight: 500;
  color: var(--primary-color);
}
.error-page__heading-desciption {
  margin-top: 10px;
  font-size: var(--fs-text);
  font-weight: 200;
}
.error-page__button {
  color: inherit;
  text-decoration: none;
  border: 1px solid var(--primary-color);
  font-size: var(--fs-button);
  font-weight: 200;
  padding: var(--button-padding);
  border-radius: 15px;
  box-shadow: 0px 7px 0px -2px var(--primary-color);
  transition: all 0.3s ease-in-out;
  text-transform: capitalize;
}
.error-page__button:hover {
  box-shadow: none;
  background-color: var(--primary-color);
  color: #fff;
}

.eyes {
  display: flex;
  justify-content: center;
  gap: 2px;
}

.eye {
  width: var(--eye-size);
  height: var(--eye-size);
  background-color: var(--primary-color);
  border-radius: 50%;
  display: grid;
  place-items: center;
}
.eye__pupil {
  width: var(--pupil-size);
  height: var(--pupil-size);
  background-color: var(--eye-pupil-color);
  border:10px solid #fff;
  border-radius: 50%;
  animation: movePupil 2s infinite ease-in-out;
  transform-origin: center center;
  /*
  To reverse the animation of the right eye, uncomment this.
  */
}
@keyframes movePupil {
  0%, 100% {
    transform: translate(0, 0);
  }
  25% {
    transform: translate(-10px, -10px);
  }
  50% {
    transform: translate(10px, 10px);
  }
  75% {
    transform: translate(-10px, 10px);
  }
}

.color-switcher {
  position: fixed;
  top: 40px;
  right: 40px;
  background-color: transparent;
  font-size: var(--fs-icon);
  cursor: pointer;
  color: var(--primary-color);
  border: 0;
}
</style>

@endsection
