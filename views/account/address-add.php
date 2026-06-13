<style>
.address-wrapper{
    max-width:900px;
    margin:30px auto;
}

.address-card{
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.address-title{
    font-size:28px;
    font-weight:700;
    margin-bottom:25px;
    color:#222;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group.full{
    grid-column:1/-1;
}

.form-label{
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#444;
}

.form-control{
    width:100%;
    padding:14px 16px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:15px;
    transition:.3s;
    box-sizing:border-box;
}

.form-control:focus{
    outline:none;
    border-color:#000;
    box-shadow:0 0 0 3px rgba(0,0,0,.08);
}

textarea.form-control{
    min-height:120px;
    resize:vertical;
}

.default-box{
    margin-top:20px;
    background:#f8f8f8;
    padding:15px;
    border-radius:10px;
}

.default-box label{
    display:flex;
    align-items:center;
    gap:10px;
    cursor:pointer;
    font-weight:500;
}

.btn-save{
    margin-top:25px;
    background:#000;
    color:#fff;
    border:none;
    padding:14px 30px;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-save:hover{
    background:#222;
}

@media(max-width:768px){

    .form-grid{
        grid-template-columns:1fr;
    }

    .address-card{
        padding:20px;
    }

    .address-title{
        font-size:24px;
    }
}
</style>

<div class="address-wrapper">

    <div class="address-card">

        <h2 class="address-title">

            <?= !empty($address)
                ? 'Edit Address'
                : 'Add New Address' ?>

        </h2>

        <form method="POST"
              action="<?= !empty($address)
                    ? siteUrl().'/user/address-update/'.$address->id
                    : siteUrl().'/user/address-save' ?>">

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">
                        Full Name
                    </label>

                    <input type="text"
                           name="full_name"
                           class="form-control"
                           value="<?= $address->full_name ?? '' ?>"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Mobile Number
                    </label>

                    <input type="text"
                           name="mobile"
                           class="form-control"
                           value="<?= $address->mobile ?? '' ?>"
                           required>
                </div>

                <div class="form-group full">
                    <label class="form-label">
                        Address
                    </label>

                    <textarea name="address_line"
                              class="form-control"
                              required><?= $address->address_line ?? '' ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        City
                    </label>

                    <input type="text"
                           name="city"
                           class="form-control"
                           value="<?= $address->city ?? '' ?>"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        State
                    </label>

                    <input type="text"
                           name="state"
                           class="form-control"
                           value="<?= $address->state ?? '' ?>"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Pincode
                    </label>

                    <input type="text"
                           name="pincode"
                           class="form-control"
                           value="<?= $address->pincode ?? '' ?>"
                           required>
                </div>

            </div>

            <div class="default-box">

                <label>

                    <input type="checkbox"
                           name="is_default"
                           value="1"
                           <?= !empty($address->is_default)
                                ? 'checked'
                                : '' ?>>

                    Set as Default Address

                </label>

            </div>

            <button type="submit"
                    class="btn-save">

                <?= !empty($address)
                    ? 'Update Address'
                    : 'Save Address' ?>

            </button>

        </form>

    </div>

</div>