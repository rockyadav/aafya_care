<?php include('header.php'); ?>
<!-- Main content Start -->
<div class="main-content">
            <!-- Breadcrumbs Section Start -->
            <div class="rs-breadcrumbs bg-8">
                <div class="container">
                    <div class="content-part text-center">
                        <h1 class="breadcrumbs-title white-color mb-0">My Account</h1>
                    </div>
                </div>
            </div>
            <!-- Breadcrumbs Section End -->

            <!-- Account Login Start -->
            <div id="rs-my-account" class="rs-my-account pt-100 pb-100 md-pt-57 md-pb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="regi-side">
                                <div class="sec-title">
                                    <h2 class="title">Registration</h2>
                                </div>
                                <form class="register-form" id="register-form" method="post" action="mailer.php">
                                    <label class="input-label">Username <span class="req">*</span></label>
                                    <input class="custom-placeholder" type="text" name="name" required="">

                                    <label class="input-label">Email Address <span class="req">*</span></label>
                                    <input class="custom-placeholder" type="email" name="email" required="">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="input-label">Password <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="password" name="psw" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="input-label">Confirm Password <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="password" name="psw-repeat" required="">
                                        </div>
                                    </div>

                                    <label class="input-label">Name <span class="req">*</span></label>
                                    <input class="custom-placeholder" type="text" name="name" required="">

                                    <div class="row">
                                        <div class="col-md-4 lg-pr-0">
                                            <div class="margin-space gender-detect">
                                                <label class="input-label">Gender <span class="req">*</span></label>
                                                <br>
                                                <label>
                                                    <input class="radio-btn" type="radio" name="gender" value="male" required=""><span>Male</span>
                                                </label>
                                                <label>
                                                    <input class="radio-btn" type="radio" name="gender" value="female" required=""><span>Female</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="margin-space">
                                                <span data-type="selectors" data-name="birthday_wrapper">
                                                    <label class="input-label">Date of Birth <span class="req">*</span></label>
                                                    <br>
                                                    <span>
                                                        <select name="birthday-day" class="date" required="">
                                                            <option value="" selected="" disabled="disabled">Day</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                            <option value="25">25</option>
                                                            <option value="26">26</option>
                                                            <option value="27">27</option>
                                                            <option value="28">28</option>
                                                            <option value="29">29</option>
                                                            <option value="30">30</option>
                                                            <option value="31">31</option>
                                                        </select>

                                                        <select name="birthday_month" class="date" required="">
                                                            <option value="" selected="" disabled="disabled">Month</option>
                                                            <option value="1">Jan</option>
                                                            <option value="2">Feb</option>
                                                            <option value="3">Mar</option>
                                                            <option value="4">Apr</option>
                                                            <option value="5">May</option>
                                                            <option value="6">Jun</option>
                                                            <option value="7">Jul</option>
                                                            <option value="8">Aug</option>
                                                            <option value="9">Sept</option>
                                                            <option value="10">Oct</option>
                                                            <option value="11">Nov</option>
                                                            <option value="12">Dec</option>
                                                        </select>

                                                        <select name="birthday-year" class="date" required="">
                                                            <option value="" selected="" disabled="disabled">Year</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2019">2019</option>
                                                            <option value="2018">2018</option>
                                                            <option value="2017">2017</option>
                                                            <option value="2016">2016</option>
                                                            <option value="2015">2015</option>
                                                            <option value="2014">2014</option>
                                                            <option value="2013">2013</option>
                                                            <option value="2012">2012</option>
                                                            <option value="2011">2011</option>
                                                            <option value="2010">2010</option>
                                                            <option value="2009">2009</option>
                                                            <option value="2008">2008</option>
                                                            <option value="2007">2007</option>
                                                            <option value="2006">2006</option>
                                                            <option value="2005">2005</option>
                                                            <option value="2004">2004</option>
                                                            <option value="2003">2003</option>
                                                            <option value="2002">2002</option>
                                                            <option value="2001">2001</option>
                                                            <option value="2000">2000</option>
                                                            <option value="1999">1999</option>
                                                            <option value="1998">1998</option>
                                                            <option value="1997">1997</option>
                                                            <option value="1996">1996</option>
                                                            <option value="1995">1995</option>
                                                            <option value="1994">1994</option>
                                                            <option value="1993">1993</option>
                                                            <option value="1992">1992</option>
                                                            <option value="1991">1991</option>
                                                            <option value="1990">1990</option>
                                                            <option value="1989">1989</option>
                                                            <option value="1988">1988</option>
                                                            <option value="1987">1987</option>
                                                            <option value="1986">1986</option>
                                                            <option value="1985">1985</option>
                                                            <option value="1984">1984</option>
                                                            <option value="1983">1983</option>
                                                            <option value="1982">1982</option>
                                                            <option value="1981">1981</option>
                                                            <option value="1980">1980</option>
                                                            <option value="1979">1979</option>
                                                            <option value="1978">1978</option>
                                                            <option value="1977">1977</option>
                                                            <option value="1976">1976</option>
                                                            <option value="1975">1975</option>
                                                            <option value="1974">1974</option>
                                                            <option value="1973">1973</option>
                                                            <option value="1972">1972</option>
                                                            <option value="1971">1971</option>
                                                            <option value="1970">1970</option>
                                                            <option value="1969">1969</option>
                                                            <option value="1968">1968</option>
                                                            <option value="1967">1967</option>
                                                            <option value="1966">1966</option>
                                                            <option value="1965">1965</option>
                                                            <option value="1964">1964</option>
                                                            <option value="1963">1963</option>
                                                            <option value="1962">1962</option>
                                                            <option value="1961">1961</option>
                                                            <option value="1960">1960</option>
                                                            <option value="1959">1959</option>
                                                            <option value="1958">1958</option>
                                                            <option value="1957">1957</option>
                                                            <option value="1956">1956</option>
                                                            <option value="1955">1955</option>
                                                            <option value="1954">1954</option>
                                                            <option value="1953">1953</option>
                                                            <option value="1952">1952</option>
                                                            <option value="1951">1951</option>
                                                            <option value="1950">1950</option>
                                                            <option value="1949">1949</option>
                                                            <option value="1948">1948</option>
                                                            <option value="1947">1947</option>
                                                            <option value="1946">1946</option>
                                                            <option value="1945">1945</option>
                                                            <option value="1944">1944</option>
                                                            <option value="1943">1943</option>
                                                            <option value="1942">1942</option>
                                                            <option value="1941">1941</option>
                                                            <option value="1940">1940</option>
                                                            <option value="1939">1939</option>
                                                            <option value="1938">1938</option>
                                                            <option value="1937">1937</option>
                                                            <option value="1936">1936</option>
                                                            <option value="1935">1935</option>
                                                            <option value="1934">1934</option>
                                                            <option value="1933">1933</option>
                                                            <option value="1932">1932</option>
                                                            <option value="1931">1931</option>
                                                            <option value="1930">1930</option>
                                                        </select>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="input-label">City <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="city" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="input-label">Country <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="country" required="">
                                        </div>
                                    </div>

                                    <label class="input-label">Address* <span class="req">*</span></label>
                                    <input class="custom-placeholder" type="text" name="address" required="">

                                    <label>
                                        <input class="checkbox" type="checkbox" name="agreement" required=""> I agree the User Agreement and <a href="#">Terms &amp; Condition.</a>
                                    </label>

                                    <div class="submit-btn">
                                        <button class="readon" type="submit">Create Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Account Login End -->
        </div> 
        <!-- Main content End -->

<?php include('footer.php'); ?>