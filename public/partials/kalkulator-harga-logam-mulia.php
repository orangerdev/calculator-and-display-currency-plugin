<form id="kalkulator-logam-mulia" action="" method="post">
    <div class="hlm-grid">
        <div class="hlm-col-50">
            <div class="hlm-box">
                <div class="hlm-field">
                    <label for="calc_title"><?php _e('Title','calculator-and-display-currency'); ?></label>
                    <select name="title" id="calc_title" placeholder="<?php _e('Select Title','calculator-and-display-currency'); ?>" class="calc-field">
                        <option value=""><?php _e('Select Title'); ?></option>
                        <?php
                        $calculator_title = hlm_get_calculator_title();
                        foreach ( $calculator_title as $key => $value) :
                        ?>
                            <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="hlm-field">
                    <label for="calc_weight"><?php _e('Weight','calculator-and-display-currency'); ?></label>
                    <input type="text" name="weight" id="calc_weight" placeholder="<?php _e('Enter Weight','calculator-and-display-currency'); ?>" class="calc-field">
                </div>
                <div class="hlm-field">
                    <label for="calc_pt"><?php _e('PT','calculator-and-display-currency'); ?></label>
                    <input type="text" name="pt" id="calc_pt" placeholder="<?php _e('Enter PT','calculator-and-display-currency'); ?>" class="calc-field">
                </div>
                <div class="hlm-field">
                    <label for="calc_pd"><?php _e('PD','calculator-and-display-currency'); ?></label>
                    <input type="text" name="pd" id="calc_pd" placeholder="<?php _e('Enter PD','calculator-and-display-currency'); ?>" class="calc-field">
                </div>
                <div class="hlm-field">
                    <label for="calc_ph"><?php _e('RH','calculator-and-display-currency'); ?></label>
                    <input type="text" name="ph" id="calc_ph" placeholder="<?php _e('Enter RH','calculator-and-display-currency'); ?>" class="calc-field">
                </div>
            </div>
        </div>
        <div class="hlm-col-50">
            <div class="hlm-box">
                <div class="hlm-harga-usd-wrap">
                    <h3><?php _e('Prices in USD','calculator-and-display-currency'); ?></h3>
                    <p class="hlm-harga-usd">_</p>
                </div>
                <div class="hlm-konversi-harga-wrap">
                    <h3><?php _e('Conversion','calculator-and-display-currency'); ?></h3>
                    <div class="hlm-field">
                        <label for="mata_uang"><?php _e('Currency','calculator-and-display-currency'); ?></label>
                        <select name="mata_uang" id="mata_uang">
                            <?php
                            $currencies = hlm_get_currencies();
                            foreach ( $currencies as $key => $value) :
                            ?>
                                <option value="<?php echo $key; ?>" <?php selected( 'IDR', $key, true ); ?>><?php echo $key; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="hlm-konversi-harga-result-wrap">
                    <?php
                    $harga_result_currency = 'IDR';
                    ?>
                    <h3><?php echo sprintf( _x('Prices in %s','calculator-and-display-currency'), '<span class="hlm-harga-result-currency">'.$harga_result_currency.'</span>' ); ?></h3>
                    <p class="hlm-harga-result">_</p>
                </div>
            </div>
        </div>
    </div>
    <div class="hlm-action hlm-align-right">
        <button type="submit" class="hlm-btn hlm-hitung-btn"><?php _e('Count','calculator-and-display-currency'); ?></button>
    </div>
</form>