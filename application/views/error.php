    <style>
    .payment_successful {
        height: 98vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .payment_successful a{
        text-align: center;
        display: block;
        color: #333;
        text-decoration: none;
        font-size: 18px;
        background: #a4c0d6;
        width: 30%;
        margin: 0 auto;
        padding: 20px 0px;
        font-weight: 600;
    }
    
    </style>

    <div class="payment_successful text-center">
        <div class="container">
            <img src="<?=base_url();?>assets/img/error-img.png" alt="" class="img-fluid">
            <a href="<?=base_url();?>login">Back to home</a>
        </div>
    </div>