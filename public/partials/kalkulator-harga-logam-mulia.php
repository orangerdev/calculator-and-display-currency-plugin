<form id="kalkulator-logam-mulia" action="" method="post">
    <div class="hlm-grid">
        <div class="hlm-col-50">
            <div class="hlm-box">
                <div class="hlm-field">
                    <label for="title"><?php _e('Title','calculator-and-display-currency'); ?></label>
                    <input type="text" name="title" id="title" placeholder="<?php _e('Masukan Title','calculator-and-display-currency'); ?>">
                </div>
                <div class="hlm-field">
                    <label for="weight"><?php _e('Weight','calculator-and-display-currency'); ?></label>
                    <input type="text" name="weight" id="weight" placeholder="<?php _e('Masukan Weight','calculator-and-display-currency'); ?>">
                </div>
                <div class="hlm-field">
                    <label for="pt"><?php _e('PT','calculator-and-display-currency'); ?></label>
                    <input type="text" name="pt" id="pt" placeholder="<?php _e('Masukan PT','calculator-and-display-currency'); ?>">
                </div>
                <div class="hlm-field">
                    <label for="pd"><?php _e('PD','calculator-and-display-currency'); ?></label>
                    <input type="text" name="pd" id="pd" placeholder="<?php _e('Masukan PD','calculator-and-display-currency'); ?>">
                </div>
                <div class="hlm-field">
                    <label for="ph"><?php _e('PH','calculator-and-display-currency'); ?></label>
                    <input type="text" name="ph" id="ph" placeholder="<?php _e('Masukan PH','calculator-and-display-currency'); ?>">
                </div>
            </div>
        </div>
        <div class="hlm-col-50">
            <div class="hlm-box">
                <div class="hlm-harga-usd-wrap">
                    <h3><?php _e('Harga Dalam USD','calculator-and-display-currency'); ?></h3>
                    <?php
                    $harga_usd = 0;
                    ?>
                    <p class="hlm-harga-usd"><?php echo $harga_usd; ?></p>
                </div>
                <div class="hlm-konversi-harga-wrap">
                    <h3><?php _e('Konversi Harga','calculator-and-display-currency'); ?></h3>
                    <div class="hlm-field">
                        <label for="mata_uang"><?php _e('Mata Uang','calculator-and-display-currency'); ?></label>
                        <select name="mata_uang" id="mata_uang">
                        </select>
                    </div>
                </div>
                <div class="hlm-konversi-harga-result-wrap">
                    <?php
                    $harga_result_currency = 'USD';
                    $harga_result = 0;
                    ?>
                    <h3><?php echo sprintf( _x('Harga Dalam %s','calculator-and-display-currency'), '<span class="hlm-harga-result-currency">'.$harga_result_currency.'</span>' ); ?></h3>
                    <p class="hlm-harga-result"><?php echo $harga_result; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="hlm-action hlm-align-right">
        <button type="submit" class="hlm-btn hlm-hitung-btn"><?php _e('Hitung','calculator-and-display-currency'); ?></button>
    </div>
</form>