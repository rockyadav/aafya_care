<!DOCTYPE html>
<html>
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bgimg {
  background-image: url('{{url("public/assets/img/forestbridge.png")}}');
  height: 100%;
  background-position: center;
  background-size: cover;
  position: relative;
  color: white;
  font-family: "Courier New", Courier, monospace;
  font-size: 25px;
}

.topleft {
  position: absolute;
  top: 0;
  left: 16px;
}

.bottomleft {
  position: absolute;
  bottom: 0;
  left: 16px;
}

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

hr {
  margin: auto;
  width: 40%;
}
</style>
<body> 
<div class="bgimg">
  <div class="middle">
    <div class="error-page">
          <h2 class="headline text-info"> 404</h2>
          <div class="error-content">
              <h3 style="color: darkblue;"><i class="fa fa-warning text-yellow" ></i> Oops! Page not found.</h3>
          </div>
    </div>
  </div>
</div>


</body>
</html>
