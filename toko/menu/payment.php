<section class="section">
    <div class="container-fluid">
        <div class="row">

            <div class="col-8">
                <div class="container">
                    <form id="checkout_form" action="checkout_process.php" method="POST">
                        <div class="row">
                            <div class="col-8">
                                <h3>Billing Address</h3>
                                <div class="mb-3">
                                    <label for="fname" class="form-label"><i class="fa fa-user"></i> Full Name</label>
                                    <input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label"><i class="fa fa-envelope"></i> Email</label>
                                    <input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" value="fahmi@gmail.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="adr" class="form-label"><i class="fa fa-address-card-o"></i> Address</label>
                                    <input type="text" id="adr" name="address" class="form-control" value="Cirendang" required>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label"><i class="fa fa-institution"></i> City</label>
                                    <input type="text" id="city" name="city" class="form-control" value="Kuningan" pattern="^[a-zA-Z ]+$" required>
                                </div>
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" id="state" name="state" class="form-control" pattern="^[a-zA-Z ]+$" required>
                                </div>
                                <div class="mb-3">
                                    <label for="zip" class="form-label">Zip</label>
                                    <input type="text" id="zip" name="zip" class="form-control" pattern="^[0-9]{6}(?:-[0-9]{4})?$" required>
                                </div>
                            </div>


                            <div class="col-4">
                                <h3>Payment</h3>
                                <label for="fname">Accepted Cards</label>
                                <div class="icon-container">
                                    <i class="fa fa-cc-visa" style="color:navy;"></i>
                                    <i class="fa fa-cc-amex" style="color:blue;"></i>
                                    <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                    <i class="fa fa-cc-discover" style="color:orange;"></i>
                                </div>


                                <label for="cname">Name on Card</label>
                                <input type="text" id="cname" name="cardname" class="form-control" pattern="^[a-zA-Z ]+$" required>

                                <div class="form-group" id="card-number-field">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                                </div>
                                <label for="expdate">Exp Date</label>
                                <input type="text" id="expdate" name="expdate" class="form-control" pattern="^((0[1-9])|(1[0-2]))\/(\d{2})$" placeholder="12/22" required>


                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cvv">CVV</label>
                                            <input type="text" class="form-control" name="cvv" id="cvv" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label><input type="CHECKBOX" name="q" class="roomselect" value="conform" required> Shipping address same as billing
                        </label><br />
                        <input type="hidden" name="total_count" value="">
                        <input type="hidden" name="total_price" value="0">

                        <input type="submit" id="submit" value="Continue to checkout" class="btn btn-success btn-block">
                    </form>
                </div>
            </div>

            <div class="col-4">
                <div class="container">

                </div>
            </div>
        </div>
    </div>
</section>