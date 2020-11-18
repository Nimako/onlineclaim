
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Chekout</title>
  </head>
  <style>
  body {
    background-color: #eee
}

.container {
    height: 100vh
}

.card {
    border: none
}

.form-control {
    border-bottom: 2px solid #eee !important;
    border: none;
    font-weight: 600
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #8bbafe;
    outline: 0;
    box-shadow: none;
    border-radius: 0px;
    border-bottom: 2px solid blue !important
}

.inputbox {
    position: relative;
    margin-bottom: 20px;
    width: 100%
}

.inputbox span {
    position: absolute;
    top: 7px;
    left: 11px;
    transition: 0.5s
}

.inputbox i {
    position: absolute;
    top: 13px;
    right: 8px;
    transition: 0.5s;
    color: #3F51B5
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0
}

.inputbox input:focus~span {
    transform: translateX(-0px) translateY(-15px);
    font-size: 12px
}

.inputbox input:valid~span {
    transform: translateX(-0px) translateY(-15px);
    font-size: 12px
}

.card-blue {
    background-color: #C20000
}

.hightlight {
    background-color: #5737d9;
    padding: 10px;
    border-radius: 10px;
    margin-top: 15px;
    font-size: 14px
}

.yellow {
    color: #fdcc49
}

.decoration {
    text-decoration: none;
    font-size: 14px
}

.btn-success {
    color: #fff;
    background-color: #C20000;
    border-color: #C20000
}

.btn-success:hover {
    color: #fff;
    background-color: #C20000;
    border-color: #C20000
}

.decoration:hover {
    text-decoration: none;
    color: #fdcc49
}
   </style>
  <body>


<div class="container mt-5 px-5">
    <div class="mb-4">
        <h2>Confirm order and pay</h2> 
        <!-- <span>please make the payment, after that you can enjoy all the features and benefits.</span> -->
    </div>
    <div class="row">
        <div class="col-md-8">
        <?= form_open("Acceptpayment/payment_initiate"); ?>
            <div class="card p-3">
                <h6 class="text-uppercase">Payment details</h6>
                <div class="inputbox mt-3"> 
                    <select class="form-control" name="network">
                        <option>Select Network</option>
                        <option ="MTN">MTN Momo</option>
                        <option value="VODAFONE">Vodafone Cash</option>
                        <option value="AIRTElTIGO">AirtelTigo Cash</option>
                    </select> 
                 </div>
               
                 <div class="inputbox mt-3"> 
                 <input type="text" name="Name" class="form-control" required="required">  <span>Wallet Name</span>
                 </div>

                 <div class="inputbox mt-3"> 
                 <input type="text" name="phoneNum" class="form-control" required="required">  <span>Phone Number</span>
                 </div>

                 <div class="inputbox mt-3"> 
                 <input type="text" name="Email" class="form-control" required="required">  <span>Email</span>
                 </div>

                 <div class="inputbox mt-3"> 
                 <input type="text" name="billCode" class="form-control" required="required"> <span>Reference</span>
                 
                 <input type="hidden" name="checkoutId" value="<?= $checkoutID; ?>">
                 </div>
            </div>
            <div class="mt-4 mb-4 d-flex justify-content-between"> <span>Cancel</span>
             <button type="submit" class="btn btn-success px-3">Pay ₵ <?= @$info->Amount; ?></button> 
            </div>
            </form>

        </div>
        <div class="col-md-4">
            <div class="card card-blue p-3 text-white mb-3"> <span>You have to pay</span>
                <div class="d-flex flex-row align-items-end mb-3">
                    <h1 class="mb-0 yellow">₵ <?= @$info->Amount; ?></h1> <span></span>
                </div> 
                <!-- <div class="hightlight"> <span>100% Guaranteed support and update for the next 5 years.</span> </div> -->
            </div>
        </div>
    </div>
</div>



    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>